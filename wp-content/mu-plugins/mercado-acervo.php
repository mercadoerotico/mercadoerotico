<?php
/**
 * Plugin Name: Mercado Erótico - Acervo Histórico & Pesquisa
 * Description: Sistema de busca e filtragem histórica por tempo e tema do portal Mercado Erótico.
 * Version: 1.2.0
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

// 2. Register Shortcode [mercado_acervo]
add_shortcode('mercado_acervo', 'mercado_acervo_shortcode');

function mercado_acervo_shortcode() {
    // Initial fetch in PHP
    $initial_data = mercado_acervo_get_posts('all', 'all', '', 1, 12);
    $rest_endpoint = esc_url_raw(rest_url('mercado/v1/acervo'));
    $ajax_endpoint = esc_url_raw(admin_url('admin-ajax.php'));
    ob_start();
    ?>
    <div id="mercado-acervo-app" class="mercado-acervo-wrapper">
        <!-- Hero Header -->
        <div class="acervo-hero">
            <div class="acervo-badge">★ ACERVO HISTÓRICO • COBERTURA ESPECIALIZADA DESDE 2018</div>
            <h1 class="acervo-title">Acervo Histórico Mercado Erótico</h1>
            <p class="acervo-subtitle">Explore o mais completo arquivo histórico, jornalístico e analítico sobre o mercado erótico e a saúde sexual no Brasil, documentado continuamente desde 2018.</p>
            
            <div class="acervo-stats-bar">
                <div class="stat-item"><span class="stat-num">2.115+</span><span class="stat-lbl">Artigos Documentados</span></div>
                <div class="stat-sep">•</div>
                <div class="stat-item"><span class="stat-num">Desde 2018</span><span class="stat-lbl">Documentação Contínua</span></div>
                <div class="stat-sep">•</div>
                <div class="stat-item"><span class="stat-num">20+</span><span class="stat-lbl">Colunistas e Especialistas</span></div>
            </div>

            <!-- Search Bar -->
            <form id="acervo-search-form" class="acervo-search-box" onsubmit="return false;">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="acervo-search-input" placeholder="Pesquisar por tema, marca, lei, produto ou especialista (ex: ECA digital, vibrador, censo, feira)..." autocomplete="off">
                <button type="submit" id="acervo-search-btn" class="acervo-btn-search">Buscar</button>
            </form>
        </div>

        <!-- Themes Filter -->
        <div class="acervo-filter-section">
            <div class="filter-header">
                <span class="filter-label"><i class="fas fa-tags"></i> Grandes Eixos Temáticos:</span>
            </div>
            <div class="themes-pill-wrap" id="themes-filter-container">
                <button type="button" class="theme-pill active" data-theme="all">🌐 Todos os Temas</button>
                <button type="button" class="theme-pill" data-theme="negocios">🏢 Negócios &amp; Mercado</button>
                <button type="button" class="theme-pill" data-theme="pesquisas">📊 Pesquisas &amp; Censos</button>
                <button type="button" class="theme-pill" data-theme="sexologia">🔬 Sexologia &amp; Saúde</button>
                <button type="button" class="theme-pill" data-theme="colunas">✍️ Colunas de Especialistas</button>
                <button type="button" class="theme-pill" data-theme="eventos">🎟️ Eventos &amp; Feiras</button>
                <button type="button" class="theme-pill" data-theme="lancamentos">✨ Lançamentos</button>
                <button type="button" class="theme-pill" data-theme="iasex">🤖 IA &amp; Tecnologia Sexual</button>
            </div>
        </div>

        <!-- Active Filter Indicator & Results Count -->
        <div class="acervo-results-bar">
            <div id="results-count" class="results-count"><strong><?php echo intval($initial_data['total_posts']); ?></strong> artigos encontrados no acervo</div>
            <button type="button" id="clear-filters-btn" class="clear-filters-btn" style="display:none;"><i class="fas fa-times"></i> Limpar Filtros</button>
        </div>

        <!-- Grid of Cards (Preloaded with first 12) -->
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
            <span>Buscando no acervo histórico...</span>
        </div>

        <!-- Load More Button -->
        <div class="acervo-actions">
            <button type="button" id="acervo-load-more" class="btn-load-more" <?php if (!$initial_data['has_more']) echo 'style="display:none;"'; ?>>Carregar mais artigos</button>
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
        background: #0f172a;
        overflow: hidden;
    }
    .card-thumb {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
        display: block;
    }
    .acervo-card:hover .card-thumb {
        transform: scale(1.05);
    }
    .card-category-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background: rgba(15, 23, 42, 0.85);
        backdrop-filter: blur(4px);
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .card-year-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: #e31c61;
        color: #fff;
        font-size: 11px;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 6px;
    }
    .card-body {
        padding: 16px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .card-meta {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 8px;
        display: flex;
        gap: 8px;
    }
    .card-title {
        font-size: 16px;
        font-weight: 700;
        line-height: 1.35;
        margin: 0 0 10px 0;
    }
    .card-title a {
        color: #0f172a;
        text-decoration: none;
        transition: color 0.2s;
    }
    .card-title a:hover {
        color: #e31c61;
    }
    .card-excerpt {
        font-size: 13px;
        color: #475569;
        line-height: 1.5;
        margin-bottom: 16px;
        flex: 1;
    }
    .card-footer {
        padding-top: 10px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .card-author {
        font-size: 12px;
        font-weight: 600;
        color: #334155;
    }
    .card-read-link {
        font-size: 12px;
        font-weight: 700;
        color: #e31c61;
        text-decoration: none;
    }
    .card-read-link:hover {
        text-decoration: underline;
    }
    .acervo-loading {
        text-align: center;
        padding: 40px;
        color: #64748b;
    }
    .spinner {
        width: 36px;
        height: 36px;
        border: 4px solid #e2e8f0;
        border-top-color: #e31c61;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        margin: 0 auto 12px;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    .acervo-actions {
        text-align: center;
        margin-top: 35px;
    }
    .btn-load-more {
        background: #0f172a;
        color: #ffffff;
        border: none;
        padding: 13px 32px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-load-more:hover {
        background: #e31c61;
        transform: translateY(-2px);
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

    <script>
    (function() {
        let currentYear = 'all';
        let currentTheme = 'all';
        let currentQuery = '';
        let currentPage = 1;
        let isLoading = false;
        let searchDebounceTimer = null;

        const restUrl = '<?php echo $rest_endpoint; ?>';
        const ajaxUrl = '<?php echo $ajax_endpoint; ?>';

        function initAcervo() {
            const grid = document.getElementById('acervo-grid');
            const countEl = document.getElementById('results-count');
            const loadingEl = document.getElementById('acervo-loading');
            const loadMoreBtn = document.getElementById('acervo-load-more');
            const clearBtn = document.getElementById('clear-filters-btn');
            const searchInput = document.getElementById('acervo-search-input');
            const searchForm = document.getElementById('acervo-search-form');
            const themeContainer = document.getElementById('themes-filter-container');

            if (!grid || !themeContainer) return;

            async function fetchPosts(append = false) {
                if (isLoading) return;
                isLoading = true;
                if (loadingEl) loadingEl.style.display = 'block';
                if (!append) {
                    grid.innerHTML = '';
                    if (loadMoreBtn) loadMoreBtn.style.display = 'none';
                }

                // Try REST API first, fallback to Admin AJAX
                let requestUrl = `${restUrl}?year=${currentYear}&theme=${currentTheme}&q=${encodeURIComponent(currentQuery)}&page=${currentPage}`;
                let data = null;

                try {
                    const res = await fetch(requestUrl);
                    if (res.ok) {
                        data = await res.json();
                    } else {
                        throw new Error('REST returned ' + res.status);
                    }
                } catch (err) {
                    console.warn('REST API failed, trying Admin AJAX fallback:', err);
                    try {
                        const ajaxReqUrl = `${ajaxUrl}?action=mercado_acervo_ajax&year=${currentYear}&theme=${currentTheme}&q=${encodeURIComponent(currentQuery)}&page=${currentPage}`;
                        const ajaxRes = await fetch(ajaxReqUrl);
                        data = await ajaxRes.json();
                    } catch (ajaxErr) {
                        console.error('AJAX fallback also failed:', ajaxErr);
                    }
                }

                isLoading = false;
                if (loadingEl) loadingEl.style.display = 'none';

                if (!data || !data.posts) {
                    if (countEl) countEl.innerText = 'Não foi possível carregar os artigos. Tente novamente.';
                    return;
                }

                if (countEl) {
                    countEl.innerHTML = `<strong>${data.total_posts}</strong> artigos encontrados no acervo`;
                }

                if (clearBtn) {
                    if (currentTheme !== 'all' || currentQuery !== '') {
                        clearBtn.style.display = 'inline-block';
                    } else {
                        clearBtn.style.display = 'none';
                    }
                }

                if (data.posts && data.posts.length > 0) {
                    renderCards(data.posts, append);
                    if (loadMoreBtn) {
                        loadMoreBtn.style.display = data.has_more ? 'inline-block' : 'none';
                    }
                } else {
                    if (!append) {
                        grid.innerHTML = `
                        <div style="grid-column: 1/-1; text-align: center; padding: 50px 20px; color: #64748b; background:#f8fafc; border-radius:12px; margin:20px 0;">
                            <i class="fas fa-search" style="font-size: 32px; color: #cbd5e1; margin-bottom: 12px; display: block;"></i>
                            <strong>Nenhum artigo encontrado com esses critérios.</strong><br>
                            <span style="font-size:13px;">Tente pesquisar por outros termos ou selecionar outro eixo temático.</span>
                        </div>`;
                    }
                    if (loadMoreBtn) loadMoreBtn.style.display = 'none';
                }
            }

            function renderCards(posts, append) {
                let html = '';
                posts.forEach(p => {
                    html += `
                    <article class="acervo-card">
                        <div class="card-thumb-wrap">
                            <img src="${p.thumbnail}" alt="${p.title}" class="card-thumb" loading="lazy">
                            <span class="card-category-badge">${p.category}</span>
                            <span class="card-year-badge">${p.year}</span>
                        </div>
                        <div class="card-body">
                            <div class="card-meta">
                                <span><i class="far fa-calendar-alt"></i> ${p.date}</span>
                            </div>
                            <h3 class="card-title"><a href="${p.link}">${p.title}</a></h3>
                            <p class="card-excerpt">${p.excerpt}</p>
                            <div class="card-footer">
                                <span class="card-author"><i class="far fa-user"></i> ${p.author}</span>
                                <a href="${p.link}" class="card-read-link">Ler artigo ➔</a>
                            </div>
                        </div>
                    </article>`;
                });
                if (append) {
                    grid.insertAdjacentHTML('beforeend', html);
                } else {
                    grid.innerHTML = html;
                }
            }

            // Theme click with both direct listeners and container delegation
            const themeButtons = themeContainer.querySelectorAll('.theme-pill');
            themeButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    themeButtons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    currentTheme = this.getAttribute('data-theme') || 'all';
                    currentPage = 1;
                    fetchPosts(false);
                });
            });

            // Search Trigger
            function doSearch() {
                if (!searchInput) return;
                currentQuery = searchInput.value.trim();
                currentPage = 1;
                fetchPosts(false);
            }

            if (searchForm) {
                searchForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    doSearch();
                });
            }

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchDebounceTimer);
                    searchDebounceTimer = setTimeout(() => {
                        doSearch();
                    }, 400);
                });
            }

            // Load More
            if (loadMoreBtn) {
                loadMoreBtn.addEventListener('click', function() {
                    currentPage++;
                    fetchPosts(true);
                });
            }

            // Clear Filters
            if (clearBtn) {
                clearBtn.addEventListener('click', function() {
                    currentYear = 'all';
                    currentTheme = 'all';
                    currentQuery = '';
                    currentPage = 1;
                    if (searchInput) searchInput.value = '';
                    themeButtons.forEach(b => b.classList.remove('active'));
                    const allBtn = themeContainer.querySelector('.theme-pill[data-theme="all"]');
                    if (allBtn) allBtn.classList.add('active');
                    fetchPosts(false);
                });
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initAcervo);
        } else {
            initAcervo();
        }
    })();
    </script>
    <?php
    return ob_get_clean();
}
