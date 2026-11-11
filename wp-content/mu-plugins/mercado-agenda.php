<?php
/**
 * Plugin Name: Mercado Erótico - Agenda Global & Inscrição de Eventos
 * Description: Sistema automatizado de Agenda de Eventos do Mercado Erótico Mundial com submissão pública e moderação administrativa.
 * Version: 1.2.0
 * Author: Equipe Portal Mercado Erótico
 */

if (!defined('ABSPATH')) exit;

// 1. REGISTRO DO POST TYPE E TAXONOMIAS
add_action('init', 'me_agenda_register_post_type');
function me_agenda_register_post_type() {
    $labels = array(
        'name'               => 'Agenda de Eventos',
        'singular_name'      => 'Evento',
        'menu_name'          => 'Agenda de Eventos',
        'name_admin_bar'     => 'Evento da Agenda',
        'add_new'            => 'Adicionar Evento',
        'add_new_item'       => 'Adicionar Novo Evento',
        'new_item'           => 'Novo Evento',
        'edit_item'          => 'Editar Evento',
        'view_item'          => 'Ver Evento',
        'all_items'          => 'Todos os Eventos',
        'search_items'       => 'Buscar Eventos',
        'not_found'          => 'Nenhum evento encontrado.',
        'not_found_in_trash' => 'Nenhum evento na lixeira.'
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'evento', 'with_front' => false),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 7,
        'menu_icon'          => 'dashicons-calendar-alt',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest'       => true
    );

    register_post_type('me_evento', $args);

    // Taxonomia: Tipo de Evento
    register_taxonomy('tipo_evento', 'me_evento', array(
        'labels' => array(
            'name'          => 'Tipos de Evento',
            'singular_name' => 'Tipo de Evento',
            'search_items'  => 'Buscar Tipos',
            'all_items'     => 'Todos os Tipos',
            'edit_item'     => 'Editar Tipo',
            'add_new_item'  => 'Adicionar Novo Tipo',
            'menu_name'     => 'Tipos de Evento'
        ),
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => array('slug' => 'tipo-evento')
    ));

    // Taxonomia: Região / País
    register_taxonomy('regiao_evento', 'me_evento', array(
        'labels' => array(
            'name'          => 'Regiões / Países',
            'singular_name' => 'Região / País',
            'search_items'  => 'Buscar Regiões',
            'all_items'     => 'Todas as Regiões',
            'edit_item'     => 'Editar Região',
            'add_new_item'  => 'Adicionar Nova Região',
            'menu_name'     => 'Regiões / Países'
        ),
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => array('slug' => 'regiao-evento')
    ));
}

// 2. BADGE DE NOTIFICAÇÃO NO MENU ADMIN PARA EVENTOS PENDENTES
add_action('admin_menu', 'me_agenda_admin_pending_badge', 999);
function me_agenda_admin_pending_badge() {
    global $menu;
    $count_obj = wp_count_posts('me_evento');
    $pending_count = !empty($count_obj->pending) ? $count_obj->pending : 0;
    if ($pending_count > 0) {
        foreach ($menu as $key => $value) {
            if ($value[2] == 'edit.php?post_type=me_evento') {
                $menu[$key][0] .= ' <span class="update-plugins count-' . $pending_count . '" style="background:#e31c61;color:#fff;border-radius:10px;padding:2px 7px;font-size:11px;font-weight:bold;margin-left:5px;"><span class="plugin-count">' . $pending_count . '</span></span>';
                break;
            }
        }
    }
}

// 3. META BOX DE DETALHES DO EVENTO NO ADMIN
add_action('add_meta_boxes', 'me_agenda_add_meta_boxes');
function me_agenda_add_meta_boxes() {
    add_meta_box(
        'me_evento_details',
        '📋 Detalhes do Evento & Informações de Inscrição',
        'me_evento_details_callback',
        'me_evento',
        'normal',
        'high'
    );
}

function me_evento_details_callback($post) {
    wp_nonce_field('me_evento_save_meta', 'me_evento_meta_nonce');

    $data_inicio     = get_post_meta($post->ID, '_evento_data_inicio', true);
    $data_fim        = get_post_meta($post->ID, '_evento_data_fim', true);
    $horario         = get_post_meta($post->ID, '_evento_horario', true);
    $formato         = get_post_meta($post->ID, '_evento_formato', true) ?: 'Presencial';
    $local_nome      = get_post_meta($post->ID, '_evento_local_nome', true);
    $cidade_pais     = get_post_meta($post->ID, '_evento_cidade_pais', true);
    $pais            = get_post_meta($post->ID, '_evento_pais', true) ?: 'Brasil';
    $site_oficial    = get_post_meta($post->ID, '_evento_site_oficial', true);
    $link_ingressos  = get_post_meta($post->ID, '_evento_link_ingressos', true);
    $org_nome        = get_post_meta($post->ID, '_evento_organizador_nome', true);
    $org_email       = get_post_meta($post->ID, '_evento_organizador_email', true);
    $org_telefone    = get_post_meta($post->ID, '_evento_organizador_telefone', true);
    $cobertura       = get_post_meta($post->ID, '_evento_cobertura_jornalistica', true);
    ?>
    <style>
        .me-admin-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 10px; }
        .me-admin-field { margin-bottom: 12px; }
        .me-admin-field label { display: block; font-weight: 600; margin-bottom: 4px; color: #1e293b; }
        .me-admin-field input, .me-admin-field select { width: 100%; max-width: 100%; border-radius: 4px; border: 1px solid #cbd5e1; padding: 6px 10px; }
        .me-admin-section-title { grid-column: span 2; font-size: 14px; font-weight: bold; color: #e31c61; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px; margin-top: 10px; }
        .me-pending-notice { background: #fffbeb; border-left: 4px solid #f59e0b; padding: 10px 14px; border-radius: 4px; margin-bottom: 15px; }
        .me-cobertura-badge-active { background: #eff6ff; border: 1px solid #3b82f6; border-left: 4px solid #2563eb; padding: 12px 14px; border-radius: 6px; margin-bottom: 15px; color: #1e3a8a; }
    </style>

    <?php if ($cobertura === '1'): ?>
        <div class="me-cobertura-badge-active">
            <strong style="color:#1d4ed8;font-size:14px;"><i class="dashicons dashicons-camera" style="margin-right:4px;"></i> 📸 SOLICITAÇÃO DE COBERTURA JORNALÍSTICA ATIVA!</strong>
            <p style="margin:6px 0 0 0;font-size:13px;color:#1e40af;">
                O organizador deste evento <strong>solicitou cobertura da equipe do Portal Mercado Erótico</strong> (reportagem exclusiva, entrevista especial ou presença de imprensa). Entre em contato através do e-mail/WhatsApp do organizador para alinhar detalhes de credenciamento.
            </p>
        </div>
    <?php endif; ?>

    <?php if ($post->post_status === 'pending'): ?>
        <div class="me-pending-notice">
            <strong style="color:#b45309;">⚠️ Evento Aguardando Liberação do Administrador</strong>
            <p style="margin:5px 0 0 0;font-size:13px;color:#78350f;">
                Este evento foi inscrito publicamente e está com status <strong>Pendente</strong>. Para que ele apareça na Agenda do Mercado Erótico, revise os dados abaixo e clique no botão azul <strong>"Publicar"</strong> no painel lateral à direita.
            </p>
        </div>
    <?php endif; ?>

    <div class="me-admin-grid">
        <div class="me-admin-section-title">📅 Datas e Formato</div>
        <div class="me-admin-field">
            <label for="me_data_inicio">Data de Início *</label>
            <input type="date" id="me_data_inicio" name="_evento_data_inicio" value="<?php echo esc_attr($data_inicio); ?>" required>
        </div>
        <div class="me-admin-field">
            <label for="me_data_fim">Data de Término (se houver)</label>
            <input type="date" id="me_data_fim" name="_evento_data_fim" value="<?php echo esc_attr($data_fim); ?>">
        </div>
        <div class="me-admin-field">
            <label for="me_horario">Horário / Cronograma</label>
            <input type="text" id="me_horario" name="_evento_horario" placeholder="Ex: 10h às 20h" value="<?php echo esc_attr($horario); ?>">
        </div>
        <div class="me-admin-field">
            <label for="me_formato">Formato do Evento</label>
            <select id="me_formato" name="_evento_formato">
                <option value="Presencial" <?php selected($formato, 'Presencial'); ?>>🏢 Presencial</option>
                <option value="Online" <?php selected($formato, 'Online'); ?>>🌐 100% Online / Transmissão</option>
                <option value="Híbrido" <?php selected($formato, 'Híbrido'); ?>>🔄 Híbrido (Presencial + Online)</option>
            </select>
        </div>

        <div class="me-admin-section-title">📍 Localização & Âmbito</div>
        <div class="me-admin-field">
            <label for="me_local_nome">Espaço / Local / Plataforma</label>
            <input type="text" id="me_local_nome" name="_evento_local_nome" placeholder="Ex: São Paulo Expo / Zoom" value="<?php echo esc_attr($local_nome); ?>">
        </div>
        <div class="me-admin-field">
            <label for="me_cidade_pais">Cidade & Estado / País</label>
            <input type="text" id="me_cidade_pais" name="_evento_cidade_pais" placeholder="Ex: São Paulo, SP - Brasil" value="<?php echo esc_attr($cidade_pais); ?>">
        </div>
        <div class="me-admin-field" style="grid-column: span 2;">
            <label for="me_pais">País / Região</label>
            <input type="text" id="me_pais" name="_evento_pais" placeholder="Ex: Brasil, Alemanha, Estados Unidos, etc." value="<?php echo esc_attr($pais); ?>">
        </div>

        <div class="me-admin-section-title">🔗 Links & Ingressos</div>
        <div class="me-admin-field">
            <label for="me_site_oficial">Site Oficial do Evento</label>
            <input type="url" id="me_site_oficial" name="_evento_site_oficial" placeholder="https://..." value="<?php echo esc_url($site_oficial); ?>">
        </div>
        <div class="me-admin-field">
            <label for="me_link_ingressos">Link de Inscrição / Ingressos</label>
            <input type="url" id="me_link_ingressos" name="_evento_link_ingressos" placeholder="https://..." value="<?php echo esc_url($link_ingressos); ?>">
        </div>

        <div class="me-admin-section-title">📸 Cobertura Jornalística & Parceria</div>
        <div class="me-admin-field" style="grid-column: span 2;">
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                <input type="checkbox" name="_evento_cobertura_jornalistica" value="1" <?php checked($cobertura, '1'); ?>>
                <strong>Solicitou cobertura jornalística da equipe do Portal Mercado Erótico</strong>
            </label>
            <small style="color:#64748b;display:block;margin-top:4px;">Marque se a organização quer reportagem exclusiva, envio de correspondente ou entrevista com palestrantes.</small>
        </div>

        <div class="me-admin-section-title">👤 Dados do Organizador / Responsável (Uso Editorial Interno)</div>
        <div class="me-admin-field">
            <label for="me_org_nome">Nome do Organizador / Produtora</label>
            <input type="text" id="me_org_nome" name="_evento_organizador_nome" value="<?php echo esc_attr($org_nome); ?>">
        </div>
        <div class="me-admin-field">
            <label for="me_org_email">E-mail do Responsável</label>
            <input type="email" id="me_org_email" name="_evento_organizador_email" value="<?php echo esc_attr($org_email); ?>">
        </div>
        <div class="me-admin-field" style="grid-column: span 2;">
            <label for="me_org_telefone">WhatsApp / Telefone para Contato</label>
            <input type="text" id="me_org_telefone" name="_evento_organizador_telefone" placeholder="Ex: (11) 99999-9999" value="<?php echo esc_attr($org_telefone); ?>">
        </div>
    </div>
    <?php
}

// SALVAR METADADOS NO ADMIN
add_action('save_post_me_evento', 'me_agenda_save_meta');
function me_agenda_save_meta($post_id) {
    if (!isset($_POST['me_evento_meta_nonce']) || !wp_verify_nonce($_POST['me_evento_meta_nonce'], 'me_evento_save_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $fields = array(
        '_evento_data_inicio',
        '_evento_data_fim',
        '_evento_horario',
        '_evento_formato',
        '_evento_local_nome',
        '_evento_cidade_pais',
        '_evento_pais',
        '_evento_site_oficial',
        '_evento_link_ingressos',
        '_evento_organizador_nome',
        '_evento_organizador_email',
        '_evento_organizador_telefone'
    );

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            if ($field === '_evento_site_oficial' || $field === '_evento_link_ingressos') {
                update_post_meta($post_id, $field, esc_url_raw($_POST[$field]));
            } elseif ($field === '_evento_organizador_email') {
                update_post_meta($post_id, $field, sanitize_email($_POST[$field]));
            } else {
                update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
            }
        }
    }

    $cobertura = !empty($_POST['_evento_cobertura_jornalistica']) ? '1' : '0';
    update_post_meta($post_id, '_evento_cobertura_jornalistica', $cobertura);
}

// 4. COLUNAS CUSTOMIZADAS NA LISTA DE EVENTOS DO ADMIN
add_filter('manage_me_evento_posts_columns', 'me_agenda_custom_columns');
function me_agenda_custom_columns($columns) {
    $new_cols = array();
    $new_cols['cb']          = $columns['cb'];
    $new_cols['flyer']       = 'Flyer';
    $new_cols['title']       = 'Nome do Evento';
    $new_cols['data']        = 'Data';
    $new_cols['local']       = 'Local / País';
    $new_cols['tipo']        = 'Tipo';
    $new_cols['cobertura']   = 'Cobertura';
    $new_cols['organizador'] = 'Organizador';
    $new_cols['status_lib']  = 'Liberação';
    return $new_cols;
}

add_action('manage_me_evento_posts_custom_column', 'me_agenda_custom_column_content', 10, 2);
function me_agenda_custom_column_content($column, $post_id) {
    $today = current_time('Y-m-d');

    switch ($column) {
        case 'flyer':
            if (has_post_thumbnail($post_id)) {
                echo get_the_post_thumbnail($post_id, array(60, 45), array('style' => 'border-radius:4px;object-fit:cover;'));
            } else {
                echo '<span style="display:inline-block;width:60px;height:45px;background:#f1f5f9;border-radius:4px;text-align:center;line-height:45px;color:#94a3b8;font-size:10px;">Sem Flyer</span>';
            }
            break;

        case 'data':
            $inicio = get_post_meta($post_id, '_evento_data_inicio', true);
            $fim    = get_post_meta($post_id, '_evento_data_fim', true);
            $limite = !empty($fim) ? $fim : $inicio;

            if ($inicio) {
                $inicio_fmt = date_i18n('d/m/Y', strtotime($inicio));
                if ($fim && $fim !== $inicio) {
                    echo '<strong>' . $inicio_fmt . '</strong> a <strong>' . date_i18n('d/m/Y', strtotime($fim)) . '</strong>';
                } else {
                    echo '<strong>' . $inicio_fmt . '</strong>';
                }
                if ($limite && $limite < $today) {
                    echo '<br><span style="color:#dc2626;font-size:10px;font-weight:bold;background:#fee2e2;padding:1px 5px;border-radius:3px;">Encerrado</span>';
                }
            } else {
                echo '—';
            }
            break;

        case 'local':
            $local = get_post_meta($post_id, '_evento_cidade_pais', true) ?: get_post_meta($post_id, '_evento_local_nome', true);
            $formato = get_post_meta($post_id, '_evento_formato', true);
            echo esc_html($local ?: 'Online');
            if ($formato) {
                echo '<br><small style="color:#64748b;">(' . esc_html($formato) . ')</small>';
            }
            break;

        case 'tipo':
            $terms = get_the_term_list($post_id, 'tipo_evento', '', ', ', '');
            echo $terms ? $terms : '<span style="color:#94a3b8;">Geral</span>';
            break;

        case 'cobertura':
            $cob = get_post_meta($post_id, '_evento_cobertura_jornalistica', true);
            if ($cob === '1') {
                echo '<span style="display:inline-block;background:#dbeafe;color:#1e40af;padding:2px 7px;border-radius:10px;font-size:11px;font-weight:700;">📸 Solicitada</span>';
            } else {
                echo '<span style="color:#94a3b8;font-size:11px;">Não</span>';
            }
            break;

        case 'organizador':
            $org   = get_post_meta($post_id, '_evento_organizador_nome', true);
            $email = get_post_meta($post_id, '_evento_organizador_email', true);
            echo esc_html($org ?: '—');
            if ($email) {
                echo '<br><a href="mailto:' . esc_attr($email) . '" style="font-size:11px;color:#64748b;">' . esc_html($email) . '</a>';
            }
            break;

        case 'status_lib':
            $status = get_post_status($post_id);
            if ($status === 'pending') {
                $approve_url = wp_nonce_url(admin_url('admin-post.php?action=me_approve_event&post_id=' . $post_id), 'me_approve_' . $post_id);
                echo '<span style="display:inline-block;background:#fef3c7;color:#b45309;padding:3px 8px;border-radius:12px;font-size:11px;font-weight:bold;margin-bottom:5px;">⏳ Pendente</span><br>';
                echo '<a href="' . esc_url($approve_url) . '" class="button button-small button-primary" style="background:#10b981;border-color:#059669;font-weight:600;">✓ Liberar & Publicar</a>';
            } elseif ($status === 'publish') {
                echo '<span style="display:inline-block;background:#d1fae5;color:#047857;padding:3px 8px;border-radius:12px;font-size:11px;font-weight:bold;">✓ Publicado na Agenda</span>';
            } else {
                echo '<span style="color:#64748b;">' . esc_html(ucfirst($status)) . '</span>';
            }
            break;
    }
}

// 5. AÇÃO DE LIBERAÇÃO RÁPIDA PELO ADMIN
add_action('admin_post_me_approve_event', 'me_agenda_handle_quick_approval');
function me_agenda_handle_quick_approval() {
    if (!current_user_can('edit_posts')) {
        wp_die('Permissão negada.');
    }
    $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
    check_admin_referer('me_approve_' . $post_id);

    if ($post_id > 0 && get_post_type($post_id) === 'me_evento') {
        wp_update_post(array(
            'ID'          => $post_id,
            'post_status' => 'publish'
        ));

        // Notificar organizador por e-mail se cadastrado
        $org_email = get_post_meta($post_id, '_evento_organizador_email', true);
        $titulo    = get_the_title($post_id);
        if (!empty($org_email) && is_email($org_email)) {
            $subject = "[Portal Mercado Erótico] Seu evento foi APROVADO: " . $titulo;
            $message = "Olá!\n\nTemos o prazer de informar que seu evento '" . $titulo . "' foi aprovado pela redação e já está publicado na Agenda do Mercado Erótico Mundial!\n\nConfira na Agenda: " . home_url('/agenda/') . "\n\nAtenciosamente,\nEquipe Editorial - Portal Mercado Erótico";
            $headers = array('Content-Type: text/plain; charset=UTF-8', 'From: Portal Mercado Erótico <contato@mercadoerotico.org>');
            wp_mail($org_email, $subject, $message, $headers);
        }
    }

    wp_safe_redirect(admin_url('edit.php?post_type=me_evento&message=approved'));
    exit;
}

// 6. PROCESSAMENTO DO FORMULÁRIO PÚBLICO (AJAX & POST SEGURO)
add_action('wp_ajax_me_submit_public_event', 'me_agenda_process_public_submission');
add_action('wp_ajax_nopriv_me_submit_public_event', 'me_agenda_process_public_submission');

function me_agenda_process_public_submission() {
    // 1. Verificação de Nonce
    if (!isset($_POST['me_nonce']) || !wp_verify_nonce($_POST['me_nonce'], 'me_public_event_action')) {
        wp_send_json_error(array('message' => 'Sessão expirada. Por favor, recarregue a página e tente novamente.'));
    }

    // 2. Proteção Honeypot Anti-Spam
    if (!empty($_POST['me_hp_company'])) {
        wp_send_json_error(array('message' => 'Envio inválido detectado.'));
    }

    // 3. Validação dos campos obrigatórios
    $titulo        = sanitize_text_field($_POST['evento_nome'] ?? '');
    $data_inicio   = sanitize_text_field($_POST['evento_data_inicio'] ?? '');
    $formato       = sanitize_text_field($_POST['evento_formato'] ?? 'Presencial');
    $cidade_pais   = sanitize_text_field($_POST['evento_cidade_pais'] ?? '');
    $pais          = sanitize_text_field($_POST['evento_pais'] ?? 'Brasil');
    $descricao     = wp_kses_post($_POST['evento_descricao'] ?? '');
    $org_nome      = sanitize_text_field($_POST['evento_org_nome'] ?? '');
    $org_email     = sanitize_email($_POST['evento_org_email'] ?? '');
    $org_telefone  = sanitize_text_field($_POST['evento_org_telefone'] ?? '');
    $site_oficial  = esc_url_raw($_POST['evento_site_oficial'] ?? '');
    $link_ingressos= esc_url_raw($_POST['evento_link_ingressos'] ?? '');
    $categoria_id  = intval($_POST['evento_categoria'] ?? 0);
    $data_fim      = sanitize_text_field($_POST['evento_data_fim'] ?? '');
    $horario       = sanitize_text_field($_POST['evento_horario'] ?? '');
    $local_nome    = sanitize_text_field($_POST['evento_local_nome'] ?? '');
    $cobertura     = !empty($_POST['evento_cobertura']) ? '1' : '0';

    if (empty($titulo) || empty($data_inicio) || empty($descricao) || empty($org_nome) || empty($org_email)) {
        wp_send_json_error(array('message' => 'Por favor, preencha todos os campos obrigatórios (Nome do Evento, Data de Início, Descrição, Organizador e E-mail).'));
    }

    if (!is_email($org_email)) {
        wp_send_json_error(array('message' => 'Por favor, informe um endereço de e-mail válido.'));
    }

    // 4. Criação do Post como PENDENTE DE REVISÃO (post_status = pending)
    $post_data = array(
        'post_title'    => $titulo,
        'post_content'  => $descricao,
        'post_status'   => 'pending', // Não vai ao ar sem liberação do adm!
        'post_type'     => 'me_evento',
        'post_author'   => 1
    );

    $post_id = wp_insert_post($post_data);

    if (is_wp_error($post_id) || !$post_id) {
        wp_send_json_error(array('message' => 'Ocorreu um erro ao registrar o evento. Tente novamente mais tarde.'));
    }

    // 5. Salva Metadados
    update_post_meta($post_id, '_evento_data_inicio', $data_inicio);
    if (!empty($data_fim)) {
        update_post_meta($post_id, '_evento_data_fim', $data_fim);
    }
    update_post_meta($post_id, '_evento_horario', $horario);
    update_post_meta($post_id, '_evento_formato', $formato);
    update_post_meta($post_id, '_evento_local_nome', $local_nome);
    update_post_meta($post_id, '_evento_cidade_pais', $cidade_pais);
    update_post_meta($post_id, '_evento_pais', $pais);
    update_post_meta($post_id, '_evento_site_oficial', $site_oficial);
    update_post_meta($post_id, '_evento_link_ingressos', $link_ingressos);
    update_post_meta($post_id, '_evento_organizador_nome', $org_nome);
    update_post_meta($post_id, '_evento_organizador_email', $org_email);
    update_post_meta($post_id, '_evento_organizador_telefone', $org_telefone);
    update_post_meta($post_id, '_evento_cobertura_jornalistica', $cobertura);

    // 6. Atribui Categoria e Região
    if ($categoria_id > 0) {
        wp_set_post_terms($post_id, array($categoria_id), 'tipo_evento');
    }
    if (!empty($pais)) {
        wp_set_post_terms($post_id, array($pais), 'regiao_evento');
    }

    // 7. Upload de Imagem (Flyer / Cartaz) se enviada
    if (!empty($_FILES['evento_flyer']['name'])) {
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');

        $file_type = wp_check_filetype($_FILES['evento_flyer']['name']);
        $allowed = array('jpg', 'jpeg', 'png', 'webp');
        if (in_array(strtolower($file_type['ext']), $allowed)) {
            $attachment_id = media_handle_upload('evento_flyer', $post_id);
            if (!is_wp_error($attachment_id)) {
                set_post_thumbnail($post_id, $attachment_id);
            }
        }
    }

    // 8. Notificação por E-mail para a Redação / Administrador
    $admin_email = get_option('admin_email');
    $notify_emails = array($admin_email, 'contato@mercadoerotico.org');
    $subject = "[Agenda Mercado Erótico] Novo Evento Inscrito: " . $titulo . " (Aguardando Liberação)";
    
    $body  = "Um novo evento foi inscrito na Agenda do Mercado Erótico e aguarda aprovação:\n\n";
    $body .= "📌 Evento: " . $titulo . "\n";
    $body .= "📅 Data: " . date_i18n('d/m/Y', strtotime($data_inicio)) . (!empty($data_fim) ? " até " . date_i18n('d/m/Y', strtotime($data_fim)) : "") . "\n";
    $body .= "📍 Formato/Local: " . $formato . " | " . $cidade_pais . " (" . $local_nome . ")\n";
    $body .= "👤 Organizador: " . $org_nome . " (" . $org_email . " - " . $org_telefone . ")\n";
    if ($site_oficial) $body .= "🔗 Site Oficial: " . $site_oficial . "\n";

    if ($cobertura === '1') {
        $body .= "\n🚨📸 SOLICITAÇÃO DE COBERTURA JORNALÍSTICA: SIM!\n";
        $body .= "O organizador solicitou cobertura editorial, reportagem ou entrevista exclusiva com a equipe do Portal Mercado Erótico.\n";
    } else {
        $body .= "\n📸 Cobertura Jornalística Solicitada: Não\n";
    }

    $body .= "\n----------------------------------------\n";
    $body .= "👉 Para revisar e LIBERAR o evento para o público, acesse o painel:\n";
    $body .= admin_url('post.php?post=' . $post_id . '&action=edit') . "\n";
    $body .= "Ou veja a lista de pendentes em:\n";
    $body .= admin_url('edit.php?post_status=pending&post_type=me_evento') . "\n";

    $headers = array('Content-Type: text/plain; charset=UTF-8', 'From: Portal Mercado Erótico <contato@mercadoerotico.org>');
    @wp_mail($notify_emails, $subject, $body, $headers);

    wp_send_json_success(array(
        'message' => '🎉 Seu evento foi inscrito com sucesso! Ele foi encaminhado para a moderação da equipe editorial. Assim que liberado pelo administrador, aparecerá automaticamente na Agenda Oficial.'
    ));
}

// 7. SHORTCODE PRINCIPAL: [mercado_agenda]
add_shortcode('mercado_agenda', 'me_agenda_shortcode_render');
function me_agenda_shortcode_render() {
    ob_start();

    $today = current_time('Y-m-d');

    // Query dos eventos PUBLICADOS
    $args = array(
        'post_type'      => 'me_evento',
        'post_status'    => 'publish', // Somente liberados pelo administrador!
        'posts_per_page' => -1,
        'meta_key'       => '_evento_data_inicio',
        'orderby'        => 'meta_value',
        'order'          => 'ASC'
    );
    $all_events_query = new WP_Query($args);

    // Filtrar apenas eventos cuja data de término (ou início) NÃO tenha passado
    $active_posts = array();
    if ($all_events_query->have_posts()) {
        while ($all_events_query->have_posts()) {
            $all_events_query->the_post();
            $pid = get_the_ID();
            $data_inicio = get_post_meta($pid, '_evento_data_inicio', true);
            $data_fim    = get_post_meta($pid, '_evento_data_fim', true);
            $data_limite = !empty($data_fim) ? $data_fim : $data_inicio;

            // Se o evento terminou antes de hoje, NÃO exibe na agenda pública
            if ($data_limite && $data_limite < $today) {
                continue;
            }
            $active_posts[] = $pid;
        }
        wp_reset_postdata();
    }

    $total_active_events = count($active_posts);

    // Tipos de evento para os filtros e formulário
    $tipos = get_terms(array(
        'taxonomy'   => 'tipo_evento',
        'hide_empty' => false
    ));
    ?>
    <div class="me-agenda-container">

        <!-- HERO HEADER -->
        <div class="me-agenda-hero">
            <div class="me-agenda-hero-badge">★ CALENDÁRIO GLOBAL DO SETOR ÍNTIMO</div>
            <h1 class="me-agenda-hero-title">Agenda do Mercado Erótico</h1>
            <p class="me-agenda-hero-subtitle">
                O calendário oficial dos maiores congressos científicos de sexologia, feiras de negócios B2B, festivais, simpósios acadêmicos e workshops no Brasil e no mundo.
            </p>
            <div class="me-agenda-hero-actions">
                <a href="#inscrever-evento" class="me-agenda-btn-primary">
                    <i class="fas fa-plus-circle"></i> Inscrever Meu Evento Gratuitamente
                </a>
                <a href="#explorar-agenda" class="me-agenda-btn-secondary">
                    <i class="fas fa-calendar-alt"></i> Ver Próximos Eventos (<?php echo $total_active_events; ?>)
                </a>
            </div>
        </div>

        <!-- STATS BAR -->
        <div class="me-agenda-stats">
            <div class="me-stat-card">
                <div class="me-stat-icon">🌍</div>
                <div class="me-stat-info">
                    <span class="me-stat-num">Global &amp; Brasil</span>
                    <span class="me-stat-desc">Eventos nacionais e internacionais</span>
                </div>
            </div>
            <div class="me-stat-card">
                <div class="me-stat-icon">🛡️</div>
                <div class="me-stat-info">
                    <span class="me-stat-num">Curadoria Oficial</span>
                    <span class="me-stat-desc">Eventos auditados e revisados pelo adm</span>
                </div>
            </div>
            <div class="me-stat-card">
                <div class="me-stat-icon">📣</div>
                <div class="me-stat-info">
                    <span class="me-stat-num">Inscrição Aberta</span>
                    <span class="me-stat-desc">Produtores e empresas podem submeter</span>
                </div>
            </div>
            <div class="me-stat-card">
                <div class="me-stat-icon">📅</div>
                <div class="me-stat-info">
                    <span class="me-stat-num">Google Agenda</span>
                    <span class="me-stat-desc">Sincronize datas com 1 clique</span>
                </div>
            </div>
        </div>

        <!-- EXPLORAR AGENDA / FILTROS -->
        <div id="explorar-agenda" class="me-agenda-filter-section">
            <div class="me-filter-topbar">
                <div class="me-search-wrapper">
                    <i class="fas fa-search me-search-icon"></i>
                    <input type="text" id="me-event-search" placeholder="Buscar por evento, cidade, tema ou organizador..." autocomplete="off">
                </div>
                <div class="me-filter-stats">
                    <span id="me-event-counter"><?php echo $total_active_events; ?></span> eventos disponíveis
                </div>
            </div>

            <!-- FILTRO PILLS -->
            <div class="me-filter-pills-wrap">
                <div class="me-filter-group">
                    <span class="me-filter-label">Formato:</span>
                    <button type="button" class="me-pill active" data-filter="all" data-type="formato">Todos</button>
                    <button type="button" class="me-pill" data-filter="Presencial" data-type="formato">🏢 Presencial</button>
                    <button type="button" class="me-pill" data-filter="Online" data-type="formato">🌐 Online</button>
                    <button type="button" class="me-pill" data-filter="Híbrido" data-type="formato">🔄 Híbrido</button>
                </div>
                <div class="me-filter-group">
                    <span class="me-filter-label">Região:</span>
                    <button type="button" class="me-pill active" data-filter="all" data-type="regiao">Todas</button>
                    <button type="button" class="me-pill" data-filter="Brasil" data-type="regiao">🇧🇷 Brasil</button>
                    <button type="button" class="me-pill" data-filter="Internacional" data-type="regiao">🌍 Internacional</button>
                </div>
            </div>
        </div>

        <!-- GRID DE EVENTOS (SOMENTE DATAS VÁLIDAS / FUTURAS) -->
        <div class="me-events-grid" id="me-events-grid">
            <?php if (!empty($active_posts)): ?>
                <?php foreach ($active_posts as $post_id): 
                    $post = get_post($post_id);
                    $data_inicio  = get_post_meta($post_id, '_evento_data_inicio', true);
                    $data_fim     = get_post_meta($post_id, '_evento_data_fim', true);
                    $horario      = get_post_meta($post_id, '_evento_horario', true);
                    $formato      = get_post_meta($post_id, '_evento_formato', true) ?: 'Presencial';
                    $local_nome   = get_post_meta($post_id, '_evento_local_nome', true);
                    $cidade_pais  = get_post_meta($post_id, '_evento_cidade_pais', true);
                    $pais         = get_post_meta($post_id, '_evento_pais', true) ?: 'Brasil';
                    $site_oficial = get_post_meta($post_id, '_evento_site_oficial', true);
                    $link_ingr    = get_post_meta($post_id, '_evento_link_ingressos', true);
                    $org_nome     = get_post_meta($post_id, '_evento_organizador_nome', true);
                    $cobertura    = get_post_meta($post_id, '_evento_cobertura_jornalistica', true);

                    $is_brasil = (stripos($pais, 'Brasil') !== false || stripos($pais, 'Brazil') !== false || (empty($pais) && preg_match('/\b(Brasil|Brazil|SP|RJ|São Paulo|Rio de Janeiro)\b/i', $cidade_pais)));
                    $regiao_attr = $is_brasil ? 'Brasil' : 'Internacional';

                    // Formatação de Datas
                    $timestamp_inicio = $data_inicio ? strtotime($data_inicio) : time();
                    $dia_inicio       = date('d', $timestamp_inicio);
                    $mes_inicio       = strtoupper(date_i18n('M', $timestamp_inicio));
                    $ano_inicio       = date('Y', $timestamp_inicio);

                    $data_display = $dia_inicio . ' de ' . date_i18n('F', $timestamp_inicio) . ' de ' . $ano_inicio;
                    if ($data_fim && $data_fim !== $data_inicio) {
                        $timestamp_fim = strtotime($data_fim);
                        $data_display = $dia_inicio . ' a ' . date_i18n('d \d\e F \d\e Y', $timestamp_fim);
                    }

                    // Google Calendar Link generator
                    $gcal_dates = date('Ymd', $timestamp_inicio);
                    if ($data_fim) {
                        $gcal_dates .= '/' . date('Ymd', strtotime($data_fim . ' +1 day'));
                    } else {
                        $gcal_dates .= '/' . date('Ymd', strtotime($data_inicio . ' +1 day'));
                    }
                    $gcal_url = 'https://calendar.google.com/calendar/render?action=TEMPLATE&text=' . urlencode($post->post_title) . '&dates=' . $gcal_dates . '&details=' . urlencode(wp_strip_all_tags($post->post_excerpt ?: $post->post_content) . "\n\nMais informações: " . ($site_oficial ?: home_url('/agenda/'))) . '&location=' . urlencode($local_nome . ' - ' . $cidade_pais);

                    // Imagem
                    $thumb_url = has_post_thumbnail($post_id) ? get_the_post_thumbnail_url($post_id, 'large') : 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2026/11/default_agenda_banner.svg';
                    
                    // Termos
                    $terms = wp_get_post_terms($post_id, 'tipo_evento');
                    $tipo_nome = !empty($terms) ? $terms[0]->name : 'Evento';
                ?>
                    <article class="me-event-card" 
                             data-title="<?php echo esc_attr(strtolower($post->post_title)); ?>" 
                             data-location="<?php echo esc_attr(strtolower($cidade_pais . ' ' . $local_nome)); ?>"
                             data-formato="<?php echo esc_attr($formato); ?>"
                             data-regiao="<?php echo esc_attr($regiao_attr); ?>">
                        
                        <!-- BANNER & DATE BADGE -->
                        <div class="me-card-image-wrap">
                            <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($post->post_title); ?>" class="me-card-img" loading="lazy">
                            <div class="me-date-badge">
                                <span class="me-date-month"><?php echo esc_html($mes_inicio); ?></span>
                                <span class="me-date-day"><?php echo esc_html($dia_inicio); ?></span>
                                <span class="me-date-year"><?php echo esc_html($ano_inicio); ?></span>
                            </div>
                            <div class="me-format-badge <?php echo esc_attr(strtolower($formato)); ?>">
                                <?php echo esc_html($formato); ?>
                            </div>
                            <?php if ($cobertura === '1'): ?>
                                <span class="me-coverage-badge" title="Cobertura Jornalística do Portal Confirmada"><i class="fas fa-camera"></i> Cobertura Portal</span>
                            <?php endif; ?>
                        </div>

                        <!-- CONTEÚDO DO CARD -->
                        <div class="me-card-body">
                            <div class="me-card-meta-top">
                                <span class="me-badge-category"><?php echo esc_html($tipo_nome); ?></span>
                                <span class="me-badge-country">
                                    <?php echo $is_brasil ? '🇧🇷 Brasil' : '🌍 ' . esc_html($pais); ?>
                                </span>
                            </div>

                            <h3 class="me-card-title"><?php echo esc_html($post->post_title); ?></h3>

                            <div class="me-card-info-list">
                                <div class="me-info-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span><strong><?php echo esc_html($local_nome ?: 'Local a confirmar'); ?></strong> — <?php echo esc_html($cidade_pais); ?></span>
                                </div>
                                <div class="me-info-item">
                                    <i class="far fa-calendar-alt"></i>
                                    <span><?php echo esc_html($data_display); ?></span>
                                </div>
                                <?php if ($horario): ?>
                                    <div class="me-info-item">
                                        <i class="far fa-clock"></i>
                                        <span><?php echo esc_html($horario); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="me-card-excerpt">
                                <?php echo wp_trim_words($post->post_excerpt ?: $post->post_content, 22, '...'); ?>
                            </div>

                            <div class="me-card-footer">
                                <?php if ($site_oficial || $link_ingr): ?>
                                    <a href="<?php echo esc_url($link_ingr ?: $site_oficial); ?>" target="_blank" rel="noopener" class="me-card-btn-action">
                                        Site &amp; Ingressos <i class="fas fa-external-link-alt"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="me-card-btn-action disabled">Inscrições em breve</span>
                                <?php endif; ?>

                                <a href="<?php echo esc_url($gcal_url); ?>" target="_blank" rel="noopener" class="me-card-btn-gcal" title="Salvar no Google Agenda">
                                    <i class="fab fa-google"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="me-no-events">
                    <i class="fas fa-calendar-check" style="font-size:3rem;color:#cbd5e1;margin-bottom:15px;display:block;"></i>
                    <p style="font-size:1.1rem;font-weight:700;color:#334155;">Nenhum evento futuro agendado no momento.</p>
                    <p style="color:#64748b;">Os eventos anteriores já foram concluídos. Seja o primeiro a inscrever seu evento gratuito abaixo!</p>
                </div>
            <?php endif; ?>
        </div>

        <div id="me-empty-results" class="me-empty-results" style="display:none;">
            <i class="fas fa-search" style="font-size:2rem;color:#94a3b8;margin-bottom:10px;"></i>
            <p>Nenhum evento encontrado para os filtros selecionados.</p>
            <button type="button" class="me-btn-reset" onclick="meResetFilters()">Limpar Filtros</button>
        </div>

        <!-- FORMULÁRIO DE INSCRIÇÃO AUTOMATIZADO -->
        <section id="inscrever-evento" class="me-submission-section">
            <div class="me-submission-header">
                <span class="me-sub-badge">SUBMISSÃO PÚBLICA GRATUITA</span>
                <h2 class="me-sub-title">Divulgue seu Evento na Maior Vitrine do Setor</h2>
                <p class="me-sub-desc">
                    Feiras de negócios, congressos, simpósios, conferências, lançamentos e workshops: qualquer produtor ou empresa pode inscrever seu evento. 
                    Após o envio, as informações passam pela <strong>revisão e liberação da nossa equipe editorial</strong> antes de entrar na Agenda Oficial.
                </p>

                <!-- GUIA DE ESPECIFICAÇÃO DE IMAGEM -->
                <div class="me-sub-spec-banner">
                    <div class="spec-banner-icon"><i class="fas fa-image"></i></div>
                    <div class="spec-banner-text">
                        <strong>Tamanho Recomendado para o Cartaz / Flyer:</strong>
                        <span>Envie em <strong>1200 x 675 pixels</strong> (proporção 16:9 horizontal). Formatos: JPG, PNG ou WEBP (máx. 5 MB). Isso garante que o cartaz fique perfeitamente nítido e legível tanto no computador quanto no celular.</span>
                    </div>
                </div>
            </div>

            <form id="me-event-submit-form" class="me-event-form" enctype="multipart/form-data">
                <?php wp_nonce_field('me_public_event_action', 'me_nonce'); ?>
                <!-- Honeypot anti-spam -->
                <div style="display:none !important;" aria-hidden="true">
                    <input type="text" name="me_hp_company" id="me_hp_company" tabindex="-1" autocomplete="off">
                </div>

                <div class="me-form-grid">
                    <!-- Coluna 1 -->
                    <div class="me-form-col">
                        <div class="me-field-group">
                            <label for="evento_nome">Nome do Evento *</label>
                            <input type="text" id="evento_nome" name="evento_nome" required placeholder="Ex: Íntimi Expo 2027, Venus Berlin...">
                        </div>

                        <div class="me-form-row">
                            <div class="me-field-group">
                                <label for="evento_categoria">Tipo de Evento *</label>
                                <select id="evento_categoria" name="evento_categoria" required>
                                    <option value="">Selecione...</option>
                                    <?php foreach ($tipos as $t): ?>
                                        <option value="<?php echo esc_attr($t->term_id); ?>"><?php echo esc_html($t->name); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="me-field-group">
                                <label for="evento_formato">Formato *</label>
                                <select id="evento_formato" name="evento_formato" required>
                                    <option value="Presencial">🏢 Presencial</option>
                                    <option value="Online">🌐 100% Online</option>
                                    <option value="Híbrido">🔄 Híbrido</option>
                                </select>
                            </div>
                        </div>

                        <div class="me-form-row">
                            <div class="me-field-group">
                                <label for="evento_data_inicio">Data de Início *</label>
                                <input type="date" id="evento_data_inicio" name="evento_data_inicio" required>
                            </div>
                            <div class="me-field-group">
                                <label for="evento_data_fim">Data de Término</label>
                                <input type="date" id="evento_data_fim" name="evento_data_fim">
                            </div>
                        </div>

                        <div class="me-field-group">
                            <label for="evento_horario">Horário / Cronograma</label>
                            <input type="text" id="evento_horario" name="evento_horario" placeholder="Ex: Das 10h às 21h">
                        </div>

                        <div class="me-form-row">
                            <div class="me-field-group">
                                <label for="evento_pais">País *</label>
                                <input type="text" id="evento_pais" name="evento_pais" required value="Brasil" placeholder="Ex: Brasil, Alemanha, EUA...">
                            </div>
                            <div class="me-field-group">
                                <label for="evento_cidade_pais">Cidade &amp; Estado *</label>
                                <input type="text" id="evento_cidade_pais" name="evento_cidade_pais" required placeholder="Ex: São Paulo, SP">
                            </div>
                        </div>

                        <div class="me-field-group">
                            <label for="evento_local_nome">Espaço / Venue / Plataforma</label>
                            <input type="text" id="evento_local_nome" name="evento_local_nome" placeholder="Ex: São Paulo Expo, Hotel Renaissance, Zoom...">
                        </div>
                    </div>

                    <!-- Coluna 2 -->
                    <div class="me-form-col">
                        <div class="me-field-group">
                            <label for="evento_site_oficial">Site Oficial do Evento</label>
                            <input type="url" id="evento_site_oficial" name="evento_site_oficial" placeholder="https://www.seuevento.com.br">
                        </div>

                        <div class="me-field-group">
                            <label for="evento_link_ingressos">Link para Ingressos / Inscrições</label>
                            <input type="url" id="evento_link_ingressos" name="evento_link_ingressos" placeholder="https://sympla.com.br/...">
                        </div>

                        <!-- CAMPO DE FLYER COM ESPECIFICAÇÃO DE TAMANHO -->
                        <div class="me-field-group">
                            <label for="evento_flyer">
                                Cartaz / Flyer do Evento 
                                <span class="me-label-highlight">(Ideal: 1200 x 675 px - horizontal)</span>
                            </label>
                            <input type="file" id="evento_flyer" name="evento_flyer" accept="image/jpeg,image/png,image/webp">
                            <div class="me-file-tip-box">
                                <i class="fas fa-ruler-combined"></i> 
                                <span><strong>Dimensão ideal:</strong> 1200 x 675 px (proporção 16:9 horizontal). Formatos aceitos: JPG, PNG ou WEBP (máx. 5 MB).</span>
                            </div>
                        </div>

                        <div class="me-field-group">
                            <label for="evento_descricao">Descrição Completa &amp; Programação *</label>
                            <textarea id="evento_descricao" name="evento_descricao" rows="5" required placeholder="Apresente os objetivos do evento, principais palestrantes, atrações, público-alvo e informações essenciais para os participantes..."></textarea>
                        </div>

                        <!-- DADOS DO ORGANIZADOR -->
                        <div class="me-org-box">
                            <div class="me-org-title"><i class="fas fa-id-badge"></i> Dados do Organizador (Uso Editorial Interno)</div>
                            <div class="me-form-row">
                                <div class="me-field-group">
                                    <label for="evento_org_nome">Nome da Empresa ou Produtor *</label>
                                    <input type="text" id="evento_org_nome" name="evento_org_nome" required placeholder="Ex: ABIPEA Eventos">
                                </div>
                                <div class="me-field-group">
                                    <label for="evento_org_email">E-mail para Contato *</label>
                                    <input type="email" id="evento_org_email" name="evento_org_email" required placeholder="contato@empresa.com">
                                </div>
                            </div>
                            <div class="me-field-group">
                                <label for="evento_org_telefone">WhatsApp de Contato</label>
                                <input type="text" id="evento_org_telefone" name="evento_org_telefone" placeholder="(11) 99999-9999">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CAMPO CLICÁVEL: SOLICITAÇÃO DE COBERTURA JORNALÍSTICA -->
                <div class="me-coverage-request-card">
                    <label class="me-coverage-toggle" for="evento_cobertura">
                        <input type="checkbox" id="evento_cobertura" name="evento_cobertura" value="1">
                        <span class="me-coverage-checkbox"></span>
                        <div class="me-coverage-content">
                            <span class="me-coverage-title">
                                <i class="fas fa-camera-retro"></i> Desejo cobertura jornalística da equipe do Portal Mercado Erótico
                            </span>
                            <span class="me-coverage-desc">
                                Marque esta opção caso tenha interesse em pauta jornalística exclusiva, envio de correspondente/repórter para o evento, cobertura fotográfica ou entrevista especial com palestrantes e organizadores. Nossa redação entrará em contato para alinhar o credenciamento de imprensa.
                            </span>
                        </div>
                    </label>
                </div>

                <div class="me-form-footer">
                    <div class="me-form-status" id="me-form-status"></div>
                    <button type="submit" class="me-btn-submit" id="me-btn-submit">
                        <span class="btn-text">🚀 Enviar Evento para Moderação</span>
                        <span class="btn-loading" style="display:none;"><i class="fas fa-spinner fa-spin"></i> Processando envio...</span>
                    </button>
                    <p class="me-disclaimer">
                        <i class="fas fa-shield-alt"></i> Seu evento será avaliado pela redação do Portal Mercado Erótico em até 24h úteis antes da publicação definitiva.
                    </p>
                </div>
            </form>
        </section>
    </div>

    <!-- ESTILOS COMPLETOS SCOPED -->
    <style>
        .me-agenda-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px 15px 80px 15px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            color: #1e293b;
        }

        /* HERO */
        .me-agenda-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 60%, #311029 100%);
            border-radius: 20px;
            padding: 50px 35px;
            text-align: center;
            color: #fff;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.25);
            margin-bottom: 35px;
            border: 1px solid rgba(227, 28, 97, 0.25);
        }
        .me-agenda-hero::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(227, 28, 97, 0.25) 0%, transparent 70%);
            pointer-events: none;
        }
        .me-agenda-hero-badge {
            display: inline-block;
            background: rgba(227, 28, 97, 0.2);
            color: #ff659c;
            border: 1px solid rgba(227, 28, 97, 0.4);
            font-size: 0.8rem;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 20px;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }
        .me-agenda-hero-title {
            font-size: 2.8rem;
            font-weight: 900;
            margin: 0 0 15px 0;
            line-height: 1.15;
            letter-spacing: -0.5px;
            color: #ffffff !important;
        }
        .me-agenda-hero-subtitle {
            font-size: 1.15rem;
            color: #cbd5e1;
            max-width: 780px;
            margin: 0 auto 30px auto;
            line-height: 1.6;
        }
        .me-agenda-hero-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            position: relative;
            z-index: 2;
        }
        .me-agenda-btn-primary {
            background: linear-gradient(135deg, #e31c61 0%, #c4124e 100%);
            color: #fff !important;
            padding: 14px 28px;
            border-radius: 30px;
            font-weight: 700;
            text-decoration: none !important;
            box-shadow: 0 6px 20px rgba(227, 28, 97, 0.4);
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .me-agenda-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(227, 28, 97, 0.6);
            color: #fff !important;
        }
        .me-agenda-btn-secondary {
            background: rgba(255,255,255,0.1);
            color: #fff !important;
            padding: 14px 28px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none !important;
            border: 1px solid rgba(255,255,255,0.25);
            backdrop-filter: blur(5px);
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .me-agenda-btn-secondary:hover {
            background: rgba(255,255,255,0.2);
            color: #fff !important;
        }

        /* STATS */
        .me-agenda-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 45px;
        }
        .me-stat-card {
            background: #ffffff;
            border-radius: 14px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        }
        .me-stat-icon {
            font-size: 2rem;
            line-height: 1;
        }
        .me-stat-num {
            display: block;
            font-size: 1.05rem;
            font-weight: 800;
            color: #0f172a;
        }
        .me-stat-desc {
            font-size: 0.8rem;
            color: #64748b;
        }

        /* FILTERS & SEARCH */
        .me-agenda-filter-section {
            background: #ffffff;
            border-radius: 16px;
            padding: 25px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            margin-bottom: 35px;
        }
        .me-filter-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .me-search-wrapper {
            position: relative;
            flex-grow: 1;
            max-width: 600px;
        }
        .me-search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
        }
        .me-search-wrapper input {
            width: 100%;
            padding: 12px 16px 12px 45px;
            border-radius: 30px;
            border: 1px solid #cbd5e1;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.2s ease;
        }
        .me-search-wrapper input:focus {
            border-color: #e31c61;
            box-shadow: 0 0 0 3px rgba(227, 28, 97, 0.15);
        }
        .me-filter-stats {
            font-size: 0.95rem;
            font-weight: 700;
            color: #475569;
        }
        .me-filter-stats span {
            color: #e31c61;
            font-size: 1.15rem;
        }
        .me-filter-pills-wrap {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
            padding-top: 15px;
            border-top: 1px solid #f1f5f9;
        }
        .me-filter-group {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .me-filter-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-right: 4px;
        }
        .me-pill {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .me-pill:hover {
            background: #e2e8f0;
            color: #1e293b;
        }
        .me-pill.active {
            background: #0f172a;
            color: #fff;
            border-color: #0f172a;
        }

        /* GRID */
        .me-events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 50px;
        }
        .me-event-card {
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            transition: all 0.25s ease;
            display: flex;
            flex-direction: column;
        }
        .me-event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.08);
            border-color: #cbd5e1;
        }
        .me-card-image-wrap {
            position: relative;
            height: 200px;
            overflow: hidden;
            background: #0f172a;
        }
        .me-card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.35s ease;
        }
        .me-event-card:hover .me-card-img {
            transform: scale(1.05);
        }
        .me-date-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: rgba(15, 23, 42, 0.9);
            backdrop-filter: blur(6px);
            color: #fff;
            padding: 8px 12px;
            border-radius: 10px;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.2);
            line-height: 1.1;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        .me-date-month {
            display: block;
            font-size: 0.7rem;
            font-weight: 800;
            color: #e31c61;
            letter-spacing: 0.5px;
        }
        .me-date-day {
            display: block;
            font-size: 1.35rem;
            font-weight: 900;
        }
        .me-date-year {
            display: block;
            font-size: 0.65rem;
            color: #94a3b8;
        }
        .me-format-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .me-format-badge.presencial { background: #10b981; color: #fff; }
        .me-format-badge.online { background: #3b82f6; color: #fff; }
        .me-format-badge.híbrido { background: #8b5cf6; color: #fff; }

        .me-coverage-badge {
            position: absolute;
            bottom: 12px;
            left: 15px;
            background: rgba(227, 28, 97, 0.9);
            color: #fff;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            backdrop-filter: blur(4px);
        }

        .me-card-body {
            padding: 22px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        .me-card-meta-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }
        .me-badge-category {
            background: #fdf2f6;
            color: #e31c61;
            font-size: 0.75rem;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 6px;
            text-transform: uppercase;
        }
        .me-badge-country {
            font-size: 0.8rem;
            font-weight: 700;
            color: #64748b;
        }
        .me-card-title {
            font-size: 1.2rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 14px 0;
            line-height: 1.35;
        }
        .me-card-info-list {
            display: flex;
            flex-direction: column;
            gap: 7px;
            margin-bottom: 16px;
            font-size: 0.85rem;
            color: #475569;
        }
        .me-info-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .me-info-item i {
            color: #e31c61;
            width: 14px;
            text-align: center;
        }
        .me-card-excerpt {
            font-size: 0.88rem;
            color: #64748b;
            line-height: 1.5;
            margin-bottom: 20px;
            flex-grow: 1;
        }
        .me-card-footer {
            display: flex;
            gap: 10px;
            border-top: 1px solid #f1f5f9;
            padding-top: 16px;
            margin-top: auto;
        }
        .me-card-btn-action {
            flex-grow: 1;
            background: #0f172a;
            color: #fff !important;
            text-align: center;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 700;
            text-decoration: none !important;
            transition: all 0.2s ease;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
        }
        .me-card-btn-action:hover {
            background: #e31c61;
            color: #fff !important;
        }
        .me-card-btn-action.disabled {
            background: #e2e8f0;
            color: #94a3b8 !important;
            cursor: not-allowed;
        }
        .me-card-btn-gcal {
            background: #f1f5f9;
            color: #475569 !important;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 1rem;
            text-decoration: none !important;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .me-card-btn-gcal:hover {
            background: #4285f4;
            color: #fff !important;
        }

        .me-no-events, .me-empty-results {
            grid-column: 1 / -1;
            text-align: center;
            padding: 50px 20px;
            background: #fff;
            border-radius: 16px;
            border: 1px dashed #cbd5e1;
        }
        .me-btn-reset {
            background: #e31c61;
            color: #fff;
            border: none;
            padding: 8px 18px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.85rem;
            cursor: pointer;
            margin-top: 10px;
        }

        /* SUBMISSION SECTION */
        .me-submission-section {
            background: #ffffff;
            border-radius: 20px;
            padding: 45px 40px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 35px rgba(0,0,0,0.04);
            position: relative;
        }
        .me-submission-header {
            text-align: center;
            max-width: 760px;
            margin: 0 auto 35px auto;
        }
        .me-sub-badge {
            display: inline-block;
            background: #fdf2f6;
            color: #e31c61;
            font-size: 0.8rem;
            font-weight: 800;
            padding: 6px 14px;
            border-radius: 20px;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }
        .me-sub-title {
            font-size: 2.1rem;
            font-weight: 900;
            color: #0f172a;
            margin: 0 0 12px 0;
            letter-spacing: -0.5px;
        }
        .me-sub-desc {
            font-size: 1rem;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        /* BANNER ESPECIFICAÇÃO DE IMAGEM */
        .me-sub-spec-banner {
            display: flex;
            align-items: center;
            gap: 15px;
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-left: 5px solid #e31c61;
            border-radius: 10px;
            padding: 16px 20px;
            text-align: left;
            margin-top: 20px;
        }
        .spec-banner-icon {
            font-size: 2rem;
            color: #e31c61;
            flex-shrink: 0;
        }
        .spec-banner-text strong {
            display: block;
            color: #0f172a;
            font-size: 0.95rem;
            margin-bottom: 3px;
        }
        .spec-banner-text span {
            font-size: 0.88rem;
            color: #475569;
            line-height: 1.5;
        }

        .me-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        .me-form-col {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }
        .me-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        .me-field-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .me-field-group label {
            font-size: 0.88rem;
            font-weight: 700;
            color: #334155;
        }
        .me-label-highlight {
            color: #e31c61;
            font-weight: 700;
            font-size: 0.82rem;
        }
        .me-field-group input, 
        .me-field-group select, 
        .me-field-group textarea {
            padding: 11px 14px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            font-size: 0.92rem;
            color: #1e293b;
            outline: none;
            transition: all 0.2s ease;
            font-family: inherit;
        }
        .me-field-group input:focus, 
        .me-field-group select:focus, 
        .me-field-group textarea:focus {
            border-color: #e31c61;
            box-shadow: 0 0 0 3px rgba(227, 28, 97, 0.12);
        }
        .me-file-tip-box {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            background: #fff5f8;
            border: 1px solid #fecdd3;
            border-radius: 6px;
            padding: 8px 12px;
            font-size: 0.82rem;
            color: #9f1239;
            line-height: 1.45;
            margin-top: 4px;
        }
        .me-file-tip-box i {
            margin-top: 2px;
            font-size: 0.9rem;
        }

        .me-org-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 18px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .me-org-title {
            font-size: 0.85rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #475569;
            margin-bottom: 2px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* CAMPO CLICÁVEL DE COBERTURA JORNALÍSTICA */
        .me-coverage-request-card {
            margin-top: 25px;
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
            border: 2px solid #a7f3d0;
            border-radius: 14px;
            padding: 20px 24px;
            transition: all 0.25s ease;
        }
        .me-coverage-request-card:hover {
            border-color: #10b981;
            box-shadow: 0 6px 18px rgba(16, 185, 129, 0.15);
        }
        .me-coverage-toggle {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            cursor: pointer;
            user-select: none;
        }
        .me-coverage-toggle input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }
        .me-coverage-checkbox {
            width: 24px;
            height: 24px;
            border-radius: 6px;
            border: 2px solid #059669;
            background: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 2px;
            transition: all 0.2s ease;
        }
        .me-coverage-toggle input[type="checkbox"]:checked + .me-coverage-checkbox {
            background: #059669;
            border-color: #059669;
        }
        .me-coverage-toggle input[type="checkbox"]:checked + .me-coverage-checkbox::after {
            content: '✓';
            color: #fff;
            font-size: 15px;
            font-weight: 900;
        }
        .me-coverage-content {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .me-coverage-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: #065f46;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .me-coverage-title i {
            color: #10b981;
            font-size: 1.15rem;
        }
        .me-coverage-desc {
            font-size: 0.88rem;
            color: #047857;
            line-height: 1.5;
        }

        .me-form-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid #f1f5f9;
        }
        .me-btn-submit {
            background: linear-gradient(135deg, #e31c61 0%, #c4124e 100%);
            color: #fff;
            border: none;
            font-size: 1.05rem;
            font-weight: 800;
            padding: 14px 38px;
            border-radius: 30px;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(227, 28, 97, 0.35);
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .me-btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 26px rgba(227, 28, 97, 0.5);
        }
        .me-btn-submit:disabled {
            background: #94a3b8;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        .me-disclaimer {
            font-size: 0.85rem;
            color: #64748b;
            margin-top: 14px;
        }
        .me-disclaimer i {
            color: #10b981;
        }
        .me-form-status {
            max-width: 700px;
            margin: 0 auto 20px auto;
            border-radius: 10px;
            padding: 14px 18px;
            font-size: 0.95rem;
            display: none;
        }
        .me-form-status.success {
            display: block;
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        .me-form-status.error {
            display: block;
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        @media (max-width: 768px) {
            .me-agenda-hero {
                padding: 35px 20px;
            }
            .me-agenda-hero-title {
                font-size: 2rem;
            }
            .me-agenda-stats {
                grid-template-columns: 1fr;
            }
            .me-form-grid {
                grid-template-columns: 1fr;
            }
            .me-form-row {
                grid-template-columns: 1fr;
            }
            .me-submission-section {
                padding: 30px 20px;
            }
            .me-sub-spec-banner {
                flex-direction: column;
                text-align: center;
            }
            .me-events-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <!-- JAVASCRIPT SCOPED DE BUSCA, FILTROS E SUBMISSÃO AJAX -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('me-event-search');
        const cards = document.querySelectorAll('.me-event-card');
        const counterEl = document.getElementById('me-event-counter');
        const emptyEl = document.getElementById('me-empty-results');
        const pills = document.querySelectorAll('.me-pill');
        
        let activeFilters = {
            search: '',
            formato: 'all',
            regiao: 'all'
        };

        function filterEvents() {
            let visibleCount = 0;
            const query = activeFilters.search.toLowerCase().trim();

            cards.forEach(card => {
                const title = card.getAttribute('data-title') || '';
                const location = card.getAttribute('data-location') || '';
                const formato = card.getAttribute('data-formato') || '';
                const regiao = card.getAttribute('data-regiao') || '';

                const matchesSearch = !query || title.includes(query) || location.includes(query);
                const matchesFormato = (activeFilters.formato === 'all') || (formato === activeFilters.formato);
                const matchesRegiao = (activeFilters.regiao === 'all') || (regiao === activeFilters.regiao);

                if (matchesSearch && matchesFormato && matchesRegiao) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (counterEl) counterEl.textContent = visibleCount;
            if (emptyEl) {
                emptyEl.style.display = (visibleCount === 0) ? 'block' : 'none';
            }
        }

        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                activeFilters.search = e.target.value;
                filterEvents();
            });
        }

        pills.forEach(pill => {
            pill.addEventListener('click', function() {
                const type = this.getAttribute('data-type');
                const filterVal = this.getAttribute('data-filter');

                document.querySelectorAll('.me-pill[data-type="' + type + '"]').forEach(p => p.classList.remove('active'));
                this.classList.add('active');

                activeFilters[type] = filterVal;
                filterEvents();
            });
        });

        window.meResetFilters = function() {
            activeFilters = { search: '', formato: 'all', regiao: 'all' };
            if (searchInput) searchInput.value = '';
            pills.forEach(p => {
                if (p.getAttribute('data-filter') === 'all') {
                    p.classList.add('active');
                } else {
                    p.classList.remove('active');
                }
            });
            filterEvents();
        };

        // SUBMISSÃO DO FORMULÁRIO VIA AJAX
        const form = document.getElementById('me-event-submit-form');
        const statusBox = document.getElementById('me-form-status');
        const submitBtn = document.getElementById('me-btn-submit');

        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const btnText = submitBtn.querySelector('.btn-text');
                const btnLoading = submitBtn.querySelector('.btn-loading');

                submitBtn.disabled = true;
                btnText.style.display = 'none';
                btnLoading.style.display = 'inline-flex';
                statusBox.style.display = 'none';
                statusBox.className = 'me-form-status';

                const formData = new FormData(form);
                formData.append('action', 'me_submit_public_event');

                fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(res => {
                    submitBtn.disabled = false;
                    btnText.style.display = 'inline-flex';
                    btnLoading.style.display = 'none';

                    if (res.success) {
                        statusBox.className = 'me-form-status success';
                        statusBox.innerHTML = '<strong>Sucesso!</strong> ' + res.data.message;
                        statusBox.style.display = 'block';
                        form.reset();
                        statusBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    } else {
                        statusBox.className = 'me-form-status error';
                        statusBox.innerHTML = '<strong>Atenção:</strong> ' + (res.data.message || 'Erro ao processar o envio.');
                        statusBox.style.display = 'block';
                        statusBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                })
                .catch(err => {
                    submitBtn.disabled = false;
                    btnText.style.display = 'inline-flex';
                    btnLoading.style.display = 'none';
                    statusBox.className = 'me-form-status error';
                    statusBox.innerHTML = '<strong>Erro de conexão:</strong> Não foi possível enviar os dados. Tente novamente.';
                    statusBox.style.display = 'block';
                });
            });
        }
    });
    </script>
    <?php
    return ob_get_clean();
}
