<?php
/**
 * Plugin Name: Mercado Erótico - Gestão de Destaques da Capa (Home Bento Grid)
 * Description: Gerenciamento no painel do WordPress para escolher exatamente quais matérias ficam no Hero da Home (Card Principal e 4 Cards Laterais), com fallback inteligente para os mais recentes não exibidos e integração com o feed inferior.
 * Version: 1.0.0
 * Author: Equipe Portal Mercado Erótico
 */

if (!defined('ABSPATH')) exit;

/**
 * ============================================================================
 * 1. FUNÇÃO CENTRAL DE DADOS & FALLBACK INTELIGENTE (FRONT-END & ADMIN)
 * ============================================================================
 */
function mercado_get_home_bento_data() {
    $config = get_option('mercado_home_bento_config', array());
    if (!is_array($config)) {
        $config = array();
    }

    $used_post_ids = array();
    $slots_info = array();

    // 1. Resolução do Card Principal (Hero Grande)
    $main_id = !empty($config['main_post']) ? intval($config['main_post']) : 0;
    $main_post = null;
    $main_is_manual = false;

    if ($main_id > 0) {
        $p = get_post($main_id);
        if ($p && $p->post_status === 'publish') {
            $main_post = $p;
            $used_post_ids[] = $p->ID;
            $main_is_manual = true;
        }
    }

    if (!$main_post) {
        $auto_main_query = get_posts(array(
            'numberposts'   => 1,
            'post_status'   => 'publish',
            'post__not_in'  => $used_post_ids,
            'orderby'       => 'date',
            'order'         => 'DESC'
        ));
        if (!empty($auto_main_query)) {
            $main_post = $auto_main_query[0];
            $used_post_ids[] = $main_post->ID;
        }
    }

    $slots_info['main_post'] = array(
        'post'      => $main_post,
        'is_manual' => $main_is_manual,
        'target_id' => $main_id
    );

    // 2. Resolução dos 4 Cards Laterais (Grid 2x2)
    $side_posts = array();
    for ($i = 1; $i <= 4; $i++) {
        $slot_key = "side_{$i}";
        $side_id = !empty($config[$slot_key]) ? intval($config[$slot_key]) : 0;
        $side_post = null;
        $side_is_manual = false;

        if ($side_id > 0 && !in_array($side_id, $used_post_ids)) {
            $p = get_post($side_id);
            if ($p && $p->post_status === 'publish') {
                $side_post = $p;
                $used_post_ids[] = $p->ID;
                $side_is_manual = true;
            }
        }

        if (!$side_post) {
            $auto_side_query = get_posts(array(
                'numberposts'   => 1,
                'post_status'   => 'publish',
                'post__not_in'  => $used_post_ids,
                'orderby'       => 'date',
                'order'         => 'DESC'
            ));
            if (!empty($auto_side_query)) {
                $side_post = $auto_side_query[0];
                $used_post_ids[] = $side_post->ID;
            }
        }

        if ($side_post) {
            $side_posts[] = $side_post;
        }

        $slots_info[$slot_key] = array(
            'post'      => $side_post,
            'is_manual' => $side_is_manual,
            'target_id' => $side_id
        );
    }

    // 3. Integração com o Restante da Página (Feed Recente de 9 matérias)
    // Exclui rigorosamente todos os posts já exibidos no Bento Hero para evitar qualquer repetição
    $feed_posts = get_posts(array(
        'numberposts'   => 9,
        'post_status'   => 'publish',
        'post__not_in'  => $used_post_ids,
        'orderby'       => 'date',
        'order'         => 'DESC'
    ));

    return array(
        'main_post'     => $main_post,
        'side_posts'    => $side_posts,
        'feed_posts'    => $feed_posts,
        'used_post_ids' => $used_post_ids,
        'slots_info'    => $slots_info,
        'config'        => $config
    );
}

/**
 * ============================================================================
 * 2. REGISTRO DO MENU NO PAINEL DO WORDPRESS
 * ============================================================================
 */
add_action('admin_menu', function() {
    add_menu_page(
        'Destaques da Capa',
        'Destaques da Capa',
        'edit_posts',
        'mercado-capa-destaques',
        'mercado_capa_destaques_admin_render',
        'dashicons-layout',
        6 // Logo após "Posts" (5)
    );
});

// Adicionar atalho na Barra de Ferramentas Superior (Admin Bar)
add_action('admin_bar_menu', function($admin_bar) {
    if (!current_user_can('edit_posts')) return;
    $admin_bar->add_node(array(
        'id'    => 'mercado_capa_destaques_bar',
        'title' => '<span class="ab-icon dashicons dashicons-layout" style="top:2px;"></span> Destaques da Capa',
        'href'  => admin_url('admin.php?page=mercado-capa-destaques'),
        'meta'  => array('title' => 'Gerenciar matérias em destaque no Hero da Home')
    ));
}, 100);

/**
 * ============================================================================
 * 3. PROCESSAMENTO DO FORMULÁRIO DE SALVAMENTO
 * ============================================================================
 */
add_action('admin_init', function() {
    if (!isset($_POST['mercado_bento_action']) || $_POST['mercado_bento_action'] !== 'save_config') {
        return;
    }

    if (!current_user_can('edit_posts')) {
        wp_die('Você não tem permissão para realizar esta ação.');
    }

    check_admin_referer('mercado_save_bento_nonce');

    if (isset($_POST['mercado_reset_all']) && $_POST['mercado_reset_all'] === '1') {
        // Redefinir todos para automático
        delete_option('mercado_home_bento_config');
    } else {
        $new_config = array(
            'main_post' => isset($_POST['mercado_bento_main_post']) ? intval($_POST['mercado_bento_main_post']) : 0,
            'side_1'    => isset($_POST['mercado_bento_side_1']) ? intval($_POST['mercado_bento_side_1']) : 0,
            'side_2'    => isset($_POST['mercado_bento_side_2']) ? intval($_POST['mercado_bento_side_2']) : 0,
            'side_3'    => isset($_POST['mercado_bento_side_3']) ? intval($_POST['mercado_bento_side_3']) : 0,
            'side_4'    => isset($_POST['mercado_bento_side_4']) ? intval($_POST['mercado_bento_side_4']) : 0,
        );
        update_option('mercado_home_bento_config', $new_config);
    }

    // Limpeza de cache LiteSpeed e WP
    if (class_exists('LiteSpeed_Cache_API')) {
        LiteSpeed_Cache_API::purge_all();
    }
    wp_cache_flush();

    wp_safe_redirect(admin_url('admin.php?page=mercado-capa-destaques&saved=1'));
    exit;
});

/**
 * ============================================================================
 * 4. ENDPOINT AJAX PARA BUSCA DE MATÉRIAS
 * ============================================================================
 */
add_action('wp_ajax_mercado_search_bento_posts', function() {
    if (!current_user_can('edit_posts')) {
        wp_send_json_error('Sem permissão');
    }

    $term = sanitize_text_field($_GET['term'] ?? '');
    if (empty($term)) {
        wp_send_json_success(array());
    }

    $query_args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => 20,
        'orderby'        => 'date',
        'order'          => 'DESC'
    );

    if (is_numeric($term)) {
        $query_args['p'] = intval($term);
    } else {
        $query_args['s'] = $term;
    }

    $posts = get_posts($query_args);
    $results = array();

    foreach ($posts as $p) {
        $thumb = get_the_post_thumbnail_url($p->ID, 'thumbnail') ?: 'https://images.unsplash.com/photo-1518895949257-7621c3c786d7?w=150';
        $cats = wp_get_post_categories($p->ID, array('fields' => 'names'));
        $cat = !empty($cats) ? $cats[0] : 'Geral';

        $results[] = array(
            'id'        => $p->ID,
            'title'     => html_entity_decode(get_the_title($p->ID), ENT_QUOTES, 'UTF-8'),
            'date'      => get_the_date('d/m/Y', $p->ID),
            'category'  => $cat,
            'thumb'     => $thumb,
            'permalink' => get_permalink($p->ID)
        );
    }

    wp_send_json_success($results);
});

/**
 * ============================================================================
 * 5. SIDEBAR META BOX NA EDIÇÃO DE POST INDIVIDUAL
 * ============================================================================
 */
add_action('add_meta_boxes', function() {
    add_meta_box(
        'mercado_bento_post_meta',
        '★ Destaque na Capa (Home Bento Grid)',
        'mercado_bento_meta_box_render',
        'post',
        'side',
        'high'
    );
});

function mercado_bento_meta_box_render($post) {
    wp_nonce_field('mercado_bento_meta_box_nonce', 'mercado_bento_meta_box_nonce_field');
    $config = get_option('mercado_home_bento_config', array());

    $current_slot = '0';
    if (!empty($config['main_post']) && $config['main_post'] == $post->ID) {
        $current_slot = 'main_post';
    } elseif (!empty($config['side_1']) && $config['side_1'] == $post->ID) {
        $current_slot = 'side_1';
    } elseif (!empty($config['side_2']) && $config['side_2'] == $post->ID) {
        $current_slot = 'side_2';
    } elseif (!empty($config['side_3']) && $config['side_3'] == $post->ID) {
        $current_slot = 'side_3';
    } elseif (!empty($config['side_4']) && $config['side_4'] == $post->ID) {
        $current_slot = 'side_4';
    }
    ?>
    <p style="font-size:12px; color:#666; margin-bottom:10px;">
        Escolha se este artigo deve ser fixado diretamente em uma das posições de destaque na página inicial.
    </p>
    <select name="mercado_bento_slot_assignment" style="width:100%; padding:6px; font-weight:500;">
        <option value="0" <?php selected($current_slot, '0'); ?>>— Padrão (Automático / Não fixado) —</option>
        <option value="main_post" <?php selected($current_slot, 'main_post'); ?>>★ Card Principal (Hero Grande)</option>
        <option value="side_1" <?php selected($current_slot, 'side_1'); ?>>Card Lateral 1 (Superior Esquerdo)</option>
        <option value="side_2" <?php selected($current_slot, 'side_2'); ?>>Card Lateral 2 (Superior Direito)</option>
        <option value="side_3" <?php selected($current_slot, 'side_3'); ?>>Card Lateral 3 (Inferior Esquerdo)</option>
        <option value="side_4" <?php selected($current_slot, 'side_4'); ?>>Card Lateral 4 (Inferior Direito)</option>
    </select>
    <?php if ($current_slot !== '0'): ?>
        <p style="margin-top:8px; font-size:11px; color:#e31c61; font-weight:600;">
            ✓ Este artigo está atualmente FIXADO na Capa.
        </p>
    <?php endif; ?>
    <p style="margin-top:10px; font-size:11px;">
        <a href="<?php echo admin_url('admin.php?page=mercado-capa-destaques'); ?>" target="_blank" style="text-decoration:none;">
            → Ver e gerenciar todos os destaques da Capa
        </a>
    </p>
    <?php
}

add_action('save_post', function($post_id, $post) {
    if (!isset($_POST['mercado_bento_meta_box_nonce_field']) || !wp_verify_nonce($_POST['mercado_bento_meta_box_nonce_field'], 'mercado_bento_meta_box_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if ($post->post_type !== 'post') return;

    $selected_slot = sanitize_text_field($_POST['mercado_bento_slot_assignment'] ?? '0');
    $config = get_option('mercado_home_bento_config', array());
    if (!is_array($config)) $config = array();

    $updated = false;

    // Remover este post de qualquer slot que ele estivesse anteriormente
    foreach (array('main_post', 'side_1', 'side_2', 'side_3', 'side_4') as $slot) {
        if (!empty($config[$slot]) && $config[$slot] == $post_id) {
            $config[$slot] = 0;
            $updated = true;
        }
    }

    // Se um slot foi escolhido, atribui este post
    if ($selected_slot !== '0' && in_array($selected_slot, array('main_post', 'side_1', 'side_2', 'side_3', 'side_4'))) {
        $config[$selected_slot] = $post_id;
        $updated = true;
    }

    if ($updated) {
        update_option('mercado_home_bento_config', $config);
        if (class_exists('LiteSpeed_Cache_API')) {
            LiteSpeed_Cache_API::purge_all();
        }
        wp_cache_flush();
    }
}, 10, 2);

/**
 * ============================================================================
 * 6. RENDERIZAÇÃO DA PÁGINA DE ADMINISTRAÇÃO "DESTAQUES DA CAPA"
 * ============================================================================
 */
function mercado_capa_destaques_admin_render() {
    $data = mercado_get_home_bento_data();
    $slots = $data['slots_info'];
    $config = $data['config'];
    $feed_sample = $data['feed_posts'];

    // Buscar as 80 reportagens mais recentes para preencher os selects
    $recent_posts = get_posts(array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => 80,
        'orderby'        => 'date',
        'order'          => 'DESC'
    ));
    ?>
    <div class="wrap mercado-bento-admin-wrap">
        <div class="me-admin-header">
            <div class="me-admin-header-title">
                <h1><span class="dashicons dashicons-layout"></span> Destaques da Capa (Home Bento Grid)</h1>
                <p class="description">
                    Escolha manualmente quais reportagens ganham destaque no topo da página inicial ou deixe em <strong>"Automático"</strong> para puxar os mais recentes sem repetições. O feed da página se integra de forma inteligente, continuando a partir da matéria seguinte.
                </p>
            </div>
            <div class="me-admin-header-actions">
                <a href="<?php echo home_url('/'); ?>" target="_blank" class="button button-secondary">
                    <span class="dashicons dashicons-external" style="margin-top:4px;"></span> Ver Home ao Vivo
                </a>
            </div>
        </div>

        <?php if (isset($_GET['saved'])): ?>
            <div class="notice notice-success is-dismissible" style="border-left-color:#e31c61;">
                <p><strong>✓ Alterações salvas com sucesso!</strong> O layout da Capa foi atualizado e o cache do site foi limpo.</p>
            </div>
        <?php endif; ?>

        <form method="post" action="" id="mercadoBentoForm">
            <?php wp_nonce_field('mercado_save_bento_nonce'); ?>
            <input type="hidden" name="mercado_bento_action" value="save_config">
            <input type="hidden" name="mercado_reset_all" id="mercadoResetAll" value="0">

            <div class="me-bento-builder-grid">
                
                <!-- COLUNA ESQUERDA: CARD PRINCIPAL HERO -->
                <div class="me-builder-col me-col-main">
                    <div class="me-slot-card me-slot-main">
                        <div class="me-slot-badge">
                            <span class="badge-icon">★</span>
                            <span class="badge-text">CARD PRINCIPAL (HERO DESTAQUE)</span>
                            <?php if (!empty($slots['main_post']['is_manual'])): ?>
                                <span class="badge-status status-manual">FIXADO MANUALMENTE</span>
                            <?php else: ?>
                                <span class="badge-status status-auto">AUTOMÁTICO (MAIS RECENTE)</span>
                            <?php endif; ?>
                        </div>

                        <?php 
                        $main_current_id = !empty($config['main_post']) ? intval($config['main_post']) : 0;
                        $main_resolved = $slots['main_post']['post'];
                        ?>

                        <!-- Card Preview -->
                        <div class="me-preview-box me-preview-main" id="preview_main_post">
                            <?php if ($main_resolved): 
                                $thumb = get_the_post_thumbnail_url($main_resolved->ID, 'medium_large') ?: 'https://images.unsplash.com/photo-1518895949257-7621c3c786d7?w=800';
                            ?>
                                <div class="preview-img" style="background-image: url('<?php echo esc_url($thumb); ?>');">
                                    <div class="preview-overlay">
                                        <span class="preview-tag">RESOLVIDO NA HOME</span>
                                        <h3 class="preview-title"><?php echo esc_html($main_resolved->post_title); ?></h3>
                                        <div class="preview-meta">
                                            <span><i class="dashicons dashicons-calendar-alt"></i> <?php echo get_the_date('d/m/Y', $main_resolved->ID); ?></span>
                                            <span>• ID #<?php echo $main_resolved->ID; ?></span>
                                            <span><a href="<?php echo get_permalink($main_resolved->ID); ?>" target="_blank" style="color:#fff; text-decoration:underline;">Ver post</a></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Selector Controls -->
                        <div class="me-slot-controls">
                            <label class="control-label">Selecionar Matéria para este Slot:</label>
                            <div class="search-helper-wrap">
                                <input type="text" class="me-quick-search-input" data-target="mercado_bento_main_post" placeholder="🔍 Digite palavras do título ou ID para buscar no acervo...">
                                <span class="spinner" style="float:none; margin:0 5px;"></span>
                            </div>

                            <select name="mercado_bento_main_post" id="mercado_bento_main_post" class="me-slot-select">
                                <option value="0" <?php selected($main_current_id, 0); ?>>
                                    ⚡ [AUTOMÁTICO] — Exibir o artigo mais recente publicado
                                </option>
                                <?php 
                                $found_in_list = false;
                                foreach ($recent_posts as $rp): 
                                    if ($rp->ID == $main_current_id) $found_in_list = true;
                                ?>
                                    <option value="<?php echo $rp->ID; ?>" <?php selected($main_current_id, $rp->ID); ?>>
                                        #<?php echo $rp->ID; ?> — <?php echo esc_html(wp_trim_words($rp->post_title, 10, '...')); ?> (<?php echo get_the_date('d/m/Y', $rp->ID); ?>)
                                    </option>
                                <?php endforeach; ?>

                                <?php if ($main_current_id > 0 && !$found_in_list): 
                                    $custom_p = get_post($main_current_id);
                                    if ($custom_p):
                                ?>
                                    <option value="<?php echo $custom_p->ID; ?>" selected>
                                        #<?php echo $custom_p->ID; ?> — <?php echo esc_html(wp_trim_words($custom_p->post_title, 10, '...')); ?> (<?php echo get_the_date('d/m/Y', $custom_p->ID); ?>) [Selecionado]
                                    </option>
                                <?php endif; endif; ?>
                            </select>

                            <div class="me-slot-actions">
                                <button type="button" class="button button-small me-btn-clear" data-target="mercado_bento_main_post">
                                    ✕ Voltar para Automático
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- COLUNA DIREITA: GRID 2x2 CARDS LATERAIS -->
                <div class="me-builder-col me-col-side">
                    <div class="me-side-grid-wrapper">
                        <?php 
                        $side_names = array(
                            1 => 'Card Lateral 1 (Superior Esquerdo)',
                            2 => 'Card Lateral 2 (Superior Direito)',
                            3 => 'Card Lateral 3 (Inferior Esquerdo)',
                            4 => 'Card Lateral 4 (Inferior Direito)',
                        );

                        for ($i = 1; $i <= 4; $i++):
                            $slot_key = "side_{$i}";
                            $current_id = !empty($config[$slot_key]) ? intval($config[$slot_key]) : 0;
                            $resolved = $slots[$slot_key]['post'];
                            $is_manual = !empty($slots[$slot_key]['is_manual']);
                        ?>
                            <div class="me-slot-card me-slot-side">
                                <div class="me-slot-badge">
                                    <span class="badge-num"><?php echo $i; ?></span>
                                    <span class="badge-text"><?php echo esc_html($side_names[$i]); ?></span>
                                    <?php if ($is_manual): ?>
                                        <span class="badge-status status-manual">FIXADO</span>
                                    <?php else: ?>
                                        <span class="badge-status status-auto">AUTOMÁTICO</span>
                                    <?php endif; ?>
                                </div>

                                <!-- Preview -->
                                <div class="me-preview-box me-preview-side" id="preview_<?php echo $slot_key; ?>">
                                    <?php if ($resolved): 
                                        $s_thumb = get_the_post_thumbnail_url($resolved->ID, 'medium') ?: 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=400';
                                    ?>
                                        <div class="side-preview-content">
                                            <div class="side-thumb" style="background-image:url('<?php echo esc_url($s_thumb); ?>');"></div>
                                            <div class="side-info">
                                                <h4 class="side-title"><?php echo esc_html(wp_trim_words($resolved->post_title, 9, '...')); ?></h4>
                                                <div class="side-meta">
                                                    <span><i class="dashicons dashicons-calendar-alt"></i> <?php echo get_the_date('d/m/Y', $resolved->ID); ?></span>
                                                    <span>• ID #<?php echo $resolved->ID; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Controls -->
                                <div class="me-slot-controls">
                                    <div class="search-helper-wrap">
                                        <input type="text" class="me-quick-search-input" data-target="mercado_bento_side_<?php echo $i; ?>" placeholder="🔍 Buscar matéria...">
                                        <span class="spinner" style="float:none; margin:0 5px;"></span>
                                    </div>

                                    <select name="mercado_bento_side_<?php echo $i; ?>" id="mercado_bento_side_<?php echo $i; ?>" class="me-slot-select">
                                        <option value="0" <?php selected($current_id, 0); ?>>
                                            ⚡ [AUTOMÁTICO] — Próximo mais recente
                                        </option>
                                        <?php 
                                        $side_found = false;
                                        foreach ($recent_posts as $rp): 
                                            if ($rp->ID == $current_id) $side_found = true;
                                        ?>
                                            <option value="<?php echo $rp->ID; ?>" <?php selected($current_id, $rp->ID); ?>>
                                                #<?php echo $rp->ID; ?> — <?php echo esc_html(wp_trim_words($rp->post_title, 8, '...')); ?> (<?php echo get_the_date('d/m/Y', $rp->ID); ?>)
                                            </option>
                                        <?php endforeach; ?>

                                        <?php if ($current_id > 0 && !$side_found): 
                                            $custom_side = get_post($current_id);
                                            if ($custom_side):
                                        ?>
                                            <option value="<?php echo $custom_side->ID; ?>" selected>
                                                #<?php echo $custom_side->ID; ?> — <?php echo esc_html(wp_trim_words($custom_side->post_title, 8, '...')); ?> (<?php echo get_the_date('d/m/Y', $custom_side->ID); ?>) [Selecionado]
                                            </option>
                                        <?php endif; endif; ?>
                                    </select>

                                    <div class="me-slot-actions">
                                        <button type="button" class="button button-small me-btn-clear" data-target="mercado_bento_side_<?php echo $i; ?>">
                                            ✕ Automático
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

            </div>

            <!-- BARRA DE INTEGRAÇÃO COM O RESTANTE DA PÁGINA (FEED RECENTE) -->
            <div class="me-integration-summary">
                <div class="summary-header">
                    <h3><span class="dashicons dashicons-randomize"></span> Integração com o Restante da Página (Feed Recente)</h3>
                    <p>
                        O algoritmo garante que <strong>nenhum dos 5 artigos acima será repetido</strong> no feed de reportagens abaixo. Veja abaixo como o feed começará na Capa:
                    </p>
                </div>
                <div class="summary-feed-preview">
                    <?php if (!empty($feed_sample)): ?>
                        <div class="feed-sequence-list">
                            <?php foreach (array_slice($feed_sample, 0, 4) as $f_idx => $fp): ?>
                                <div class="feed-sequence-item">
                                    <span class="seq-num">Feed #<?php echo $f_idx + 1; ?></span>
                                    <span class="seq-title"><?php echo esc_html($fp->post_title); ?></span>
                                    <span class="seq-date"><?php echo get_the_date('d/m/Y', $fp->ID); ?></span>
                                </div>
                            <?php endforeach; ?>
                            <div class="feed-sequence-item feed-sequence-more">
                                <span>... e mais <?php echo count($feed_posts ?? array()) > 4 ? count($feed_posts) - 4 : 5; ?> matérias em sequência contínua</span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- BARRA FIXA / RODAPÉ DE SALVAMENTO -->
            <div class="me-save-bar">
                <div class="save-bar-left">
                    <button type="submit" class="button button-primary button-hero me-btn-save">
                        <span class="dashicons dashicons-saved" style="margin-top:4px;"></span> Salvar Destaques da Capa
                    </button>
                    <button type="button" class="button button-secondary button-hero me-btn-reset-all">
                        Restaurar Todos para Automático
                    </button>
                </div>
                <div class="save-bar-right">
                    <span class="save-hint">Ao salvar, o cache da Home é purgado automaticamente.</span>
                </div>
            </div>
        </form>
    </div>

    <!-- ESTILOS DO PAINEL DE GESTÃO -->
    <style>
    .mercado-bento-admin-wrap {
        max-width: 1380px;
        margin: 20px 20px 50px 0;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }
    .me-admin-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #fff;
        padding: 24px 28px;
        border-radius: 12px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.05);
        margin-bottom: 24px;
        border-left: 5px solid #e31c61;
    }
    .me-admin-header h1 {
        font-size: 24px;
        font-weight: 700;
        color: #111;
        margin: 0 0 6px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .me-admin-header h1 .dashicons {
        font-size: 28px;
        width: 28px;
        height: 28px;
        color: #e31c61;
    }
    .me-admin-header .description {
        font-size: 13.5px;
        color: #555;
        margin: 0;
        max-width: 850px;
        line-height: 1.5;
    }
    .me-bento-builder-grid {
        display: grid;
        grid-template-columns: 1.35fr 1fr;
        gap: 24px;
        margin-bottom: 24px;
    }
    @media (max-width: 1080px) {
        .me-bento-builder-grid {
            grid-template-columns: 1fr;
        }
    }
    .me-slot-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.05);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        border: 1px solid #e2e8f0;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .me-slot-card:hover {
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    }
    .me-slot-badge {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 16px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        font-size: 12px;
        font-weight: 700;
        color: #334155;
    }
    .badge-icon {
        color: #e31c61;
        font-size: 14px;
    }
    .badge-num {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        height: 20px;
        background: #e31c61;
        color: #fff;
        border-radius: 50%;
        font-size: 11px;
    }
    .badge-text {
        flex: 1;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .badge-status {
        font-size: 10px;
        padding: 3px 8px;
        border-radius: 12px;
        letter-spacing: 0.3px;
        font-weight: 700;
    }
    .status-manual {
        background: #e31c61;
        color: #fff;
    }
    .status-auto {
        background: #10b981;
        color: #fff;
    }
    .me-preview-main {
        position: relative;
        min-height: 280px;
        background: #0f172a;
    }
    .preview-img {
        width: 100%;
        height: 280px;
        background-size: cover;
        background-position: center;
        position: relative;
    }
    .preview-overlay {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        padding: 20px;
        background: linear-gradient(0deg, rgba(0,0,0,0.92) 0%, rgba(0,0,0,0.4) 70%, transparent 100%);
        color: #fff;
    }
    .preview-tag {
        display: inline-block;
        background: rgba(227, 28, 97, 0.9);
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 4px;
        margin-bottom: 8px;
        text-transform: uppercase;
    }
    .preview-title {
        color: #fff;
        font-size: 18px;
        font-weight: 700;
        line-height: 1.35;
        margin: 0 0 8px 0;
    }
    .preview-meta {
        font-size: 11px;
        color: #cbd5e1;
        display: flex;
        gap: 8px;
        align-items: center;
    }
    .me-side-grid-wrapper {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    @media (max-width: 600px) {
        .me-side-grid-wrapper {
            grid-template-columns: 1fr;
        }
    }
    .me-preview-side {
        padding: 12px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }
    .side-preview-content {
        display: flex;
        gap: 12px;
        align-items: center;
    }
    .side-thumb {
        width: 65px;
        height: 65px;
        border-radius: 6px;
        background-size: cover;
        background-position: center;
        flex-shrink: 0;
        background-color: #cbd5e1;
    }
    .side-title {
        font-size: 13px;
        font-weight: 600;
        color: #0f172a;
        margin: 0 0 4px 0;
        line-height: 1.3;
    }
    .side-meta {
        font-size: 11px;
        color: #64748b;
    }
    .me-slot-controls {
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .control-label {
        font-size: 12px;
        font-weight: 600;
        color: #475569;
    }
    .search-helper-wrap {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .me-quick-search-input {
        width: 100% !important;
        font-size: 12px !important;
        padding: 6px 10px !important;
        border-radius: 6px !important;
        border: 1px solid #cbd5e1 !important;
        background: #fdfdfd !important;
    }
    .me-quick-search-input:focus {
        border-color: #e31c61 !important;
        box-shadow: 0 0 0 1px #e31c61 !important;
    }
    .me-slot-select {
        width: 100% !important;
        max-width: 100% !important;
        font-size: 12.5px !important;
        padding: 6px 8px !important;
        border-radius: 6px !important;
        border: 1px solid #cbd5e1 !important;
        font-weight: 500 !important;
    }
    .me-slot-actions {
        display: flex;
        justify-content: flex-end;
    }
    .me-btn-clear {
        color: #64748b !important;
        font-size: 11px !important;
    }
    .me-btn-clear:hover {
        color: #e31c61 !important;
    }
    .me-integration-summary {
        background: #fff;
        padding: 24px 28px;
        border-radius: 12px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.05);
        margin-bottom: 24px;
        border-top: 3px solid #10b981;
    }
    .summary-header h3 {
        font-size: 17px;
        font-weight: 700;
        margin: 0 0 6px 0;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .summary-header h3 .dashicons {
        color: #10b981;
    }
    .summary-header p {
        font-size: 13px;
        color: #64748b;
        margin: 0 0 16px 0;
    }
    .feed-sequence-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 12px;
    }
    .feed-sequence-item {
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 8px;
        padding: 12px 14px;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .seq-num {
        font-size: 10px;
        font-weight: 700;
        color: #10b981;
        text-transform: uppercase;
    }
    .seq-title {
        font-size: 12.5px;
        font-weight: 600;
        color: #1e293b;
        line-height: 1.35;
    }
    .seq-date {
        font-size: 11px;
        color: #94a3b8;
    }
    .feed-sequence-more {
        align-items: center;
        justify-content: center;
        color: #64748b;
        font-size: 12px;
        font-style: italic;
        text-align: center;
    }
    .me-save-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #1e293b;
        padding: 18px 28px;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }
    .save-bar-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .me-btn-save {
        background: #e31c61 !important;
        border-color: #c0134f !important;
        color: #fff !important;
        font-weight: 700 !important;
        font-size: 15px !important;
        padding: 6px 24px !important;
        height: auto !important;
        box-shadow: 0 4px 12px rgba(227, 28, 97, 0.4) !important;
    }
    .me-btn-save:hover {
        background: #c0134f !important;
        color: #fff !important;
    }
    .me-btn-reset-all {
        background: rgba(255,255,255,0.12) !important;
        border-color: rgba(255,255,255,0.2) !important;
        color: #e2e8f0 !important;
        font-size: 13.5px !important;
        height: auto !important;
        padding: 6px 16px !important;
    }
    .me-btn-reset-all:hover {
        background: rgba(255,255,255,0.2) !important;
        color: #fff !important;
    }
    .save-bar-right .save-hint {
        color: #94a3b8;
        font-size: 12.5px;
    }
    </style>

    <!-- SCRIPT DE INTERAÇÃO & AJAX SEARCH -->
    <script>
    jQuery(document).ready(function($) {
        // Limpar slot individual para Automático
        $('.me-btn-clear').on('click', function() {
            var targetId = $(this).data('target');
            $('#' + targetId).val('0').trigger('change');
        });

        // Restaurar Todos para Automático
        $('.me-btn-reset-all').on('click', function() {
            if (confirm('Tem certeza de que deseja redefinir todas as posições para o modo AUTOMÁTICO (mais recentes)?')) {
                $('#mercadoResetAll').val('1');
                $('#mercadoBentoForm').submit();
            }
        });

        // Busca rápida de matérias via AJAX
        var searchTimeouts = {};
        $('.me-quick-search-input').on('keyup', function() {
            var $input = $(this);
            var term = $input.val().trim();
            var targetSelectId = $input.data('target');
            var $spinner = $input.siblings('.spinner');

            clearTimeout(searchTimeouts[targetSelectId]);

            if (term.length < 2) {
                return;
            }

            searchTimeouts[targetSelectId] = setTimeout(function() {
                $spinner.addClass('is-active');

                $.ajax({
                    url: ajaxurl,
                    type: 'GET',
                    data: {
                        action: 'mercado_search_bento_posts',
                        term: term
                    },
                    success: function(response) {
                        $spinner.removeClass('is-active');
                        if (response.success && response.data && response.data.length > 0) {
                            var $select = $('#' + targetSelectId);
                            // Criar ou atualizar optgroup de busca
                            $select.find('optgroup.search-results-group').remove();
                            var $group = $('<optgroup label="Resultados da Busca (' + response.data.length + ')" class="search-results-group"></optgroup>');
                            
                            response.data.forEach(function(item) {
                                var opt = $('<option></option>')
                                    .val(item.id)
                                    .text('#' + item.id + ' — ' + item.title + ' (' + item.date + ') [Busca]');
                                $group.append(opt);
                            });

                            $select.prepend($group);
                            // Seleciona o primeiro resultado automaticamente para comodidade
                            $select.val(response.data[0].id).trigger('change');
                        }
                    },
                    error: function() {
                        $spinner.removeClass('is-active');
                    }
                });
            }, 450);
        });

        // Atualizar visual do badge quando o select muda
        $('.me-slot-select').on('change', function() {
            var val = $(this).val();
            var $card = $(this).closest('.me-slot-card');
            var $badge = $card.find('.badge-status');

            if (val === '0' || val === 0) {
                $badge.removeClass('status-manual').addClass('status-auto').text('AUTOMÁTICO');
            } else {
                $badge.removeClass('status-auto').addClass('status-manual').text('FIXADO');
            }
        });
    });
    </script>
    <?php
}
