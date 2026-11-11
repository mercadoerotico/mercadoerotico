<?php
/**
 * Plugin Name: Mercado Erótico - Acervo de Notícias & Pesquisa
 * Description: Sistema de busca e filtragem histórica por tempo e tema do portal Mercado Erótico.
 * Version: 2.0.0
 * Author: Antigravity
 */

if (!defined('ABSPATH')) exit;

// 1. Register REST API endpoint
add_action('rest_api_init', function() {
    register_rest_route('mercado/v1', '/acervo', [
        'methods' => 'GET',
        'callback' => 'mercado_acervo_api_callback',
        'permission_callback' => '__return_true'
    ]);
});

// Also register Admin AJAX fallback for 100% reliability
add_action('wp_ajax_mercado_acervo_ajax', 'mercado_acervo_ajax_callback');
add_action('wp_ajax_nopriv_mercado_acervo_ajax', 'mercado_acervo_ajax_callback');

function mercado_acervo_ajax_callback() {
    $year  = isset($_GET['year']) ? sanitize_text_field($_GET['year']) : 'all';
    $theme = isset($_GET['theme']) ? sanitize_text_field($_GET['theme']) : 'all';
    $q     = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';
    $page  = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

    $result = mercado_acervo_get_posts($year, $theme, $q, $page);
    wp_send_json($result);
}

function mercado_acervo_get_posts($year = 'all', $theme = 'all', $q = '', $page = 1, $per_page = 12) {
    $args = [
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $per_page,
        'paged'          => $page,
        'orderby'        => 'date',
        'order'          => 'DESC'
    ];

    if ($year && is_numeric($year)) {
        $args['date_query'] = [
            ['year' => intval($year)]
        ];
    }

    if (!empty($q)) {
        $args['s'] = $q;
    }

    if ($theme && $theme !== 'all') {
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

        $excerpt = wp_strip_all_tags($post->post_excerpt ?: wp_trim_words($post->post_content, 20, '...'));

        $posts_data[] = [
            'id'        => $post->ID,
            'title'     => html_entity_decode(get_the_title($post->ID)),
            'link'      => get_permalink($post->ID),
            'date'      => get_the_date('d/m/Y', $post->ID),
            'year'      => get_the_date('Y', $post->ID),
            'author'    => get_the_author_meta('display_name', $post->post_author),
            'category'  => $primary_cat,
            'thumbnail' => $thumb_url,
            'excerpt'   => $excerpt
        ];
    }

    return [
        'posts'        => $posts_data,
        'total_posts'  => $query->found_posts,
        'total_pages'  => $query->max_num_pages,
        'current_page' => $page,
        'has_more'     => $page < $query->max_num_pages
    ];
}

function mercado_acervo_api_callback($request) {
    $year  = sanitize_text_field($request->get_param('year'));
    $theme = sanitize_text_field($request->get_param('theme'));
    $q     = sanitize_text_field($request->get_param('q'));
    $page  = max(1, intval($request->get_param('page')));

    return mercado_acervo_get_posts($year, $theme, $q, $page);
}

// Global flag to indicate acervo shortcode was rendered
global $mercado_acervo_rendered;
$mercado_acervo_rendered = false;

// 2. Register Shortcode [mercado_acervo]
add_shortcode('mercado_acervo', 'mercado_acervo_shortcode');

function mercado_acervo_shortcode() {
    global $mercado_acervo_rendered;
    $mercado_acervo_rendered = true;

    // Initial fetch in PHP
    $initial_data = mercado_acervo_get_posts('all', 'all', '', 1, 12);
    ob_start();
    ?>
    <div id="mercado-acervo-app" class="mercado-acervo-wrapper">
        <!-- Hero Header -->
        <div class="acervo-hero">
            <div class="acervo-badge">★ ACERVO DE NOTÍCIAS • COBERTURA ESPECIALIZADA DESDE 2018</div>
            <h1 class="acervo-title">Acervo de Notícias Mercado Erótico</h1>
            <p class="acervo-subtitle">Explore o mais completo arquivo histórico, jornalístico e analítico sobre o mercado erótico e a saúde sexual no Brasil, documentado continuamente desde 2018.</p>
            
            <div class="acervo-stats-bar">
                <div class="stat-item"><span class="stat-num">2.115+</span><span class="stat-lbl">Artigos Documentados</span></div>
                <div class="stat-sep">•</div>
                <div class="stat-item"><span class="stat-num">Desde 2018</span><span class="stat-lbl">Documentação Contínua</span></div>
                <div class="stat-sep">•</div>
                <div class="stat-item"><span class="stat-num">20+</span><span class="stat-lbl">Colunistas e Especialistas</span></div>
            </div>

            <!-- Search Bar -->
            <div class="acervo-search-box">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="acervo-search-input" placeholder="Pesquisar por tema, marca, lei, produto ou especialista (ex: ECA digital, vibrador, censo, feira)..." autocomplete="off" onkeydown="if(event.key==='Enter'){event.preventDefault();doAcervoSearch();}">
                <button type="button" id="acervo-search-btn" class="acervo-btn-search" onclick="doAcervoSearch()">Buscar</button>
            </div>
        </div>

        <!-- Themes Filter -->
        <div class="acervo-filter-section">
            <div class="filter-header">
                <span class="filter-label"><i class="fas fa-tags"></i> Grandes Eixos Temáticos:</span>
            </div>
            <div class="themes-pill-wrap" id="themes-filter-container">
                <button type="button" class="theme-pill active" data-theme="all" onclick="selectAcervoTheme('all', this)">🌐 Todos os Temas</button>
                <button type="button" class="theme-pill" data-theme="negocios" onclick="selectAcervoTheme('negocios', this)">🏢 Negócios &amp; Mercado</button>
                <button type="button" class="theme-pill" data-theme="pesquisas" onclick="selectAcervoTheme('pesquisas', this)">📊 Pesquisas &amp; Censos</button>
                <button type="button" class="theme-pill" data-theme="sexologia" onclick="selectAcervoTheme('sexologia', this)">🔬 Sexologia &amp; Saúde</button>
                <button type="button" class="theme-pill" data-theme="colunas" onclick="selectAcervoTheme('colunas', this)">✍️ Colunas de Especialistas</button>
                <button type="button" class="theme-pill" data-theme="eventos" onclick="selectAcervoTheme('eventos', this)">🎟️ Eventos &amp; Feiras</button>
                <button type="button" class="theme-pill" data-theme="lancamentos" onclick="selectAcervoTheme('lancamentos', this)">✨ Lançamentos</button>
                <button type="button" class="theme-pill" data-theme="iasex" onclick="selectAcervoTheme('iasex', this)">🤖 IA &amp; Tecnologia Sexual</button>
            </div>
        </div>

        <!-- Active Filter Indicator & Results Count -->
        <div class="acervo-results-bar">
            <div id="results-count" class="results-count"><strong><?php echo intval($initial_data['total_posts']); ?></strong> artigos encontrados no acervo</div>
            <button type="button" id="clear-filters-btn" class="clear-filters-btn" style="display:none;" onclick="clearAcervoFilters()"><i class="fas fa-times"></i> Limpar Filtros</button>
        </div>

        <!-- Grid of Cards -->
        <div id="acervo-grid" class="acervo-grid">
            <?php foreach ($initial_data['posts'] as $p): ?>
                <article class="acervo-card">
                    <div class="card-thumb-wrap">
                        <img src="<?php echo esc_url($p['thumbnail']); ?>" alt="<?php echo esc_attr($p['title']); ?>" class="card-thumb" loading="lazy">
                        <span class="card-category-badge"><?php echo esc_html($p['category']); ?></span>
                        <span class="card-year-badge"><?php echo esc_html($p['year']); ?></span>
                    </div>
                    <div class="card-body">
                        <div class="card-meta">
                            <span><i class="far fa-calendar-alt"></i> <?php echo esc_html($p['date']); ?></span>
                        </div>
                        <h3 class="card-title"><a href="<?php echo esc_url($p['link']); ?>"><?php echo esc_html($p['title']); ?></a></h3>
                        <p class="card-excerpt"><?php echo esc_html($p['excerpt']); ?></p>
                        <div class="card-footer">
                            <span class="card-author"><i class="far fa-user"></i> <?php echo esc_html($p['author']); ?></span>
                            <a href="<?php echo esc_url($p['link']); ?>" class="card-read-link">Ler artigo ➔</a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <!-- Loading Spinner -->
        <div id="acervo-loading" class="acervo-loading" style="display:none;">
            <div class="spinner"></div>
            <span>Buscando no acervo de notícias...</span>
        </div>

        <!-- Load More Button -->
        <div class="acervo-actions">
            <button type="button" id="acervo-load-more" class="btn-load-more" onclick="loadMoreAcervo()" <?php if (!$initial_data['has_more']) echo 'style="display:none;"'; ?>>Carregar mais artigos</button>
        </div>
    </div>

    <style>
    /* ACERVO HISTORICO - MODERN EDITORIAL CSS */
    .page-id-13623 .page-title-section { display: none !important; }
    .mercado-acervo-wrapper {
        clear: both;
        max-width: 1200px;
        margin: 25px auto 60px;
        padding: 0 15px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        color: #1f2937;
    }
    .acervo-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #31102f 100%);
        border-radius: 20px;
        padding: 45px 30px;
        color: #fff;
        text-align: center;
        margin-bottom: 25px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.15);
        border: 1px solid rgba(227, 28, 97, 0.2);
    }
    .acervo-badge {
        display: inline-block;
        background: rgba(225, 29, 72, 0.2);
        color: #fb7185;
        border: 1px solid rgba(225, 29, 72, 0.4);
        padding: 4px 14px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        margin-bottom: 14px;
    }
    .acervo-title {
        font-size: 34px;
        font-weight: 800;
        color: #ffffff !important;
        margin: 0 0 12px 0;
        line-height: 1.2;
    }
    .acervo-subtitle {
        font-size: 16px;
        color: #cbd5e1;
        max-width: 720px;
        margin: 0 auto 24px;
        line-height: 1.6;
    }
    .acervo-stats-bar {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 30px;
        padding: 12px 24px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.12);
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
    }
    .stat-sep {
        color: #64748b;
    }
    .acervo-search-box {
        max-width: 680px;
        margin: 0 auto;
        position: relative;
        display: flex;
        background: #ffffff;
        border-radius: 50px;
        padding: 5px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.25);
    }
    .acervo-search-box .search-icon {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 16px;
        pointer-events: none;
    }
    .acervo-search-box input {
        flex: 1;
        border: none !important;
        outline: none !important;
        padding: 12px 16px 12px 46px !important;
        font-size: 15px !important;
        color: #1e293b !important;
        border-radius: 50px !important;
        background: transparent !important;
        box-shadow: none !important;
    }
    .acervo-btn-search {
        background: #e31c61;
        color: #ffffff;
        border: none;
        border-radius: 50px;
        padding: 0 28px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        transition: background 0.2s ease, transform 0.2s ease;
    }
    .acervo-btn-search:hover {
        background: #c4124e;
        transform: scale(1.02);
    }
    .acervo-filter-section {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 18px 22px;
        margin-bottom: 20px;
    }
    .filter-header {
        margin-bottom: 12px;
    }
    .filter-label {
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .themes-pill-wrap {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .theme-pill {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 13.5px;
        font-weight: 600;
        color: #334155;
        cursor: pointer;
        position: relative;
        z-index: 5;
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
    .acervo-results-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 20px 0 16px;
        padding: 0 4px;
    }
    .results-count {
        font-size: 15px;
        font-weight: 600;
        color: #475569;
    }
    .clear-filters-btn {
        background: none;
        border: 1px solid #e2e8f0;
        padding: 5px 12px;
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
    }
    .acervo-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 22px;
    }
    .acervo-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        display: flex;
        flex-direction: column;
    }
    .acervo-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.08);
        border-color: rgba(227, 28, 97, 0.3);
    }
    .card-thumb-wrap {
        position: relative;
        height: 180px;
        overflow: hidden;
        background: #f1f5f9;
    }
    .card-thumb {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .acervo-card:hover .card-thumb {
        transform: scale(1.05);
    }
    .card-category-badge {
        position: absolute;
        bottom: 10px;
        left: 10px;
        background: rgba(15, 23, 42, 0.85);
        backdrop-filter: blur(4px);
        color: #ffffff;
        font-size: 11px;
        font-weight: 700;
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
        font-size: 11px;
        font-weight: 800;
        padding: 2px 7px;
        border-radius: 4px;
    }
    .card-body {
        padding: 18px 20px 20px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .card-meta {
        font-size: 12px;
        color: #94a3b8;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .card-title {
        font-size: 16px;
        font-weight: 700;
        line-height: 1.4;
        margin: 0 0 10px 0;
    }
    .card-title a {
        color: #1e293b !important;
        text-decoration: none !important;
        transition: color 0.2s ease;
    }
    .card-title a:hover {
        color: #e31c61 !important;
    }
    .card-excerpt {
        font-size: 13.5px;
        color: #64748b;
        line-height: 1.5;
        margin: 0 0 16px 0;
        flex: 1;
    }
    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
        font-size: 12.5px;
    }
    .card-author {
        color: #64748b;
        font-weight: 500;
    }
    .card-read-link {
        color: #e31c61 !important;
        font-weight: 700;
        text-decoration: none !important;
        transition: transform 0.2s ease;
        display: inline-block;
    }
    .card-read-link:hover {
        transform: translateX(3px);
    }
    .acervo-actions {
        text-align: center;
        margin-top: 35px;
    }
    .btn-load-more {
        background: #ffffff;
        border: 2px solid #e31c61;
        color: #e31c61;
        padding: 12px 32px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-load-more:hover {
        background: #e31c61;
        color: #ffffff;
        box-shadow: 0 6px 15px rgba(227, 28, 97, 0.25);
    }
    .acervo-loading {
        text-align: center;
        padding: 40px 0;
        color: #64748b;
        font-weight: 600;
    }
    .spinner {
        width: 32px;
        height: 32px;
        border: 3px solid rgba(227, 28, 97, 0.2);
        border-top-color: #e31c61;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        margin: 0 auto 12px;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    @media (max-width: 991px) {
        .acervo-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .acervo-hero { padding: 30px 18px; }
        .acervo-title { font-size: 26px; }
        .acervo-search-box { flex-direction: column; background: transparent; box-shadow: none; padding: 0; }
        .acervo-search-box input { background: #fff !important; margin-bottom: 8px; border-radius: 8px !important; padding-left: 42px !important; }
        .acervo-btn-search { padding: 12px; border-radius: 8px; }
        .acervo-grid { grid-template-columns: 1fr; }
    }
    </style>
    <?php
    return ob_get_clean();
}

/**
 * 3. FOOTER SCRIPTS: Completely protected from WordPress content filters
 */
function mercado_acervo_footer_scripts() {
    global $mercado_acervo_rendered;
    if (!$mercado_acervo_rendered) return;

    $rest_endpoint = esc_url_raw(rest_url('mercado/v1/acervo'));
    $ajax_endpoint = esc_url_raw(admin_url('admin-ajax.php'));
    ?>
    <script>
    (function() {
        window.currentAcervoYear = 'all';
        window.currentAcervoTheme = 'all';
        window.currentAcervoQuery = '';
        window.currentAcervoPage = 1;
        window.isAcervoLoading = false;

        const restUrl = '<?php echo $rest_endpoint; ?>';
        const ajaxUrl = '<?php echo $ajax_endpoint; ?>';

        window.selectAcervoTheme = function(theme, btn) {
            window.currentAcervoTheme = theme || 'all';
            window.currentAcervoPage = 1;

            const pills = document.querySelectorAll('#themes-filter-container .theme-pill');
            pills.forEach(function(p) {
                if (p.getAttribute('data-theme') === theme) {
                    p.classList.add('active');
                } else {
                    p.classList.remove('active');
                }
            });

            window.fetchAcervoPosts(false);
        };

        window.doAcervoSearch = function() {
            const input = document.getElementById('acervo-search-input');
            window.currentAcervoQuery = input ? input.value.trim() : '';
            window.currentAcervoPage = 1;
            window.fetchAcervoPosts(false);
        };

        window.clearAcervoFilters = function() {
            window.currentAcervoTheme = 'all';
            window.currentAcervoQuery = '';
            window.currentAcervoPage = 1;

            const input = document.getElementById('acervo-search-input');
            if (input) input.value = '';

            const pills = document.querySelectorAll('#themes-filter-container .theme-pill');
            pills.forEach(function(p) {
                if (p.getAttribute('data-theme') === 'all') {
                    p.classList.add('active');
                } else {
                    p.classList.remove('active');
                }
            });

            window.fetchAcervoPosts(false);
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

            if (loadingEl) loadingEl.style.display = 'block';
            if (!append && grid) {
                grid.innerHTML = '';
                if (loadMoreBtn) loadMoreBtn.style.display = 'none';
            }

            const theme = window.currentAcervoTheme || 'all';
            const q = window.currentAcervoQuery || '';
            const page = window.currentAcervoPage || 1;

            let data = null;

            // 1. Try REST API
            const requestUrl = restUrl + '?year=all&theme=' + encodeURIComponent(theme) + '&q=' + encodeURIComponent(q) + '&page=' + page;
            try {
                const res = await fetch(requestUrl);
                if (res.ok) {
                    data = await res.json();
                } else {
                    throw new Error('REST returned ' + res.status);
                }
            } catch (err) {
                // 2. Fallback to Admin AJAX
                console.warn('REST failed, fallback to Admin AJAX:', err);
                try {
                    const ajaxReqUrl = ajaxUrl + '?action=mercado_acervo_ajax&year=all&theme=' + encodeURIComponent(theme) + '&q=' + encodeURIComponent(q) + '&page=' + page;
                    const ajaxRes = await fetch(ajaxReqUrl);
                    data = await ajaxRes.json();
                } catch (ajaxErr) {
                    console.error('AJAX fallback failed:', ajaxErr);
                }
            }

            window.isAcervoLoading = false;
            if (loadingEl) loadingEl.style.display = 'none';

            if (!data || !Array.isArray(data.posts)) {
                if (countEl) countEl.innerText = 'Não foi possível carregar os artigos. Tente novamente.';
                return;
            }

            if (countEl) {
                countEl.innerHTML = '<strong>' + data.total_posts + '</strong> artigos encontrados no acervo';
            }

            if (clearBtn) {
                if (theme !== 'all' || q !== '') {
                    clearBtn.style.display = 'inline-block';
                } else {
                    clearBtn.style.display = 'none';
                }
            }

            if (data.posts.length > 0) {
                let html = '';
                data.posts.forEach(function(p) {
                    const safeTitle = (p.title || '').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                    const safeAuthor = (p.author || '').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                    const safeCat = (p.category || 'Mercado Erótico').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                    const safeExcerpt = (p.excerpt || '').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                    const safeThumb = p.thumbnail || 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2026/11/colunista_padrao_logo.png';

                    html += '<article class="acervo-card">' +
                        '<div class="card-thumb-wrap">' +
                            '<img ' + 'src="' + safeThumb + '" alt="' + safeTitle.replace(/"/g, '&quot;') + '" class="card-thumb" loading="lazy">' +
                            '<span class="card-category-badge">' + safeCat + '</span>' +
                            '<span class="card-year-badge">' + (p.year || '') + '</span>' +
                        '</div>' +
                        '<div class="card-body">' +
                            '<div class="card-meta">' +
                                '<span><i class="far fa-calendar-alt"></i> ' + (p.date || '') + '</span>' +
                            '</div>' +
                            '<h3 class="card-title"><a href="' + p.link + '">' + safeTitle + '</a></h3>' +
                            '<p class="card-excerpt">' + safeExcerpt + '</p>' +
                            '<div class="card-footer">' +
                                '<span class="card-author"><i class="far fa-user"></i> ' + safeAuthor + '</span>' +
                                '<a href="' + p.link + '" class="card-read-link">Ler artigo ➔</a>' +
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
                        '<strong>Nenhum artigo encontrado com esses critérios.</strong><br>' +
                        '<span style="font-size:13px;">Tente pesquisar por outros termos ou selecione outro eixo temático.</span>' +
                    '</div>';
                }
                if (loadMoreBtn) loadMoreBtn.style.display = 'none';
            }
        };

        // Check URL params on load (e.g. ?theme=pesquisas or ?q=vibrador)
        const params = new URLSearchParams(window.location.search);
        const urlTheme = params.get('theme');
        const urlQ = params.get('q') || params.get('s');

        if (urlTheme && urlTheme !== 'all') {
            const targetBtn = document.querySelector('#themes-filter-container .theme-pill[data-theme="' + urlTheme + '"]');
            window.selectAcervoTheme(urlTheme, targetBtn);
        } else if (urlQ) {
            const input = document.getElementById('acervo-search-input');
            if (input) input.value = urlQ;
            window.doAcervoSearch();
        }
    })();
    </script>
    <?php
}
add_action('wp_footer', 'mercado_acervo_footer_scripts', 99);
