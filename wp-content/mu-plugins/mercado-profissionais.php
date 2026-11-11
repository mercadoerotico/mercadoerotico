<?php
/**
 * Plugin Name: Mercado Erótico - Guia de Profissionais
 * Description: Sistema administrativo completo para gerenciar o diretório de profissionais, terapeutas e sexólogos especializados.
 * Version: 2.0.0
 * Author: Equipe Portal Mercado Erótico
 */

if (!defined('ABSPATH')) exit;

/**
 * 1. DADOS PADRÃO (INITIAL PROFESSIONALS LIST)
 */
function mercado_get_default_profissionais_items() {
    return [
        [
            'id'          => 'alyne-meirelles',
            'name'        => 'Alyne Meirelles',
            'specialty'   => 'Sexóloga & Educadora Sexual',
            'image'       => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2020/04/WhatsApp-Image-2020-04-07-at-16.51.19-1-300x293.jpeg',
            'bio'         => 'Mestranda em Sexualidade Humana, Pós-graduada em Terapia Sexual e palestrante das principais feiras do setor. Presta consultoria a sex shops, consultores e atendimento clínico individual.',
            'instagram'   => 'https://www.instagram.com/alyne.meirelles',
            'insta_label' => '@alyne.meirelles',
            'email'       => 'falecom@alynemeirelles.com.br',
            'whatsapp'    => '',
            'website'     => '',
            'phone'       => '',
            'active'      => true
        ],
        [
            'id'          => 'andreia-salustiano',
            'name'        => 'Andreia Salustiano',
            'specialty'   => 'Pompoarismo & Terapia Breve (PNL)',
            'image'       => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2020/04/IMG-20200403-WA0028-293x300.jpg',
            'bio'         => 'Ajuda mulheres a desenvolverem prazer, libido e autoestima através de (Re)Educação Sexual, Ginástica Íntima e PNL. Atendimentos com sigilo, ética e sensibilidade.',
            'instagram'   => 'https://www.instagram.com/andreia_mulherliderdesi',
            'insta_label' => '@andreia_mulherliderdesi',
            'email'       => '',
            'whatsapp'    => '',
            'website'     => '',
            'phone'       => '',
            'active'      => true
        ],
        [
            'id'          => 'diego-zahori',
            'name'        => 'Diego Zahori (Diego Sampaio)',
            'specialty'   => 'Psicólogo & Terapeuta Tântrico',
            'image'       => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2020/04/WhatsApp-Image-2020-03-22-at-15.36.16-300x300.jpeg',
            'bio'         => 'Psicólogo com pós-graduação em Sexualidade Humana Aplicada e Terapia Tântrica. Atua auxiliando pessoas a superarem bloqueios e julgamentos para vivenciarem relações plenas e saudáveis.',
            'instagram'   => 'https://www.instagram.com/psi_diegosampaio',
            'insta_label' => '@psi_diegosampaio',
            'whatsapp'    => '5519978236302',
            'email'       => '',
            'website'     => '',
            'phone'       => '',
            'active'      => true
        ],
        [
            'id'          => 'fatima-mourah',
            'name'        => 'Fátima Mourah',
            'specialty'   => 'Eventos Femininos & Consultoria Sensual',
            'image'       => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2020/04/20952916_1478934835506474_442912303442649816_n.jpg',
            'bio'         => 'Pioneira em palestras e encontros femininos, fundadora da Chá de Lingerie Oficial. Especialista em empoderamento, dinâmicas de casal e eventos sensuais corporativos.',
            'instagram'   => 'https://www.instagram.com/chadelingerie_oficial',
            'insta_label' => '@chadelingerie_oficial',
            'whatsapp'    => '5511993294324',
            'email'       => '',
            'website'     => '',
            'phone'       => '',
            'active'      => true
        ],
        [
            'id'          => 'karina-brum',
            'name'        => 'Karina Brum',
            'specialty'   => 'Psicóloga & Sexóloga Clínica',
            'image'       => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2025/04/WhatsApp-Image-2025-04-05-at-14.10.21-256x300.jpeg',
            'bio'         => 'Atendimento psicológico e sexológico com foco em inteligência emocional, resolução de conflitos conjugais e desmistificação do prazer feminino.',
            'instagram'   => 'https://www.instagram.com/karinabrumoficial/',
            'insta_label' => '@karinabrumoficial',
            'whatsapp'    => '5511964920033',
            'email'       => '',
            'website'     => '',
            'phone'       => '',
            'active'      => true
        ],
        [
            'id'          => 'katia-arruda',
            'name'        => 'Kátia Arruda',
            'specialty'   => 'Especialista em Sexualidade (Abrasex)',
            'image'       => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2020/04/WhatsApp-Image-2020-12-07-at-12.51.34-225x300.jpeg',
            'bio'         => 'Filiada à Abrasex, atua no desenvolvimento pessoal e conjugal com workshops, cursos e atendimentos para autoconhecimento íntimo e quebra de tabus.',
            'instagram'   => 'https://www.instagram.com/katiaarrudaoficial',
            'insta_label' => '@katiaarrudaoficial',
            'whatsapp'    => '5561986531333',
            'email'       => '',
            'website'     => '',
            'phone'       => '',
            'active'      => true
        ],
        [
            'id'          => 'neusa-pandolfo',
            'name'        => 'Neusa Pandolfo',
            'specialty'   => 'Educadora Sexual & Palestrante',
            'image'       => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2026/11/neusa_pandolfo_avatar.webp',
            'bio'         => 'Publicitária formada pela Unisinos e pós-graduada em Educação Sexual pela Unisal-SP. Palestrante e consultora de renome nacional com passagens pela TV (Amor & Sexo na Globo), especialista em autoestima, intimidade, comunicação de casais e quebra de tabus.',
            'instagram'   => 'https://www.instagram.com/neusapandolfo/',
            'insta_label' => '@neusapandolfo',
            'website'     => 'https://neusapandolfo.com.br/',
            'whatsapp'    => '5551999690009',
            'email'       => '',
            'phone'       => '',
            'active'      => true
        ],
        [
            'id'          => 'lucimara-siqueira',
            'name'        => 'Lucimara Siqueira (Lu Pompoar)',
            'specialty'   => 'Fisioterapia Pélvica & Pompoarismo',
            'image'       => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2021/06/lu-pompoar.jpg',
            'bio'         => 'Referência internacional em pompoarismo e ginástica íntima. Pós-graduada em Terapia Sexual e Saúde da Mulher, criadora de método exclusivo com milhares de alunas formadas.',
            'instagram'   => 'https://www.instagram.com/lupompoar/',
            'insta_label' => '@lupompoar',
            'whatsapp'    => '5511986368294',
            'email'       => '',
            'website'     => '',
            'phone'       => '',
            'active'      => true
        ],
        [
            'id'          => 'pablo-cruz',
            'name'        => 'Pablo Cruz (Pablito)',
            'specialty'   => 'Expressão Corporal & Stiletto Dance',
            'image'       => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2021/06/WhatsApp-Image-2021-06-19-at-15.45.04-1024x1024.jpeg',
            'bio'         => 'Bailarino profissional e professor de dança no salto (Stiletto) e jazz musical. Conduz vivências corporais voltadas para sensualidade, postura e autoconfiança.',
            'instagram'   => 'https://www.instagram.com/pablituou',
            'insta_label' => '@pablituou',
            'whatsapp'    => '5521968298282',
            'email'       => '',
            'website'     => '',
            'phone'       => '',
            'active'      => true
        ],
        [
            'id'          => 'rani-muniz',
            'name'        => 'Rani Muniz',
            'specialty'   => 'Sexóloga Humana & Terapia Sexual',
            'image'       => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2024/06/sXZpwjyQR0CjItUIVuBX_N66CQpWT7bFQec09.webp',
            'bio'         => 'Pós-graduada em Sexologia Humana e Terapia Sexual. Dedica-se a desmistificar a sexualidade com leveza, embasamento científico e respeito à diversidade.',
            'instagram'   => 'https://www.instagram.com/rani.muniz',
            'insta_label' => '@rani.muniz',
            'whatsapp'    => '5521970204899',
            'email'       => '',
            'website'     => '',
            'phone'       => '',
            'active'      => true
        ],
        [
            'id'          => 'thiago-souza',
            'name'        => 'Thiago Souza',
            'specialty'   => 'Personal Dancer & Sexy Dance',
            'image'       => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2020/04/thiago-souza-personal-dancer-quarentena.png',
            'bio'         => 'Criador de metodologia de dança sensual voltada para mulheres reais. Ensina a liberar a sensualidade natural e elevar a autoestima através da dança e do movimento.',
            'instagram'   => 'https://www.instagram.com/thiagosouza_academy/',
            'insta_label' => '@thiagosouza_academy',
            'whatsapp'    => '5521966898787',
            'email'       => '',
            'website'     => '',
            'phone'       => '',
            'active'      => true
        ],
        [
            'id'          => 'dra-vivian-santana',
            'name'        => 'Dra. Vivian Santana',
            'specialty'   => 'Fisioterapeuta Pélvica & Menopausa',
            'image'       => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2021/07/WhatsApp-Image-2021-07-10-at-19.32.06.jpeg',
            'bio'         => 'Especialista em reabilitação do assoalho pélvico e sexualidade feminina há mais de 10 anos. Conscientiza mulheres sobre climatério, menopausa e prevenção de disfunções sexuais.',
            'instagram'   => 'https://www.instagram.com/dra_vivian_santana',
            'insta_label' => '@dra_vivian_santana',
            'phone'       => '(11) 4723-8590',
            'whatsapp'    => '',
            'email'       => '',
            'website'     => '',
            'active'      => true
        ]
    ];
}

/**
 * 2. STORAGE / RETRIEVAL
 */
function mercado_get_profissionais_items() {
    $items = get_option('mercado_profissionais_items', null);
    if (!is_array($items) || empty($items)) {
        $items = mercado_get_default_profissionais_items();
        update_option('mercado_profissionais_items', $items);
    }
    return $items;
}

/**
 * 3. ADMIN SCRIPTS & ASSETS (Media Uploader)
 */
add_action('admin_enqueue_scripts', function($hook) {
    if (strpos($hook, 'mercado-profissionais') !== false) {
        wp_enqueue_media();
    }
});

/**
 * 4. ADMIN MENU
 */
add_action('admin_menu', function() {
    add_menu_page(
        'Guia de Profissionais',
        'Profissionais',
        'manage_options',
        'mercado-profissionais',
        'mercado_profissionais_admin_page',
        'dashicons-groups',
        30
    );
});

/**
 * 5. ADMIN DASHBOARD PAGE
 */
function mercado_profissionais_admin_page() {
    if (!current_user_can('manage_options')) return;

    $items = mercado_get_profissionais_items();
    $message = '';
    $message_type = 'success';
    $editing_item = null;

    // Handle POST Actions
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Reset defaults
        if (isset($_POST['mercado_prof_action']) && $_POST['mercado_prof_action'] === 'reset_defaults') {
            check_admin_referer('mercado_prof_reset_verify', 'mercado_prof_nonce');
            $items = mercado_get_default_profissionais_items();
            update_option('mercado_profissionais_items', $items);
            if (function_exists('wp_cache_flush')) wp_cache_flush();
            do_action('litespeed_purge_all');
            $message = 'Lista de profissionais restaurada para o padrão com sucesso!';
        }
        // Save (Add or Edit)
        elseif (isset($_POST['mercado_prof_action']) && $_POST['mercado_prof_action'] === 'save_item') {
            check_admin_referer('mercado_prof_save_verify', 'mercado_prof_nonce');

            $name = sanitize_text_field($_POST['name'] ?? '');
            $specialty = sanitize_text_field($_POST['specialty'] ?? '');
            $image = esc_url_raw($_POST['image'] ?? '');
            $bio = sanitize_textarea_field($_POST['bio'] ?? '');
            $instagram = esc_url_raw($_POST['instagram'] ?? '');
            $insta_label = sanitize_text_field($_POST['insta_label'] ?? '');
            $whatsapp = preg_replace('/[^0-9]/', '', $_POST['whatsapp'] ?? '');
            $website = esc_url_raw($_POST['website'] ?? '');
            $phone = sanitize_text_field($_POST['phone'] ?? '');
            $email = sanitize_email($_POST['email'] ?? '');
            $active = !empty($_POST['active']);

            if (empty($insta_label) && !empty($instagram)) {
                $path = trim(parse_url($instagram, PHP_URL_PATH) ?? '', '/');
                $insta_label = $path ? '@' . $path : '@perfil';
            }

            if (!empty($name)) {
                $item_id = sanitize_key($_POST['item_id'] ?? '');
                if (empty($item_id)) {
                    $item_id = sanitize_title($name) . '-' . substr(md5(uniqid()), 0, 5);
                }

                $new_item = [
                    'id'          => $item_id,
                    'name'        => $name,
                    'specialty'   => $specialty,
                    'image'       => $image,
                    'bio'         => $bio,
                    'instagram'   => $instagram,
                    'insta_label' => $insta_label,
                    'whatsapp'    => $whatsapp,
                    'website'     => $website,
                    'phone'       => $phone,
                    'email'       => $email,
                    'active'      => $active
                ];

                $found = false;
                foreach ($items as $k => $existing) {
                    if (($existing['id'] ?? '') === $item_id) {
                        $items[$k] = $new_item;
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    array_unshift($items, $new_item);
                    $message = 'Profissional "' . esc_html($name) . '" cadastrado com sucesso!';
                } else {
                    $message = 'Dados de "' . esc_html($name) . '" atualizados com sucesso!';
                }

                update_option('mercado_profissionais_items', $items);
                if (function_exists('wp_cache_flush')) wp_cache_flush();
                do_action('litespeed_purge_all');
            } else {
                $message = 'Por favor, preencha ao menos o Nome do profissional.';
                $message_type = 'error';
            }
        }
        // Delete
        elseif (isset($_POST['mercado_prof_action']) && $_POST['mercado_prof_action'] === 'delete_item') {
            check_admin_referer('mercado_prof_del_verify', 'mercado_prof_nonce');
            $del_id = sanitize_key($_POST['delete_id'] ?? '');

            $deleted_name = '';
            foreach ($items as $k => $it) {
                if (($it['id'] ?? '') === $del_id) {
                    $deleted_name = $it['name'] ?? 'Profissional';
                    unset($items[$k]);
                    break;
                }
            }

            $items = array_values($items);
            update_option('mercado_profissionais_items', $items);
            if (function_exists('wp_cache_flush')) wp_cache_flush();
            do_action('litespeed_purge_all');
            $message = 'Profissional "' . esc_html($deleted_name) . '" removido com sucesso!';
        }
        // Toggle Active/Inactive
        elseif (isset($_POST['mercado_prof_action']) && $_POST['mercado_prof_action'] === 'toggle_active') {
            check_admin_referer('mercado_prof_toggle_verify', 'mercado_prof_nonce');
            $toggle_id = sanitize_key($_POST['toggle_id'] ?? '');

            foreach ($items as $k => $it) {
                if (($it['id'] ?? '') === $toggle_id) {
                    $curr = !isset($it['active']) || $it['active'];
                    $items[$k]['active'] = !$curr;
                    $message = 'Status de "' . esc_html($it['name']) . '" alterado para ' . ($items[$k]['active'] ? 'Ativo' : 'Inativo') . '!';
                    break;
                }
            }

            update_option('mercado_profissionais_items', $items);
            if (function_exists('wp_cache_flush')) wp_cache_flush();
            do_action('litespeed_purge_all');
        }
    }

    // Check Edit GET
    if (isset($_GET['action']) && $_GET['action'] === 'edit' && !empty($_GET['id'])) {
        $edit_id = sanitize_key($_GET['id']);
        foreach ($items as $it) {
            if (($it['id'] ?? '') === $edit_id) {
                $editing_item = $it;
                break;
            }
        }
    }

    $total_items = count($items);
    $active_items = count(array_filter($items, function($it) {
        return !isset($it['active']) || $it['active'];
    }));
    ?>
    <div class="wrap me-prof-admin">
        <h1 class="wp-heading-inline">
            <span class="dashicons dashicons-groups" style="font-size:28px; width:28px; height:28px; vertical-align:middle; margin-right:8px; color:#e31c61;"></span>
            Guia de Profissionais &bull; Painel de Gerenciamento
        </h1>
        <hr class="wp-header-end">

        <?php if (!empty($message)): ?>
            <div class="notice notice-<?php echo esc_attr($message_type); ?> is-dismissible" style="margin-top:15px;">
                <p><strong><?php echo $message; ?></strong></p>
            </div>
        <?php endif; ?>

        <!-- Stats Bar -->
        <div class="me-prof-stats-bar">
            <div class="stat-card">
                <span class="stat-num"><?php echo $total_items; ?></span>
                <span class="stat-lbl">Total Cadastrados</span>
            </div>
            <div class="stat-card">
                <span class="stat-num" style="color:#10b981;"><?php echo $active_items; ?></span>
                <span class="stat-lbl">Ativos no Guia</span>
            </div>
            <div class="stat-card">
                <span class="stat-num" style="color:#64748b;"><?php echo ($total_items - $active_items); ?></span>
                <span class="stat-lbl">Pausados / Inativos</span>
            </div>
            <div class="stat-card stat-integration">
                <span class="stat-lbl">Página Integrada:</span>
                <a href="<?php echo esc_url(home_url('/profissionais-especialistas-em-sexualidade/')); ?>" target="_blank" class="button button-secondary">
                    Ver Página Pública <span class="dashicons dashicons-external" style="vertical-align:middle; font-size:16px;"></span>
                </a>
            </div>
        </div>

        <div class="me-prof-layout">
            <!-- Formulário (Esquerda) -->
            <div class="me-prof-form-col">
                <div class="me-admin-box">
                    <h2 class="box-title">
                        <?php echo $editing_item ? '✏️ Editar Profissional' : '➕ Adicionar Novo Profissional'; ?>
                    </h2>
                    
                    <form method="post" action="<?php echo esc_url(admin_url('admin.php?page=mercado-profissionais')); ?>" id="profForm">
                        <?php wp_nonce_field('mercado_prof_save_verify', 'mercado_prof_nonce'); ?>
                        <input type="hidden" name="mercado_prof_action" value="save_item">
                        <input type="hidden" name="item_id" value="<?php echo esc_attr($editing_item['id'] ?? ''); ?>">

                        <p>
                            <label for="prof_name"><strong>Nome Completo *</strong></label>
                            <input type="text" name="name" id="prof_name" class="widefat" required 
                                   value="<?php echo esc_attr($editing_item['name'] ?? ''); ?>" 
                                   placeholder="Ex: Dra. Juliana Ferreira">
                        </p>

                        <p>
                            <label for="prof_specialty"><strong>Especialidade / Título Profissional *</strong></label>
                            <input type="text" name="specialty" id="prof_specialty" class="widefat" required 
                                   value="<?php echo esc_attr($editing_item['specialty'] ?? ''); ?>" 
                                   placeholder="Ex: Fisioterapeuta Pélvica & Sexóloga Clínica">
                        </p>

                        <p>
                            <label for="prof_image"><strong>Foto do Profissional (URL ou Galeria)</strong></label>
                            <div style="display:flex; gap:8px;">
                                <input type="url" name="image" id="prof_image" class="widefat" 
                                       value="<?php echo esc_url($editing_item['image'] ?? ''); ?>" 
                                       placeholder="https://.../foto.jpg">
                                <button type="button" class="button button-secondary" id="btnUploadImage">
                                    Escolher Imagem
                                </button>
                            </div>
                            <small class="description">Recomendado foto quadrada ou retrato (mínimo 300x300px).</small>
                        </p>

                        <div id="image_preview_wrap" style="margin: 10px 0; <?php echo empty($editing_item['image']) ? 'display:none;' : ''; ?>">
                            <img id="image_preview" src="<?php echo esc_url($editing_item['image'] ?? ''); ?>" 
                                 style="width:70px; height:70px; border-radius:50%; object-fit:cover; border:2px solid #e31c61;">
                        </div>

                        <p>
                            <label for="prof_bio"><strong>Minibiografia / Resumo Profissional</strong></label>
                            <textarea name="bio" id="prof_bio" class="widefat" rows="4" 
                                      placeholder="Descreva a formação, especialidades, abordagem e histórico de atuação..."><?php echo esc_textarea($editing_item['bio'] ?? ''); ?></textarea>
                        </p>

                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                            <p>
                                <label for="prof_instagram"><strong>Instagram (URL Completa)</strong></label>
                                <input type="url" name="instagram" id="prof_instagram" class="widefat" 
                                       value="<?php echo esc_url($editing_item['instagram'] ?? ''); ?>" 
                                       placeholder="https://www.instagram.com/usuario">
                            </p>
                            <p>
                                <label for="prof_insta_label"><strong>@ Usuário no Instagram</strong></label>
                                <input type="text" name="insta_label" id="prof_insta_label" class="widefat" 
                                       value="<?php echo esc_attr($editing_item['insta_label'] ?? ''); ?>" 
                                       placeholder="@usuario">
                            </p>
                        </div>

                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                            <p>
                                <label for="prof_whatsapp"><strong>WhatsApp (com DDD, apenas números)</strong></label>
                                <input type="text" name="whatsapp" id="prof_whatsapp" class="widefat" 
                                       value="<?php echo esc_attr($editing_item['whatsapp'] ?? ''); ?>" 
                                       placeholder="Ex: 5511999999999">
                            </p>
                            <p>
                                <label for="prof_phone"><strong>Telefone Fixo / Comercial</strong></label>
                                <input type="text" name="phone" id="prof_phone" class="widefat" 
                                       value="<?php echo esc_attr($editing_item['phone'] ?? ''); ?>" 
                                       placeholder="Ex: (11) 4723-8590">
                            </p>
                        </div>

                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                            <p>
                                <label for="prof_website"><strong>Site Oficial</strong></label>
                                <input type="url" name="website" id="prof_website" class="widefat" 
                                       value="<?php echo esc_url($editing_item['website'] ?? ''); ?>" 
                                       placeholder="https://meusite.com.br">
                            </p>
                            <p>
                                <label for="prof_email"><strong>E-mail de Contato</strong></label>
                                <input type="email" name="email" id="prof_email" class="widefat" 
                                       value="<?php echo esc_attr($editing_item['email'] ?? ''); ?>" 
                                       placeholder="contato@especialista.com">
                            </p>
                        </div>

                        <p style="margin-top:15px;">
                            <label>
                                <input type="checkbox" name="active" value="1" <?php checked(!isset($editing_item['active']) || $editing_item['active']); ?>>
                                <strong>Exibir profissional no Guia Público (Ativo)</strong>
                            </label>
                        </p>

                        <div style="margin-top:20px; display:flex; gap:10px;">
                            <button type="submit" class="button button-primary button-large" style="background:#e31c61; border-color:#c41652;">
                                <?php echo $editing_item ? '💾 Atualizar Profissional' : '➕ Adicionar ao Guia'; ?>
                            </button>
                            <?php if ($editing_item): ?>
                                <a href="<?php echo esc_url(admin_url('admin.php?page=mercado-profissionais')); ?>" class="button button-secondary button-large">
                                    Cancelar Edição
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>

                <div class="me-admin-box" style="margin-top:20px; border-left: 4px solid #f59e0b;">
                    <h3 style="margin-top:0;">⚠️ Restaurar Acervo Original</h3>
                    <p style="color:#64748b; font-size:13px;">Caso queira restaurar os 12 profissionais padrão originais do portal, utilize o botão abaixo:</p>
                    <form method="post" action="<?php echo esc_url(admin_url('admin.php?page=mercado-profissionais')); ?>" onsubmit="return confirm('ATENÇÃO: Isso restaurará a lista original de 12 profissionais. Deseja continuar?');">
                        <?php wp_nonce_field('mercado_prof_reset_verify', 'mercado_prof_nonce'); ?>
                        <input type="hidden" name="mercado_prof_action" value="reset_defaults">
                        <button type="submit" class="button button-link-delete">
                            Restaurar 12 Profissionais Padrão
                        </button>
                    </form>
                </div>
            </div>

            <!-- Tabela de Profissionais (Direita) -->
            <div class="me-prof-table-col">
                <div class="me-admin-box">
                    <h2 class="box-title">
                        📋 Profissionais Cadastrados (<?php echo $total_items; ?>)
                    </h2>

                    <?php if (empty($items)): ?>
                        <p style="color:#64748b; font-style:italic;">Nenhum profissional cadastrado no momento.</p>
                    <?php else: ?>
                        <table class="wp-list-table widefat fixed striped">
                            <thead>
                                <tr>
                                    <th style="width:60px;">Foto</th>
                                    <th>Profissional & Especialidade</th>
                                    <th style="width:160px;">Contatos</th>
                                    <th style="width:90px; text-align:center;">Status</th>
                                    <th style="width:180px; text-align:right;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $it): 
                                    $is_active = !isset($it['active']) || $it['active'];
                                    $img_src = !empty($it['image']) ? $it['image'] : 'https://placehold.co/100x100?text=Sem+Foto';
                                ?>
                                    <tr>
                                        <td>
                                            <img src="<?php echo esc_url($img_src); ?>" 
                                                 alt="<?php echo esc_attr($it['name']); ?>" 
                                                 style="width:48px; height:48px; border-radius:50%; object-fit:cover; border:2px solid #e2e8f0;">
                                        </td>
                                        <td>
                                            <strong style="font-size:14px; color:#1e293b;"><?php echo esc_html($it['name']); ?></strong>
                                            <br>
                                            <span style="display:inline-block; font-size:11px; font-weight:700; color:#e31c61; background:#fdf2f4; padding:2px 8px; border-radius:10px; margin-top:3px;">
                                                <?php echo esc_html($it['specialty']); ?>
                                            </span>
                                            <div style="font-size:12px; color:#64748b; margin-top:4px; max-height:36px; overflow:hidden; text-overflow:ellipsis;">
                                                <?php echo esc_html(wp_trim_words($it['bio'] ?? '', 12)); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="display:flex; flex-wrap:wrap; gap:4px;">
                                                <?php if (!empty($it['instagram'])): ?>
                                                    <a href="<?php echo esc_url($it['instagram']); ?>" target="_blank" class="contact-pill ig" title="Instagram">
                                                        <i class="dashicons dashicons-instagram"></i> IG
                                                    </a>
                                                <?php endif; ?>
                                                <?php if (!empty($it['whatsapp'])): ?>
                                                    <a href="https://api.whatsapp.com/send?phone=<?php echo esc_attr($it['whatsapp']); ?>" target="_blank" class="contact-pill wpp" title="WhatsApp">
                                                        <i class="dashicons dashicons-whatsapp"></i> WPP
                                                    </a>
                                                <?php endif; ?>
                                                <?php if (!empty($it['website'])): ?>
                                                    <a href="<?php echo esc_url($it['website']); ?>" target="_blank" class="contact-pill web" title="Site">
                                                        <i class="dashicons dashicons-admin-site"></i> Web
                                                    </a>
                                                <?php endif; ?>
                                                <?php if (!empty($it['phone'])): ?>
                                                    <span class="contact-pill tel" title="Tel: <?php echo esc_attr($it['phone']); ?>">
                                                        <i class="dashicons dashicons-phone"></i> Tel
                                                    </span>
                                                <?php endif; ?>
                                                <?php if (!empty($it['email'])): ?>
                                                    <span class="contact-pill mail" title="Email: <?php echo esc_attr($it['email']); ?>">
                                                        <i class="dashicons dashicons-email"></i> Email
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td style="text-align:center;">
                                            <?php if ($is_active): ?>
                                                <span class="status-badge active">Ativo</span>
                                            <?php else: ?>
                                                <span class="status-badge inactive">Inativo</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="text-align:right;">
                                            <div style="display:flex; justify-content:flex-end; gap:6px; align-items:center;">
                                                <!-- Editar -->
                                                <a href="<?php echo esc_url(admin_url('admin.php?page=mercado-profissionais&action=edit&id=' . urlencode($it['id']))); ?>" 
                                                   class="button button-small">
                                                    Editar
                                                </a>

                                                <!-- Pausar / Ativar -->
                                                <form method="post" action="<?php echo esc_url(admin_url('admin.php?page=mercado-profissionais')); ?>" style="display:inline;">
                                                    <?php wp_nonce_field('mercado_prof_toggle_verify', 'mercado_prof_nonce'); ?>
                                                    <input type="hidden" name="mercado_prof_action" value="toggle_active">
                                                    <input type="hidden" name="toggle_id" value="<?php echo esc_attr($it['id']); ?>">
                                                    <button type="submit" class="button button-small" title="<?php echo $is_active ? 'Pausar exibição' : 'Ativar exibição'; ?>">
                                                        <?php echo $is_active ? '⏸️' : '▶️'; ?>
                                                    </button>
                                                </form>

                                                <!-- Excluir -->
                                                <form method="post" action="<?php echo esc_url(admin_url('admin.php?page=mercado-profissionais')); ?>" style="display:inline;"
                                                      onsubmit="return confirm('Deseja realmente remover <?php echo esc_js($it['name']); ?> do guia?');">
                                                    <?php wp_nonce_field('mercado_prof_del_verify', 'mercado_prof_nonce'); ?>
                                                    <input type="hidden" name="mercado_prof_action" value="delete_item">
                                                    <input type="hidden" name="delete_id" value="<?php echo esc_attr($it['id']); ?>">
                                                    <button type="submit" class="button button-small button-link-delete" style="color:#ef4444;">
                                                        Excluir
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Script WP Media & Interatividade -->
    <script>
    jQuery(document).ready(function($) {
        var mediaUploader;
        $('#btnUploadImage').click(function(e) {
            e.preventDefault();
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }
            mediaUploader = wp.media({
                title: 'Selecionar Foto do Profissional',
                button: { text: 'Usar esta foto' },
                multiple: false
            });
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                $('#prof_image').val(attachment.url);
                $('#image_preview').attr('src', attachment.url);
                $('#image_preview_wrap').show();
            });
            mediaUploader.open();
        });

        $('#prof_image').on('input', function() {
            var url = $(this).val();
            if (url) {
                $('#image_preview').attr('src', url);
                $('#image_preview_wrap').show();
            } else {
                $('#image_preview_wrap').hide();
            }
        });
    });
    </script>

    <style>
    .me-prof-admin {
        margin-top: 20px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }
    .me-prof-stats-bar {
        display: flex;
        gap: 16px;
        margin: 20px 0;
        flex-wrap: wrap;
    }
    .stat-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 14px 22px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
        min-width: 130px;
    }
    .stat-num {
        font-size: 24px;
        font-weight: 800;
        color: #1e293b;
        line-height: 1.2;
    }
    .stat-lbl {
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        margin-top: 2px;
    }
    .stat-card.stat-integration {
        margin-left: auto;
        justify-content: center;
        align-items: flex-end;
    }
    .me-prof-layout {
        display: flex;
        gap: 24px;
        align-items: flex-start;
    }
    .me-prof-form-col {
        flex: 0 0 380px;
        max-width: 380px;
    }
    .me-prof-table-col {
        flex: 1;
        min-width: 0;
    }
    .me-admin-box {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 22px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .box-title {
        margin: 0 0 18px;
        font-size: 17px;
        font-weight: 700;
        color: #0f172a;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }
    .status-badge {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 700;
    }
    .status-badge.active {
        background: #dcfce7;
        color: #15803d;
    }
    .status-badge.inactive {
        background: #f1f5f9;
        color: #64748b;
    }
    .contact-pill {
        display: inline-flex;
        align-items: center;
        gap: 2px;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 4px;
        text-decoration: none;
    }
    .contact-pill.ig { background: #fdf2f8; color: #db2777; }
    .contact-pill.wpp { background: #ecfdf5; color: #059669; }
    .contact-pill.web { background: #eff6ff; color: #2563eb; }
    .contact-pill.tel { background: #f8fafc; color: #475569; border: 1px solid #e2e8f0; }
    .contact-pill.mail { background: #fefce8; color: #ca8a04; }
    .contact-pill i { font-size: 12px; width: 12px; height: 12px; }
    @media (max-width: 1080px) {
        .me-prof-layout { flex-direction: column; }
        .me-prof-form-col { flex: 1 1 100%; max-width: 100%; }
        .stat-card.stat-integration { margin-left: 0; }
    }
    </style>
    <?php
}

/**
 * 6. SHORTCODE PÚBLICO [mercado_profissionais]
 */
function mercado_profissionais_shortcode() {
    $all_items = mercado_get_profissionais_items();
    $professionals = array_filter($all_items, function($it) {
        return !isset($it['active']) || $it['active'];
    });

    ob_start();
    ?>
    <div class="prof-wrapper">
        <div class="prof-hero">
            <div class="prof-badge">★ GUIA DE ESPECIALISTAS & SAÚDE ÍNTIMA</div>
            <h1 class="prof-title">Profissionais Especialistas em Sexualidade</h1>
            <p class="prof-subtitle">Conheça terapeutas sexuais, psicólogos, fisioterapeutas pélvicos e educadores corporais de referência para atendimentos, consultorias e palestras.</p>
            
            <div class="prof-stats-bar">
                <span><i class="fas fa-user-check"></i> Especialistas Certificados</span>
                <span>&bull;</span>
                <span><i class="fas fa-lock"></i> Ética & Sigilo Profissional</span>
                <span>&bull;</span>
                <span><i class="fas fa-globe-americas"></i> Atendimento Presencial & Online</span>
            </div>
        </div>

        <?php if (empty($professionals)): ?>
            <div style="text-align:center; padding:50px 20px; background:#fff; border-radius:16px; border:1px solid #eaeaea;">
                <p style="color:#64748b; font-size:1.1rem; margin:0;">Nenhum profissional listado no momento.</p>
            </div>
        <?php else: ?>
            <div class="prof-grid">
                <?php foreach ($professionals as $p): 
                    $img_src = !empty($p['image']) ? $p['image'] : 'https://placehold.co/300x300?text=Profissional';
                ?>
                    <div class="prof-card">
                        <div class="prof-card-top">
                            <div class="prof-avatar-wrap">
                                <img src="<?php echo esc_url($img_src); ?>" alt="<?php echo esc_attr($p['name']); ?>" class="prof-avatar" loading="lazy">
                            </div>
                            <span class="prof-specialty-badge"><?php echo esc_html($p['specialty']); ?></span>
                            <h3 class="prof-name"><?php echo esc_html($p['name']); ?></h3>
                        </div>

                        <div class="prof-card-body">
                            <p class="prof-bio"><?php echo esc_html($p['bio']); ?></p>
                        </div>

                        <div class="prof-card-footer">
                            <?php if (!empty($p['instagram'])): ?>
                                <a href="<?php echo esc_url($p['instagram']); ?>" target="_blank" rel="noopener noreferrer" class="btn-prof-insta">
                                    <i class="fab fa-instagram"></i> <?php echo esc_html(!empty($p['insta_label']) ? $p['insta_label'] : '@instagram'); ?>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($p['website'])): ?>
                                <a href="<?php echo esc_url($p['website']); ?>" target="_blank" rel="noopener noreferrer" class="btn-prof-web" title="Visitar Site Oficial">
                                    <i class="fas fa-globe"></i>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($p['whatsapp'])): ?>
                                <a href="https://api.whatsapp.com/send?phone=<?php echo esc_attr($p['whatsapp']); ?>&text=Ol%C3%A1%2C+encontrei+seu+perfil+no+Portal+Mercado+Er%C3%B3tico" target="_blank" rel="noopener" class="btn-prof-wpp" title="Conversar no WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            <?php elseif (!empty($p['phone'])): ?>
                                <a href="tel:<?php echo esc_attr($p['phone']); ?>" class="btn-prof-wpp" title="Ligar">
                                    <i class="fas fa-phone"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <style>
    .prof-wrapper {
        max-width: 1240px;
        margin: 0 auto;
        padding: 10px 20px 80px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }
    .prof-hero {
        background: radial-gradient(circle at 50% 30%, #1f1122 0%, #0d0612 100%);
        border-radius: 20px;
        padding: 50px 30px;
        text-align: center;
        color: #fff;
        margin-bottom: 45px;
        border: 1px solid rgba(227, 28, 97, 0.25);
        box-shadow: 0 15px 35px rgba(0,0,0,0.25);
    }
    .prof-badge {
        display: inline-block;
        background: linear-gradient(135deg, #e31c61, #9c1543);
        color: #fff;
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 1.5px;
        padding: 5px 16px;
        border-radius: 30px;
        margin-bottom: 15px;
    }
    .prof-title {
        font-size: 2.4rem;
        font-weight: 900;
        color: #fff;
        margin: 0 0 12px;
        line-height: 1.25;
    }
    .prof-subtitle {
        font-size: 1.1rem;
        color: #d1c7d4;
        max-width: 750px;
        margin: 0 auto 25px;
        line-height: 1.6;
    }
    .prof-stats-bar {
        display: flex;
        justify-content: center;
        gap: 20px;
        font-size: 0.88rem;
        color: #e31c61;
        font-weight: 600;
        flex-wrap: wrap;
    }
    .prof-stats-bar span i { margin-right: 6px; }
    .prof-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 28px;
    }
    .prof-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #eaeaea;
        box-shadow: 0 6px 20px rgba(0,0,0,0.04);
        display: flex;
        flex-direction: column;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        padding: 30px 24px 24px;
        text-align: center;
    }
    .prof-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 14px 30px rgba(0,0,0,0.1);
        border-color: #ddd;
    }
    .prof-avatar-wrap {
        width: 110px;
        height: 110px;
        margin: 0 auto 16px;
        border-radius: 50%;
        overflow: hidden;
        border: 4px solid #fff;
        box-shadow: 0 6px 18px rgba(227, 28, 97, 0.25);
        background: #f0f0f5;
    }
    .prof-avatar {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .prof-specialty-badge {
        display: inline-block;
        background: #fdf2f4;
        color: #e31c61;
        font-size: 0.75rem;
        font-weight: 800;
        padding: 4px 12px;
        border-radius: 20px;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .prof-name {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1a1a1a;
        margin: 0 0 14px;
        line-height: 1.3;
    }
    .prof-bio {
        font-size: 0.9rem;
        color: #666;
        line-height: 1.6;
        margin: 0 0 20px;
        flex-grow: 1;
        text-align: left;
    }
    .prof-card-footer {
        display: flex;
        align-items: center;
        gap: 10px;
        border-top: 1px solid #f0f0f0;
        padding-top: 18px;
        margin-top: auto;
    }
    .btn-prof-insta {
        flex-grow: 1;
        background: #f8f8fb;
        color: #333;
        border: 1px solid #e2e2ec;
        padding: 9px 14px;
        border-radius: 25px;
        font-size: 0.85rem;
        font-weight: 700;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
    }
    .btn-prof-insta:hover {
        background: #e31c61;
        color: #fff;
        border-color: #e31c61;
    }
    .btn-prof-web {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #2563eb;
        color: #fff !important;
        display: flex;
        justify-content: center;
        align-items: center;
        text-decoration: none !important;
        font-size: 1rem;
        flex-shrink: 0;
        transition: transform 0.2s, background 0.2s;
    }
    .btn-prof-web:hover {
        background: #1d4ed8;
        transform: scale(1.08);
        color: #fff !important;
    }
    .btn-prof-wpp {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #10b981;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        text-decoration: none;
        font-size: 1.1rem;
        flex-shrink: 0;
        transition: transform 0.2s, background 0.2s;
    }
    .btn-prof-wpp:hover {
        background: #059669;
        transform: scale(1.08);
        color: #fff;
    }
    @media (max-width: 768px) {
        .prof-title { font-size: 1.8rem; }
        .prof-grid { grid-template-columns: 1fr; }
    }
    </style>
    <?php
    return ob_get_clean();
}
add_shortcode('mercado_profissionais', 'mercado_profissionais_shortcode');
