<?php
/**
 * Plugin Name: Mercado Erótico - Gerenciador de Banners & Publicidade
 * Description: Sistema completo de gerenciamento de banners publicitários e institucionais com suporte a múltiplos slots (Home Topo IAB, Barra Lateral, Feed), agendamento, integração nativa com a Biblioteca de Mídia do WordPress e métricas de impressões e cliques.
 * Version: 1.0.0
 * Author: Equipe Portal Mercado Erótico
 */

if (!defined('ABSPATH')) exit;

/**
 * ============================================================================
 * 1. DEFINIÇÃO DE SLOTS & CONFIGURAÇÕES PADRÃO
 * ============================================================================
 */
function mercado_get_banner_slots() {
    return array(
        'home_top' => array(
            'label'       => 'Home - Topo IAB (1200x300)',
            'desc'        => 'Carrossel principal no topo da página inicial, padrão rotativo IAB.',
            'recommended' => '1200 x 300 px',
        ),
        'in_content' => array(
            'label'       => 'Artigos & Feed - Entre Blocos (1200x300 ou 728x90)',
            'desc'        => 'Exibido entre blocos de conteúdo e no meio de reportagens.',
            'recommended' => '1200 x 300 px ou 728 x 90 px',
        ),
        'sidebar' => array(
            'label'       => 'Barra Lateral - Sidebar (300x250 ou 300x600)',
            'desc'        => 'Banners verticais ou quadrados para laterais de matérias.',
            'recommended' => '300 x 250 px ou 300 x 600 px',
        ),
        'footer' => array(
            'label'       => 'Rodapé Geral - Footer Banner',
            'desc'        => 'Exibido acima do rodapé institucional do portal.',
            'recommended' => '1200 x 250 px',
        ),
    );
}

/**
 * Banners Padrão da Casa (Sementes Iniciais)
 */
function mercado_get_default_banners() {
    return array(
        'banner_anuario_2026' => array(
            'id'           => 'banner_anuario_2026',
            'title'        => 'Anuário Grandes Marcas 2026',
            'slot'         => 'home_top',
            'image'        => home_url('/wp-content/uploads/2026/11/banner_anuario_home_with_cover.png'),
            'image_mobile' => '',
            'link'         => home_url('/anuario-grandes-marcas-do-mercado-erotico-2026/'),
            'alt'          => 'Anuário Grandes Marcas do Mercado Erótico - 4ª Edição',
            'target_blank' => 0,
            'rel_attr'     => 'follow',
            'date_start'   => '',
            'date_end'     => '',
            'order'        => 1,
            'status'       => 'active',
            'created_at'   => '2026-11-01 10:00:00',
        ),
        'banner_livraria_vitrine' => array(
            'id'           => 'banner_livraria_vitrine',
            'title'        => 'Livraria Mercado Erótico - Vitrine Digital',
            'slot'         => 'home_top',
            'image'        => home_url('/wp-content/uploads/2026/11/banner_livraria_vitrine_digital.webp'),
            'image_mobile' => '',
            'link'         => home_url('/livraria/'),
            'alt'          => 'Livraria Mercado Erótico - Vitrine Digital e Conteúdos Gratuitos',
            'target_blank' => 0,
            'rel_attr'     => 'follow',
            'date_start'   => '',
            'date_end'     => '',
            'order'        => 2,
            'status'       => 'active',
            'created_at'   => '2026-11-01 10:00:00',
        ),
        'banner_guia_sexshop' => array(
            'id'           => 'banner_guia_sexshop',
            'title'        => 'Guia de Sexshop',
            'slot'         => 'home_top',
            'image'        => home_url('/wp-content/uploads/2026/11/banner_guia_de_sexshop.webp'),
            'image_mobile' => '',
            'link'         => 'https://www.guiadesexshop.com.br/',
            'alt'          => 'Guia de Sexshop - O maior buscador de sexshops do Brasil',
            'target_blank' => 1,
            'rel_attr'     => 'sponsored',
            'date_start'   => '',
            'date_end'     => '',
            'order'        => 3,
            'status'       => 'active',
            'created_at'   => '2026-11-01 10:00:00',
        ),
    );
}

/**
 * Obter todos os banners cadastrados
 */
function mercado_get_all_banners() {
    $banners = get_option('mercado_portal_banners', null);
    if ($banners === null || !is_array($banners)) {
        $banners = mercado_get_default_banners();
        update_option('mercado_portal_banners', $banners);
    }
    return $banners;
}

/**
 * Obter banners filtrados por slot e status ativo
 */
function mercado_get_banners_by_slot($slot = 'home_top') {
    $all = mercado_get_all_banners();
    $active = array();
    $today = date('Y-m-d');

    foreach ($all as $b) {
        if ($b['slot'] !== $slot) continue;
        if ($b['status'] !== 'active') continue;

        // Validação de período de agendamento (se preenchido)
        if (!empty($b['date_start']) && $today < $b['date_start']) continue;
        if (!empty($b['date_end']) && $today > $b['date_end']) continue;

        $active[] = $b;
    }

    // Ordenar por campo 'order' ascendente
    usort($active, function($a, $b) {
        $oa = isset($a['order']) ? intval($a['order']) : 10;
        $ob = isset($b['order']) ? intval($b['order']) : 10;
        return $oa - $ob;
    });

    return $active;
}

/**
 * Métricas de Estatísticas (Views & Clicks)
 */
function mercado_get_banner_stats() {
    $stats = get_option('mercado_banner_stats', array());
    return is_array($stats) ? $stats : array();
}

function mercado_increment_banner_view($banner_id) {
    if (empty($banner_id) || is_admin()) return;
    $stats = mercado_get_banner_stats();
    if (!isset($stats[$banner_id])) {
        $stats[$banner_id] = array('views' => 0, 'clicks' => 0);
    }
    $stats[$banner_id]['views']++;
    update_option('mercado_banner_stats', $stats, false);
}

function mercado_increment_banner_click($banner_id) {
    if (empty($banner_id)) return;
    $stats = mercado_get_banner_stats();
    if (!isset($stats[$banner_id])) {
        $stats[$banner_id] = array('views' => 0, 'clicks' => 0);
    }
    $stats[$banner_id]['clicks']++;
    update_option('mercado_banner_stats', $stats, false);
}

/**
 * AJAX Endpoint para Registro de Clique Sem Atrasar Navegação
 */
add_action('wp_ajax_mercado_banner_click', 'mercado_ajax_banner_click');
add_action('wp_ajax_nopriv_mercado_banner_click', 'mercado_ajax_banner_click');
function mercado_ajax_banner_click() {
    $banner_id = isset($_POST['banner_id']) ? sanitize_key($_POST['banner_id']) : '';
    if (!empty($banner_id)) {
        mercado_increment_banner_click($banner_id);
    }
    wp_send_json_success(array('tracked' => true));
}

/**
 * ============================================================================
 * 2. FRONT-END: RENDERIZADOR DE SLOTS DE BANNERS
 * ============================================================================
 */
function mercado_render_banners_slot($slot = 'home_top', $echo = true) {
    $banners = mercado_get_banners_by_slot($slot);

    // Se não houver banner ativo no slot, se for 'home_top', usa fallback padrão
    if (empty($banners)) {
        if ($slot === 'home_top') {
            $banners = mercado_get_default_banners();
        } else {
            return '';
        }
    }

    // Contabilizar impressões de cada banner ativo exibido
    foreach ($banners as $b) {
        mercado_increment_banner_view($b['id']);
    }

    $total_banners = count($banners);
    ob_start();
    ?>
    <div class="me-ad-standard-container" id="meStandardAdContainer" data-slot="<?php echo esc_attr($slot); ?>">
        <div class="ad-standard-header">
            <span class="ad-standard-badge"><i class="fas fa-bullhorn"></i> PUBLICIDADE</span>
            <a href="<?php echo esc_url(home_url('/contato/')); ?>" class="ad-standard-mediakit">Anuncie no Portal <i class="fas fa-angle-right"></i></a>
        </div>
        <div class="ad-standard-track">
            <?php foreach ($banners as $i => $b): 
                $target = !empty($b['target_blank']) ? 'target="_blank"' : '';
                $rel_parts = array('noopener');
                if (!empty($b['target_blank'])) $rel_parts[] = 'noreferrer';
                if (!empty($b['rel_attr']) && $b['rel_attr'] === 'sponsored') $rel_parts[] = 'sponsored';
                elseif (!empty($b['rel_attr']) && $b['rel_attr'] === 'nofollow') $rel_parts[] = 'nofollow';
                $rel = implode(' ', $rel_parts);
            ?>
                <div class="ad-standard-slide <?php echo $i === 0 ? 'active' : ''; ?>" data-banner-id="<?php echo esc_attr($b['id']); ?>">
                    <a href="<?php echo esc_url($b['link']); ?>" <?php echo $target; ?> rel="<?php echo esc_attr($rel); ?>" title="<?php echo esc_attr($b['title']); ?>" onclick="mercadoTrackAdClick('<?php echo esc_js($b['id']); ?>')">
                        <picture>
                            <?php if (!empty($b['image_mobile'])): ?>
                                <source media="(max-width: 600px)" srcset="<?php echo esc_url($b['image_mobile']); ?>">
                            <?php endif; ?>
                            <img src="<?php echo esc_url($b['image']); ?>" alt="<?php echo esc_attr(!empty($b['alt']) ? $b['alt'] : $b['title']); ?>" class="ad-img-standard" width="1200" height="300" loading="<?php echo $i === 0 ? 'eager' : 'lazy'; ?>">
                        </picture>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if ($total_banners > 1): ?>
            <div class="ad-standard-dots" id="adStandardDots">
                <?php for ($d = 0; $d < $total_banners; $d++): ?>
                    <button type="button" class="ad-dot <?php echo $d === 0 ? 'active' : ''; ?>" onclick="goToAdBanner(<?php echo $d; ?>)" aria-label="Banner <?php echo ($d + 1); ?>"></button>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Script de Tracking e Rotação Suave -->
    <script>
    function mercadoTrackAdClick(bannerId) {
        if (!bannerId) return;
        const ajaxUrl = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
        const formData = new FormData();
        formData.append('action', 'mercado_banner_click');
        formData.append('banner_id', bannerId);

        if (navigator.sendBeacon) {
            navigator.sendBeacon(ajaxUrl, formData);
        } else {
            fetch(ajaxUrl, { method: 'POST', body: formData, keepalive: true }).catch(function(){});
        }
    }
    </script>
    <?php
    $output = ob_get_clean();

    if ($echo) {
        echo $output;
    } else {
        return $output;
    }
}

/**
 * Shortcode Global: [mercado_banner slot="home_top"]
 */
add_shortcode('mercado_banner', 'mercado_banner_shortcode');
function mercado_banner_shortcode($atts) {
    $a = shortcode_atts(array(
        'slot' => 'home_top',
        'id'   => '',
    ), $atts, 'mercado_banner');

    if (!empty($a['id'])) {
        $all = mercado_get_all_banners();
        if (isset($all[$a['id']]) && $all[$a['id']]['status'] === 'active') {
            $b = $all[$a['id']];
            mercado_increment_banner_view($b['id']);
            $target = !empty($b['target_blank']) ? 'target="_blank"' : '';
            return '<div class="me-banner-single" data-banner-id="' . esc_attr($b['id']) . '">
                <a href="' . esc_url($b['link']) . '" ' . $target . ' title="' . esc_attr($b['title']) . '" onclick="mercadoTrackAdClick(\'' . esc_js($b['id']) . '\')">
                    <img src="' . esc_url($b['image']) . '" alt="' . esc_attr($b['title']) . '" class="me-banner-img" loading="lazy">
                </a>
            </div>';
        }
        return '';
    }

    return mercado_render_banners_slot($a['slot'], false);
}

/**
 * ============================================================================
 * 3. PAINEL ADMINISTRATIVO NO WORDPRESS (WP ADMIN)
 * ============================================================================
 */
add_action('admin_menu', 'mercado_banners_register_menu');
function mercado_banners_register_menu() {
    $hook = add_menu_page(
        'Banners & Publicidade',
        'Banners & Anúncios',
        'manage_options',
        'mercado-banners',
        'mercado_banners_render_admin_page',
        'dashicons-megaphone',
        29
    );

    // Carregar wp.media apenas na página do gerenciador de banners
    add_action('admin_print_scripts-' . $hook, function() {
        wp_enqueue_media();
    });
}

/**
 * Processamento de Ações do Admin (Salvar, Excluir, Alternar Status, Zerar Métricas)
 */
add_action('admin_init', 'mercado_banners_handle_actions');
function mercado_banners_handle_actions() {
    if (!current_user_can('manage_options')) return;

    // A. Salvar / Editar Banner
    if (isset($_POST['mercado_banner_action']) && $_POST['mercado_banner_action'] === 'save_banner') {
        check_admin_referer('mercado_banner_save_verify', 'mercado_banner_nonce');

        $banners = mercado_get_all_banners();
        $id = !empty($_POST['banner_id']) ? sanitize_key($_POST['banner_id']) : 'banner_' . time();

        $image_url = esc_url_raw(trim($_POST['banner_image']));
        $image_mobile = esc_url_raw(trim($_POST['banner_image_mobile']));
        $link_url = esc_url_raw(trim($_POST['banner_link']));

        if (empty($image_url)) {
            wp_redirect(admin_url('admin.php?page=mercado-banners&err=missing_image'));
            exit;
        }

        $banners[$id] = array(
            'id'           => $id,
            'title'        => sanitize_text_field($_POST['banner_title']),
            'slot'         => sanitize_key($_POST['banner_slot']),
            'image'        => $image_url,
            'image_mobile' => $image_mobile,
            'link'         => $link_url,
            'alt'          => sanitize_text_field($_POST['banner_alt']),
            'target_blank' => isset($_POST['banner_target_blank']) ? 1 : 0,
            'rel_attr'     => sanitize_key($_POST['banner_rel']),
            'date_start'   => sanitize_text_field($_POST['banner_date_start']),
            'date_end'     => sanitize_text_field($_POST['banner_date_end']),
            'order'        => intval($_POST['banner_order']),
            'status'       => sanitize_key($_POST['banner_status']),
            'updated_at'   => current_time('mysql'),
        );

        update_option('mercado_portal_banners', $banners);
        wp_redirect(admin_url('admin.php?page=mercado-banners&msg=saved'));
        exit;
    }

    // B. Alternar Status (Ativar / Pausar)
    if (isset($_GET['action']) && $_GET['action'] === 'toggle_status' && isset($_GET['banner_id'])) {
        check_admin_referer('toggle_banner_' . $_GET['banner_id']);
        $banners = mercado_get_all_banners();
        $id = sanitize_key($_GET['banner_id']);

        if (isset($banners[$id])) {
            $banners[$id]['status'] = ($banners[$id]['status'] === 'active') ? 'paused' : 'active';
            update_option('mercado_portal_banners', $banners);
        }
        wp_redirect(admin_url('admin.php?page=mercado-banners&msg=status_updated'));
        exit;
    }

    // C. Excluir Banner
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['banner_id'])) {
        check_admin_referer('delete_banner_' . $_GET['banner_id']);
        $banners = mercado_get_all_banners();
        $id = sanitize_key($_GET['banner_id']);

        if (isset($banners[$id])) {
            unset($banners[$id]);
            update_option('mercado_portal_banners', $banners);
        }
        wp_redirect(admin_url('admin.php?page=mercado-banners&msg=deleted'));
        exit;
    }

    // D. Zerar Estatísticas de um Banner
    if (isset($_GET['action']) && $_GET['action'] === 'reset_stats' && isset($_GET['banner_id'])) {
        check_admin_referer('reset_stats_' . $_GET['banner_id']);
        $stats = mercado_get_banner_stats();
        $id = sanitize_key($_GET['banner_id']);

        if (isset($stats[$id])) {
            $stats[$id] = array('views' => 0, 'clicks' => 0);
            update_option('mercado_banner_stats', $stats);
        }
        wp_redirect(admin_url('admin.php?page=mercado-banners&msg=stats_reset'));
        exit;
    }

    // E. Restaurar Banners Padrão da Casa
    if (isset($_POST['mercado_banner_action']) && $_POST['mercado_banner_action'] === 'reset_defaults') {
        check_admin_referer('mercado_banner_reset_verify', 'mercado_reset_nonce');
        update_option('mercado_portal_banners', mercado_get_default_banners());
        wp_redirect(admin_url('admin.php?page=mercado-banners&msg=reset_done'));
        exit;
    }
}

/**
 * Render da Tela Administrativa
 */
function mercado_banners_render_admin_page() {
    $banners = mercado_get_all_banners();
    $slots   = mercado_get_banner_slots();
    $stats   = mercado_get_banner_stats();

    // Filtro por Slot atual
    $current_slot_filter = isset($_GET['filter_slot']) ? sanitize_key($_GET['filter_slot']) : 'all';

    // Edição de Banner
    $editing_banner = null;
    if (isset($_GET['edit_banner'])) {
        $edit_id = sanitize_key($_GET['edit_banner']);
        if (isset($banners[$edit_id])) {
            $editing_banner = $banners[$edit_id];
        }
    }

    // Cálculos Gerais de Métricas
    $total_active = 0;
    $total_views = 0;
    $total_clicks = 0;

    foreach ($banners as $b) {
        if ($b['status'] === 'active') $total_active++;
        $bid = $b['id'];
        if (isset($stats[$bid])) {
            $total_views += isset($stats[$bid]['views']) ? intval($stats[$bid]['views']) : 0;
            $total_clicks += isset($stats[$bid]['clicks']) ? intval($stats[$bid]['clicks']) : 0;
        }
    }
    $global_ctr = ($total_views > 0) ? round(($total_clicks / $total_views) * 100, 2) : 0;
    ?>
    <div class="wrap me-banners-admin">
        <h1 class="wp-heading-inline">
            <span class="dashicons dashicons-megaphone" style="font-size:28px;width:28px;height:28px;color:#e31c61;margin-right:8px;"></span>
            Gerenciador de Banners &amp; Publicidade
        </h1>
        <a href="<?php echo admin_url('admin.php?page=mercado-banners'); ?>#banner-form" class="page-title-action button-primary">
            + Novo Banner
        </a>
        <hr class="wp-header-end">

        <!-- Mensagens de Feedback -->
        <?php if (isset($_GET['msg'])): ?>
            <?php if ($_GET['msg'] === 'saved'): ?>
                <div class="notice notice-success is-dismissible"><p><strong>Sucesso:</strong> Banner salvo e publicado com sucesso!</p></div>
            <?php elseif ($_GET['msg'] === 'deleted'): ?>
                <div class="notice notice-warning is-dismissible"><p><strong>Aviso:</strong> Banner excluído com sucesso.</p></div>
            <?php elseif ($_GET['msg'] === 'status_updated'): ?>
                <div class="notice notice-info is-dismissible"><p><strong>Status Atualizado:</strong> O status do banner foi modificado.</p></div>
            <?php elseif ($_GET['msg'] === 'stats_reset'): ?>
                <div class="notice notice-info is-dismissible"><p><strong>Métricas Zeradas:</strong> As visualizações e cliques deste banner foram resetados.</p></div>
            <?php elseif ($_GET['msg'] === 'reset_done'): ?>
                <div class="notice notice-info is-dismissible"><p><strong>Restaurado:</strong> Os 3 banners padrão do portal foram restaurados com sucesso.</p></div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (isset($_GET['err']) && $_GET['err'] === 'missing_image'): ?>
            <div class="notice notice-error is-dismissible"><p><strong>Erro:</strong> Você precisa informar ou selecionar uma imagem para o banner.</p></div>
        <?php endif; ?>

        <!-- Cards de Estatísticas Gerais (KPIs) -->
        <div class="me-kpi-bar">
            <div class="me-kpi-card">
                <span class="kpi-icon"><i class="dashicons dashicons-images-alt2"></i></span>
                <div>
                    <strong class="kpi-value"><?php echo $total_active; ?> / <?php echo count($banners); ?></strong>
                    <span class="kpi-label">Banners Ativos</span>
                </div>
            </div>
            <div class="me-kpi-card">
                <span class="kpi-icon"><i class="dashicons dashicons-visibility"></i></span>
                <div>
                    <strong class="kpi-value"><?php echo number_format($total_views, 0, ',', '.'); ?></strong>
                    <span class="kpi-label">Visualizações Totais</span>
                </div>
            </div>
            <div class="me-kpi-card">
                <span class="kpi-icon"><i class="dashicons dashicons-external"></i></span>
                <div>
                    <strong class="kpi-value" style="color:#e31c61;"><?php echo number_format($total_clicks, 0, ',', '.'); ?></strong>
                    <span class="kpi-label">Cliques Registrados</span>
                </div>
            </div>
            <div class="me-kpi-card">
                <span class="kpi-icon"><i class="dashicons dashicons-chart-pie"></i></span>
                <div>
                    <strong class="kpi-value" style="color:#10b981;"><?php echo $global_ctr; ?>%</strong>
                    <span class="kpi-label">Taxa de Clique Média (CTR)</span>
                </div>
            </div>
        </div>

        <!-- Layout 2 Colunas: Lista à Esquerda | Formulário à Direita -->
        <div class="me-admin-grid">
            <!-- Coluna Principal: Lista de Banners -->
            <div class="me-main-col">
                <div class="postbox">
                    <div class="postbox-header me-card-header">
                        <h2><span class="dashicons dashicons-list-view"></span> Banners Cadastrados no Portal</h2>
                        
                        <!-- Filtros por Slot -->
                        <div class="me-slot-filters">
                            <a href="<?php echo admin_url('admin.php?page=mercado-banners&filter_slot=all'); ?>" class="button button-small <?php echo $current_slot_filter === 'all' ? 'button-primary' : ''; ?>">Todos (<?php echo count($banners); ?>)</a>
                            <?php foreach ($slots as $sk => $sinfo): 
                                $cnt = 0;
                                foreach ($banners as $b) { if ($b['slot'] === $sk) $cnt++; }
                            ?>
                                <a href="<?php echo admin_url('admin.php?page=mercado-banners&filter_slot=' . esc_attr($sk)); ?>" class="button button-small <?php echo $current_slot_filter === $sk ? 'button-primary' : ''; ?>">
                                    <?php echo esc_html($sinfo['label']); ?> (<?php echo $cnt; ?>)
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="inside" style="padding:0;">
                        <table class="wp-list-table widefat fixed striped me-banners-table">
                            <thead>
                                <tr>
                                    <th style="width:130px;">Preview</th>
                                    <th>Título &amp; Destino</th>
                                    <th style="width:140px;">Posição / Slot</th>
                                    <th style="width:110px;text-align:center;">Métricas (CTR)</th>
                                    <th style="width:90px;text-align:center;">Status</th>
                                    <th style="width:140px;text-align:right;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $has_displayed = false;
                                foreach ($banners as $b):
                                    if ($current_slot_filter !== 'all' && $b['slot'] !== $current_slot_filter) continue;
                                    $has_displayed = true;
                                    $bid = $b['id'];
                                    $bviews = isset($stats[$bid]['views']) ? intval($stats[$bid]['views']) : 0;
                                    $bclicks = isset($stats[$bid]['clicks']) ? intval($stats[$bid]['clicks']) : 0;
                                    $bctr = ($bviews > 0) ? round(($bclicks / $bviews) * 100, 1) : 0;
                                    $slot_label = isset($slots[$b['slot']]['label']) ? $slots[$b['slot']]['label'] : $b['slot'];
                                ?>
                                    <tr>
                                        <!-- Preview -->
                                        <td>
                                            <a href="<?php echo esc_url($b['image']); ?>" target="_blank" class="me-thumb-link" title="Ver imagem ampliada">
                                                <img src="<?php echo esc_url($b['image']); ?>" alt="<?php echo esc_attr($b['title']); ?>" class="me-admin-thumb">
                                            </a>
                                        </td>
                                        <!-- Título & Link -->
                                        <td>
                                            <strong><?php echo esc_html($b['title']); ?></strong>
                                            <div class="me-link-preview">
                                                <i class="dashicons dashicons-admin-links"></i>
                                                <a href="<?php echo esc_url($b['link']); ?>" target="_blank" rel="noopener noreferrer">
                                                    <?php echo esc_html($b['link']); ?>
                                                </a>
                                            </div>
                                            <small style="color:#64748b;">Ordem: <code><?php echo intval($b['order']); ?></code> | Rel: <code><?php echo esc_html($b['rel_attr']); ?></code></small>
                                        </td>
                                        <!-- Posição -->
                                        <td>
                                            <span class="me-slot-badge slot-<?php echo esc_attr($b['slot']); ?>">
                                                <?php echo esc_html($slot_label); ?>
                                            </span>
                                        </td>
                                        <!-- Métricas -->
                                        <td style="text-align:center;">
                                            <strong style="color:#e31c61;font-size:14px;"><?php echo $bclicks; ?></strong> <small>cliques</small><br>
                                            <small style="color:#64748b;"><?php echo number_format($bviews, 0, ',', '.'); ?> views</small><br>
                                            <span class="me-ctr-tag"><?php echo $bctr; ?>% CTR</span>
                                        </td>
                                        <!-- Status -->
                                        <td style="text-align:center;">
                                            <?php if ($b['status'] === 'active'): ?>
                                                <span class="me-status-pill status-active">● Ativo</span>
                                            <?php else: ?>
                                                <span class="me-status-pill status-paused">○ Pausado</span>
                                            <?php endif; ?>
                                        </td>
                                        <!-- Ações -->
                                        <td style="text-align:right;">
                                            <a href="<?php echo admin_url('admin.php?page=mercado-banners&edit_banner=' . esc_attr($bid)); ?>#banner-form" class="button button-small" title="Editar">
                                                Editar
                                            </a>
                                            <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=mercado-banners&action=toggle_status&banner_id=' . esc_attr($bid)), 'toggle_banner_' . $bid); ?>" class="button button-small" title="<?php echo $b['status'] === 'active' ? 'Pausar Banner' : 'Ativar Banner'; ?>">
                                                <?php echo $b['status'] === 'active' ? 'Pausar' : 'Ativar'; ?>
                                            </a>
                                            <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=mercado-banners&action=delete&banner_id=' . esc_attr($bid)), 'delete_banner_' . $bid); ?>" class="button button-small button-link-delete" onclick="return confirm('Deseja realmente excluir este banner?');" title="Excluir">
                                                ×
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if (!$has_displayed): ?>
                                    <tr>
                                        <td colspan="6" style="text-align:center;padding:30px;color:#64748b;">
                                            Nenhum banner cadastrado nesta posição. Use o formulário ao lado para cadastrar.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Info Box sobre Shortcode -->
                <div class="postbox">
                    <div class="inside" style="padding:16px 20px;">
                        <h4 style="margin:0 0 8px;"><span class="dashicons dashicons-editor-code"></span> Como usar em qualquer página ou widget:</h4>
                        <p style="margin:0 0 6px;color:#475569;">Você pode inserir qualquer slot de banner no Elementor, Gutenberg ou texto de artigos com o shortcode:</p>
                        <code>[mercado_banner slot="home_top"]</code> &nbsp;ou&nbsp; <code>[mercado_banner slot="in_content"]</code> &nbsp;ou&nbsp; <code>[mercado_banner slot="sidebar"]</code>
                    </div>
                </div>
            </div>

            <!-- Coluna Lateral: Formulário de Cadastro / Edição -->
            <div class="me-side-col" id="banner-form">
                <div class="postbox" style="border-top:3px solid #e31c61;">
                    <div class="postbox-header">
                        <h2>
                            <?php if ($editing_banner): ?>
                                <span class="dashicons dashicons-edit"></span> Editar Banner: <em><?php echo esc_html($editing_banner['title']); ?></em>
                            <?php else: ?>
                                <span class="dashicons dashicons-plus-alt"></span> Cadastrar Novo Banner
                            <?php endif; ?>
                        </h2>
                    </div>
                    <div class="inside">
                        <form method="post" action="">
                            <?php wp_nonce_field('mercado_banner_save_verify', 'mercado_banner_nonce'); ?>
                            <input type="hidden" name="mercado_banner_action" value="save_banner">
                            <input type="hidden" name="banner_id" value="<?php echo $editing_banner ? esc_attr($editing_banner['id']) : ''; ?>">

                            <!-- Título -->
                            <p>
                                <label><strong>Título / Nome do Anunciante:</strong></label><br>
                                <input type="text" name="banner_title" value="<?php echo $editing_banner ? esc_attr($editing_banner['title']) : ''; ?>" placeholder="Ex: Campanha Primavera / Anuário 2026" class="widefat" required>
                            </p>

                            <!-- Posição / Slot -->
                            <p>
                                <label><strong>Posição de Exibição (Slot):</strong></label><br>
                                <select name="banner_slot" class="widefat" required>
                                    <?php foreach ($slots as $sk => $sinfo): 
                                        $selected = ($editing_banner && $editing_banner['slot'] === $sk) ? 'selected' : '';
                                    ?>
                                        <option value="<?php echo esc_attr($sk); ?>" <?php echo $selected; ?>>
                                            <?php echo esc_html($sinfo['label']); ?> (Recomendado: <?php echo esc_html($sinfo['recommended']); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </p>

                            <!-- Imagem Desktop (Integrada com wp.media) -->
                            <p>
                                <label><strong>Imagem do Banner (Desktop):</strong></label><br>
                                <div style="display:flex;gap:8px;">
                                    <input type="url" id="banner_image_input" name="banner_image" value="<?php echo $editing_banner ? esc_attr($editing_banner['image']) : ''; ?>" placeholder="https://..." class="widefat" required>
                                    <button type="button" class="button" onclick="openMediaUploader('banner_image_input', 'banner_preview')">
                                        <span class="dashicons dashicons-admin-media" style="vertical-align:middle;"></span> Escolher
                                    </button>
                                </div>
                                <small style="color:#64748b;">Clique em <strong>Escolher</strong> para enviar uma nova arte ou selecionar da Biblioteca de Mídia.</small>
                                <div id="banner_preview" style="margin-top:8px;">
                                    <?php if ($editing_banner && !empty($editing_banner['image'])): ?>
                                        <img src="<?php echo esc_url($editing_banner['image']); ?>" style="max-width:100%;height:auto;border-radius:6px;border:1px solid #e2e8f0;">
                                    <?php endif; ?>
                                </div>
                            </p>

                            <!-- Imagem Mobile Opcional -->
                            <p>
                                <label><strong>Imagem Mobile (Opcional - para telas de celular):</strong></label><br>
                                <div style="display:flex;gap:8px;">
                                    <input type="url" id="banner_mobile_input" name="banner_image_mobile" value="<?php echo $editing_banner ? esc_attr($editing_banner['image_mobile']) : ''; ?>" placeholder="https://..." class="widefat">
                                    <button type="button" class="button" onclick="openMediaUploader('banner_mobile_input', 'banner_mobile_preview')">
                                        Escolher
                                    </button>
                                </div>
                                <div id="banner_mobile_preview" style="margin-top:6px;">
                                    <?php if ($editing_banner && !empty($editing_banner['image_mobile'])): ?>
                                        <img src="<?php echo esc_url($editing_banner['image_mobile']); ?>" style="max-width:100%;height:auto;border-radius:6px;border:1px solid #e2e8f0;">
                                    <?php endif; ?>
                                </div>
                            </p>

                            <!-- Link de Destino -->
                            <p>
                                <label><strong>Link de Destino (URL ao clicar):</strong></label><br>
                                <input type="url" name="banner_link" value="<?php echo $editing_banner ? esc_attr($editing_banner['link']) : ''; ?>" placeholder="https://seusite.com.br ou /pagina/" class="widefat" required>
                            </p>

                            <!-- Texto Alternativo (Alt Text) -->
                            <p>
                                <label><strong>Texto Alternativo (Alt / Acessibilidade / SEO):</strong></label><br>
                                <input type="text" name="banner_alt" value="<?php echo $editing_banner ? esc_attr($editing_banner['alt']) : ''; ?>" placeholder="Descrição da imagem para leitores de tela" class="widefat">
                            </p>

                            <!-- Opções de Link -->
                            <div style="background:#f8fafc;padding:12px;border-radius:6px;border:1px solid #e2e8f0;margin-bottom:15px;">
                                <label style="display:block;margin-bottom:6px;">
                                    <input type="checkbox" name="banner_target_blank" value="1" <?php echo ($editing_banner && !empty($editing_banner['target_blank'])) ? 'checked' : ''; ?>>
                                    Abrir link em nova aba (<code>target="_blank"</code>)
                                </label>
                                <label style="display:block;margin-bottom:4px;"><strong>Relação de SEO (rel):</strong></label>
                                <select name="banner_rel" class="widefat">
                                    <option value="follow" <?php echo ($editing_banner && $editing_banner['rel_attr'] === 'follow') ? 'selected' : ''; ?>>Padrão / Institucional (follow)</option>
                                    <option value="sponsored" <?php echo ($editing_banner && $editing_banner['rel_attr'] === 'sponsored') ? 'selected' : ''; ?>>Patrocinado Oficial (rel="sponsored")</option>
                                    <option value="nofollow" <?php echo ($editing_banner && $editing_banner['rel_attr'] === 'nofollow') ? 'selected' : ''; ?>>Não Seguir Link (rel="nofollow")</option>
                                </select>
                            </div>

                            <!-- Ordem e Status -->
                            <div style="display:flex;gap:12px;margin-bottom:15px;">
                                <div style="flex:1;">
                                    <label><strong>Ordem / Posição:</strong></label>
                                    <input type="number" name="banner_order" value="<?php echo $editing_banner ? intval($editing_banner['order']) : 1; ?>" class="widefat" min="1" max="99">
                                </div>
                                <div style="flex:1;">
                                    <label><strong>Status:</strong></label>
                                    <select name="banner_status" class="widefat">
                                        <option value="active" <?php echo ($editing_banner && $editing_banner['status'] === 'active') ? 'selected' : ''; ?>>Ativo (Visível)</option>
                                        <option value="paused" <?php echo ($editing_banner && $editing_banner['status'] === 'paused') ? 'selected' : ''; ?>>Pausado (Oculto)</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Agendamento Opcional -->
                            <div style="background:#f8fafc;padding:12px;border-radius:6px;border:1px solid #e2e8f0;margin-bottom:15px;">
                                <label style="display:block;margin-bottom:4px;"><strong>Período de Veiculação (Opcional):</strong></label>
                                <div style="display:flex;gap:8px;">
                                    <div style="flex:1;">
                                        <small style="color:#64748b;">Data Início:</small>
                                        <input type="date" name="banner_date_start" value="<?php echo $editing_banner ? esc_attr($editing_banner['date_start']) : ''; ?>" class="widefat">
                                    </div>
                                    <div style="flex:1;">
                                        <small style="color:#64748b;">Data Término:</small>
                                        <input type="date" name="banner_date_end" value="<?php echo $editing_banner ? esc_attr($editing_banner['date_end']) : ''; ?>" class="widefat">
                                    </div>
                                </div>
                            </div>

                            <!-- Botões de Ação -->
                            <p style="margin:0;">
                                <button type="submit" class="button button-primary button-large" style="width:100%;">
                                    <span class="dashicons <?php echo $editing_banner ? 'dashicons-update' : 'dashicons-saved'; ?>" style="vertical-align:middle;"></span>
                                    <?php echo $editing_banner ? 'Atualizar Banner' : 'Publicar Banner'; ?>
                                </button>
                                <?php if ($editing_banner): ?>
                                    <a href="<?php echo admin_url('admin.php?page=mercado-banners'); ?>" class="button button-secondary" style="width:100%;margin-top:8px;text-align:center;display:block;">
                                        Cancelar Edição
                                    </a>
                                <?php endif; ?>
                            </p>
                        </form>
                    </div>
                </div>

                <!-- Restaurar Banners Padrão -->
                <div class="postbox">
                    <div class="postbox-header">
                        <h2><span class="dashicons dashicons-image-rotate"></span> Restaurar Banners Originais</h2>
                    </div>
                    <div class="inside">
                        <p style="font-size:12px;color:#64748b;margin:0 0 10px;">Restaura os 3 banners originais da redação (Anuário 2026, Livraria e Guia de Sexshop).</p>
                        <form method="post" action="" onsubmit="return confirm('Atenção: Os banners atuais serão redefinidos para os 3 originais da casa. Deseja continuar?');">
                            <?php wp_nonce_field('mercado_banner_reset_verify', 'mercado_reset_nonce'); ?>
                            <input type="hidden" name="mercado_banner_action" value="reset_defaults">
                            <button type="submit" class="button button-secondary" style="width:100%;">
                                Restaurar 3 Banners Padrão
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts do Media Uploader nativo do WP -->
    <script>
    function openMediaUploader(targetInputId, previewContainerId) {
        let mediaUploader = wp.media({
            title: 'Selecionar Imagem do Banner',
            button: { text: 'Usar esta Imagem' },
            multiple: false
        });

        mediaUploader.on('select', function() {
            let attachment = mediaUploader.state().get('selection').first().toJSON();
            document.getElementById(targetInputId).value = attachment.url;
            if (previewContainerId) {
                document.getElementById(previewContainerId).innerHTML = '<img src="' + attachment.url + '" style="max-width:100%;height:auto;border-radius:6px;border:1px solid #e2e8f0;margin-top:6px;">';
            }
        });

        mediaUploader.open();
    }
    </script>

    <style>
    .me-banners-admin {
        max-width: 1400px;
        margin-top: 20px;
    }
    .me-kpi-bar {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 15px;
        margin: 20px 0 25px;
    }
    .me-kpi-card {
        background: #fff;
        border: 1px solid #c3c4c7;
        border-radius: 8px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .me-kpi-card .kpi-icon {
        width: 44px;
        height: 44px;
        background: #fdf2f6;
        color: #e31c61;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }
    .me-kpi-card .kpi-value {
        display: block;
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
    }
    .me-kpi-card .kpi-label {
        font-size: 12px;
        color: #64748b;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    .me-admin-grid {
        display: flex;
        gap: 25px;
        align-items: flex-start;
    }
    .me-main-col {
        flex: 1 1 65%;
        min-width: 0;
    }
    .me-side-col {
        flex: 1 1 35%;
        min-width: 320px;
    }
    .me-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        padding: 12px 18px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }
    .me-card-header h2 {
        font-size: 14px;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .me-slot-filters {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }
    .me-banners-table td {
        vertical-align: middle;
    }
    .me-admin-thumb {
        width: 110px;
        height: 48px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        display: block;
    }
    .me-link-preview {
        font-size: 12px;
        color: #64748b;
        margin-top: 3px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .me-link-preview a {
        color: #3b82f6 !important;
        text-decoration: none;
        max-width: 250px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        display: inline-block;
    }
    .me-slot-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 700;
        background: #f1f5f9;
        color: #334155;
        border: 1px solid #e2e8f0;
    }
    .me-slot-badge.slot-home_top {
        background: #e0f2fe;
        color: #0369a1;
        border-color: #bae6fd;
    }
    .me-slot-badge.slot-in_content {
        background: #fef3c7;
        color: #b45309;
        border-color: #fde68a;
    }
    .me-slot-badge.slot-sidebar {
        background: #f3e8ff;
        color: #7e22ce;
        border-color: #e9d5ff;
    }
    .me-ctr-tag {
        display: inline-block;
        background: #ecfdf5;
        color: #047857;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 4px;
        border: 1px solid #a7f3d0;
        margin-top: 2px;
    }
    .me-status-pill {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
    }
    .status-active {
        background: #dcfce7;
        color: #15803d;
    }
    .status-paused {
        background: #f1f5f9;
        color: #64748b;
    }
    @media (max-width: 960px) {
        .me-admin-grid {
            flex-direction: column;
        }
        .me-side-col {
            width: 100%;
        }
    }
    </style>
    <?php
}
