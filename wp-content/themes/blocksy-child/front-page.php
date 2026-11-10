<?php
/**
 * Front Page Template - Portal Mercado Erótico (Modern Bento Grid with Dynamic Hero Slide)
 */

get_header();

// 0. Total Published Posts Count (Dynamic)
$count_posts = wp_count_posts('post');
$total_published_count = !empty($count_posts->publish) ? number_format($count_posts->publish, 0, ',', '.') : '2.115';

// 1. Featured Posts for Bento Hero
// Top 4 stories rotate inside the Main Bento Slide
$main_slides = get_posts(array(
    'numberposts' => 4,
    'post_status' => 'publish'
));

// 4 Secondary stories on the right side of Bento Grid
$side_posts = get_posts(array(
    'numberposts' => 4,
    'offset' => 4,
    'post_status' => 'publish'
));

// 2. Curated Categories for Eixos
$negocios_posts = get_posts(array('category_name' => 'negocios', 'numberposts' => 3, 'post_status' => 'publish'));
$sexologia_posts = get_posts(array('category_name' => 'sexologia', 'numberposts' => 3, 'post_status' => 'publish'));
$eventos_posts = get_posts(array('category_name' => 'eventos', 'numberposts' => 3, 'post_status' => 'publish'));

// 3. Livraria Featured Items
$livraria_items = array();
$livraria_file = WP_CONTENT_DIR . '/uploads/livraria/livraria_clean.json';
if (file_exists($livraria_file)) {
    $all_books = json_decode(file_get_contents($livraria_file), true) ?: array();
    $livraria_items = array_slice($all_books, 0, 4);
}

// 4. Recent Feed Posts (offset 8)
$feed_posts = get_posts(array(
    'numberposts' => 9,
    'offset' => 8,
    'post_status' => 'publish'
));

// 5. Query All-Time Most Read Posts (Before Footer)
global $wpdb;
$most_read_sql = "
    SELECT p.ID, p.post_title, p.post_date,
           GREATEST(
               COALESCE(CAST(pm1.meta_value AS UNSIGNED), 0),
               COALESCE(CAST(pm2.meta_value AS UNSIGNED), 0)
           ) as total_views
    FROM {$wpdb->posts} p
    LEFT JOIN {$wpdb->postmeta} pm1 ON (p.ID = pm1.post_id AND pm1.meta_key = 'tie_views')
    LEFT JOIN {$wpdb->postmeta} pm2 ON (p.ID = pm2.post_id AND pm2.meta_key = 'newscrunch_views')
    WHERE p.post_type = 'post' AND p.post_status = 'publish'
    GROUP BY p.ID
    HAVING total_views > 0
    ORDER BY total_views DESC
    LIMIT 6
";
$most_read_posts = $wpdb->get_results($most_read_sql);
?>

<div class="me-home-wrapper">
        <!-- ESPAÇO DE PUBLICIDADE - BANNER PADRÃO ROTATIVO (PADRÃO IAB) -->
    <div class="me-ad-standard-container" id="meStandardAdContainer">
        <div class="ad-standard-header">
            <span class="ad-standard-badge"><i class="fas fa-bullhorn"></i> PUBLICIDADE</span>
            <a href="<?php echo home_url('/contato/'); ?>" class="ad-standard-mediakit">Anuncie no Portal <i class="fas fa-angle-right"></i></a>
        </div>
        <div class="ad-standard-track">
            <!-- Banner Destaque 1: Anuário Grandes Marcas 2026 -->
            <div class="ad-standard-slide active">
                <a href="<?php echo home_url('/anuario-grandes-marcas-do-mercado-erotico-2026/'); ?>" title="Anuário Grandes Marcas do Mercado Erótico - Baixe Grátis">
                    <img src="https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2026/11/banner_anuario_home_clean.png" alt="Anuário Grandes Marcas do Mercado Erótico - 4ª Edição" class="ad-img-standard" width="1200" height="300">
                </a>
            </div>

            <!-- Banner Padrão 2: Sex Shop Atacadão -->
            <div class="ad-standard-slide">
                <a href="https://www.sexshopatacadao.com.br/" target="_blank" rel="noopener sponsored" title="Sex Shop Atacadão - Distribuidor">
                    <img src="https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2022/06/Anuncio-Banner-30.06-VO.png" alt="Sex Shop Atacadão" class="ad-img-standard">
                </a>
            </div>

            <!-- Banner Padrão 3: Apimentou Marketplace -->
            <div class="ad-standard-slide">
                <a href="https://www.apimentou.com.br/" target="_blank" rel="noopener sponsored" title="Apimentou Marketplace - Venda para todo o Brasil">
                    <img src="https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2022/08/BANNER-LOJISTA-APIMENTOU.png" alt="Apimentou Marketplace" class="ad-img-standard">
                </a>
            </div>

            <!-- Banner Padrão 4: Garota Veneno Lingerie -->
            <div class="ad-standard-slide">
                <a href="https://garotaveneno.com.br/" target="_blank" rel="noopener sponsored" title="Garota Veneno - Lingerie de Luxo">
                    <img src="https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2022/09/Banner-Mercado-Erotico.jpg" alt="Garota Veneno Lingerie" class="ad-img-standard">
                </a>
            </div>

            <!-- Banner Padrão 5: Adão & Eva Toys -->
            <div class="ad-standard-slide">
                <a href="<?php echo home_url('/categoria/negocios/'); ?>" target="_blank" rel="noopener sponsored" title="Adão e Eva Toys">
                    <img src="https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2022/06/banner.jpg" alt="Adão e Eva Toys" class="ad-img-standard">
                </a>
            </div>
        </div>

        <!-- Indicadores / Dots -->
        <div class="ad-standard-dots" id="adStandardDots">
            <button class="ad-dot active" onclick="goToAdBanner(0)" aria-label="Banner 1: Anuário Grandes Marcas"></button>
            <button class="ad-dot" onclick="goToAdBanner(1)" aria-label="Banner 2: Sex Shop Atacadão"></button>
            <button class="ad-dot" onclick="goToAdBanner(2)" aria-label="Banner 3: Apimentou Marketplace"></button>
            <button class="ad-dot" onclick="goToAdBanner(3)" aria-label="Banner 4: Garota Veneno Lingerie"></button>
            <button class="ad-dot" onclick="goToAdBanner(4)" aria-label="Banner 5: Adão e Eva Toys"></button>
        </div>
    </div>

    <!-- BLOCO 1: BENTO GRID HERO (COM SLIDE DINÂMICO NA IMAGEM PRINCIPAL) -->
    <section class="me-bento-hero">
        <!-- Main Card: Slideshow Dinâmico das 4 Matérias de Capa -->
        <div class="bento-main-slider" id="bentoSlider">
            <div class="bento-slides-track">
                <?php foreach ($main_slides as $idx => $slide): 
                    $thumb = get_the_post_thumbnail_url($slide->ID, 'full') ?: 'https://images.unsplash.com/photo-1518895949257-7621c3c786d7?w=1200';
                    $cats = wp_get_post_categories($slide->ID, array('fields' => 'names'));
                    $cat = !empty($cats) ? $cats[0] : 'Destaque';
                    $author_name = get_the_author_meta('display_name', $slide->post_author);
                ?>
                    <article class="bento-slide-item <?php echo $idx === 0 ? 'active' : ''; ?>">
                        <a href="<?php echo get_permalink($slide->ID); ?>" class="bento-card-link">
                            <div class="bento-bg" style="background-image: url('<?php echo esc_url($thumb); ?>');"></div>
                            <div class="bento-gradient"></div>
                            <div class="bento-content">
                                <span class="bento-cat-tag"><?php echo esc_html($cat); ?></span>
                                <h1 class="bento-main-title"><?php echo esc_html($slide->post_title); ?></h1>
                                <p class="bento-excerpt"><?php echo wp_trim_words($slide->post_content, 22, '...'); ?></p>
                                <div class="bento-meta">
                                    <span><i class="far fa-calendar-alt"></i> <?php echo get_the_date('d/m/Y', $slide->ID); ?></span>
                                    <span>•</span>
                                    <span><i class="far fa-user"></i> <?php echo esc_html($author_name); ?></span>
                                </div>
                            </div>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>

            <!-- Bento Slider Navigation Dots -->
            <div class="bento-dots" id="bentoDots">
                <?php for ($i = 0; $i < count($main_slides); $i++): ?>
                    <button class="bdot <?php echo $i === 0 ? 'active' : ''; ?>" onclick="goToBentoSlide(<?php echo $i; ?>)" aria-label="Slide <?php echo $i + 1; ?>"></button>
                <?php endfor; ?>
            </div>
        </div>

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

    <!-- BLOCO 2: ACERVO HISTÓRICO -->
    <section class="me-acervo-callout">
        <div class="acervo-callout-inner">
            <div class="acervo-callout-left">
                <span class="callout-tag">★ MEMÓRIA & DOCUMENTAÇÃO DO MERCADO ÍNTIMO</span>
                <h2 class="callout-title">Pesquise em Mais de <?php echo esc_html($total_published_count); ?> Reportagens e Análises Históricas</h2>
                <p class="callout-desc">O mais completo arquivo jornalístico, analítico e regulatório do mercado erótico e bem-estar sexual no Brasil, com <?php echo esc_html($total_published_count); ?> matérias documentadas continuamente desde 2018. Explore por temas, marcas, produtos e censos.</p>
                <div class="callout-pills">
                    <span class="pill-mini">🏢 Negócios & Mercado</span>
                    <span class="pill-mini">📊 Pesquisas & Censos</span>
                    <span class="pill-mini">🔬 Sexologia & Saúde</span>
                    <span class="pill-mini">🎟️ Eventos & Feiras</span>
                </div>
            </div>
            <div class="acervo-callout-right">
                <a href="<?php echo home_url('/acervo/'); ?>" class="btn-acervo-cta">
                    <i class="fas fa-search"></i> Acessar Acervo Histórico
                </a>
            </div>
        </div>
    </section>

    <!-- BLOCO 3: 3 COLUNAS TEMÁTICAS CURADAS -->
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

    <!-- RADAR ECONÔMICO: LINHA DE CHAMADA COMPACTA -->
    <?php echo do_shortcode('[mercado_radar_home_callout]'); ?>

    <!-- BLOCO 4: VITRINE DIGITAL DA LIVRARIA -->
    <section class="me-livraria-showcase">
        <div class="showcase-header">
            <div class="showcase-titles">
                <span class="showcase-badge">VITRINE DIGITAL</span>
                <h2 class="showcase-main-title">Livraria & Formação Profissional</h2>
                <p class="showcase-sub">E-books, manuais técnicos e treinamentos exclusivos para potencializar suas vendas e profissionalizar sua atuação no mercado íntimo.</p>
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

    <!-- BLOCO 5: FEED RECENTE DE REPORTAGENS -->
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

    <!-- BLOCO 6: 🔥 OS MAIS LIDOS DE TODOS OS TEMPOS (ANTES DO RODAPÉ) -->
    <section class="me-most-read-section">
        <div class="most-read-header">
            <div>
                <span class="most-read-badge"><i class="fas fa-fire"></i> RECORDES DE AUDIÊNCIA</span>
                <h2 class="most-read-title">Os Artigos Mais Lidos de Todos os Tempos</h2>
                <p class="most-read-sub">As reportagens, guias práticos e conteúdos que mais marcaram época e geraram impacto na história do portal.</p>
            </div>
            <div class="most-read-line"></div>
        </div>

        <div class="most-read-grid">
            <?php foreach ($most_read_posts as $idx => $mr): 
                $mr_thumb = get_the_post_thumbnail_url($mr->ID, 'medium_large') ?: 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=600';
                $mr_cats = wp_get_post_categories($mr->ID, array('fields' => 'names'));
                $mr_cat = !empty($mr_cats) ? $mr_cats[0] : 'Destaque';
                $views_fmt = $mr->total_views >= 1000 ? round($mr->total_views / 1000, 1) . 'k' : number_format($mr->total_views, 0, ',', '.');
                $rank_str = str_pad($idx + 1, 2, '0', STR_PAD_LEFT);
            ?>
                <article class="most-read-card">
                    <a href="<?php echo get_permalink($mr->ID); ?>" class="most-read-link">
                        <div class="rank-number"><?php echo $rank_str; ?></div>
                        <div class="most-read-thumb-wrap">
                            <img src="<?php echo esc_url($mr_thumb); ?>" alt="<?php echo esc_attr($mr->post_title); ?>" loading="lazy">
                        </div>
                        <div class="most-read-content">
                            <div class="most-read-meta-top">
                                <span class="most-read-cat"><?php echo esc_html($mr_cat); ?></span>
                                <span class="most-read-views"><i class="fas fa-eye"></i> <?php echo esc_html($views_fmt); ?> leituras</span>
                            </div>
                            <h3 class="most-read-card-title"><?php echo esc_html($mr->post_title); ?></h3>
                            <span class="most-read-date"><i class="far fa-calendar-alt"></i> Publicado em <?php echo get_the_date('M/Y', $mr->ID); ?></span>
                        </div>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
</div>



<script>
// SLIDER DINÂMICO NO CARD PRINCIPAL DO BENTO GRID
let bentoSlideIdx = 0;
const bentoSlides = document.querySelectorAll('.bento-slide-item');
const bentoDots = document.querySelectorAll('#bentoDots .bdot');
const totalBentoSlides = bentoSlides.length;
let bentoInterval = null;
const BENTO_DURATION = 6000; // 6 segundos

function showBentoSlide(idx) {
    if (idx >= totalBentoSlides) bentoSlideIdx = 0;
    else if (idx < 0) bentoSlideIdx = totalBentoSlides - 1;
    else bentoSlideIdx = idx;

    bentoSlides.forEach((slide, i) => {
        if (i === bentoSlideIdx) slide.classList.add('active');
        else slide.classList.remove('active');
    });

    bentoDots.forEach((dot, i) => {
        if (i === bentoSlideIdx) dot.classList.add('active');
        else dot.classList.remove('active');
    });
}

function goToBentoSlide(idx) {
    clearInterval(bentoInterval);
    showBentoSlide(idx);
    startBentoTimer();
}

function startBentoTimer() {
    bentoInterval = setInterval(() => {
        showBentoSlide(bentoSlideIdx + 1);
    }, BENTO_DURATION);
}

const bentoSliderElem = document.getElementById('bentoSlider');
if (bentoSliderElem) {
    bentoSliderElem.addEventListener('mouseenter', () => clearInterval(bentoInterval));
    bentoSliderElem.addEventListener('mouseleave', () => startBentoTimer());
}

startBentoTimer();

// BANNER PADRÃO ROTATIVO (PADRÃO IAB)
let curAdIdx = 0;
const adSlides = document.querySelectorAll('.ad-standard-slide');
const adDots = document.querySelectorAll('#adStandardDots .ad-dot');
const totalAds = adSlides.length;
let adInterval = null;

function showAdBanner(idx) {
    if (totalAds === 0) return;
    if (idx >= totalAds) curAdIdx = 0;
    else if (idx < 0) curAdIdx = totalAds - 1;
    else curAdIdx = idx;

    adSlides.forEach((s, i) => {
        if (i === curAdIdx) s.classList.add('active');
        else s.classList.remove('active');
    });

    adDots.forEach((d, i) => {
        if (i === curAdIdx) d.classList.add('active');
        else d.classList.remove('active');
    });
}

function goToAdBanner(idx) {
    clearInterval(adInterval);
    showAdBanner(idx);
    startAdTimer();
}

function startAdTimer() {
    adInterval = setInterval(() => {
        showAdBanner(curAdIdx + 1);
    }, 6000);
}

const adContainerElem = document.getElementById('meStandardAdContainer');
if (adContainerElem) {
    adContainerElem.addEventListener('mouseenter', () => clearInterval(adInterval));
    adContainerElem.addEventListener('mouseleave', () => startAdTimer());
}

if (totalAds > 1) {
    startAdTimer();
}
</script>

<style>
/* CSS COMPLETO E ROBUSTO DA HOME */
.me-home-wrapper {
    max-width: 1320px;
    margin: 0 auto;
    padding: 20px 20px 60px;
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
    scrollbar-width: none;
}
.trending-ticker::-webkit-scrollbar { display: none; }
.ticker-item {
    color: #333;
    text-decoration: none;
    font-weight: 600;
}
.ticker-item:hover { color: #e31c61; }
.ticker-item span { color: #e31c61; margin-right: 5px; }

/* BENTO HERO GRID COM SLIDE DINÂMICO */
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
.bento-main-slider {
    position: relative;
    border-radius: 18px;
    overflow: hidden;
    min-height: 480px;
    background: #111;
    box-shadow: 0 10px 30px rgba(0,0,0,0.12);
}
@media (max-width: 768px) {
    .bento-main-slider {
        min-height: 400px;
    }
}
.bento-slides-track {
    position: relative;
    width: 100%;
    height: 100%;
    min-height: 480px;
}
.bento-slide-item {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.8s;
    display: flex;
}
.bento-slide-item.active {
    opacity: 1;
    visibility: visible;
    z-index: 2;
}
.bento-card-link {
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    width: 100%;
    position: relative;
    text-decoration: none;
    padding: 35px;
}
@media (max-width: 768px) {
    .bento-card-link { padding: 25px 20px; }
}
.bento-bg {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background-size: cover;
    background-position: center;
    transition: transform 6s ease;
}
.bento-slide-item.active .bento-bg {
    transform: scale(1.04);
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
    margin-bottom: 12px;
}
.bento-main-title {
    font-size: 2rem;
    font-weight: 900;
    line-height: 1.25;
    color: #fff;
    margin: 0 0 12px;
    letter-spacing: -0.5px;
}
@media (max-width: 768px) {
    .bento-main-title { font-size: 1.45rem; }
}
.bento-excerpt {
    font-size: 1rem;
    color: #e1d8e3;
    line-height: 1.5;
    margin: 0 0 16px;
    max-width: 650px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
@media (max-width: 768px) {
    .bento-excerpt { display: none; }
}
.bento-meta {
    font-size: 0.85rem;
    color: #c4b5c7;
    display: flex;
    gap: 12px;
    align-items: center;
}
.bento-dots {
    position: absolute;
    bottom: 20px;
    right: 25px;
    z-index: 10;
    display: flex;
    gap: 6px;
}
.bdot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: rgba(255,255,255,0.4);
    border: none;
    cursor: pointer;
    transition: all 0.25s;
}
.bdot.active {
    width: 22px;
    border-radius: 6px;
    background: #e31c61;
}

/* Side 4 Cards */
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
@media (max-width: 480px) {
    .side-card-link { grid-template-columns: 100px 1fr; }
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
    font-size: 0.95rem;
    font-weight: 700;
    line-height: 1.35;
    color: #1a1a1a;
    margin: 0 0 6px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.side-date {
    font-size: 0.75rem;
    color: #888;
}

/* BLOCO 2: ACERVO CALLOUT */
.me-acervo-callout {
    background: linear-gradient(135deg, #110d18 0%, #1e1329 100%);
    border-radius: 18px;
    padding: 40px;
    color: #fff;
    margin-bottom: 50px;
    border: 1px solid rgba(227, 28, 97, 0.3);
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
}
@media (max-width: 768px) {
    .me-acervo-callout {
        padding: 25px 20px;
        border-radius: 14px;
    }
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
@media (max-width: 768px) {
    .callout-title { font-size: 1.35rem; }
}
.callout-desc {
    font-size: 0.98rem;
    color: #c9bed2;
    margin: 0 0 16px;
    max-width: 680px;
    line-height: 1.6;
}
.callout-pills {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}
.pill-mini {
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.15);
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    color: #d1c8d4;
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

/* BLOCO 3: 3 COLUNAS TEMÁTICAS */
.me-thematic-columns {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
    margin-bottom: 50px;
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
    padding: 22px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
}
.col-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 12px;
    margin-bottom: 16px;
}
.col-title {
    font-size: 1.05rem;
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
.col-more { font-size: 0.82rem; font-weight: 700; color: #888; text-decoration: none; }
.col-more:hover { color: #e31c61; }
.col-cards { display: flex; flex-direction: column; gap: 14px; }
.col-card-link {
    display: grid;
    grid-template-columns: 80px 1fr;
    gap: 12px;
    text-decoration: none;
    color: inherit;
    align-items: center;
}
.col-thumb {
    width: 80px;
    height: 62px;
    object-fit: cover;
    border-radius: 6px;
}
.col-card-title {
    font-size: 0.88rem;
    font-weight: 700;
    line-height: 1.35;
    color: #222;
    margin: 0 0 4px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.col-card-link:hover .col-card-title { color: #e31c61; }
.col-card-date { font-size: 0.75rem; color: #999; }

/* BLOCO 4: LIVRARIA VITRINE */
.me-livraria-showcase {
    background: radial-gradient(circle at 70% 30%, #1e1022 0%, #0d0612 100%);
    border-radius: 20px;
    padding: 40px;
    color: #fff;
    margin-bottom: 50px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    border: 1px solid rgba(227, 28, 97, 0.25);
}
@media (max-width: 768px) {
    .me-livraria-showcase { padding: 25px 20px; border-radius: 14px; }
}
.showcase-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 25px;
    flex-wrap: wrap;
    gap: 15px;
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
    margin-bottom: 8px;
}
.showcase-main-title { font-size: 1.85rem; font-weight: 900; color: #fff; margin: 0 0 6px; }
@media (max-width: 768px) {
    .showcase-main-title { font-size: 1.35rem; }
}
.showcase-sub { font-size: 0.95rem; color: #c9bed0; margin: 0; max-width: 650px; }
.btn-view-all-livraria {
    background: rgba(255,255,255,0.12);
    color: #fff;
    border: 1px solid rgba(255,255,255,0.25);
    padding: 10px 20px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.88rem;
    transition: all 0.2s ease;
    white-space: nowrap;
}
.btn-view-all-livraria:hover { background: #e31c61; border-color: #e31c61; color: #fff; }
.showcase-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
    gap: 20px;
}
@media (max-width: 576px) {
    .showcase-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
}
.showcase-book-card {
    background: rgba(255,255,255,0.05);
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.1);
    overflow: hidden;
    transition: transform 0.2s ease, border-color 0.2s;
}
.showcase-book-card:hover { transform: translateY(-4px); border-color: #e31c61; }
.book-link { text-decoration: none; color: inherit; display: flex; flex-direction: column; height: 100%; }
.book-img-box {
    position: relative;
    padding: 16px;
    height: 180px;
    display: flex;
    justify-content: center;
    align-items: center;
    background: rgba(0,0,0,0.2);
}
.book-img-box img { max-height: 100%; max-width: 100%; object-fit: contain; border-radius: 4px; }
.badge-free-mini {
    position: absolute;
    top: 8px; left: 8px;
    background: #10b981;
    color: #fff;
    font-size: 0.65rem;
    font-weight: 800;
    padding: 2px 7px;
    border-radius: 10px;
}
.book-mini-info { padding: 14px; display: flex; flex-direction: column; flex-grow: 1; }
.book-mini-title {
    font-size: 0.92rem;
    font-weight: 800;
    color: #fff;
    margin: 0 0 10px;
    line-height: 1.35;
    flex-grow: 1;
}
.book-mini-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid rgba(255,255,255,0.1);
    padding-top: 8px;
}
.book-mini-price { font-size: 1.05rem; font-weight: 900; color: #10b981; }
.book-btn-mini { font-size: 0.78rem; font-weight: 700; color: #e31c61; }

/* BLOCO 5: FEED RECENTE */
.me-feed-section { margin-bottom: 50px; }
.feed-header { display: flex; align-items: center; gap: 20px; margin-bottom: 25px; }
.feed-title { font-size: 1.6rem; font-weight: 900; color: #111; margin: 0; white-space: nowrap; }
@media (max-width: 768px) {
    .feed-title { font-size: 1.25rem; }
}
.feed-line { flex-grow: 1; height: 2px; background: #eee; }
.feed-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
    gap: 25px;
}
@media (max-width: 576px) {
    .feed-grid { grid-template-columns: 1fr; }
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
.feed-card:hover { transform: translateY(-4px); box-shadow: 0 12px 25px rgba(0,0,0,0.08); border-color: #ddd; }
.feed-card-link { text-decoration: none; color: inherit; display: flex; flex-direction: column; height: 100%; }
.feed-thumb-box { position: relative; height: 200px; overflow: hidden; }
.feed-thumb-box img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease; }
.feed-card:hover .feed-thumb-box img { transform: scale(1.04); }
.feed-cat-badge {
    position: absolute;
    top: 10px; left: 10px;
    background: rgba(13, 6, 18, 0.85);
    backdrop-filter: blur(4px);
    color: #fff;
    font-size: 0.7rem;
    font-weight: 800;
    padding: 3px 8px;
    border-radius: 4px;
    text-transform: uppercase;
}
.feed-card-body { padding: 20px; display: flex; flex-direction: column; flex-grow: 1; }
.feed-card-title {
    font-size: 1.1rem;
    font-weight: 800;
    color: #1a1a1a;
    margin: 0 0 10px;
    line-height: 1.35;
    transition: color 0.2s;
}
.feed-card-link:hover .feed-card-title { color: #e31c61; }
.feed-excerpt { font-size: 0.88rem; color: #666; line-height: 1.5; margin: 0 0 15px; flex-grow: 1; }
.feed-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid #f0f0f0;
    padding-top: 12px;
    font-size: 0.8rem;
    color: #888;
}
.read-more-text { font-weight: 700; color: #e31c61; }

/* BLOCO 6: MAIS LIDOS DE TODOS OS TEMPOS (ANTES DO RODAPÉ) */
.me-most-read-section {
    background: #fbfbfd;
    border-radius: 20px;
    padding: 35px 30px;
    margin-bottom: 50px;
    border: 1px solid #ebebf0;
}
@media (max-width: 768px) {
    .me-most-read-section {
        padding: 22px 16px;
        border-radius: 14px;
    }
}
.most-read-header {
    margin-bottom: 25px;
}
.most-read-badge {
    display: inline-block;
    background: #e31c61;
    color: #fff;
    font-size: 0.72rem;
    font-weight: 800;
    letter-spacing: 1px;
    padding: 3px 10px;
    border-radius: 4px;
    margin-bottom: 8px;
}
.most-read-title {
    font-size: 1.8rem;
    font-weight: 900;
    color: #111;
    margin: 0 0 6px;
}
@media (max-width: 768px) {
    .most-read-title { font-size: 1.35rem; }
}
.most-read-sub {
    font-size: 0.95rem;
    color: #666;
    margin: 0;
}
.most-read-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}
@media (max-width: 900px) {
    .most-read-grid {
        grid-template-columns: 1fr;
    }
}
.most-read-card {
    background: #fff;
    border-radius: 12px;
    border: 1px solid #e7e7ec;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.most-read-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 22px rgba(0,0,0,0.08);
    border-color: #ddd;
}
.most-read-link {
    display: grid;
    grid-template-columns: 50px 100px 1fr;
    gap: 14px;
    text-decoration: none;
    color: inherit;
    align-items: center;
    padding: 12px 16px;
}
@media (max-width: 480px) {
    .most-read-link {
        grid-template-columns: 35px 80px 1fr;
        gap: 10px;
        padding: 10px 12px;
    }
}
.rank-number {
    font-size: 1.8rem;
    font-weight: 900;
    color: #e31c61;
    text-align: center;
    font-style: italic;
    opacity: 0.85;
}
.most-read-thumb-wrap {
    width: 100px;
    height: 75px;
    border-radius: 8px;
    overflow: hidden;
    background: #f0f0f5;
    flex-shrink: 0;
}
@media (max-width: 480px) {
    .most-read-thumb-wrap {
        width: 80px;
        height: 65px;
    }
}
.most-read-thumb-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.most-read-content {
    display: flex;
    flex-direction: column;
    overflow: hidden;
}
.most-read-meta-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 4px;
    font-size: 0.75rem;
}
.most-read-cat {
    color: #e31c61;
    font-weight: 800;
    text-transform: uppercase;
}
.most-read-views {
    color: #059669;
    font-weight: 700;
    background: #ecfdf5;
    padding: 2px 7px;
    border-radius: 12px;
    font-size: 0.72rem;
}
.most-read-card-title {
    font-size: 0.95rem;
    font-weight: 800;
    color: #1a1a1a;
    line-height: 1.35;
    margin: 0 0 5px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.most-read-card:hover .most-read-card-title {
    color: #e31c61;
}
.most-read-date {
    font-size: 0.74rem;
    color: #888;
}

/* RODAPÉ MODERNO */
.me-footer {
    background: #0d0612;
    color: #d1c7d4;
    padding: 60px 20px 25px;
    border-top: 3px solid #e31c61;
    font-size: 0.92rem;
}
.footer-inner {
    max-width: 1320px;
    margin: 0 auto;
}
.footer-grid {
    display: grid;
    grid-template-columns: 1.8fr 1fr 1.2fr 1.2fr;
    gap: 40px;
    margin-bottom: 50px;
}
@media (max-width: 991px) {
    .footer-grid {
        grid-template-columns: 1fr 1fr;
    }
}
@media (max-width: 576px) {
    .footer-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
}
.footer-logo-img {
    max-height: 55px;
    width: auto;
    margin-bottom: 18px;
    filter: brightness(0) invert(1);
}
.footer-bio {
    color: #a89ba9;
    line-height: 1.6;
    margin-bottom: 20px;
    font-size: 0.9rem;
}
.footer-social-links {
    display: flex;
    gap: 12px;
}
.social-icon {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255,255,255,0.08);
    color: #fff;
    font-size: 1.1rem;
    text-decoration: none;
    transition: all 0.25s ease;
    border: 1px solid rgba(255,255,255,0.1);
}
.social-icon:hover {
    background: #e31c61;
    color: #fff;
    transform: translateY(-3px);
    border-color: #e31c61;
}
.footer-heading {
    color: #fff;
    font-size: 1.05rem;
    font-weight: 800;
    margin: 0 0 20px;
    letter-spacing: 0.5px;
    position: relative;
    padding-bottom: 10px;
}
.footer-heading::after {
    content: "";
    position: absolute;
    bottom: 0; left: 0;
    width: 30px;
    height: 2px;
    background: #e31c61;
}
.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}
.footer-links li {
    margin-bottom: 10px;
}
.footer-links a {
    color: #a89ba9;
    text-decoration: none;
    transition: color 0.2s, padding-left 0.2s;
    display: inline-block;
}
.footer-links a:hover {
    color: #fff;
    padding-left: 5px;
}
.footer-contact-info {
    color: #a89ba9;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.footer-contact-info i {
    color: #e31c61;
}
.btn-footer-contact {
    display: inline-block;
    background: #e31c61;
    color: #fff;
    padding: 9px 20px;
    border-radius: 20px;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.85rem;
    margin-top: 10px;
    transition: background 0.2s;
}
.btn-footer-contact:hover {
    background: #b5144b;
    color: #fff;
}
.footer-bottom {
    border-top: 1px solid rgba(255,255,255,0.08);
    padding-top: 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
    font-size: 0.85rem;
    color: #7d6f7e;
}
.footer-bottom strong {
    color: #bbb;
}
.footer-madeby {
    color: #e31c61;
    font-weight: 600;
}

/* ESPAÇO DE PUBLICIDADE - BANNER PADRÃO IAB */
.me-ad-standard-container {
    max-width: 1200px;
    margin: 15px auto 25px;
    position: relative;
}
.ad-standard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 6px;
    padding: 0 4px;
}
.ad-standard-badge {
    font-size: 0.7rem;
    font-weight: 800;
    color: #8c828e;
    letter-spacing: 1.2px;
    text-transform: uppercase;
}
.ad-standard-mediakit {
    font-size: 0.75rem;
    font-weight: 600;
    color: #e31c61;
    text-decoration: none;
    transition: opacity 0.2s;
}
.ad-standard-mediakit:hover {
    text-decoration: underline;
}
.ad-standard-track {
    position: relative;
    border-radius: 10px;
    overflow: hidden;
    background: #0b0c10;
    border: 1px solid #222;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 90px;
}
.ad-standard-slide {
    display: none;
    width: 100%;
    text-align: center;
    animation: adFadeIn 0.5s ease;
}
.ad-standard-slide.active {
    display: block;
}
@keyframes adFadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
.ad-standard-slide a {
    display: block;
    line-height: 0;
}
.ad-img-standard {
    width: 100%;
    max-width: 1200px;
    height: auto;
    max-height: 300px;
    object-fit: contain;
    display: block;
    margin: 0 auto;
    transition: transform 0.25s ease;
}
.ad-standard-slide:hover .ad-img-standard {
    transform: scale(1.005);
}
.ad-standard-dots {
    display: flex;
    justify-content: center;
    gap: 6px;
    margin-top: 8px;
}
.ad-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #d8cbd9;
    border: none;
    cursor: pointer;
    transition: all 0.25s ease;
    padding: 0;
}
.ad-dot.active {
    width: 18px;
    border-radius: 4px;
    background: #e31c61;
}
@media (max-width: 768px) {
    .me-ad-standard-container {
        margin: 10px auto 18px;
    }
}
</style>

<?php get_footer(); ?>
