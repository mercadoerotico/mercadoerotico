<?php
/**
 * Plugin Name: Mercado Erótico - Acervo de Notícias & Pesquisa
 * Description: Sistema de busca e filtragem histórica, geográfica e temática com dossiês estratégicos permanentes.
 * Version: 2.5.0
 * Author: Antigravity
 */

if (!defined('ABSPATH')) exit;

// 1. Dossiês Temáticos Estratégicos Permanentes
function mercado_acervo_get_dossiers() {
    return [
        'historia-sexshops' => [
            'slug'        => 'historia-sexshops',
            'title'       => 'História dos Sexshops no Brasil',
            'badge'       => 'Memória Setorial',
            'icon'        => '🏛️',
            'tagline'     => 'Da clandestinidade aos shoppings: a evolução do varejo físico ao digital',
            'description' => 'Documentação histórica completa sobre o pioneirismo no Brasil, as primeiras lojas físicas, a migração para o e-commerce e as três décadas de transformação sociocultural do mercado erótico nacional.',
            'term'        => 'sexshop',
            'cats'        => []
        ],
        'industria-brasileira' => [
            'slug'        => 'industria-brasileira',
            'title'       => 'Indústria Brasileira de Produtos Eróticos',
            'badge'       => 'Produção Nacional',
            'icon'        => '🏭',
            'tagline'     => 'Parque fabril, tecnologia em silicone, inovação de moldes e marcas nacionais',
            'description' => 'Mapeamento profundo da indústria nacional de sex toys e cosméticos sensuais: fabricação própria, polos industriais no Brasil, substituição de importações e certificações técnicas.',
            'term'        => 'indústria',
            'cats'        => []
        ],
        'cosmeticos-sensuais' => [
            'slug'        => 'cosmeticos-sensuais',
            'title'       => 'Mercado de Cosméticos Sensuais',
            'badge'       => 'Segmento Líder',
            'icon'        => '💄',
            'tagline'     => 'Lubrificantes, géis funcionais, óleos corporais e perfumaria íntima',
            'description' => 'O segmento com maior volume de vendas e giro do setor íntimo. Tendências farmacêuticas, vigilância sanitária, inovação sensorial, ingredientes naturais e aromaterapia aplicada ao bem-estar.',
            'term'        => 'cosmético',
            'cats'        => []
        ],
        'sexual-wellness' => [
            'slug'        => 'sexual-wellness',
            'title'       => 'Sexual Wellness e Saúde Íntima',
            'badge'       => 'Saúde & Bem-Estar',
            'icon'        => '🩺',
            'tagline'     => 'A convergência entre prazer, medicina sexual, ginecologia e fisioterapia pélvica',
            'description' => 'A desmistificação do tabu pelo viés da saúde integrativa. Estudos médicos, saúde pélvica, tratamentos, menopausa, longevidade sexual e a integração entre profissionais de saúde e produtos íntimos.',
            'term'        => '',
            'cats'        => ['sexologia', 'saude', 'sexual-wellness', 'sexo-na-pratica']
        ],
        'legislacao' => [
            'slug'        => 'legislacao',
            'title'       => 'Legislação e Regulação do Mercado Adulto',
            'badge'       => 'Segurança Jurídica',
            'icon'        => '⚖️',
            'tagline'     => 'Normas ANVISA, enquadramento fiscal, compliance e projetos de lei',
            'description' => 'Guia analítico permanente sobre os marcos regulatórios no Brasil: exigências da ANVISA para cosméticos, tributação e classificação fiscal de produtos eróticos, direito do consumidor e regras de publicidade.',
            'term'        => 'legislação',
            'cats'        => []
        ],
        'tecnologia-ia' => [
            'slug'        => 'tecnologia-ia',
            'title'       => 'Tecnologia & Inteligência Artificial (Sextech)',
            'badge'       => 'Inovação & Futuro',
            'icon'        => '🤖',
            'tagline'     => 'Dispositivos IoT conectados, realidade virtual, algoritmos e prazer digital',
            'description' => 'O ecossistema sextech em rápida aceleração: estimuladores controlados por aplicativo via Bluetooth/Wi-Fi, interfaces hápticas, inteligência artificial generativa e o futuro das relações mediadas por tecnologia.',
            'term'        => '',
            'cats'        => ['iasex', 'tecnologia', 'sextech']
        ],
        'america-latina' => [
            'slug'        => 'america-latina',
            'title'       => 'Mercado Erótico na América Latina',
            'badge'       => 'Panorama Regional',
            'icon'        => '🌎',
            'tagline'     => 'Expansão de marcas brasileiras, comportamento de consumo e dados na LATAM',
            'description' => 'Investigações sobre os mercados vizinhos: oportunidades de exportação para marcas nacionais, feiras latino-americanas, hábitos de consumo e barreiras alfandegárias na Colômbia, Argentina, Chile e México.',
            'term'        => 'América Latina',
            'cats'        => []
        ]
    ];
}

// 2. Register REST API endpoint
add_action('rest_api_init', function() {
    register_rest_route('mercado/v1', '/acervo', [
        'methods'             => 'GET',
        'callback'            => 'mercado_acervo_api_callback',
        'permission_callback' => '__return_true'
    ]);
});

// Also register Admin AJAX fallback for 100% reliability
add_action('wp_ajax_mercado_acervo_ajax', 'mercado_acervo_ajax_callback');
add_action('wp_ajax_nopriv_mercado_acervo_ajax', 'mercado_acervo_ajax_callback');

function mercado_acervo_ajax_callback() {
    $year   = isset($_GET['year']) ? sanitize_text_field($_GET['year']) : 'all';
    $theme  = isset($_GET['theme']) ? sanitize_text_field($_GET['theme']) : 'all';
    $dossie = isset($_GET['dossie']) ? sanitize_text_field($_GET['dossie']) : '';
    $geo    = isset($_GET['geo']) ? sanitize_text_field($_GET['geo']) : 'all';
    $type   = isset($_GET['type']) ? sanitize_text_field($_GET['type']) : 'all';
    $q      = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';
    $page   = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

    $result = mercado_acervo_get_posts($year, $theme, $q, $page, 12, $dossie, $geo, $type);
    wp_send_json($result);
}

function mercado_acervo_api_callback($request) {
    $year   = sanitize_text_field($request->get_param('year'));
    $theme  = sanitize_text_field($request->get_param('theme'));
    $dossie = sanitize_text_field($request->get_param('dossie'));
    $geo    = sanitize_text_field($request->get_param('geo'));
    $type   = sanitize_text_field($request->get_param('type'));
    $q      = sanitize_text_field($request->get_param('q'));
    $page   = max(1, intval($request->get_param('page')));

    return mercado_acervo_get_posts($year, $theme, $q, $page, 12, $dossie, $geo, $type);
}

function mercado_acervo_get_posts($year = 'all', $theme = 'all', $q = '', $page = 1, $per_page = 12, $dossie = '', $geo = 'all', $type = 'all') {
    $args = [
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $per_page,
        'paged'          => $page,
        'orderby'        => 'date',
        'order'          => 'DESC'
    ];

    // Filtro por Ano
    if ($year && is_numeric($year)) {
        $args['date_query'] = [
            ['year' => intval($year)]
        ];
    }

    // Termo de busca textual
    $search_terms = [];
    if (!empty($q)) {
        $search_terms[] = $q;
    }

    // Suporte a Dossiês Temáticos Estratégicos
    $dossiers = mercado_acervo_get_dossiers();
    if (!empty($dossie) && isset($dossiers[$dossie])) {
        $d_info = $dossiers[$dossie];
        if (!empty($d_info['term'])) {
            $search_terms[] = $d_info['term'];
        }
        if (!empty($d_info['cats'])) {
            $args['tax_query'] = [
                [
                    'taxonomy'         => 'category',
                    'field'            => 'slug',
                    'terms'            => $d_info['cats'],
                    'include_children' => true
                ]
            ];
        }
    }

    // Filtro por País / Abrangência Geográfica
    if ($geo && $geo !== 'all') {
        switch ($geo) {
            case 'brasil':
                $search_terms[] = 'Brasil';
                break;
            case 'latam':
                $search_terms[] = 'América Latina';
                break;
            case 'eua':
                $search_terms[] = 'Estados Unidos';
                break;
            case 'europa':
                $search_terms[] = 'Europa';
                break;
            case 'global':
                $search_terms[] = 'global';
                break;
        }
    }

    if (!empty($search_terms)) {
        // Se houver busca explícita, usa o termo; se não, pega o primeiro termo temático
        $args['s'] = implode(' ', $search_terms);
    }

    // Filtro por Categoria / Eixo Temático
    if ($theme && $theme !== 'all' && empty($dossie)) {
        $category_slugs = [];
        switch ($theme) {
            case 'negocios':
                $category_slugs = ['negocios', 'hot-news', 'coluna-empresarios-sex'];
                break;
            case 'pesquisas':
                $category_slugs = ['pesquisas', 'dados-e-estatisticas', 'pesquisa'];
                break;
            case 'sexologia':
                $category_slugs = ['sexologia', 'saude', 'sexo-na-pratica', 'sexual-wellness'];
                break;
            case 'eventos':
                $category_slugs = ['eventos', 'calendario-erotico', 'feiras'];
                break;
            case 'colunas':
                $category_slugs = ['colunas', 'coluna-ka-entre-nos', 'cartas-sexo-diversao', 'dona-do-proprio-poder', 'coluna-sexativar', 'coluna-de-pernas-pro-ar-com-erica-rambalde', 'marlene-sexy'];
                break;
            case 'lancamentos':
                $category_slugs = ['lancamentos', 'produtos', 'novidades'];
                break;
            case 'iasex':
                $category_slugs = ['iasex', 'tecnologia', 'sextech'];
                break;
            default:
                $category_slugs = [$theme];
                break;
        }

        $args['tax_query'] = [
            [
                'taxonomy'         => 'category',
                'field'            => 'slug',
                'terms'            => $category_slugs,
                'include_children' => true
            ]
        ];
    }

    // Filtro por Tipo de Conteúdo
    if ($type && $type !== 'all') {
        if (!isset($args['tax_query'])) {
            $args['tax_query'] = [];
        }
        switch ($type) {
            case 'reportagem':
                $args['tax_query'][] = [
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => ['hot-news', 'mundo-erotico', 'negocios']
                ];
                break;
            case 'estudo':
                $args['tax_query'][] = [
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => ['pesquisas', 'dados-e-estatisticas', 'pesquisa']
                ];
                break;
            case 'entrevista':
                $args['tax_query'][] = [
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => ['colunas', 'coluna-ka-entre-nos', 'cartas-sexo-diversao', 'dona-do-proprio-poder', 'coluna-sexativar', 'coluna-de-pernas-pro-ar-com-erica-rambalde', 'marlene-sexy']
                ];
                break;
            case 'evento':
                $args['tax_query'][] = [
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => ['eventos', 'calendario-erotico', 'feiras']
                ];
                break;
            case 'guia':
                $args['tax_query'][] = [
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => ['lancamentos', 'sexo-na-pratica', 'saude']
                ];
                break;
        }
    }

    $query = new WP_Query($args);
    $posts_data = [];

    foreach ($query->posts as $post) {
        $cats = get_the_category($post->ID);
        $primary_cat = !empty($cats) ? $cats[0]->name : 'Mercado Erótico';

        $thumb_url = get_the_post_thumbnail_url($post->ID, 'medium_large');
        if (!$thumb_url) {
            $thumb_url = get_the_post_thumbnail_url($post->ID, 'medium');
        }
        if (!$thumb_url) {
            $thumb_url = 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2026/11/colunista_padrao_logo.png';
        }

        $excerpt = wp_strip_all_tags($post->post_excerpt ?: wp_trim_words($post->post_content, 22, '...'));
        $author_name = get_the_author_meta('display_name', $post->post_author);
        $reading_time = max(1, ceil(str_word_count(strip_tags($post->post_content)) / 200));

        $posts_data[] = [
            'id'           => $post->ID,
            'title'        => html_entity_decode(get_the_title($post->ID)),
            'link'         => get_permalink($post->ID),
            'date'         => get_the_date('d/m/Y', $post->ID),
            'date_full'    => get_the_date('j \d\e F \d\e Y', $post->ID),
            'year'         => get_the_date('Y', $post->ID),
            'author'       => $author_name ? $author_name : 'Redação Mercado Erótico',
            'category'     => $primary_cat,
            'thumbnail'    => $thumb_url,
            'excerpt'      => $excerpt,
            'reading_time' => $reading_time . ' min de leitura'
        ];
    }

    return [
        'posts'        => $posts_data,
        'total_posts'  => $query->found_posts,
        'total_pages'  => $query->max_num_pages,
        'current_page' => $page,
        'has_more'     => $page < $query->max_num_pages,
        'active_filters' => [
            'year'   => $year,
            'theme'  => $theme,
            'dossie' => $dossie,
            'geo'    => $geo,
            'type'   => $type,
            'q'      => $q
        ]
    ];
}

// Global flag to indicate acervo shortcode was rendered
global $mercado_acervo_rendered;
$mercado_acervo_rendered = false;

// 3. Register Shortcode [mercado_acervo]
add_shortcode('mercado_acervo', 'mercado_acervo_shortcode');

function mercado_acervo_shortcode() {
    global $mercado_acervo_rendered;
    $mercado_acervo_rendered = true;

    // Check URL parameters for initial load
    $init_dossie = isset($_GET['dossie']) ? sanitize_text_field($_GET['dossie']) : '';
    $init_year   = isset($_GET['ano']) ? sanitize_text_field($_GET['ano']) : (isset($_GET['year']) ? sanitize_text_field($_GET['year']) : 'all');
    $init_theme  = isset($_GET['tema']) ? sanitize_text_field($_GET['tema']) : (isset($_GET['theme']) ? sanitize_text_field($_GET['theme']) : 'all');
    $init_geo    = isset($_GET['pais']) ? sanitize_text_field($_GET['pais']) : (isset($_GET['geo']) ? sanitize_text_field($_GET['geo']) : 'all');
    $init_type   = isset($_GET['tipo']) ? sanitize_text_field($_GET['tipo']) : (isset($_GET['type']) ? sanitize_text_field($_GET['type']) : 'all');
    $init_q      = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : (isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '');

    // Initial fetch in PHP
    $initial_data = mercado_acervo_get_posts($init_year, $init_theme, $init_q, 1, 12, $init_dossie, $init_geo, $init_type);
    $count_posts = wp_count_posts('post');
    $total_posts_num = !empty($count_posts->publish) ? (int)$count_posts->publish : 2116;
    $total_posts_formatted = number_format($total_posts_num, 0, ',', '.') . '+';
    $col_count = function_exists('mercado_colunistas_get_list') ? count(mercado_colunistas_get_list()) : 10;
    
    $dossiers = mercado_acervo_get_dossiers();
    $active_dossier = (!empty($init_dossie) && isset($dossiers[$init_dossie])) ? $dossiers[$init_dossie] : null;

    ob_start();
    ?>
    <div id="mercado-acervo-app" class="mercado-acervo-wrapper">
        <!-- Hero Header -->
        <div class="acervo-hero">
            <div class="acervo-badge">★ CENTRO DE INTELIGÊNCIA &bull; ACERVO HISTÓRICO DESDE 2018</div>
            <h1 class="acervo-title">Arquivo Histórico &amp; Ferramenta de Pesquisa</h1>
            <p class="acervo-subtitle">O mais completo centro documental e analítico do mercado erótico no Brasil. Explore reportagens, censos e investigações estratégicas por período, território e linhas temáticas permanentes.</p>
            
            <div class="acervo-stats-bar">
                <div class="stat-item"><span class="stat-num"><?php echo esc_html($total_posts_formatted); ?></span><span class="stat-lbl">Artigos Documentados</span></div>
                <div class="stat-sep">•</div>
                <div class="stat-item"><span class="stat-num">8+ Anos</span><span class="stat-lbl">Memória Contínua</span></div>
                <div class="stat-sep">•</div>
                <div class="stat-item"><span class="stat-num">7 Dossiês</span><span class="stat-lbl">Linhas Estratégicas</span></div>
                <div class="stat-sep">•</div>
                <div class="stat-item"><span class="stat-num"><?php echo esc_html($col_count); ?>+</span><span class="stat-lbl">Especialistas e Autores</span></div>
            </div>

            <!-- Search Bar Form -->
            <form id="acervo-search-form" class="acervo-search-box" action="#" onsubmit="event.preventDefault(); doAcervoSearch();" role="search">
                <div class="acervo-input-wrap">
                    <i class="fas fa-search search-icon"></i>
                    <input type="search" id="acervo-search-input" name="s" value="<?php echo esc_attr($init_q); ?>" placeholder="Pesquise por termo, marca, produto, norma jurídica ou autor..." autocomplete="off" enterkeyhint="search" onkeydown="if(event.key==='Enter'||event.keyCode===13){event.preventDefault();doAcervoSearch();}">
                    <button type="button" id="acervo-clear-input-btn" class="acervo-clear-btn" title="Limpar busca" onclick="clearSearchInput()" <?php if (!empty($init_q)) echo 'style="display:block;"'; ?>><i class="fas fa-times-circle"></i></button>
                </div>
                <button type="submit" id="acervo-search-btn" class="acervo-btn-search">
                    <span class="btn-text">Pesquisar no Acervo</span>
                </button>
            </form>

            <!-- Instant Search Feedback in Hero -->
            <div id="acervo-hero-feedback" class="acervo-hero-feedback" style="display:none;"></div>
        </div>

        <!-- Banner de Dossiê Ativo (quando filtrado por linha temática) -->
        <div id="active-dossier-banner" class="active-dossier-banner" <?php if (!$active_dossier) echo 'style="display:none;"'; ?>>
            <div class="dossier-banner-content">
                <div class="dossier-banner-badge" id="dossier-badge-text"><?php echo $active_dossier ? esc_html($active_dossier['badge']) : 'DOSSIÊ ESTRATÉGICO'; ?></div>
                <h2 class="dossier-banner-title" id="dossier-title-text"><?php echo $active_dossier ? esc_html($active_dossier['icon'] . ' ' . $active_dossier['title']) : ''; ?></h2>
                <p class="dossier-banner-desc" id="dossier-desc-text"><?php echo $active_dossier ? esc_html($active_dossier['description']) : ''; ?></p>
            </div>
            <div class="dossier-banner-actions">
                <button type="button" class="btn-clear-dossier" onclick="clearAcervoFilters()"><i class="fas fa-times"></i> Ver Todo o Acervo Geral</button>
            </div>
        </div>

        <!-- Top Themes Filter -->
        <div class="acervo-filter-section">
            <div class="filter-header">
                <span class="filter-label"><i class="fas fa-compass"></i> Navegação Rápida por Editoria:</span>
            </div>
            <div class="themes-pill-wrap" id="themes-filter-container">
                <button type="button" class="theme-pill <?php echo ($init_theme === 'all' && empty($init_dossie)) ? 'active' : ''; ?>" data-theme="all" onclick="selectAcervoTheme('all', this)">🌐 Todas as Editorias</button>
                <button type="button" class="theme-pill <?php echo ($init_theme === 'negocios') ? 'active' : ''; ?>" data-theme="negocios" onclick="selectAcervoTheme('negocios', this)">🏢 Negócios &amp; Mercado</button>
                <button type="button" class="theme-pill <?php echo ($init_theme === 'pesquisas') ? 'active' : ''; ?>" data-theme="pesquisas" onclick="selectAcervoTheme('pesquisas', this)">📊 Pesquisas &amp; Censos</button>
                <button type="button" class="theme-pill <?php echo ($init_theme === 'sexologia') ? 'active' : ''; ?>" data-theme="sexologia" onclick="selectAcervoTheme('sexologia', this)">🔬 Sexologia &amp; Saúde</button>
                <button type="button" class="theme-pill <?php echo ($init_theme === 'colunas') ? 'active' : ''; ?>" data-theme="colunas" onclick="selectAcervoTheme('colunas', this)">✍️ Colunas de Especialistas</button>
                <button type="button" class="theme-pill <?php echo ($init_theme === 'eventos') ? 'active' : ''; ?>" data-theme="eventos" onclick="selectAcervoTheme('eventos', this)">🎟️ Eventos &amp; Feiras</button>
                <button type="button" class="theme-pill <?php echo ($init_theme === 'lancamentos') ? 'active' : ''; ?>" data-theme="lancamentos" onclick="selectAcervoTheme('lancamentos', this)">✨ Lançamentos</button>
                <button type="button" class="theme-pill <?php echo ($init_theme === 'iasex') ? 'active' : ''; ?>" data-theme="iasex" onclick="selectAcervoTheme('iasex', this)">🤖 IA &amp; Sextech</button>
            </div>
        </div>

        <!-- Active Filter Indicator & Results Count -->
        <div class="acervo-results-bar" id="acervo-results-bar">
            <div id="results-count" class="results-count">
                <strong><?php echo intval($initial_data['total_posts']); ?></strong> artigos catalogados neste recorte de pesquisa
            </div>
            <button type="button" id="clear-filters-btn" class="clear-filters-btn" <?php if (empty($init_dossie) && $init_year === 'all' && $init_theme === 'all' && $init_geo === 'all' && $init_type === 'all' && empty($init_q)) echo 'style="display:none;"'; ?> onclick="clearAcervoFilters()"><i class="fas fa-times"></i> Limpar Filtros Ativos</button>
        </div>

        <!-- Grid of Cards (Com Autoria & Data em Alta Visibilidade) -->
        <div id="acervo-grid" class="acervo-grid">
            <?php foreach ($initial_data['posts'] as $p): ?>
                <article class="acervo-card">
                    <div class="card-thumb-wrap">
                        <img src="<?php echo esc_url($p['thumbnail']); ?>" alt="<?php echo esc_attr($p['title']); ?>" class="card-thumb" loading="lazy">
                        <span class="card-category-badge"><?php echo esc_html($p['category']); ?></span>
                        <span class="card-year-badge"><?php echo esc_html($p['year']); ?></span>
                    </div>
                    <div class="card-body">
                        <!-- Byline Bar de Alta Visibilidade (Autoria + Data) -->
                        <div class="card-byline">
                            <div class="byline-author" title="Autor(a) da matéria">
                                <span class="author-icon"><i class="fas fa-feather-alt"></i></span>
                                <span class="author-text">Por <strong class="author-name"><?php echo esc_html($p['author']); ?></strong></span>
                            </div>
                            <div class="byline-date" title="Data de publicação original">
                                <i class="far fa-calendar-alt"></i> <?php echo esc_html($p['date_full']); ?>
                            </div>
                        </div>

                        <h3 class="card-title"><a href="<?php echo esc_url($p['link']); ?>"><?php echo esc_html($p['title']); ?></a></h3>
                        <p class="card-excerpt"><?php echo esc_html($p['excerpt']); ?></p>

                        <div class="card-footer">
                            <span class="card-reading-time"><i class="far fa-clock"></i> <?php echo esc_html($p['reading_time']); ?></span>
                            <a href="<?php echo esc_url($p['link']); ?>" class="card-read-link">Ler artigo completo ➔</a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <!-- Loading Spinner -->
        <div id="acervo-loading" class="acervo-loading" style="display:none;">
            <div class="spinner"></div>
            <span>Buscando no acervo documental do portal...</span>
        </div>

        <!-- Load More Button -->
        <div class="acervo-actions">
            <button type="button" id="acervo-load-more" class="btn-load-more" onclick="loadMoreAcervo()" <?php if (!$initial_data['has_more']) echo 'style="display:none;"'; ?>>Carregar mais artigos deste recorte</button>
        </div>

        <!-- ================================================================= -->
        <!-- SEÇÃO: DOSSIÊS TEMÁTICOS ESTRATÉGICOS (LINHAS PERMANENTES) -->
        <!-- ================================================================= -->
        <section class="acervo-dossiers-section" id="dossies-estrategicos">
            <div class="dossiers-header">
                <span class="dossiers-overline">LINHAS DE PESQUISA &bull; ACERVO PERMANENTE</span>
                <h2 class="dossiers-title">Dossiês Temáticos Estratégicos</h2>
                <p class="dossiers-subtitle">Coleções documentais permanentes que agregam o conhecimento acumulado pelo portal em eixos fundamentais da indústria, varejo, regulação e comportamento no Brasil e no mundo.</p>
            </div>

            <div class="dossiers-grid">
                <?php foreach ($dossiers as $d_slug => $d): ?>
                    <div class="dossier-card <?php echo ($init_dossie === $d_slug) ? 'active' : ''; ?>" onclick="selectAcervoDossie('<?php echo esc_attr($d_slug); ?>')">
                        <div class="dossier-card-top">
                            <span class="dossier-icon"><?php echo esc_html($d['icon']); ?></span>
                            <span class="dossier-badge"><?php echo esc_html($d['badge']); ?></span>
                        </div>
                        <h3 class="dossier-title"><?php echo esc_html($d['title']); ?></h3>
                        <p class="dossier-tagline"><?php echo esc_html($d['tagline']); ?></p>
                        <p class="dossier-desc"><?php echo esc_html($d['description']); ?></p>
                        <div class="dossier-footer">
                            <span class="dossier-cta">Explorar Dossiê Completo ➔</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- ================================================================= -->
        <!-- RODAPÉ ESPECIAL: CENTRAL DE PESQUISA & FILTROS MULTIDIMENSIONAIS -->
        <!-- ================================================================= -->
        <footer class="acervo-research-footer" id="central-pesquisa">
            <div class="footer-research-header">
                <div class="footer-header-icon"><i class="fas fa-sliders-h"></i></div>
                <div>
                    <h3 class="footer-research-title">Central de Pesquisa Avançada &amp; Filtros Cruzados</h3>
                    <p class="footer-research-desc">Combine critérios cronológicos, territoriais e de formato para transformar o acervo em uma ferramenta investigativa sob medida para acadêmicos, jornalistas e marcas.</p>
                </div>
            </div>

            <div class="research-filters-grid">
                <!-- 1. Cronologia por Ano -->
                <div class="filter-col">
                    <h4 class="col-title"><i class="far fa-calendar"></i> Ano de Publicação:</h4>
                    <div class="filter-pills" id="year-filters-group">
                        <button type="button" class="rf-pill <?php echo ($init_year === 'all') ? 'active' : ''; ?>" data-val="all" onclick="selectAcervoYear('all', this)">Todos</button>
                        <button type="button" class="rf-pill <?php echo ($init_year === '2026') ? 'active' : ''; ?>" data-val="2026" onclick="selectAcervoYear('2026', this)">2026</button>
                        <button type="button" class="rf-pill <?php echo ($init_year === '2025') ? 'active' : ''; ?>" data-val="2025" onclick="selectAcervoYear('2025', this)">2025</button>
                        <button type="button" class="rf-pill <?php echo ($init_year === '2024') ? 'active' : ''; ?>" data-val="2024" onclick="selectAcervoYear('2024', this)">2024</button>
                        <button type="button" class="rf-pill <?php echo ($init_year === '2023') ? 'active' : ''; ?>" data-val="2023" onclick="selectAcervoYear('2023', this)">2023</button>
                        <button type="button" class="rf-pill <?php echo ($init_year === '2022') ? 'active' : ''; ?>" data-val="2022" onclick="selectAcervoYear('2022', this)">2022</button>
                        <button type="button" class="rf-pill <?php echo ($init_year === '2021') ? 'active' : ''; ?>" data-val="2021" onclick="selectAcervoYear('2021', this)">2021</button>
                        <button type="button" class="rf-pill <?php echo ($init_year === '2020') ? 'active' : ''; ?>" data-val="2020" onclick="selectAcervoYear('2020', this)">2020</button>
                        <button type="button" class="rf-pill <?php echo ($init_year === '2019') ? 'active' : ''; ?>" data-val="2019" onclick="selectAcervoYear('2019', this)">2019</button>
                        <button type="button" class="rf-pill <?php echo ($init_year === '2018') ? 'active' : ''; ?>" data-val="2018" onclick="selectAcervoYear('2018', this)">2018</button>
                    </div>
                </div>

                <!-- 2. Abrangência Territorial / País -->
                <div class="filter-col">
                    <h4 class="col-title"><i class="fas fa-globe-americas"></i> País / Abrangência:</h4>
                    <div class="filter-pills" id="geo-filters-group">
                        <button type="button" class="rf-pill <?php echo ($init_geo === 'all') ? 'active' : ''; ?>" data-val="all" onclick="selectAcervoGeo('all', this)">🌐 Todos os Territórios</button>
                        <button type="button" class="rf-pill <?php echo ($init_geo === 'brasil') ? 'active' : ''; ?>" data-val="brasil" onclick="selectAcervoGeo('brasil', this)">🇧🇷 Brasil &amp; Nacional</button>
                        <button type="button" class="rf-pill <?php echo ($init_geo === 'latam') ? 'active' : ''; ?>" data-val="latam" onclick="selectAcervoGeo('latam', this)">🌎 América Latina (LATAM)</button>
                        <button type="button" class="rf-pill <?php echo ($init_geo === 'eua') ? 'active' : ''; ?>" data-val="eua" onclick="selectAcervoGeo('eua', this)">🇺🇸 Estados Unidos</button>
                        <button type="button" class="rf-pill <?php echo ($init_geo === 'europa') ? 'active' : ''; ?>" data-val="europa" onclick="selectAcervoGeo('europa', this)">🇪🇺 Europa &amp; Global</button>
                    </div>
                </div>

                <!-- 3. Formato / Tipo de Conteúdo -->
                <div class="filter-col">
                    <h4 class="col-title"><i class="fas fa-file-alt"></i> Tipo de Conteúdo:</h4>
                    <div class="filter-pills" id="type-filters-group">
                        <button type="button" class="rf-pill <?php echo ($init_type === 'all') ? 'active' : ''; ?>" data-val="all" onclick="selectAcervoType('all', this)">Todos os Formatos</button>
                        <button type="button" class="rf-pill <?php echo ($init_type === 'reportagem') ? 'active' : ''; ?>" data-val="reportagem" onclick="selectAcervoType('reportagem', this)">📰 Reportagens &amp; Notícias</button>
                        <button type="button" class="rf-pill <?php echo ($init_type === 'estudo') ? 'active' : ''; ?>" data-val="estudo" onclick="selectAcervoType('estudo', this)">📊 Estudos &amp; Censos</button>
                        <button type="button" class="rf-pill <?php echo ($init_type === 'entrevista') ? 'active' : ''; ?>" data-val="entrevista" onclick="selectAcervoType('entrevista', this)">🎙️ Artigos &amp; Colunas</button>
                        <button type="button" class="rf-pill <?php echo ($init_type === 'evento') ? 'active' : ''; ?>" data-val="evento" onclick="selectAcervoType('evento', this)">🎪 Coberturas de Eventos</button>
                        <button type="button" class="rf-pill <?php echo ($init_type === 'guia') ? 'active' : ''; ?>" data-val="guia" onclick="selectAcervoType('guia', this)">📚 Guias &amp; Lançamentos</button>
                    </div>
                </div>
            </div>

            <div class="footer-bottom-bar">
                <div class="footer-research-meta">
                    <i class="fas fa-shield-alt"></i> <strong>Portal Mercado Erótico</strong> &bull; Acervo Histórico, Jornalismo e Inteligência de Mercado desde 2000.
                </div>
                <button type="button" class="btn-footer-reset" onclick="clearAcervoFilters()"><i class="fas fa-redo"></i> Resetar Todos os Filtros</button>
            </div>
        </footer>
    </div>

    <style>
    /* ========================================================================= */
    /* ACERVO HISTORICO & FERRAMENTA DE PESQUISA - STYLES                        */
    /* ========================================================================= */
    .page-id-13623 .page-title-section { display: none !important; }
    .mercado-acervo-wrapper {
        clear: both;
        max-width: 1240px;
        margin: 25px auto 70px;
        padding: 0 15px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        color: #1e293b;
    }
    
    /* HERO */
    .acervo-hero {
        background: linear-gradient(135deg, #090d16 0%, #171630 45%, #2a0b27 100%);
        border-radius: 20px;
        padding: 45px 30px 40px;
        color: #fff;
        text-align: center;
        margin-bottom: 25px;
        box-shadow: 0 12px 35px rgba(15, 23, 42, 0.2);
        border: 1px solid rgba(227, 28, 97, 0.25);
        position: relative;
        overflow: hidden;
    }
    .acervo-badge {
        display: inline-block;
        background: rgba(225, 29, 72, 0.25);
        color: #fb7185;
        border: 1px solid rgba(225, 29, 72, 0.45);
        padding: 5px 16px;
        border-radius: 50px;
        font-size: 11.5px;
        font-weight: 800;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        margin-bottom: 15px;
    }
    .acervo-title {
        font-size: 34px;
        font-weight: 850;
        color: #ffffff !important;
        margin: 0 0 14px 0;
        line-height: 1.2;
        letter-spacing: -0.6px;
    }
    .acervo-subtitle {
        font-size: 16px;
        color: #cbd5e1;
        max-width: 780px;
        margin: 0 auto 26px;
        line-height: 1.6;
    }
    .acervo-stats-bar {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 28px;
        padding: 12px 26px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.14);
        border-radius: 50px;
    }
    .stat-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .stat-num {
        font-weight: 800;
        color: #f43f5e;
        font-size: 15px;
    }
    .stat-lbl {
        color: #e2e8f0;
        font-size: 13px;
        font-weight: 500;
    }
    .stat-sep {
        color: #64748b;
    }

    /* SEARCH BOX */
    .acervo-search-box {
        max-width: 720px;
        margin: 0 auto;
        position: relative;
        display: flex;
        align-items: center;
        background: #ffffff;
        border-radius: 50px;
        padding: 6px;
        box-shadow: 0 12px 30px rgba(0,0,0,0.3);
    }
    .acervo-input-wrap {
        position: relative;
        flex: 1;
        display: flex;
        align-items: center;
        min-width: 0;
    }
    .acervo-input-wrap .search-icon {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 17px;
        pointer-events: none;
        z-index: 2;
    }
    .acervo-input-wrap input {
        width: 100%;
        border: none !important;
        outline: none !important;
        padding: 13px 40px 13px 52px !important;
        font-size: 15px !important;
        color: #0f172a !important;
        border-radius: 50px !important;
        background: transparent !important;
        box-shadow: none !important;
    }
    .acervo-clear-btn {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #94a3b8;
        font-size: 17px;
        cursor: pointer;
        padding: 4px;
        line-height: 1;
        display: none;
        z-index: 2;
        transition: color 0.2s ease;
    }
    .acervo-clear-btn:hover {
        color: #e31c61;
    }
    .acervo-btn-search {
        background: #e31c61;
        color: #ffffff;
        border: none;
        border-radius: 50px;
        padding: 0 28px;
        height: 46px;
        font-weight: 700;
        font-size: 14.5px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        flex-shrink: 0;
        white-space: nowrap;
    }
    .acervo-btn-search:hover {
        background: #c4124e;
        transform: scale(1.02);
        box-shadow: 0 4px 14px rgba(227, 28, 97, 0.4);
    }
    .acervo-hero-feedback {
        margin-top: 18px;
        padding: 9px 20px;
        border-radius: 50px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-size: 13.5px;
        font-weight: 600;
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.22);
        color: #ffffff;
        backdrop-filter: blur(8px);
    }
    .acervo-hero-feedback.has-results {
        background: rgba(16, 185, 129, 0.25);
        border-color: rgba(16, 185, 129, 0.45);
        color: #a7f3d0;
    }
    .acervo-hero-feedback.no-results {
        background: rgba(244, 63, 94, 0.25);
        border-color: rgba(244, 63, 94, 0.45);
        color: #fecdd3;
    }
    .acervo-hero-feedback.is-loading {
        background: rgba(227, 28, 97, 0.25);
        border-color: rgba(227, 28, 97, 0.45);
        color: #fbcfe8;
    }
    .acervo-hero-feedback .feedback-btn {
        background: #ffffff;
        color: #0f172a;
        border: none;
        border-radius: 20px;
        padding: 4px 14px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
    }

    /* ACTIVE DOSSIER BANNER */
    .active-dossier-banner {
        background: linear-gradient(135deg, #1e1b4b 0%, #31102f 100%);
        border: 1.5px solid #e31c61;
        border-radius: 16px;
        padding: 24px 28px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        box-shadow: 0 8px 24px rgba(227, 28, 97, 0.15);
        color: #ffffff;
    }
    .dossier-banner-badge {
        display: inline-block;
        background: #e31c61;
        color: #ffffff;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1px;
        padding: 3px 10px;
        border-radius: 4px;
        margin-bottom: 8px;
        text-transform: uppercase;
    }
    .dossier-banner-title {
        font-size: 22px;
        font-weight: 850;
        color: #ffffff !important;
        margin: 0 0 6px 0;
    }
    .dossier-banner-desc {
        font-size: 14px;
        color: #cbd5e1;
        margin: 0;
        line-height: 1.5;
        max-width: 820px;
    }
    .btn-clear-dossier {
        background: #ffffff;
        color: #0f172a;
        border: none;
        padding: 10px 20px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        transition: all 0.2s ease;
    }
    .btn-clear-dossier:hover {
        background: #e31c61;
        color: #ffffff;
    }

    /* TOP FILTER SECTION */
    .acervo-filter-section {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px 20px;
        margin-bottom: 20px;
    }
    .filter-header {
        margin-bottom: 10px;
    }
    .filter-label {
        font-size: 12.5px;
        font-weight: 750;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .themes-pill-wrap {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .theme-pill {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 7px 14px;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
    }
    .theme-pill:hover {
        border-color: #e31c61;
        color: #e31c61;
        background: #fff5f8;
    }
    .theme-pill.active {
        background: #e31c61 !important;
        color: #ffffff !important;
        border-color: #e31c61 !important;
        box-shadow: 0 4px 10px rgba(227, 28, 97, 0.3);
    }

    /* RESULTS BAR */
    .acervo-results-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 22px 0 18px;
        padding: 0 4px;
    }
    .results-count {
        font-size: 14.5px;
        font-weight: 600;
        color: #475569;
    }
    .results-count strong {
        color: #0f172a;
        font-weight: 800;
    }
    .clear-filters-btn {
        background: #fff;
        border: 1px solid #cbd5e1;
        padding: 6px 14px;
        border-radius: 20px;
        color: #e31c61;
        font-weight: 700;
        font-size: 12.5px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .clear-filters-btn:hover {
        background: #e31c61;
        color: #fff;
        border-color: #e31c61;
    }

    /* CARDS GRID */
    .acervo-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }
    .acervo-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        display: flex;
        flex-direction: column;
    }
    .acervo-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.08);
        border-color: rgba(227, 28, 97, 0.4);
    }
    .card-thumb-wrap {
        position: relative;
        height: 185px;
        overflow: hidden;
        background: #f1f5f9;
    }
    .card-thumb {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.35s ease;
    }
    .acervo-card:hover .card-thumb {
        transform: scale(1.04);
    }
    .card-category-badge {
        position: absolute;
        bottom: 10px;
        left: 10px;
        background: rgba(15, 23, 42, 0.88);
        backdrop-filter: blur(4px);
        color: #ffffff;
        font-size: 11px;
        font-weight: 750;
        padding: 3px 8px;
        border-radius: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .card-year-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #e31c61;
        color: #ffffff;
        font-size: 11.5px;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 4px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.25);
    }
    .card-body {
        padding: 18px 20px 20px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    /* NOVO: BYLINE BAR DE ALTA VISIBILIDADE (AUTORIA + DATA) */
    .card-byline {
        display: flex;
        flex-direction: column;
        gap: 4px;
        background: #f8fafc;
        border-left: 3px solid #e31c61;
        padding: 8px 12px;
        border-radius: 0 6px 6px 0;
        margin-bottom: 12px;
    }
    .byline-author {
        font-size: 12.5px;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .author-icon {
        color: #e31c61;
        font-size: 11px;
    }
    .author-name {
        color: #0f172a;
        font-weight: 750;
    }
    .byline-date {
        font-size: 11.5px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 5px;
        font-weight: 500;
    }
    .byline-date i {
        color: #94a3b8;
    }

    .card-title {
        font-size: 16px;
        font-weight: 750;
        line-height: 1.4;
        margin: 0 0 10px 0;
    }
    .card-title a {
        color: #0f172a !important;
        text-decoration: none !important;
        transition: color 0.2s ease;
    }
    .card-title a:hover {
        color: #e31c61 !important;
    }
    .card-excerpt {
        font-size: 13.5px;
        color: #475569;
        line-height: 1.55;
        margin: 0 0 16px 0;
        flex: 1;
    }
    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
        font-size: 12px;
    }
    .card-reading-time {
        color: #94a3b8;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .card-read-link {
        color: #e31c61 !important;
        font-weight: 750;
        text-decoration: none !important;
        transition: transform 0.2s ease;
        display: inline-block;
    }
    .card-read-link:hover {
        transform: translateX(3px);
    }

    /* ACTIONS / LOAD MORE */
    .acervo-actions {
        text-align: center;
        margin: 35px 0 50px;
    }
    .btn-load-more {
        background: #ffffff;
        border: 2px solid #e31c61;
        color: #e31c61;
        padding: 12px 34px;
        border-radius: 50px;
        font-size: 14.5px;
        font-weight: 750;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-load-more:hover {
        background: #e31c61;
        color: #ffffff;
        box-shadow: 0 6px 16px rgba(227, 28, 97, 0.3);
    }

    /* ========================================================================= */
    /* SEÇÃO DE DOSSIÊS ESTRATÉGICOS                                             */
    /* ========================================================================= */
    .acervo-dossiers-section {
        margin: 55px 0 45px;
        padding-top: 40px;
        border-top: 2px solid #e2e8f0;
    }
    .dossiers-header {
        margin-bottom: 30px;
        text-align: center;
    }
    .dossiers-overline {
        font-size: 11.5px;
        font-weight: 800;
        letter-spacing: 1.5px;
        color: #e31c61;
        text-transform: uppercase;
        display: block;
        margin-bottom: 6px;
    }
    .dossiers-title {
        font-size: 28px;
        font-weight: 850;
        color: #0f172a;
        margin: 0 0 10px;
        letter-spacing: -0.5px;
    }
    .dossiers-subtitle {
        font-size: 15px;
        color: #64748b;
        max-width: 760px;
        margin: 0 auto;
        line-height: 1.55;
    }
    .dossiers-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 20px;
    }
    .dossier-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 24px;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        transition: all 0.2s ease;
        position: relative;
    }
    .dossier-card:hover {
        transform: translateY(-4px);
        border-color: #e31c61;
        box-shadow: 0 12px 28px rgba(227, 28, 97, 0.12);
    }
    .dossier-card.active {
        border-color: #e31c61;
        background: #fff8fa;
        box-shadow: 0 0 0 2px #e31c61;
    }
    .dossier-card-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
    }
    .dossier-icon {
        font-size: 26px;
    }
    .dossier-badge {
        background: #f1f5f9;
        color: #475569;
        font-size: 11px;
        font-weight: 750;
        padding: 3px 8px;
        border-radius: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .dossier-title {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 6px;
        line-height: 1.3;
    }
    .dossier-tagline {
        font-size: 12.5px;
        font-weight: 700;
        color: #e31c61;
        margin: 0 0 10px;
        line-height: 1.4;
    }
    .dossier-desc {
        font-size: 13px;
        color: #64748b;
        line-height: 1.5;
        margin: 0 0 18px;
        flex: 1;
    }
    .dossier-footer {
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
    }
    .dossier-cta {
        color: #e31c61;
        font-weight: 750;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: transform 0.2s ease;
    }
    .dossier-card:hover .dossier-cta {
        transform: translateX(4px);
    }

    /* ========================================================================= */
    /* RODAPÉ ESPECIAL: CENTRAL DE PESQUISA & FILTROS MULTIDIMENSIONAIS          */
    /* ========================================================================= */
    .acervo-research-footer {
        background: #0f172a;
        border-radius: 18px;
        padding: 36px 32px 28px;
        color: #ffffff;
        margin-top: 50px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.25);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .footer-research-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 28px;
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.12);
    }
    .footer-header-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #e31c61;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    .footer-research-title {
        font-size: 20px;
        font-weight: 800;
        color: #ffffff !important;
        margin: 0 0 4px;
    }
    .footer-research-desc {
        font-size: 13.5px;
        color: #94a3b8;
        margin: 0;
        line-height: 1.5;
    }
    .research-filters-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
        margin-bottom: 30px;
    }
    .filter-col .col-title {
        font-size: 13px;
        font-weight: 750;
        color: #cbd5e1;
        margin: 0 0 12px;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .filter-col .col-title i {
        color: #e31c61;
    }
    .filter-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
    }
    .rf-pill {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.14);
        color: #e2e8f0;
        font-size: 12px;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
    }
    .rf-pill:hover {
        background: rgba(255, 255, 255, 0.18);
        color: #ffffff;
        border-color: rgba(255, 255, 255, 0.3);
    }
    .rf-pill.active {
        background: #e31c61 !important;
        color: #ffffff !important;
        border-color: #e31c61 !important;
        box-shadow: 0 2px 8px rgba(227, 28, 97, 0.4);
    }
    .footer-bottom-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        flex-wrap: wrap;
        gap: 12px;
    }
    .footer-research-meta {
        font-size: 12.5px;
        color: #64748b;
    }
    .footer-research-meta strong {
        color: #cbd5e1;
    }
    .footer-research-meta i {
        color: #e31c61;
    }
    .btn-footer-reset {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #ffffff;
        padding: 7px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .btn-footer-reset:hover {
        background: #e31c61;
        border-color: #e31c61;
    }

    /* LOADING & SPINNER */
    .acervo-loading {
        text-align: center;
        padding: 40px 0;
        color: #64748b;
        font-weight: 600;
    }
    .spinner {
        width: 34px;
        height: 34px;
        border: 3px solid rgba(227, 28, 97, 0.2);
        border-top-color: #e31c61;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        margin: 0 auto 12px;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* RESPONSIVE */
    @media (max-width: 991px) {
        .acervo-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .acervo-hero { padding: 26px 16px; }
        .acervo-title { font-size: 24px; }
        .acervo-subtitle { font-size: 13.5px; margin-bottom: 18px; }
        .acervo-stats-bar { padding: 8px 14px; gap: 8px; margin-bottom: 20px; }
        .stat-item { gap: 4px; }
        .stat-num { font-size: 13px; }
        .stat-lbl { font-size: 11px; }
        .acervo-search-box {
            display: flex;
            flex-direction: row;
            background: #ffffff;
            border-radius: 50px;
            padding: 4px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.25);
            width: 100%;
        }
        .acervo-input-wrap .search-icon {
            left: 14px;
            font-size: 14px;
        }
        .acervo-input-wrap input {
            font-size: 13.5px !important;
            padding: 9px 30px 9px 36px !important;
            border-radius: 50px !important;
        }
        .acervo-clear-btn {
            right: 8px;
            font-size: 15px;
        }
        .acervo-btn-search {
            height: 38px;
            padding: 0 16px;
            font-size: 13px;
            border-radius: 50px;
            flex-shrink: 0;
        }
        .acervo-grid { grid-template-columns: 1fr; }
        .active-dossier-banner { flex-direction: column; align-items: flex-start; }
        .acervo-research-footer { padding: 24px 16px; }
        .footer-research-header { flex-direction: column; align-items: flex-start; }
    }
    </style>
    <?php
    return ob_get_clean();
}

/**
 * 4. FOOTER SCRIPTS: Completely protected from WordPress content filters
 */
function mercado_acervo_footer_scripts() {
    global $mercado_acervo_rendered;
    if (!$mercado_acervo_rendered) return;

    $rest_endpoint = esc_url_raw(rest_url('mercado/v1/acervo'));
    $ajax_endpoint = esc_url_raw(admin_url('admin-ajax.php'));
    $dossiers_json = wp_json_encode(mercado_acervo_get_dossiers());
    ?>
    <script>
    (function() {
        window.currentAcervoYear = 'all';
        window.currentAcervoTheme = 'all';
        window.currentAcervoDossie = '';
        window.currentAcervoGeo = 'all';
        window.currentAcervoType = 'all';
        window.currentAcervoQuery = '';
        window.currentAcervoPage = 1;
        window.isAcervoLoading = false;

        const restUrl = '<?php echo $rest_endpoint; ?>';
        const ajaxUrl = '<?php echo $ajax_endpoint; ?>';
        const dossiersMap = <?php echo $dossiers_json; ?>;

        window.scrollToAcervoResults = function() {
            const target = document.getElementById('acervo-results-bar') || document.getElementById('acervo-grid');
            if (target) {
                const y = target.getBoundingClientRect().top + window.pageYOffset - 90;
                window.scrollTo({ top: y, behavior: 'smooth' });
            }
        };

        window.clearSearchInput = function() {
            const input = document.getElementById('acervo-search-input');
            const clearBtn = document.getElementById('acervo-clear-input-btn');
            const feedbackBox = document.getElementById('acervo-hero-feedback');
            if (input) {
                input.value = '';
                input.focus();
            }
            if (clearBtn) clearBtn.style.display = 'none';
            if (feedbackBox) feedbackBox.style.display = 'none';
            window.doAcervoSearch();
        };

        const searchInput = document.getElementById('acervo-search-input');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const clearBtn = document.getElementById('acervo-clear-input-btn');
                if (clearBtn) {
                    clearBtn.style.display = this.value.trim() ? 'block' : 'none';
                }
            });
        }

        // 1. Selecionar Dossiê Estratégico
        window.selectAcervoDossie = function(dossieSlug) {
            window.currentAcervoDossie = dossieSlug || '';
            window.currentAcervoTheme = 'all'; // Reseta tema genérico
            window.currentAcervoPage = 1;

            // Atualiza banner de dossiê
            const banner = document.getElementById('active-dossier-banner');
            const bBadge = document.getElementById('dossier-badge-text');
            const bTitle = document.getElementById('dossier-title-text');
            const bDesc = document.getElementById('dossier-desc-text');

            if (dossieSlug && dossiersMap[dossieSlug]) {
                const d = dossiersMap[dossieSlug];
                if (bBadge) bBadge.innerText = d.badge;
                if (bTitle) bTitle.innerText = d.icon + ' ' + d.title;
                if (bDesc) bDesc.innerText = d.description;
                if (banner) banner.style.display = 'flex';
            } else if (banner) {
                banner.style.display = 'none';
            }

            // Atualiza classe ativa nos cards de dossiê
            document.querySelectorAll('.dossier-card').forEach(function(card) {
                if (card.getAttribute('onclick') && card.getAttribute('onclick').includes(dossieSlug)) {
                    card.classList.add('active');
                } else {
                    card.classList.remove('active');
                }
            });

            // Reseta botões de tema do topo
            document.querySelectorAll('#themes-filter-container .theme-pill').forEach(function(p) {
                p.classList.remove('active');
            });

            window.updateAcervoUrl();
            window.fetchAcervoPosts(false);
            window.scrollToAcervoResults();
        };

        // 2. Selecionar Tema Topo
        window.selectAcervoTheme = function(theme, btn) {
            window.currentAcervoTheme = theme || 'all';
            window.currentAcervoDossie = ''; // Limpa dossiê ativo se clicar em tema topo
            window.currentAcervoPage = 1;

            const banner = document.getElementById('active-dossier-banner');
            if (banner) banner.style.display = 'none';
            document.querySelectorAll('.dossier-card').forEach(function(c) { c.classList.remove('active'); });

            const pills = document.querySelectorAll('#themes-filter-container .theme-pill');
            pills.forEach(function(p) {
                if (p.getAttribute('data-theme') === theme) {
                    p.classList.add('active');
                } else {
                    p.classList.remove('active');
                }
            });

            window.updateAcervoUrl();
            window.fetchAcervoPosts(false);
        };

        // 3. Selecionar Ano
        window.selectAcervoYear = function(year, btn) {
            window.currentAcervoYear = year || 'all';
            window.currentAcervoPage = 1;

            document.querySelectorAll('#year-filters-group .rf-pill').forEach(function(p) {
                if (p.getAttribute('data-val') === year) {
                    p.classList.add('active');
                } else {
                    p.classList.remove('active');
                }
            });

            window.updateAcervoUrl();
            window.fetchAcervoPosts(false);
            window.scrollToAcervoResults();
        };

        // 4. Selecionar Geografia
        window.selectAcervoGeo = function(geo, btn) {
            window.currentAcervoGeo = geo || 'all';
            window.currentAcervoPage = 1;

            document.querySelectorAll('#geo-filters-group .rf-pill').forEach(function(p) {
                if (p.getAttribute('data-val') === geo) {
                    p.classList.add('active');
                } else {
                    p.classList.remove('active');
                }
            });

            window.updateAcervoUrl();
            window.fetchAcervoPosts(false);
            window.scrollToAcervoResults();
        };

        // 5. Selecionar Tipo de Conteúdo
        window.selectAcervoType = function(type, btn) {
            window.currentAcervoType = type || 'all';
            window.currentAcervoPage = 1;

            document.querySelectorAll('#type-filters-group .rf-pill').forEach(function(p) {
                if (p.getAttribute('data-val') === type) {
                    p.classList.add('active');
                } else {
                    p.classList.remove('active');
                }
            });

            window.updateAcervoUrl();
            window.fetchAcervoPosts(false);
            window.scrollToAcervoResults();
        };

        // 6. Busca por Texto
        window.doAcervoSearch = function() {
            const input = document.getElementById('acervo-search-input');
            const query = input ? input.value.trim() : '';
            window.currentAcervoQuery = query;
            window.currentAcervoPage = 1;

            window.updateAcervoUrl();
            window.fetchAcervoPosts(false);
        };

        // 7. Limpar Todos os Filtros
        window.clearAcervoFilters = function() {
            window.currentAcervoYear = 'all';
            window.currentAcervoTheme = 'all';
            window.currentAcervoDossie = '';
            window.currentAcervoGeo = 'all';
            window.currentAcervoType = 'all';
            window.currentAcervoQuery = '';
            window.currentAcervoPage = 1;

            const input = document.getElementById('acervo-search-input');
            if (input) input.value = '';
            const clearInputBtn = document.getElementById('acervo-clear-input-btn');
            if (clearInputBtn) clearInputBtn.style.display = 'none';

            const feedbackBox = document.getElementById('acervo-hero-feedback');
            if (feedbackBox) feedbackBox.style.display = 'none';

            const banner = document.getElementById('active-dossier-banner');
            if (banner) banner.style.display = 'none';

            // Reset pills
            document.querySelectorAll('.dossier-card').forEach(function(c) { c.classList.remove('active'); });
            document.querySelectorAll('#themes-filter-container .theme-pill').forEach(function(p) {
                if (p.getAttribute('data-theme') === 'all') p.classList.add('active');
                else p.classList.remove('active');
            });
            document.querySelectorAll('#year-filters-group .rf-pill').forEach(function(p) {
                if (p.getAttribute('data-val') === 'all') p.classList.add('active');
                else p.classList.remove('active');
            });
            document.querySelectorAll('#geo-filters-group .rf-pill').forEach(function(p) {
                if (p.getAttribute('data-val') === 'all') p.classList.add('active');
                else p.classList.remove('active');
            });
            document.querySelectorAll('#type-filters-group .rf-pill').forEach(function(p) {
                if (p.getAttribute('data-val') === 'all') p.classList.add('active');
                else p.classList.remove('active');
            });

            window.updateAcervoUrl();
            window.fetchAcervoPosts(false);
        };

        window.updateAcervoUrl = function() {
            const params = new URLSearchParams();
            if (window.currentAcervoDossie) params.set('dossie', window.currentAcervoDossie);
            if (window.currentAcervoTheme && window.currentAcervoTheme !== 'all') params.set('tema', window.currentAcervoTheme);
            if (window.currentAcervoYear && window.currentAcervoYear !== 'all') params.set('ano', window.currentAcervoYear);
            if (window.currentAcervoGeo && window.currentAcervoGeo !== 'all') params.set('pais', window.currentAcervoGeo);
            if (window.currentAcervoType && window.currentAcervoType !== 'all') params.set('tipo', window.currentAcervoType);
            if (window.currentAcervoQuery) params.set('q', window.currentAcervoQuery);

            const queryString = params.toString();
            const newUrl = window.location.pathname + (queryString ? '?' + queryString : '');
            if (window.history && window.history.pushState) {
                window.history.pushState(null, '', newUrl);
            }
        };

        window.loadMoreAcervo = function() {
            window.currentAcervoPage++;
            window.fetchAcervoPosts(true);
        };

        window.fetchAcervoPosts = async function(append) {
            if (window.isAcervoLoading) return;
            window.isAcervoLoading = true;

            const grid = document.getElementById('acervo-grid');
            const countEl = document.getElementById('results-count');
            const loadingEl = document.getElementById('acervo-loading');
            const loadMoreBtn = document.getElementById('acervo-load-more');
            const clearBtn = document.getElementById('clear-filters-btn');
            const searchBtn = document.getElementById('acervo-search-btn');
            const feedbackBox = document.getElementById('acervo-hero-feedback');

            const year = window.currentAcervoYear || 'all';
            const theme = window.currentAcervoTheme || 'all';
            const dossie = window.currentAcervoDossie || '';
            const geo = window.currentAcervoGeo || 'all';
            const type = window.currentAcervoType || 'all';
            const q = window.currentAcervoQuery || '';
            const page = window.currentAcervoPage || 1;

            if (searchBtn && !append) {
                searchBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span class="btn-text">Pesquisando...</span>';
                searchBtn.disabled = true;
            }

            if (feedbackBox && q !== '' && !append) {
                feedbackBox.style.display = 'inline-flex';
                feedbackBox.className = 'acervo-hero-feedback is-loading';
                feedbackBox.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Buscando no arquivo histórico por "<strong>' + q.replace(/</g, '&lt;').replace(/>/g, '&gt;') + '</strong>"...';
            }

            if (loadingEl) loadingEl.style.display = 'block';
            if (!append && grid) {
                grid.innerHTML = '';
                if (loadMoreBtn) loadMoreBtn.style.display = 'none';
            }

            let data = null;
            const queryParams = '?year=' + encodeURIComponent(year) +
                                '&theme=' + encodeURIComponent(theme) +
                                '&dossie=' + encodeURIComponent(dossie) +
                                '&geo=' + encodeURIComponent(geo) +
                                '&type=' + encodeURIComponent(type) +
                                '&q=' + encodeURIComponent(q) +
                                '&page=' + page +
                                '&_=' + Date.now();

            // 1. Tentar REST API relativa
            try {
                const res = await fetch('/wp-json/mercado/v1/acervo' + queryParams);
                if (res.ok) {
                    data = await res.json();
                } else {
                    throw new Error('Relative REST status: ' + res.status);
                }
            } catch (err) {
                // 2. Tentar REST URL absoluta
                try {
                    const res2 = await fetch(restUrl + queryParams);
                    if (res2.ok) {
                        data = await res2.json();
                    } else {
                        throw new Error('Absolute REST status: ' + res2.status);
                    }
                } catch (err2) {
                    // 3. Fallback para Admin AJAX
                    try {
                        const ajaxReqUrl = '/wp-admin/admin-ajax.php?action=mercado_acervo_ajax' + queryParams;
                        const ajaxRes = await fetch(ajaxReqUrl);
                        data = await ajaxRes.json();
                    } catch (ajaxErr) {
                        console.error('Search fetch failed:', ajaxErr);
                    }
                }
            }

            window.isAcervoLoading = false;
            if (loadingEl) loadingEl.style.display = 'none';

            if (searchBtn) {
                searchBtn.innerHTML = '<span class="btn-text">Pesquisar no Acervo</span>';
                searchBtn.disabled = false;
            }

            if (!data || !Array.isArray(data.posts)) {
                if (countEl) countEl.innerText = 'Não foi possível carregar os artigos. Tente novamente.';
                if (feedbackBox && q !== '') {
                    feedbackBox.className = 'acervo-hero-feedback no-results';
                    feedbackBox.innerHTML = '<i class="fas fa-exclamation-circle"></i> Erro ao pesquisar artigos.';
                }
                return;
            }

            const totalPosts = parseInt(data.total_posts || 0, 10);
            const safeQ = q.replace(/</g, '&lt;').replace(/>/g, '&gt;');

            if (countEl) {
                countEl.innerHTML = '<strong>' + totalPosts + '</strong> artigos catalogados neste recorte de pesquisa';
            }

            // Update instant feedback in Hero
            if (feedbackBox) {
                if (q !== '') {
                    feedbackBox.style.display = 'inline-flex';
                    if (totalPosts > 0) {
                        feedbackBox.className = 'acervo-hero-feedback has-results';
                        feedbackBox.innerHTML = '<span><i class="fas fa-check-circle"></i> <strong>' + totalPosts + '</strong> ' + (totalPosts === 1 ? 'artigo encontrado' : 'artigos encontrados') + ' para "<strong>' + safeQ + '</strong>"</span> <button type="button" class="feedback-btn" onclick="scrollToAcervoResults()">Ver resultados ↓</button>';
                    } else {
                        feedbackBox.className = 'acervo-hero-feedback no-results';
                        feedbackBox.innerHTML = '<span><i class="fas fa-exclamation-triangle"></i> Nenhum artigo encontrado para "<strong>' + safeQ + '</strong>"</span>';
                    }
                } else {
                    feedbackBox.style.display = 'none';
                }
            }

            if (clearBtn) {
                const hasFilters = (dossie !== '' || year !== 'all' || theme !== 'all' || geo !== 'all' || type !== 'all' || q !== '');
                clearBtn.style.display = hasFilters ? 'inline-block' : 'none';
            }

            if (data.posts.length > 0) {
                let html = '';
                data.posts.forEach(function(p) {
                    const safeTitle = (p.title || '').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                    const safeAuthor = (p.author || 'Redação').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                    const safeDateFull = (p.date_full || p.date || '').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                    const safeCat = (p.category || 'Mercado Erótico').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                    const safeExcerpt = (p.excerpt || '').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                    const safeReadingTime = (p.reading_time || '3 min de leitura').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                    const safeThumb = p.thumbnail || 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2026/11/colunista_padrao_logo.png';

                    html += '<article class="acervo-card">' +
                        '<div class="card-thumb-wrap">' +
                            '<img src="' + safeThumb + '" alt="' + safeTitle.replace(/"/g, '&quot;') + '" class="card-thumb" loading="lazy">' +
                            '<span class="card-category-badge">' + safeCat + '</span>' +
                            '<span class="card-year-badge">' + (p.year || '') + '</span>' +
                        '</div>' +
                        '<div class="card-body">' +
                            '<div class="card-byline">' +
                                '<div class="byline-author" title="Autor(a) da matéria">' +
                                    '<span class="author-icon"><i class="fas fa-feather-alt"></i></span>' +
                                    '<span class="author-text">Por <strong class="author-name">' + safeAuthor + '</strong></span>' +
                                '</div>' +
                                '<div class="byline-date" title="Data de publicação original">' +
                                    '<i class="far fa-calendar-alt"></i> ' + safeDateFull +
                                '</div>' +
                            '</div>' +
                            '<h3 class="card-title"><a href="' + p.link + '">' + safeTitle + '</a></h3>' +
                            '<p class="card-excerpt">' + safeExcerpt + '</p>' +
                            '<div class="card-footer">' +
                                '<span class="card-reading-time"><i class="far fa-clock"></i> ' + safeReadingTime + '</span>' +
                                '<a href="' + p.link + '" class="card-read-link">Ler artigo completo ➔</a>' +
                            '</div>' +
                        '</div>' +
                    '</article>';
                });

                if (append && grid) {
                    grid.insertAdjacentHTML('beforeend', html);
                } else if (grid) {
                    grid.innerHTML = html;
                }

                if (loadMoreBtn) {
                    loadMoreBtn.style.display = data.has_more ? 'inline-block' : 'none';
                }
            } else {
                if (!append && grid) {
                    grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 50px 20px; color: #64748b; background:#f8fafc; border-radius:12px; margin:20px 0;">' +
                        '<i class="fas fa-search" style="font-size: 32px; color: #cbd5e1; margin-bottom: 12px; display: block;"></i>' +
                        '<strong>Nenhum artigo encontrado com esses critérios específicos de pesquisa.</strong><br>' +
                        '<span style="font-size:13px;">Experimente selecionar outro ano, limpar os filtros territoriais ou explorar um dos nossos Dossiês Estratégicos abaixo.</span>' +
                    '</div>';
                }
                if (loadMoreBtn) loadMoreBtn.style.display = 'none';
            }
        };

        // Check URL params on load (e.g. ?dossie=historia-sexshops or ?ano=2024)
        const params = new URLSearchParams(window.location.search);
        const urlDossie = params.get('dossie');
        const urlYear = params.get('ano') || params.get('year');
        const urlTheme = params.get('tema') || params.get('theme');
        const urlGeo = params.get('pais') || params.get('geo');
        const urlType = params.get('tipo') || params.get('type');
        const urlQ = params.get('q') || params.get('s');

        if (urlDossie && dossiersMap[urlDossie]) {
            window.currentAcervoDossie = urlDossie;
        }
        if (urlYear && urlYear !== 'all') {
            window.currentAcervoYear = urlYear;
        }
        if (urlTheme && urlTheme !== 'all') {
            window.currentAcervoTheme = urlTheme;
        }
        if (urlGeo && urlGeo !== 'all') {
            window.currentAcervoGeo = urlGeo;
        }
        if (urlType && urlType !== 'all') {
            window.currentAcervoType = urlType;
        }
        if (urlQ) {
            window.currentAcervoQuery = urlQ;
        }
    })();
    </script>
    <?php
}
add_action('wp_footer', 'mercado_acervo_footer_scripts', 99);
