<?php
/**
 * Plugin Name: Mercado Erótico - Acervo Histórico & Pesquisa
 * Description: Sistema de busca e filtragem histórica por tempo e tema do portal Mercado Erótico.
 * Version: 1.1.0
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

function mercado_acervo_get_posts($year = 'all', $theme = 'all', $q = '', $page = 1, $per_page = 12) {
    $args = [
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => $per_page,
        'paged' => $page,
        'orderby' => 'date',
        'order' => 'DESC'
    ];

    if ($year && is_numeric($year)) {
        $args['date_query'] = [
            ['year' => intval($year)]
        ];
    }

    if ($q) {
        $args['s'] = $q;
    }

    if ($theme && $theme !== 'all') {
        $category_slugs = [];
        switch ($theme) {
            case 'negocios':
                $category_slugs = ['negocios', 'hot-news', 'coluna-empresarios-sex'];
                break;
            case 'pesquisas':
                $category_slugs = ['pesquisas'];
                break;
            case 'sexologia':
                $category_slugs = ['sexologia', 'saude', 'sexo-na-pratica'];
                break;
            case 'eventos':
                $category_slugs = ['eventos', 'calendario-erotico'];
                break;
            case 'colunas':
                $category_slugs = ['colunas', 'coluna-ka-entre-nos', 'cartas-sexo-diversao', 'dona-do-proprio-poder', 'coluna-sexativar', 'marlene-sexy'];
                break;
            case 'lancamentos':
                $category_slugs = ['lancamentos'];
                break;
            case 'iasex':
                $category_slugs = ['iasex'];
                break;
            default:
                $category_slugs = [$theme];
                break;
        }

        $args['tax_query'] = [
            [
                'taxonomy' => 'category',
                'field' => 'slug',
                'terms' => $category_slugs
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
            $thumb_url = 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2022/10/Copia-de-Julianna-Santos-10.png';
        }

        $excerpt = wp_strip_all_tags($post->post_excerpt ?: wp_trim_words($post->post_content, 20, '...'));

        $posts_data[] = [
            'id' => $post->ID,
            'title' => html_entity_decode(get_the_title($post->ID)),
            'link' => get_permalink($post->ID),
            'date' => get_the_date('d/m/Y', $post->ID),
            'year' => get_the_date('Y', $post->ID),
            'author' => get_the_author_meta('display_name', $post->post_author),
            'category' => $primary_cat,
            'thumbnail' => $thumb_url,
            'excerpt' => $excerpt
        ];
    }

    return [
        'posts' => $posts_data,
        'total_posts' => $query->found_posts,
        'total_pages' => $query->max_num_pages,
        'current_page' => $page,
        'has_more' => $page < $query->max_num_pages
    ];
}

function mercado_acervo_api_callback($request) {
    $year = sanitize_text_field($request->get_param('year'));
    $theme = sanitize_text_field($request->get_param('theme'));
    $q = sanitize_text_field($request->get_param('q'));
    $page = max(1, intval($request->get_param('page')));

    return mercado_acervo_get_posts($year, $theme, $q, $page);
}

// 2. Register Shortcode [mercado_acervo]
add_shortcode('mercado_acervo', 'mercado_acervo_shortcode');

function mercado_acervo_shortcode() {
    // Initial fetch in PHP
    $initial_data = mercado_acervo_get_posts('all', 'all', '', 1, 12);
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
            <div class="acervo-search-box">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="acervo-search-input" placeholder="Pesquisar por tema, marca, lei, produto ou especialista (ex: ECA digital, vibrador, censo, feira)...">
                <button type="button" id="acervo-search-btn" class="acervo-btn-search">Buscar</button>
            </div>
        </div>

        <!-- Themes Filter -->
        <div class="acervo-filter-section">
            <div class="filter-header">
                <span class="filter-label"><i class="fas fa-tags"></i> Grandes Eixos Temáticos:</span>
            </div>
            <div class="themes-pill-wrap" id="themes-filter-container">
                <button class="theme-pill active" data-theme="all">🌐 Todos os Temas</button>
                <button class="theme-pill" data-theme="negocios">🏢 Negócios & Mercado</button>
                <button class="theme-pill" data-theme="pesquisas">📊 Pesquisas & Censos</button>
                <button class="theme-pill" data-theme="sexologia">🔬 Sexologia & Saúde</button>
                <button class="theme-pill" data-theme="colunas">✍️ Colunas de Especialistas</button>
                <button class="theme-pill" data-theme="eventos">🎟️ Eventos & Feiras</button>
                <button class="theme-pill" data-theme="lancamentos">✨ Lançamentos</button>
                <button class="theme-pill" data-theme="iasex">🤖 IA & Tecnologia Sexual</button>
            </div>
        </div>

        <!-- Active Filter Indicator & Results Count -->
        <div class="acervo-results-bar">
            <div id="results-count" class="results-count"><strong><?php echo intval($initial_data['total_posts']); ?></strong> artigos encontrados no acervo</div>
            <button id="clear-filters-btn" class="clear-filters-btn" style="display:none;"><i class="fas fa-times"></i> Limpar Filtros</button>
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
            <button id="acervo-load-more" class="btn-load-more" <?php if (!$initial_data['has_more']) echo 'style="display:none;"'; ?>>Carregar mais artigos</button>
        </div>
    </div>

    <style>
    /* ACERVO HISTORICO - MODERN EDITORIAL CSS */
    .page-id-13623 .page-title-section { display: none !important; }
    .mercado-acervo-wrapper { clear: both; margin-top: 50px !important;
        max-width: 1240px;
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
        padding: 4px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.25);
    }
    .acervo-search-box .search-icon {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 16px;
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
        background: #dd3333;
        color: #ffffff;
        border: none;
        border-radius: 50px;
        padding: 0 28px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: background 0.2s ease;
    }
    .acervo-btn-search:hover {
        background: #b91c1c;
    }
    .acervo-filter-section {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px 20px;
        margin-bottom: 14px;
    }
    .filter-header {
        margin-bottom: 10px;
    }
    .filter-label {
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .years-pill-scroll {
        display: flex;
        gap: 8px;
        overflow-x: auto;
        padding-bottom: 4px;
    }
    .pill-btn {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 50px;
        padding: 7px 16px;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        cursor: pointer;
        white-space: nowrap;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .pill-btn:hover {
        border-color: #dd3333;
        color: #dd3333;
    }
    .pill-btn.active {
        background: #dd3333;
        color: #ffffff;
        border-color: #dd3333;
    }
    .pill-count {
        font-size: 11px;
        background: rgba(0,0,0,0.08);
        padding: 2px 6px;
        border-radius: 10px;
    }
    .pill-btn.active .pill-count {
        background: rgba(255,255,255,0.25);
        color: #fff;
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
    }
    .theme-pill:hover {
        border-color: #dd3333;
        color: #dd3333;
    }
    .theme-pill.active {
        background: #1e293b;
        color: #ffffff;
        border-color: #1e293b;
    }
    .acervo-results-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 24px 0 16px;
        padding: 0 4px;
    }
    .results-count {
        font-size: 15px;
        font-weight: 600;
        color: #475569;
    }
    .clear-filters-btn {
        background: none;
        border: none;
        color: #dd3333;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
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
        border-color: #cbd5e1;
    }
    .card-thumb-wrap {
        position: relative;
        height: 180px;
        background: #f1f5f9;
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
        background: #dd3333;
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
        color: #dd3333;
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
        color: #dd3333;
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
        border-top-color: #dd3333;
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
        background: #1e293b;
        color: #ffffff;
        border: none;
        padding: 13px 32px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-load-more:hover {
        background: #dd3333;
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

        const grid = document.getElementById('acervo-grid');
        const countEl = document.getElementById('results-count');
        const loadingEl = document.getElementById('acervo-loading');
        const loadMoreBtn = document.getElementById('acervo-load-more');
        const clearBtn = document.getElementById('clear-filters-btn');
        const searchInput = document.getElementById('acervo-search-input');
        const searchBtn = document.getElementById('acervo-search-btn');

        async function fetchPosts(append = false) {
            if (isLoading) return;
            isLoading = true;
            loadingEl.style.display = 'block';
            if (!append) {
                grid.innerHTML = '';
                loadMoreBtn.style.display = 'none';
            }

            const url = `/wp-json/mercado/v1/acervo?year=${currentYear}&theme=${currentTheme}&q=${encodeURIComponent(currentQuery)}&page=${currentPage}`;

            try {
                const res = await fetch(url);
                const data = await res.json();
                
                countEl.innerHTML = `<strong>${data.total_posts}</strong> artigos encontrados no acervo`;
                
                if (currentYear !== 'all' || currentTheme !== 'all' || currentQuery !== '') {
                    clearBtn.style.display = 'inline-block';
                } else {
                    clearBtn.style.display = 'none';
                }

                if (data.posts && data.posts.length > 0) {
                    renderCards(data.posts, append);
                    if (data.has_more) {
                        loadMoreBtn.style.display = 'inline-block';
                    } else {
                        loadMoreBtn.style.display = 'none';
                    }
                } else {
                    if (!append) {
                        grid.innerHTML = `<div style="grid-column: 1/-1; text-align: center; padding: 50px 20px; color: #64748b;">
                            <i class="fas fa-search" style="font-size: 32px; color: #cbd5e1; margin-bottom: 12px; display: block;"></i>
                            Nenhum artigo encontrado com esses critérios. Tente buscar por outros termos ou anos.
                        </div>`;
                    }
                    loadMoreBtn.style.display = 'none';
                }
            } catch (err) {
                console.error("Erro ao buscar no acervo:", err);
                countEl.innerText = "Erro ao carregar dados do acervo.";
            } finally {
                isLoading = false;
                loadingEl.style.display = 'none';
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

        // Years filter click
        // year selector listener removed

        // Theme filter click
        document.getElementById('themes-filter-container').addEventListener('click', function(e) {
            const btn = e.target.closest('.theme-pill');
            if (!btn) return;
            document.querySelectorAll('.theme-pill').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            currentTheme = btn.dataset.theme;
            currentPage = 1;
            fetchPosts(false);
        });

        // Search trigger
        function doSearch() {
            currentQuery = searchInput.value.trim();
            currentPage = 1;
            fetchPosts(false);
        }

        searchBtn.addEventListener('click', doSearch);
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                doSearch();
            }
        });

        // Load More
        loadMoreBtn.addEventListener('click', function() {
            currentPage++;
            fetchPosts(true);
        });

        // Clear Filters
        clearBtn.addEventListener('click', function() {
            currentYear = 'all';
            currentTheme = 'all';
            currentQuery = '';
            currentPage = 1;
            searchInput.value = '';
            document.querySelectorAll('.pill-btn').forEach(b => b.classList.remove('active'));
            document.querySelector('.pill-btn[data-year="all"]').classList.add('active');
            document.querySelectorAll('.theme-pill').forEach(b => b.classList.remove('active'));
            document.querySelector('.theme-pill[data-theme="all"]').classList.add('active');
            fetchPosts(false);
        });
    })();
    </script>
    <?php
    return ob_get_clean();
}
