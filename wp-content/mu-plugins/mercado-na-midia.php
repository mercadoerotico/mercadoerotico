<?php
/**
 * Plugin Name: Mercado Erótico - Na Mídia & Assessoria de Imprensa
 * Description: Sistema administrativo completo para gerenciar matérias e repercussões do portal na imprensa, alimentando a página /na-midia/.
 * Version: 1.0.0
 * Author: Equipe Portal Mercado Erótico
 */

if (!defined('ABSPATH')) exit;

/**
 * 1. DADOS PADRÃO (INITIAL PRESS CLIPPINGS)
 */
function mercado_get_default_na_midia_items() {
    return [
        [
            'id'          => 'folha-ecommerce',
            'outlet'      => 'Folha de S.Paulo',
            'category'    => 'jornal',
            'category_lbl'=> 'Jornal Impresso & Digital',
            'outlet_tag'  => 'FOLHA DE S.PAULO',
            'tag_color'   => '#1f2937',
            'title'       => 'O boom do comércio eletrônico de produtos sensuais no Brasil',
            'date'        => '2024',
            'excerpt'     => 'Mercado Erótico fornece dados de faturamento, crescimento das vendas digitais e a evolução da cadeia produtiva do segmento adulto no país.',
            'url'         => 'https://www1.folha.uol.com.br/',
            'featured'    => true
        ],
        [
            'id'          => 'oglobo-vibradores',
            'outlet'      => 'O Globo / G1',
            'category'    => 'portal',
            'category_lbl'=> 'Portal & Notícias',
            'outlet_tag'  => 'O GLOBO',
            'tag_color'   => '#0284c7',
            'title'       => 'Benefícios dos acessórios para a saúde e bem-estar sexual da mulher',
            'date'        => '2022',
            'excerpt'     => 'Análise técnica de especialistas do portal sobre a democratização do setor de bem-estar íntimo, segurança e certificação de produtos sensuais.',
            'url'         => 'https://oglobo.globo.com/saude/medicina/noticia/2022/07/sabrina-sato-revela-ter-40-vibradores-conheca-os-beneficios-do-acessorio-para-a-saude-da-mulher.ghtml',
            'featured'    => true
        ],
        [
            'id'          => 'estadao-maturidade',
            'outlet'      => 'O Estado de S. Paulo',
            'category'    => 'jornal',
            'category_lbl'=> 'Economia & Negócios',
            'outlet_tag'  => 'ESTADÃO',
            'tag_color'   => '#0369a1',
            'title'       => 'Profissionalização e maturidade empresarial no setor de bem-estar íntimo',
            'date'        => '2023',
            'excerpt'     => 'Como marcas brasileiras investem em tecnologia, governança e atendimento consultivo, com dados históricos mapeados por Paula Aguiar.',
            'url'         => 'https://www.estadao.com.br/',
            'featured'    => true
        ],
        [
            'id'          => 'exame-bilionario',
            'outlet'      => 'Revista Exame',
            'category'    => 'revista',
            'category_lbl'=> 'Business & Mercado',
            'outlet_tag'  => 'EXAME',
            'tag_color'   => '#b91c1c',
            'title'       => 'De tabu a indústria bilionária: a evolução do mercado erótico',
            'date'        => '2024',
            'excerpt'     => 'Métricas sobre o crescimento de franquias, distribuição e pequenas empresas da cadeia produtiva levantadas pela redação do Mercado Erótico.',
            'url'         => 'https://exame.com/',
            'featured'    => true
        ],
        [
            'id'          => 'tab-uol-gospel',
            'outlet'      => 'TAB UOL',
            'category'    => 'portal',
            'category_lbl'=> 'Cultura & Comportamento',
            'outlet_tag'  => 'TAB UOL',
            'tag_color'   => '#ea580c',
            'title'       => 'Refúgios de autocuidado e o impacto nos hábitos de intimidade dos brasileiros',
            'date'        => '2020',
            'excerpt'     => 'Reportagem especial aprofundando como o isolamento impulsionou novas práticas de bem-estar e a busca por conexão pessoal com colaboração do portal.',
            'url'         => 'https://tab.uol.com.br/noticias/redacao/2020/07/10/sexo-meditacao-psicodelia-refugios-para-lidar-com-impactos-do-isolamento.htm',
            'featured'    => false
        ],
        [
            'id'          => 'cnn-brasil-saude',
            'outlet'      => 'CNN Brasil',
            'category'    => 'tv',
            'category_lbl'=> 'Televisão & Notícias',
            'outlet_tag'  => 'CNN BRASIL',
            'tag_color'   => '#dc2626',
            'title'       => 'Saúde sexual feminina e autocuidado em debate nacional',
            'date'        => '2023',
            'excerpt'     => 'Participação em reportagens abordando fisioterapia pélvica, quebra de preconceitos e a consolidação do conceito de Sexual Wellness no Brasil.',
            'url'         => 'https://www.cnnbrasil.com.br/',
            'featured'    => true
        ],
        [
            'id'          => 'cbn-radio-entrevista',
            'outlet'      => 'Rádio CBN / Sistema Globo',
            'category'    => 'radio',
            'category_lbl'=> 'Rádio & Podcast',
            'outlet_tag'  => 'CBN RÁDIO',
            'tag_color'   => '#b45309',
            'title'       => 'A sexualidade feminina ligada ao empoderamento e ao autoconhecimento',
            'date'        => '2022',
            'excerpt'     => 'Entrevista em estúdio com as fundadoras e especialistas do portal debatendo transformações culturais e dados empíricos do varejo sensual.',
            'url'         => 'https://cbn.globoradio.globo.com/',
            'featured'    => false
        ],
        [
            'id'          => 'istoe-dinheiro',
            'outlet'      => 'IstoÉ Dinheiro',
            'category'    => 'revista',
            'category_lbl'=> 'Finanças & Indústria',
            'outlet_tag'  => 'ISTOÉ DINHEIRO',
            'tag_color'   => '#991b1b',
            'title'       => 'A pujança dos lançamentos nacionais e o faturamento do segmento sensual',
            'date'        => '2023',
            'excerpt'     => 'Análise das feiras corporativas, rodadas de negócios de atacado e o volume financeiro anual movimentado pelo setor.',
            'url'         => 'https://istoedinheiro.com.br/',
            'featured'    => false
        ],
        [
            'id'          => 'pegn-gestao',
            'outlet'      => 'Pequenas Empresas & Grandes Negócios',
            'category'    => 'revista',
            'category_lbl'=> 'Empreendedorismo',
            'outlet_tag'  => 'PEGN',
            'tag_color'   => '#047857',
            'title'       => 'Como abrir e estruturar um sex shop lucrativo e consultivo',
            'date'        => '2021',
            'excerpt'     => 'Literatura técnica, manuais de gestão e recomendações para lojistas elaborados pela consultoria de negócios de Paula Aguiar.',
            'url'         => 'https://revistapegn.globo.com/',
            'featured'    => false
        ]
    ];
}

function mercado_get_na_midia_items() {
    $items = get_option('mercado_na_midia_items', null);
    if (!is_array($items) || empty($items)) {
        $items = mercado_get_default_na_midia_items();
        update_option('mercado_na_midia_items', $items);
    }
    return $items;
}

/**
 * 2. ADMIN MENU & DASHBOARD
 */
add_action('admin_menu', function() {
    add_menu_page(
        'Na Mídia & Imprensa',
        'Na Mídia',
        'manage_options',
        'mercado-na-midia',
        'mercado_na_midia_admin_page',
        'dashicons-megaphone',
        29
    );
});

function mercado_na_midia_admin_page() {
    if (!current_user_can('manage_options')) return;

    $items = mercado_get_na_midia_items();
    $message = '';
    $editing_item = null;

    // Ações POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Reset
        if (isset($_POST['mercado_midia_action']) && $_POST['mercado_midia_action'] === 'reset_defaults') {
            check_admin_referer('mercado_midia_reset_verify', 'mercado_midia_nonce');
            $items = mercado_get_default_na_midia_items();
            update_option('mercado_na_midia_items', $items);
            if (function_exists('wp_cache_flush')) wp_cache_flush();
            $message = '<div class="notice notice-success is-dismissible"><p><strong>Padrões Restaurados:</strong> Todas as 9 matérias originais foram recarregadas com sucesso!</p></div>';
        }

        // Salvar / Atualizar
        if (isset($_POST['mercado_midia_action']) && $_POST['mercado_midia_action'] === 'save_item') {
            check_admin_referer('mercado_midia_save_verify', 'mercado_midia_nonce');

            $item_id   = sanitize_title($_POST['item_id'] ?? '');
            if (empty($item_id)) {
                $item_id = 'midia-' . time();
            }

            $outlet      = sanitize_text_field($_POST['outlet'] ?? '');
            $category    = sanitize_text_field($_POST['category'] ?? 'portal');
            $category_lbl= sanitize_text_field($_POST['category_lbl'] ?? '');
            $outlet_tag  = sanitize_text_field($_POST['outlet_tag'] ?? strtoupper($outlet));
            $tag_color   = sanitize_hex_color($_POST['tag_color'] ?? '#e31c61') ?: '#e31c61';
            $title       = sanitize_text_field($_POST['title'] ?? '');
            $date        = sanitize_text_field($_POST['date'] ?? date('Y'));
            $excerpt     = sanitize_textarea_field($_POST['excerpt'] ?? '');
            $url         = esc_url_raw($_POST['url'] ?? '');
            $featured    = !empty($_POST['featured']);

            $new_item = [
                'id'          => $item_id,
                'outlet'      => $outlet,
                'category'    => $category,
                'category_lbl'=> $category_lbl,
                'outlet_tag'  => $outlet_tag,
                'tag_color'   => $tag_color,
                'title'       => $title,
                'date'        => $date,
                'excerpt'     => $excerpt,
                'url'         => $url,
                'featured'    => $featured
            ];

            // Update ou Add
            $found = false;
            foreach ($items as $idx => $it) {
                if ($it['id'] === $item_id) {
                    $items[$idx] = $new_item;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                array_unshift($items, $new_item);
            }

            update_option('mercado_na_midia_items', $items);
            if (function_exists('wp_cache_flush')) wp_cache_flush();
            $message = '<div class="notice notice-success is-dismissible"><p><strong>Matéria Salva:</strong> A publicação na mídia foi registrada com sucesso e já está disponível na página pública!</p></div>';
        }

        // Delete
        if (isset($_POST['mercado_midia_action']) && $_POST['mercado_midia_action'] === 'delete_item') {
            check_admin_referer('mercado_midia_delete_verify', 'mercado_midia_nonce');
            $del_id = sanitize_text_field($_POST['delete_id'] ?? '');
            $filtered = [];
            foreach ($items as $it) {
                if ($it['id'] !== $del_id) {
                    $filtered[] = $it;
                }
            }
            $items = $filtered;
            update_option('mercado_na_midia_items', $items);
            if (function_exists('wp_cache_flush')) wp_cache_flush();
            $message = '<div class="notice notice-warning is-dismissible"><p>Matéria removida com sucesso.</p></div>';
        }
    }

    // Modo edição
    if (isset($_GET['action']) && $_GET['action'] === 'edit' && !empty($_GET['item_id'])) {
        $edit_id = sanitize_text_field($_GET['item_id']);
        foreach ($items as $it) {
            if ($it['id'] === $edit_id) {
                $editing_item = $it;
                break;
            }
        }
    }

    ?>
    <div class="wrap me-admin-wrap">
        <h1 class="wp-heading-inline"><span class="dashicons dashicons-megaphone" style="font-size:28px;width:30px;height:30px;margin-right:8px;color:#e31c61;"></span> Na Mídia &bull; Gestão de Imprensa &amp; Citações</h1>
        <hr class="wp-header-end">

        <?php echo $message; ?>

        <div class="me-status-box">
            <div class="me-status-item">
                <span class="me-status-dot"></span>
                <strong>Status do Módulo:</strong> Ativo &amp; Integrado à página <code>/na-midia/</code>
            </div>
            <div class="me-status-item">
                <span class="dashicons dashicons-media-document"></span>
                <strong>Total de Matérias Cadastradas:</strong> <?php echo count($items); ?>
            </div>
            <div class="me-status-item">
                <span class="dashicons dashicons-external"></span>
                <a href="<?php echo esc_url(home_url('/na-midia/')); ?>" target="_blank" class="button button-small" style="color:#e31c61;font-weight:700;">
                    Ver Página Pública <i class="dashicons dashicons-arrow-right-alt2" style="font-size:14px;vertical-align:middle;"></i>
                </a>
            </div>
        </div>

        <div class="me-admin-columns">
            <!-- Coluna Principal: Tabela de Matérias -->
            <div class="me-col-main">
                <div class="postbox me-postbox">
                    <div class="postbox-header">
                        <h2><span class="dashicons dashicons-list-view"></span> Matérias &amp; Aparições na Imprensa (<?php echo count($items); ?>)</h2>
                    </div>
                    <div class="inside" style="padding:0;">
                        <table class="wp-list-table widefat fixed striped">
                            <thead>
                                <tr>
                                    <th style="width:160px;">Veículo</th>
                                    <th>Título da Reportagem &amp; Resumo</th>
                                    <th style="width:100px;">Ano / Data</th>
                                    <th style="width:120px;">Categoria</th>
                                    <th style="width:90px;text-align:center;">Destaque</th>
                                    <th style="width:130px;text-align:right;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($items)): ?>
                                    <tr><td colspan="6" style="text-align:center;padding:30px;">Nenhuma matéria cadastrada. Adicione uma no formulário ao lado ou restaure os padrões.</td></tr>
                                <?php else: ?>
                                    <?php foreach ($items as $it): ?>
                                        <tr>
                                            <td>
                                                <strong style="color:#0f172a;display:block;"><?php echo esc_html($it['outlet']); ?></strong>
                                                <span style="display:inline-block;background:<?php echo esc_attr($it['tag_color'] ?? '#e31c61'); ?>;color:#fff;font-size:10px;font-weight:700;padding:2px 6px;border-radius:4px;margin-top:4px;">
                                                    <?php echo esc_html($it['outlet_tag'] ?? $it['outlet']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <strong style="font-size:13.5px;color:#1e293b;display:block;margin-bottom:4px;"><?php echo esc_html($it['title']); ?></strong>
                                                <p style="margin:0;color:#64748b;font-size:12px;line-height:1.4;"><?php echo esc_html(wp_trim_words($it['excerpt'], 20, '...')); ?></p>
                                                <?php if (!empty($it['url'])): ?>
                                                    <a href="<?php echo esc_url($it['url']); ?>" target="_blank" style="font-size:11px;color:#e31c61;text-decoration:none;display:inline-block;margin-top:4px;">
                                                        <span class="dashicons dashicons-admin-links" style="font-size:12px;vertical-align:middle;"></span> <?php echo esc_html($it['url']); ?>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                            <td><strong><?php echo esc_html($it['date']); ?></strong></td>
                                            <td>
                                                <span class="me-cat-pill"><?php echo esc_html($it['category_lbl'] ?: ucfirst($it['category'])); ?></span>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php if (!empty($it['featured'])): ?>
                                                    <span style="color:#eab308;font-size:16px;" title="Destaque">★</span>
                                                <?php else: ?>
                                                    <span style="color:#cbd5e1;">&bull;</span>
                                                <?php endif; ?>
                                            </td>
                                            <td style="text-align:right;">
                                                <a href="<?php echo admin_url('admin.php?page=mercado-na-midia&action=edit&item_id=' . urlencode($it['id'])); ?>" class="button button-small" title="Editar">
                                                    Editar
                                                </a>
                                                <form method="post" style="display:inline-block;" onsubmit="return confirm('Deseja realmente remover esta matéria?');">
                                                    <?php wp_nonce_field('mercado_midia_delete_verify', 'mercado_midia_nonce'); ?>
                                                    <input type="hidden" name="mercado_midia_action" value="delete_item">
                                                    <input type="hidden" name="delete_id" value="<?php echo esc_attr($it['id']); ?>">
                                                    <button type="submit" class="button button-small button-link-delete" style="color:#b91c1c;">
                                                        Excluir
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Coluna Lateral: Formulário de Adicionar / Editar -->
            <div class="me-col-side">
                <div class="postbox me-postbox" style="border-top:3px solid #e31c61;">
                    <div class="postbox-header">
                        <h2>
                            <span class="dashicons <?php echo $editing_item ? 'dashicons-edit' : 'dashicons-plus-alt2'; ?>"></span>
                            <?php echo $editing_item ? 'Editar Matéria' : 'Nova Matéria na Mídia'; ?>
                        </h2>
                    </div>
                    <div class="inside">
                        <form method="post" action="<?php echo admin_url('admin.php?page=mercado-na-midia'); ?>">
                            <?php wp_nonce_field('mercado_midia_save_verify', 'mercado_midia_nonce'); ?>
                            <input type="hidden" name="mercado_midia_action" value="save_item">
                            <input type="hidden" name="item_id" value="<?php echo $editing_item ? esc_attr($editing_item['id']) : ''; ?>">

                            <p>
                                <label for="outlet"><strong>Nome do Veículo:</strong></label><br>
                                <input type="text" name="outlet" id="outlet" class="widefat" value="<?php echo $editing_item ? esc_attr($editing_item['outlet']) : ''; ?>" placeholder="Ex: Folha de S.Paulo, O Globo, CNN Brasil, Exame" required>
                            </p>

                            <p>
                                <label for="category"><strong>Tipo de Mídia / Canal:</strong></label><br>
                                <select name="category" id="category" class="widefat">
                                    <option value="jornal" <?php selected($editing_item['category'] ?? '', 'jornal'); ?>>📰 Jornal Impresso / Digital</option>
                                    <option value="portal" <?php selected($editing_item['category'] ?? '', 'portal'); ?>>🌐 Portal de Notícias</option>
                                    <option value="tv" <?php selected($editing_item['category'] ?? '', 'tv'); ?>>📺 Televisão &amp; Streaming</option>
                                    <option value="radio" <?php selected($editing_item['category'] ?? '', 'radio'); ?>>🎙️ Rádio &amp; Podcast</option>
                                    <option value="revista" <?php selected($editing_item['category'] ?? '', 'revista'); ?>>📖 Revista Especializada</option>
                                </select>
                            </p>

                            <p>
                                <label for="category_lbl"><strong>Subtítulo / Linha Editorial:</strong></label><br>
                                <input type="text" name="category_lbl" id="category_lbl" class="widefat" value="<?php echo $editing_item ? esc_attr($editing_item['category_lbl']) : ''; ?>" placeholder="Ex: Economia & Negócios, Saúde & Bem-Estar">
                            </p>

                            <p>
                                <label for="outlet_tag"><strong>Texto da Tag / Selo:</strong></label><br>
                                <input type="text" name="outlet_tag" id="outlet_tag" class="widefat" value="<?php echo $editing_item ? esc_attr($editing_item['outlet_tag']) : ''; ?>" placeholder="Ex: FOLHA DE S.PAULO, G1">
                            </p>

                            <p>
                                <label for="title"><strong>Título da Reportagem / Pauta:</strong></label><br>
                                <input type="text" name="title" id="title" class="widefat" value="<?php echo $editing_item ? esc_attr($editing_item['title']) : ''; ?>" placeholder="Ex: O boom do comércio eletrônico de produtos sensuais" required>
                            </p>

                            <p>
                                <label for="date"><strong>Data ou Ano de Publicação:</strong></label><br>
                                <input type="text" name="date" id="date" class="widefat" value="<?php echo $editing_item ? esc_attr($editing_item['date']) : date('Y'); ?>" placeholder="Ex: 2024, Julho/2023, 14/05/2024">
                            </p>

                            <p>
                                <label for="excerpt"><strong>Resumo / Como o Mercado Erótico foi Citado:</strong></label><br>
                                <textarea name="excerpt" id="excerpt" class="widefat" rows="4" placeholder="Descreva brevemente a citação, dados fornecidos ou análise do portal na matéria..."><?php echo $editing_item ? esc_textarea($editing_item['excerpt']) : ''; ?></textarea>
                            </p>

                            <p>
                                <label for="url"><strong>Link Original da Matéria (URL Completa):</strong></label><br>
                                <input type="url" name="url" id="url" class="widefat" value="<?php echo $editing_item ? esc_attr($editing_item['url']) : ''; ?>" placeholder="https://globo.com/noticia/..." required>
                            </p>

                            <p>
                                <label>
                                    <input type="checkbox" name="featured" value="1" <?php checked(!empty($editing_item['featured'])); ?>>
                                    <strong>Destacar na primeira linha da página</strong>
                                </label>
                            </p>

                            <p style="margin-top:20px;">
                                <button type="submit" class="button button-primary button-large" style="width:100%;background:#e31c61;border-color:#e31c61;">
                                    <span class="dashicons <?php echo $editing_item ? 'dashicons-update' : 'dashicons-plus'; ?>" style="vertical-align:middle;"></span>
                                    <?php echo $editing_item ? 'Salvar Alterações' : 'Adicionar à Mídia'; ?>
                                </button>
                                <?php if ($editing_item): ?>
                                    <a href="<?php echo admin_url('admin.php?page=mercado-na-midia'); ?>" class="button button-secondary" style="width:100%;margin-top:8px;text-align:center;">
                                        Cancelar Edição
                                    </a>
                                <?php endif; ?>
                            </p>
                        </form>
                    </div>
                </div>

                <!-- Reset Box -->
                <div class="postbox me-postbox">
                    <div class="postbox-header">
                        <h2><span class="dashicons dashicons-image-rotate"></span> Restaurar Dados Padrão</h2>
                    </div>
                    <div class="inside">
                        <p class="description">Recarrega as matérias originais recomendadas de grandes veículos nacionais (Folha, Globo, Estadão, Exame, etc.).</p>
                        <form method="post" action="" onsubmit="return confirm('Atenção: Todas as matérias personalizadas serão substituídas pela lista padrão. Continuar?');">
                            <?php wp_nonce_field('mercado_midia_reset_verify', 'mercado_midia_nonce'); ?>
                            <input type="hidden" name="mercado_midia_action" value="reset_defaults">
                            <button type="submit" class="button button-secondary" style="color:#d63638;border-color:#d63638;width:100%;">
                                Restaurar Lista Padrão
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    .me-admin-wrap { max-width: 1350px; margin-top: 20px; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
    .me-status-box { background: #fff; border: 1px solid #c3c4c7; border-radius: 8px; padding: 14px 20px; margin: 18px 0 25px; display: flex; align-items: center; gap: 30px; flex-wrap: wrap; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
    .me-status-item { display: inline-flex; align-items: center; gap: 6px; font-size: 13px; color: #1d2327; }
    .me-status-dot { width: 10px; height: 10px; border-radius: 50%; background: #10b981; display: inline-block; }
    .me-admin-columns { display: flex; gap: 25px; align-items: flex-start; }
    .me-col-main { flex: 1 1 65%; min-width: 0; }
    .me-col-side { flex: 1 1 35%; min-width: 320px; }
    .me-postbox { background: #fff; border: 1px solid #c3c4c7; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.04); margin-bottom: 25px; overflow: hidden; }
    .me-postbox .postbox-header { background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 12px 18px; }
    .me-postbox .postbox-header h2 { font-size: 14px; font-weight: 700; margin: 0; display: flex; align-items: center; gap: 8px; }
    .me-postbox .inside { padding: 18px; margin: 0; }
    .me-cat-pill { display: inline-block; background: #f1f5f9; color: #0f172a; font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 4px; border: 1px solid #e2e8f0; }
    @media (max-width: 960px) {
        .me-admin-columns { flex-direction: column; }
        .me-col-side { width: 100%; }
    }
    </style>
    <?php
}

/**
 * 3. SHORTCODE DINÂMICO PARA /NA-MIDIA/
 */
add_shortcode('mercado_na_midia', 'mercado_na_midia_render');
function mercado_na_midia_render() {
    $items = mercado_get_na_midia_items();
    $total_items = count($items);

    ob_start();
    ?>
    <div class="me-internal-wrapper me-na-midia-app" id="na-midia-app">
        <!-- Hero Banner Oficial -->
        <div class="me-internal-hero">
            <span class="me-internal-badge"><i class="fas fa-bullhorn"></i> IMPRENSA &bull; RECONHECIMENTO &amp; CREDIBILIDADE</span>
            <h1 class="me-internal-title">Mercado Erótico na Mídia</h1>
            <p class="me-internal-subtitle">
                O portal e suas especialistas são referências consolidadas como fontes primárias de dados, investigações comportamentais e inteligência de mercado nos principais veículos de imprensa do Brasil e do mundo.
            </p>
            <div class="me-midia-stats-bar">
                <span class="stat-highlight"><strong><?php echo $total_items; ?></strong> Aparições Documentadas</span>
                <span class="stat-sep">&bull;</span>
                <span>Cobertura Nacional e Internacional</span>
                <span class="stat-sep">&bull;</span>
                <span>Jornais, TV, Rádio e Revistas de Negócios</span>
            </div>
        </div>

        <!-- Filtro Rápido por Canal / Veículo -->
        <div class="me-midia-filter-bar">
            <span class="filter-bar-lbl"><i class="fas fa-filter"></i> Filtrar por Formato:</span>
            <div class="midia-filter-pills" id="midiaFilterPills">
                <button type="button" class="midia-pill active" data-cat="all" onclick="filterMidia('all', this)">
                    🌐 Todas as Aparições (<?php echo $total_items; ?>)
                </button>
                <button type="button" class="midia-pill" data-cat="jornal" onclick="filterMidia('jornal', this)">
                    📰 Jornais
                </button>
                <button type="button" class="midia-pill" data-cat="portal" onclick="filterMidia('portal', this)">
                    💻 Portais de Notícias
                </button>
                <button type="button" class="midia-pill" data-cat="tv" onclick="filterMidia('tv', this)">
                    📺 Televisão
                </button>
                <button type="button" class="midia-pill" data-cat="radio" onclick="filterMidia('radio', this)">
                    🎙️ Rádio &amp; Podcasts
                </button>
                <button type="button" class="midia-pill" data-cat="revista" onclick="filterMidia('revista', this)">
                    📖 Revistas de Negócios
                </button>
            </div>
        </div>

        <!-- Grid Dinâmico de Matérias -->
        <div class="me-media-grid" id="midiaCardsGrid">
            <?php foreach ($items as $it): 
                $cat = esc_attr($it['category'] ?? 'portal');
                $tag_color = esc_attr($it['tag_color'] ?? '#e31c61');
            ?>
                <article class="media-card" data-category="<?php echo $cat; ?>">
                    <div class="media-outlet-header">
                        <span class="outlet-tag" style="background:<?php echo $tag_color; ?>; color:#ffffff;">
                            <?php echo esc_html($it['outlet_tag'] ?? $it['outlet']); ?>
                        </span>
                        <span class="media-year"><i class="far fa-calendar-alt"></i> <?php echo esc_html($it['date']); ?></span>
                    </div>
                    <div class="media-category-sub"><?php echo esc_html($it['category_lbl'] ?? ''); ?></div>
                    <h3 class="media-headline"><?php echo esc_html($it['title']); ?></h3>
                    <p class="media-excerpt"><?php echo esc_html($it['excerpt']); ?></p>
                    <div class="media-card-footer">
                        <a href="<?php echo esc_url($it['url']); ?>" target="_blank" rel="noopener noreferrer" class="media-link">
                            <span>Acessar Reportagem Original</span>
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <!-- Box Assessoria de Imprensa para Jornalistas -->
        <section class="me-press-kit-box" aria-label="Espaço para Imprensa">
            <div class="press-kit-inner">
                <div class="press-kit-icon">
                    <i class="fas fa-microphone-alt"></i>
                </div>
                <div class="press-kit-content">
                    <span class="press-badge">ATENDIMENTO À IMPRENSA</span>
                    <h2 class="press-title">Espaço para Jornalistas, Produtores e Redações</h2>
                    <p class="press-desc">
                        Precisa de dados consolidados do mercado erótico brasileiro, estatísticas de faturamento, fontes técnicas para entrevistas ou dados comportamentais sobre <em>Sexual Wellness</em> para sua reportagem? Nossa equipe editorial e assessoria atende com rapidez redatores, emissoras de TV, podcasts e portais.
                    </p>
                    <div class="press-kit-actions">
                        <a href="<?php echo esc_url(home_url('/contato/')); ?>" class="btn-press-primary">
                            <i class="fas fa-envelope"></i> Solicitar Pauta ou Fonte
                        </a>
                        <a href="https://api.whatsapp.com/send?phone=5562982763039&text=Ol%C3%A1%2C%20sou%20jornalista%20e%20gostaria%20de%20solicitar%20uma%20pauta%2Fdados%20ao%20Mercado%20Er%C3%B3tico." target="_blank" rel="noopener noreferrer" class="btn-press-whatsapp">
                            <i class="fab fa-whatsapp"></i> WhatsApp da Redação
                        </a>
                        <a href="<?php echo esc_url(home_url('/pesquisas-de-mercado/')); ?>" class="btn-press-secondary">
                            <i class="fas fa-chart-line"></i> Consultar Indicadores &amp; Pesquisas
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Estilos do Módulo Na Mídia -->
    <style>
    .me-na-midia-app {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        color: #1e293b;
        max-width: 1200px;
        margin: 0 auto;
        padding-bottom: 70px;
    }

    /* Hero */
    .me-internal-hero {
        background: linear-gradient(135deg, #130a17 0%, #200924 60%, #160719 100%);
        border: 1px solid rgba(227, 28, 97, 0.4);
        border-radius: 20px;
        padding: 42px 36px;
        text-align: center;
        color: #ffffff;
        box-shadow: 0 16px 45px rgba(0, 0, 0, 0.25);
        margin-bottom: 30px;
    }
    .me-internal-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(227, 28, 97, 0.2);
        color: #ff3b7e;
        border: 1px solid rgba(227, 28, 97, 0.5);
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 0.78rem;
        font-weight: 800;
        letter-spacing: 0.8px;
        margin-bottom: 14px;
    }
    .me-internal-title {
        color: #ffffff;
        font-size: 2.2rem;
        font-weight: 800;
        margin: 0 0 12px;
        letter-spacing: -0.5px;
    }
    .me-internal-subtitle {
        color: #cbd5e1;
        font-size: 1.05rem;
        line-height: 1.6;
        max-width: 820px;
        margin: 0 auto 20px;
    }
    .me-midia-stats-bar {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 8px 18px;
        border-radius: 50px;
        font-size: 0.82rem;
        color: #94a3b8;
        flex-wrap: wrap;
        justify-content: center;
    }
    .stat-highlight {
        color: #ff3b7e;
        font-weight: 700;
    }
    .stat-sep {
        color: rgba(255, 255, 255, 0.3);
    }

    /* Filter Bar */
    .me-midia-filter-bar {
        display: flex;
        align-items: center;
        gap: 16px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 14px 20px;
        border-radius: 14px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        flex-wrap: wrap;
    }
    .filter-bar-lbl {
        font-size: 0.88rem;
        font-weight: 700;
        color: #475569;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .midia-filter-pills {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    .midia-pill {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #475569;
        padding: 7px 14px;
        border-radius: 50px;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .midia-pill:hover {
        background: #f1f5f9;
        color: #0f172a;
        border-color: #cbd5e1;
    }
    .midia-pill.active {
        background: #e31c61;
        color: #ffffff;
        border-color: #e31c61;
        box-shadow: 0 3px 10px rgba(227, 28, 97, 0.28);
    }

    /* Grid de Cards */
    .me-media-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 22px;
        margin-bottom: 40px;
    }
    .media-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px;
        display: flex;
        flex-direction: column;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04);
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        position: relative;
    }
    .media-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08);
        border-color: #f43f5e;
    }
    .media-outlet-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }
    .outlet-tag {
        font-size: 0.72rem;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 6px;
        letter-spacing: 0.6px;
        text-transform: uppercase;
    }
    .media-year {
        font-size: 0.8rem;
        color: #94a3b8;
        font-weight: 600;
    }
    .media-category-sub {
        font-size: 0.76rem;
        font-weight: 700;
        color: #e31c61;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
    }
    .media-headline {
        font-size: 1.15rem;
        font-weight: 800;
        line-height: 1.35;
        color: #0f172a;
        margin: 0 0 12px;
    }
    .media-excerpt {
        font-size: 0.9rem;
        color: #64748b;
        line-height: 1.55;
        margin: 0 0 18px;
        flex-grow: 1;
    }
    .media-card-footer {
        padding-top: 14px;
        border-top: 1px solid #f1f5f9;
    }
    .media-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #e31c61;
        font-size: 0.85rem;
        font-weight: 700;
        text-decoration: none;
        transition: gap 0.2s ease, color 0.2s ease;
    }
    .media-link:hover {
        color: #be123c;
        gap: 9px;
    }

    /* Box Assessoria */
    .me-press-kit-box {
        background: linear-gradient(135deg, #18091f 0%, #260a2c 100%);
        border: 1px solid rgba(227, 28, 97, 0.4);
        border-radius: 20px;
        padding: 38px 40px;
        color: #ffffff;
        box-shadow: 0 16px 40px rgba(0, 0, 0, 0.2);
    }
    .press-kit-inner {
        display: flex;
        gap: 28px;
        align-items: flex-start;
    }
    .press-kit-icon {
        width: 54px;
        height: 54px;
        min-width: 54px;
        border-radius: 12px;
        background: rgba(227, 28, 97, 0.2);
        color: #ff3b7e;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        border: 1px solid rgba(227, 28, 97, 0.4);
    }
    .press-badge {
        color: #ff3b7e;
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 0.8px;
        display: block;
        margin-bottom: 6px;
    }
    .press-title {
        color: #ffffff;
        font-size: 1.5rem;
        font-weight: 800;
        margin: 0 0 12px;
    }
    .press-desc {
        color: #cbd5e1;
        font-size: 0.95rem;
        line-height: 1.6;
        margin: 0 0 24px;
        max-width: 880px;
    }
    .press-kit-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }
    .btn-press-primary {
        background: #e31c61;
        color: #ffffff;
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 0.88rem;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s;
    }
    .btn-press-primary:hover {
        background: #be123c;
        color: #ffffff;
    }
    .btn-press-whatsapp {
        background: #25d366;
        color: #ffffff;
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 0.88rem;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s;
    }
    .btn-press-whatsapp:hover {
        background: #1eb956;
        color: #ffffff;
    }
    .btn-press-secondary {
        background: rgba(255, 255, 255, 0.08);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 0.88rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s;
    }
    .btn-press-secondary:hover {
        background: rgba(255, 255, 255, 0.16);
        color: #ffffff;
    }

    /* Responsividade */
    @media (max-width: 991px) {
        .me-media-grid { grid-template-columns: repeat(2, 1fr); }
        .press-kit-inner { flex-direction: column; gap: 18px; }
    }
    @media (max-width: 640px) {
        .me-media-grid { grid-template-columns: 1fr; }
        .me-internal-hero { padding: 30px 20px; }
        .me-internal-title { font-size: 1.65rem; }
        .me-press-kit-box { padding: 26px 20px; }
    }
    </style>

    <!-- Script de Filtro Interativo -->
    <script>
    function filterMidia(category, btn) {
        // Atualiza pills
        document.querySelectorAll('#midiaFilterPills .midia-pill').forEach(function(p) {
            p.classList.remove('active');
        });
        if (btn) btn.classList.add('active');

        // Filtra cards
        const cards = document.querySelectorAll('#midiaCardsGrid .media-card');
        cards.forEach(function(card) {
            const cardCat = card.getAttribute('data-category');
            if (category === 'all' || cardCat === category) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }
    </script>
    <?php
    return ob_get_clean();
}
