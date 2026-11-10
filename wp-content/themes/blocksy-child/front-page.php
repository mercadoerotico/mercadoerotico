<?php
/**
 * Front Page Template - Mercado Erótico Modern Magazine
 */

get_header();

// 1. Get Top 5 Featured Posts for Bento Grid
$featured_posts = get_posts(array(
    'numberposts' => 5,
    'post_status' => 'publish'
));

$main_post = !empty($featured_posts) ? $featured_posts[0] : null;
$side_posts = array_slice($featured_posts, 1, 4);

// 2. Curated Categories for Eixos
$negocios_posts = get_posts(array('category_name' => 'negocios', 'numberposts' => 3, 'post_status' => 'publish'));
$sexologia_posts = get_posts(array('category_name' => 'sexologia', 'numberposts' => 3, 'post_status' => 'publish'));
$eventos_posts = get_posts(array('category_name' => 'eventos', 'numberposts' => 3, 'post_status' => 'publish'));

// 3. Livraria Featured Items (from clean json)
$livraria_items = array();
$livraria_file = WP_CONTENT_DIR . '/uploads/livraria/livraria_clean.json';
if (file_exists($livraria_file)) {
    $all_books = json_decode(file_get_contents($livraria_file), true) ?: array();
    $livraria_items = array_slice($all_books, 0, 4);
}

// 4. Recent Feed Posts (offset 5 so no duplication)
$feed_posts = get_posts(array(
    'numberposts' => 9,
    'offset' => 5,
    'post_status' => 'publish'
));
?>

<div class="me-home-wrapper">
    <!-- Top Trending Ticker -->
    <div class="me-trending-bar">
        <div class="trending-badge"><i class="fas fa-bolt"></i> EM ALTA</div>
        <div class="trending-ticker">
            <?php foreach ($featured_posts as $fp): ?>
                <a href="<?php echo get_permalink($fp->ID); ?>" class="ticker-item">
                    <span>•</span> <?php echo esc_html($fp->post_title); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Hero Bento Grid -->
    <section class="me-bento-hero">
        <?php if ($main_post): 
            $main_thumb = get_the_post_thumbnail_url($main_post->ID, 'full') ?: 'https://images.unsplash.com/photo-1518895949257-7621c3c786d7?w=1200';
            $main_cats = wp_get_post_categories($main_post->ID, array('fields' => 'names'));
            $main_cat = !empty($main_cats) ? $main_cats[0] : 'Destaque';
        ?>
            <article class="bento-main-card">
                <a href="<?php echo get_permalink($main_post->ID); ?>" class="bento-card-link">
                    <div class="bento-bg" style="background-image: url('<?php echo esc_url($main_thumb); ?>');"></div>
                    <div class="bento-gradient"></div>
                    <div class="bento-content">
                        <span class="bento-cat-tag"><?php echo esc_html($main_cat); ?></span>
                        <h1 class="bento-main-title"><?php echo esc_html($main_post->post_title); ?></h1>
                        <p class="bento-excerpt"><?php echo wp_trim_words($main_post->post_content, 22, '...'); ?></p>
                        <div class="bento-meta">
                            <span><i class="far fa-calendar-alt"></i> <?php echo get_the_date('d/m/Y', $main_post->ID); ?></span>
                            <span>•</span>
                            <span><i class="far fa-user"></i> <?php echo get_the_author_meta('display_name', $main_post->post_author); ?></span>
                        </div>
                    </div>
                </a>
            </article>
        <?php endif; ?>

        <!-- Side 4 Cards -->
        <div class="bento-side-grid">
            <?php foreach ($side_posts as $sp): 
                $sp_thumb = get_the_post_thumbnail_url($sp->ID, 'medium_large') ?: 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=600';
                $sp_cats = wp_get_post_categories($sp->ID, array('fields' => 'names'));
                $sp_cat = !empty($sp_cats) ? $sp_cats[0] : 'Mundo Erótico';
            ?>
                <article class="bento-side-card">
                    <a href="<?php echo get_permalink($sp->ID); ?>" class="side-card-link">
                        <div class="side-thumb-wrap">
                            <img src="<?php echo esc_url($sp_thumb); ?>" alt="<?php echo esc_attr($sp->post_title); ?>" loading="lazy">
                        </div>
                        <div class="side-content">
                            <span class="side-cat"><?php echo esc_html($sp_cat); ?></span>
                            <h3 class="side-title"><?php echo esc_html($sp->post_title); ?></h3>
                            <span class="side-date"><i class="far fa-clock"></i> <?php echo get_the_date('d/m/Y', $sp->ID); ?></span>
                        </div>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Livraria Digital Showcase Banner -->
    <section class="me-livraria-showcase">
        <div class="showcase-header">
            <div class="showcase-titles">
                <span class="showcase-badge">VITRINE DIGITAL</span>
                <h2 class="showcase-main-title">Livraria & Formação Profissional</h2>
                <p class="showcase-sub">Manuais práticos, e-books e workshops exclusivos para potencializar suas vendas e sua visão de mercado.</p>
            </div>
            <a href="<?php echo home_url('/livraria/'); ?>" class="btn-view-all-livraria">
                Ver todos os 54 títulos <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="showcase-grid">
            <?php foreach ($livraria_items as $b): ?>
                <div class="showcase-book-card">
                    <a href="<?php echo home_url('/livraria/'); ?>" class="book-link">
                        <div class="book-img-box">
                            <img src="<?php echo esc_url($b['image']); ?>" alt="<?php echo esc_attr($b['name']); ?>" loading="lazy">
                            <?php if ($b['is_free']): ?>
                                <span class="badge-free-mini">GRATUITO</span>
                            <?php endif; ?>
                        </div>
                        <div class="book-mini-info">
                            <h4 class="book-mini-title"><?php echo esc_html($b['name']); ?></h4>
                            <div class="book-mini-bottom">
                                <span class="book-mini-price"><?php echo esc_html($b['price_formatted']); ?></span>
                                <span class="book-btn-mini">Detalhes</span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- 3 Curated Thematic Editorial Columns -->
    <section class="me-thematic-columns">
        <!-- Col 1: Negócios -->
        <div class="editorial-col">
            <div class="col-head">
                <h3 class="col-title"><span class="col-dot dot-negocios"></span> Negócios & SexShop</h3>
                <a href="<?php echo home_url('/categoria/negocios/'); ?>" class="col-more">Mais →</a>
            </div>
            <div class="col-cards">
                <?php foreach ($negocios_posts as $np): 
                    $np_thumb = get_the_post_thumbnail_url($np->ID, 'medium') ?: '';
                ?>
                    <article class="col-card">
                        <a href="<?php echo get_permalink($np->ID); ?>" class="col-card-link">
                            <?php if ($np_thumb): ?>
                                <img src="<?php echo esc_url($np_thumb); ?>" alt="<?php echo esc_attr($np->post_title); ?>" class="col-thumb" loading="lazy">
                            <?php endif; ?>
                            <div class="col-card-info">
                                <h4 class="col-card-title"><?php echo esc_html($np->post_title); ?></h4>
                                <span class="col-card-date"><?php echo get_the_date('d/m/Y', $np->ID); ?></span>
                            </div>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Col 2: Sexologia & Bem-Estar -->
        <div class="editorial-col">
            <div class="col-head">
                <h3 class="col-title"><span class="col-dot dot-sexologia"></span> Sexologia & Saúde</h3>
                <a href="<?php echo home_url('/categoria/sexologia/'); ?>" class="col-more">Mais →</a>
            </div>
            <div class="col-cards">
                <?php foreach ($sexologia_posts as $xp): 
                    $xp_thumb = get_the_post_thumbnail_url($xp->ID, 'medium') ?: '';
                ?>
                    <article class="col-card">
                        <a href="<?php echo get_permalink($xp->ID); ?>" class="col-card-link">
                            <?php if ($xp_thumb): ?>
                                <img src="<?php echo esc_url($xp_thumb); ?>" alt="<?php echo esc_attr($xp->post_title); ?>" class="col-thumb" loading="lazy">
                            <?php endif; ?>
                            <div class="col-card-info">
                                <h4 class="col-card-title"><?php echo esc_html($xp->post_title); ?></h4>
                                <span class="col-card-date"><?php echo get_the_date('d/m/Y', $xp->ID); ?></span>
                            </div>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Col 3: Eventos & Feiras -->
        <div class="editorial-col">
            <div class="col-head">
                <h3 class="col-title"><span class="col-dot dot-eventos"></span> Eventos & Mercado</h3>
                <a href="<?php echo home_url('/categoria/eventos/'); ?>" class="col-more">Mais →</a>
            </div>
            <div class="col-cards">
                <?php foreach ($eventos_posts as $ep): 
                    $ep_thumb = get_the_post_thumbnail_url($ep->ID, 'medium') ?: '';
                ?>
                    <article class="col-card">
                        <a href="<?php echo get_permalink($ep->ID); ?>" class="col-card-link">
                            <?php if ($ep_thumb): ?>
                                <img src="<?php echo esc_url($ep_thumb); ?>" alt="<?php echo esc_attr($ep->post_title); ?>" class="col-thumb" loading="lazy">
                            <?php endif; ?>
                            <div class="col-card-info">
                                <h4 class="col-card-title"><?php echo esc_html($ep->post_title); ?></h4>
                                <span class="col-card-date"><?php echo get_the_date('d/m/Y', $ep->ID); ?></span>
                            </div>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Acervo Histórico Luxury Callout -->
    <section class="me-acervo-callout">
        <div class="acervo-callout-inner">
            <div class="acervo-callout-left">
                <span class="callout-tag">★ MEMÓRIA DO MERCADO ERÓTICO</span>
                <h2 class="callout-title">Pesquise em Mais de 2.115 Reportagens e Análises Históricas</h2>
                <p class="callout-desc">Uma cobertura contínua e aprofundada desde 2018: dados de censos, lançamentos, regulação, bastidores e entrevistas com os principais nomes do setor.</p>
            </div>
            <div class="acervo-callout-right">
                <a href="<?php echo home_url('/acervo/'); ?>" class="btn-acervo-cta">
                    <i class="fas fa-search"></i> Acessar Acervo Histórico
                </a>
            </div>
        </div>
    </section>

    <!-- Recent News Grid Feed -->
    <section class="me-feed-section">
        <div class="feed-header">
            <h2 class="feed-title">Mais Reportagens & Artigos Recentes</h2>
            <div class="feed-line"></div>
        </div>

        <div class="feed-grid">
            <?php foreach ($feed_posts as $post): 
                $thumb = get_the_post_thumbnail_url($post->ID, 'medium_large') ?: 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=600';
                $cats = wp_get_post_categories($post->ID, array('fields' => 'names'));
                $cat = !empty($cats) ? $cats[0] : 'Geral';
            ?>
                <article class="feed-card">
                    <a href="<?php echo get_permalink($post->ID); ?>" class="feed-card-link">
                        <div class="feed-thumb-box">
                            <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($post->post_title); ?>" loading="lazy">
                            <span class="feed-cat-badge"><?php echo esc_html($cat); ?></span>
                        </div>
                        <div class="feed-card-body">
                            <h3 class="feed-card-title"><?php echo esc_html($post->post_title); ?></h3>
                            <p class="feed-excerpt"><?php echo wp_trim_words($post->post_content, 18, '...'); ?></p>
                            <div class="feed-card-footer">
                                <span><i class="far fa-calendar-alt"></i> <?php echo get_the_date('d/m/Y', $post->ID); ?></span>
                                <span class="read-more-text">Ler Matéria →</span>
                            </div>
                        </div>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
</div>

<style>
/* MODERN MAGAZINE EDITORIAL STYLES */
.me-home-wrapper {
    max-width: 1320px;
    margin: 0 auto;
    padding: 25px 20px 80px;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    color: #1a1a1a;
}

/* Trending Ticker */
.me-trending-bar {
    display: flex;
    align-items: center;
    background: #fdf2f4;
    border-left: 4px solid #e31c61;
    border-radius: 8px;
    padding: 10px 16px;
    margin-bottom: 25px;
    overflow: hidden;
}
.trending-badge {
    background: #e31c61;
    color: #fff;
    font-size: 0.72rem;
    font-weight: 800;
    letter-spacing: 1px;
    padding: 4px 10px;
    border-radius: 4px;
    white-space: nowrap;
    margin-right: 15px;
}
.trending-ticker {
    display: flex;
    gap: 20px;
    white-space: nowrap;
    overflow-x: auto;
    font-size: 0.9rem;
}
.ticker-item {
    color: #333;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.2s;
}
.ticker-item:hover {
    color: #e31c61;
}
.ticker-item span {
    color: #e31c61;
    margin-right: 5px;
}

/* Bento Hero Grid */
.me-bento-hero {
    display: grid;
    grid-template-columns: 1.35fr 1fr;
    gap: 24px;
    margin-bottom: 50px;
}
@media (max-width: 991px) {
    .me-bento-hero {
        grid-template-columns: 1fr;
    }
}
.bento-main-card {
    position: relative;
    border-radius: 18px;
    overflow: hidden;
    min-height: 480px;
    display: flex;
    box-shadow: 0 10px 30px rgba(0,0,0,0.12);
}
.bento-card-link {
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    width: 100%;
    position: relative;
    text-decoration: none;
    padding: 40px;
}
.bento-bg {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background-size: cover;
    background-position: center;
    transition: transform 0.4s ease;
}
.bento-main-card:hover .bento-bg {
    transform: scale(1.03);
}
.bento-gradient {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(180deg, rgba(10,5,15,0.1) 0%, rgba(10,5,15,0.7) 50%, rgba(10,5,15,0.95) 100%);
}
.bento-content {
    position: relative;
    z-index: 2;
    color: #fff;
}
.bento-cat-tag {
    display: inline-block;
    background: #e31c61;
    color: #fff;
    font-size: 0.75rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 5px 12px;
    border-radius: 4px;
    margin-bottom: 15px;
}
.bento-main-title {
    font-size: 2.1rem;
    font-weight: 900;
    line-height: 1.25;
    color: #fff;
    margin: 0 0 15px;
    letter-spacing: -0.5px;
}
.bento-excerpt {
    font-size: 1.05rem;
    color: #e1d8e3;
    line-height: 1.5;
    margin: 0 0 20px;
    max-width: 650px;
}
.bento-meta {
    font-size: 0.85rem;
    color: #c4b5c7;
    display: flex;
    gap: 12px;
    align-items: center;
}

.bento-side-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 14px;
}
.bento-side-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #ebebeb;
    box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.bento-side-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    border-color: #ddd;
}
.side-card-link {
    display: grid;
    grid-template-columns: 130px 1fr;
    text-decoration: none;
    color: inherit;
    height: 100%;
}
.side-thumb-wrap {
    overflow: hidden;
    height: 100%;
}
.side-thumb-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}
.bento-side-card:hover .side-thumb-wrap img {
    transform: scale(1.05);
}
.side-content {
    padding: 14px 18px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.side-cat {
    font-size: 0.7rem;
    font-weight: 800;
    color: #e31c61;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 5px;
}
.side-title {
    font-size: 0.98rem;
    font-weight: 700;
    line-height: 1.35;
    color: #1a1a1a;
    margin: 0 0 8px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.side-date {
    font-size: 0.78rem;
    color: #888;
}

/* Livraria Showcase Section */
.me-livraria-showcase {
    background: radial-gradient(circle at 70% 30%, #1e1022 0%, #0d0612 100%);
    border-radius: 20px;
    padding: 40px;
    color: #fff;
    margin-bottom: 50px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    border: 1px solid rgba(227, 28, 97, 0.25);
}
.showcase-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 20px;
}
.showcase-badge {
    display: inline-block;
    background: #e31c61;
    color: #fff;
    font-size: 0.72rem;
    font-weight: 800;
    letter-spacing: 1px;
    padding: 4px 12px;
    border-radius: 4px;
    margin-bottom: 10px;
}
.showcase-main-title {
    font-size: 1.9rem;
    font-weight: 900;
    color: #fff;
    margin: 0 0 8px;
}
.showcase-sub {
    font-size: 1rem;
    color: #c9bed0;
    margin: 0;
    max-width: 650px;
}
.btn-view-all-livraria {
    background: rgba(255,255,255,0.12);
    color: #fff;
    border: 1px solid rgba(255,255,255,0.25);
    padding: 10px 22px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    white-space: nowrap;
}
.btn-view-all-livraria:hover {
    background: #e31c61;
    border-color: #e31c61;
    color: #fff;
}
.showcase-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 20px;
}
.showcase-book-card {
    background: rgba(255,255,255,0.05);
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.1);
    overflow: hidden;
    transition: transform 0.2s ease, border-color 0.2s;
}
.showcase-book-card:hover {
    transform: translateY(-5px);
    border-color: #e31c61;
}
.book-link {
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    height: 100%;
}
.book-img-box {
    position: relative;
    padding: 20px;
    height: 200px;
    display: flex;
    justify-content: center;
    align-items: center;
    background: rgba(0,0,0,0.2);
}
.book-img-box img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
    border-radius: 4px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.3);
}
.badge-free-mini {
    position: absolute;
    top: 10px;
    left: 10px;
    background: #10b981;
    color: #fff;
    font-size: 0.65rem;
    font-weight: 800;
    padding: 2px 8px;
    border-radius: 10px;
}
.book-mini-info {
    padding: 16px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}
.book-mini-title {
    font-size: 0.95rem;
    font-weight: 800;
    color: #fff;
    margin: 0 0 12px;
    line-height: 1.35;
    flex-grow: 1;
}
.book-mini-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid rgba(255,255,255,0.1);
    padding-top: 10px;
}
.book-mini-price {
    font-size: 1.1rem;
    font-weight: 900;
    color: #10b981;
}
.book-btn-mini {
    font-size: 0.8rem;
    font-weight: 700;
    color: #e31c61;
}

/* 3 Curated Columns */
.me-thematic-columns {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    margin-bottom: 55px;
}
@media (max-width: 900px) {
    .me-thematic-columns {
        grid-template-columns: 1fr;
    }
}
.editorial-col {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #eaeaea;
    padding: 24px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
}
.col-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 12px;
    margin-bottom: 18px;
}
.col-title {
    font-size: 1.1rem;
    font-weight: 800;
    color: #111;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.col-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    display: inline-block;
}
.dot-negocios { background: #3b82f6; }
.dot-sexologia { background: #ec4899; }
.dot-eventos { background: #f59e0b; }
.col-more {
    font-size: 0.82rem;
    font-weight: 700;
    color: #888;
    text-decoration: none;
}
.col-more:hover { color: #e31c61; }
.col-cards {
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.col-card-link {
    display: grid;
    grid-template-columns: 85px 1fr;
    gap: 14px;
    text-decoration: none;
    color: inherit;
    align-items: center;
}
.col-thumb {
    width: 85px;
    height: 65px;
    object-fit: cover;
    border-radius: 6px;
}
.col-card-title {
    font-size: 0.88rem;
    font-weight: 700;
    line-height: 1.35;
    color: #222;
    margin: 0 0 5px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.col-card-link:hover .col-card-title {
    color: #e31c61;
}
.col-card-date {
    font-size: 0.75rem;
    color: #999;
}

/* Acervo Luxury Callout */
.me-acervo-callout {
    background: linear-gradient(135deg, #110d18 0%, #1e1329 100%);
    border-radius: 18px;
    padding: 40px;
    color: #fff;
    margin-bottom: 55px;
    border: 1px solid rgba(255,255,255,0.12);
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
}
.acervo-callout-inner {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 30px;
    flex-wrap: wrap;
}
.callout-tag {
    display: inline-block;
    color: #e31c61;
    font-size: 0.78rem;
    font-weight: 800;
    letter-spacing: 1.2px;
    margin-bottom: 12px;
}
.callout-title {
    font-size: 1.85rem;
    font-weight: 900;
    color: #fff;
    margin: 0 0 10px;
    line-height: 1.3;
}
.callout-desc {
    font-size: 1rem;
    color: #c9bed2;
    margin: 0;
    max-width: 680px;
    line-height: 1.6;
}
.btn-acervo-cta {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: #e31c61;
    color: #fff;
    font-size: 1.05rem;
    font-weight: 800;
    padding: 14px 28px;
    border-radius: 40px;
    text-decoration: none;
    box-shadow: 0 6px 20px rgba(227, 28, 97, 0.4);
    transition: all 0.2s ease;
    white-space: nowrap;
}
.btn-acervo-cta:hover {
    background: #c71452;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(227, 28, 97, 0.5);
}

/* Recent Feed Section */
.me-feed-section {
    margin-bottom: 50px;
}
.feed-header {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 30px;
}
.feed-title {
    font-size: 1.7rem;
    font-weight: 900;
    color: #111;
    margin: 0;
    white-space: nowrap;
}
.feed-line {
    flex-grow: 1;
    height: 2px;
    background: #eee;
}
.feed-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 30px;
}
.feed-card {
    background: #fff;
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid #eaeaea;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    display: flex;
    flex-direction: column;
}
.feed-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.1);
    border-color: #ddd;
}
.feed-card-link {
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    height: 100%;
}
.feed-thumb-box {
    position: relative;
    height: 210px;
    overflow: hidden;
}
.feed-thumb-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}
.feed-card:hover .feed-thumb-box img {
    transform: scale(1.05);
}
.feed-cat-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: rgba(13, 6, 18, 0.85);
    backdrop-filter: blur(4px);
    color: #fff;
    font-size: 0.72rem;
    font-weight: 800;
    padding: 4px 10px;
    border-radius: 4px;
    text-transform: uppercase;
}
.feed-card-body {
    padding: 22px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}
.feed-card-title {
    font-size: 1.15rem;
    font-weight: 800;
    color: #1a1a1a;
    margin: 0 0 10px;
    line-height: 1.35;
    transition: color 0.2s;
}
.feed-card-link:hover .feed-card-title {
    color: #e31c61;
}
.feed-excerpt {
    font-size: 0.9rem;
    color: #666;
    line-height: 1.55;
    margin: 0 0 18px;
    flex-grow: 1;
}
.feed-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid #f0f0f0;
    padding-top: 14px;
    font-size: 0.82rem;
    color: #888;
}
.read-more-text {
    font-weight: 700;
    color: #e31c61;
}
</style>

<?php get_footer(); ?>
