<?php
/**
 * Front Page Template - Portal Mercado Erótico (Modern Magazine 2026)
 */

get_header();

// 1. Get Top 6 Latest Posts for Dynamic Slideshow (Block 1)
$slider_posts = get_posts(array(
    'numberposts' => 6,
    'post_status' => 'publish'
));

// 2. Curated Categories for Eixos (Block 3)
$negocios_posts = get_posts(array('category_name' => 'negocios', 'numberposts' => 3, 'post_status' => 'publish'));
$sexologia_posts = get_posts(array('category_name' => 'sexologia', 'numberposts' => 3, 'post_status' => 'publish'));
$eventos_posts = get_posts(array('category_name' => 'eventos', 'numberposts' => 3, 'post_status' => 'publish'));

// 3. Livraria Featured Items (Block 4)
$livraria_items = array();
$livraria_file = WP_CONTENT_DIR . '/uploads/livraria/livraria_clean.json';
if (file_exists($livraria_file)) {
    $all_books = json_decode(file_get_contents($livraria_file), true) ?: array();
    $livraria_items = array_slice($all_books, 0, 4);
}

// 4. Query All-Time Most Read Posts (Block 5 - Campeões de Audiência)
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

// 5. Recent Feed Posts (Block 5, offset 6)
$feed_posts = get_posts(array(
    'numberposts' => 9,
    'offset' => 6,
    'post_status' => 'publish'
));
?>

<div class="me-home-wrapper">
    <!-- Top Trending Ticker -->
    <div class="me-trending-bar">
        <div class="trending-badge"><i class="fas fa-bolt"></i> EM ALTA</div>
        <div class="trending-ticker">
            <?php foreach ($slider_posts as $sp): ?>
                <a href="<?php echo get_permalink($sp->ID); ?>" class="ticker-item">
                    <span>•</span> <?php echo esc_html($sp->post_title); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- BLOCO 1: SLIDER DINÂMICO DE ÚLTIMAS MATÉRIAS (Transição mais lenta e elegante) -->
    <section class="me-slider-section">
        <div class="me-carousel-container" id="meHeroCarousel">
            <div class="me-carousel-track">
                <?php foreach ($slider_posts as $idx => $sp): 
                    $thumb = get_the_post_thumbnail_url($sp->ID, 'full') ?: 'https://images.unsplash.com/photo-1518895949257-7621c3c786d7?w=1400';
                    $cats = wp_get_post_categories($sp->ID, array('fields' => 'names'));
                    $cat = !empty($cats) ? $cats[0] : 'Destaque';
                    $author_name = get_the_author_meta('display_name', $sp->post_author);
                ?>
                    <div class="me-slide <?php echo $idx === 0 ? 'active' : ''; ?>">
                        <div class="slide-bg" style="background-image: url('<?php echo esc_url($thumb); ?>');"></div>
                        <div class="slide-overlay"></div>
                        <div class="slide-content">
                            <span class="slide-cat-badge"><?php echo esc_html($cat); ?></span>
                            <h2 class="slide-title">
                                <a href="<?php echo get_permalink($sp->ID); ?>"><?php echo esc_html($sp->post_title); ?></a>
                            </h2>
                            <p class="slide-excerpt"><?php echo wp_trim_words($sp->post_content, 26, '...'); ?></p>
                            <div class="slide-meta">
                                <span><i class="far fa-calendar-alt"></i> <?php echo get_the_date('d/m/Y', $sp->ID); ?></span>
                                <span>•</span>
                                <span><i class="far fa-user"></i> <?php echo esc_html($author_name); ?></span>
                                <span>•</span>
                                <a href="<?php echo get_permalink($sp->ID); ?>" class="slide-read-btn">Ler Matéria Completa →</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Carousel Controls -->
            <button class="carousel-arrow prev-arrow" onclick="moveSlide(-1)" aria-label="Slide Anterior">&#10094;</button>
            <button class="carousel-arrow next-arrow" onclick="moveSlide(1)" aria-label="Próximo Slide">&#10095;</button>

            <!-- Dots Indicator -->
            <div class="carousel-dots" id="carouselDots">
                <?php for ($i = 0; $i < count($slider_posts); $i++): ?>
                    <button class="dot <?php echo $i === 0 ? 'active' : ''; ?>" onclick="goToSlide(<?php echo $i; ?>)" aria-label="Ir para slide <?php echo $i + 1; ?>"></button>
                <?php endfor; ?>
            </div>
        </div>
    </section>

    <!-- BLOCO 2: ACERVO HISTÓRICO (Destaque Principal de Acesso) -->
    <section class="me-acervo-callout">
        <div class="acervo-callout-inner">
            <div class="acervo-callout-left">
                <span class="callout-tag">★ MEMÓRIA & DOCUMENTAÇÃO DO MERCADO ÍNTIMO</span>
                <h2 class="callout-title">Pesquise em Mais de 2.115 Reportagens e Análises Históricas</h2>
                <p class="callout-desc">O mais completo arquivo jornalístico, analítico e regulatório do mercado erótico e bem-estar sexual no Brasil, documentado continuamente desde 2018. Explore por temas, marcas, produtos e censos.</p>
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

    <!-- BLOCO 3: 3 COLUNAS TEMÁTICAS CURADAS (Negócios, Sexologia, Eventos) -->
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

        <!-- BLOCO NOVO: 🔥 OS MAIS LIDOS DE TODOS OS TEMPOS -->
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
</div>

<!-- BLOCO 8: RODAPÉ MODERNO COM REDES SOCIAIS -->
<footer class="me-footer">
    <div class="footer-inner">
        <div class="footer-grid">
            <!-- Coluna 1: Logo e Bio -->
            <div class="footer-col footer-brand">
                <a href="<?php echo home_url('/'); ?>" class="footer-logo-link">
                    <img src="https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2022/10/Copia-de-Julianna-Santos-10.png" alt="Mercado Erótico" class="footer-logo-img">
                </a>
                <p class="footer-bio">O principal portal jornalístico, analítico e documental sobre o mercado íntimo, saúde sexual e bem-estar no Brasil. Cobertura especializada contínua desde 2018.</p>
                <div class="footer-social-links">
                    <a href="https://www.instagram.com/mercadoerotico/" target="_blank" rel="noopener" class="social-icon instagram" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.facebook.com/mercadoerotico/" target="_blank" rel="noopener" class="social-icon facebook" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.youtube.com/@mercadoerotico" target="_blank" rel="noopener" class="social-icon youtube" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="https://api.whatsapp.com/send?phone=5511999999999" target="_blank" rel="noopener" class="social-icon whatsapp" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>

            <!-- Coluna 2: Navegação Rápida -->
            <div class="footer-col">
                <h4 class="footer-heading">Navegação</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo home_url('/'); ?>">Início</a></li>
                    <li><a href="<?php echo home_url('/sobre/'); ?>">Sobre Nós</a></li>
                    <li><a href="<?php echo home_url('/acervo/'); ?>">Acervo Histórico (Desde 2018)</a></li>
                    <li><a href="<?php echo home_url('/livraria/'); ?>">Livraria Digital</a></li>
                    <li><a href="<?php echo home_url('/contato/'); ?>">Contatos</a></li>
                </ul>
            </div>

            <!-- Coluna 3: Especialidades & Mercado -->
            <div class="footer-col">
                <h4 class="footer-heading">Editorias & Destaques</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo home_url('/categoria/negocios/'); ?>">Negócios & SexShop</a></li>
                    <li><a href="<?php echo home_url('/categoria/sexologia/'); ?>">Sexologia & Saúde</a></li>
                    <li><a href="<?php echo home_url('/categoria/eventos/'); ?>">Eventos & Feiras</a></li>
                    <li><a href="<?php echo home_url('/profissionais-especialistas-em-sexualidade/'); ?>">Guia de Profissionais</a></li>
                    <li><a href="https://www.guiadesexshop.com.br/" target="_blank" rel="noopener">Guia de Sex Shop</a></li>
                </ul>
            </div>

            <!-- Coluna 4: Canais & Atendimento -->
            <div class="footer-col">
                <h4 class="footer-heading">Imprensa & Contato</h4>
                <p class="footer-contact-info"><i class="fas fa-envelope"></i> redacao@mercadoerotico.org</p>
                <p class="footer-contact-info"><i class="fas fa-shield-alt"></i> Portal Seguro & Auditado</p>
                <a href="<?php echo home_url('/contato/'); ?>" class="btn-footer-contact">Fale com a Redação</a>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <strong>Portal Mercado Erótico</strong>. Todos os direitos reservados. Material jornalístico e histórico protegido.</p>
            <p class="footer-madeby">Ambiente moderno de alto desempenho • Otimizado para Mobile</p>
        </div>
    </div>
</footer>

<script>
// SLIDER DINÂMICO DE ÚLTIMAS MATÉRIAS COM TRANSIÇÃO SUAVE E LENTA
let currentSlideIndex = 0;
const slides = document.querySelectorAll('.me-slide');
const dots = document.querySelectorAll('#carouselDots .dot');
const totalSlides = slides.length;
let slideInterval = null;
const SLIDE_DURATION = 6500; // 6.5 segundos para leitura confortável

function showSlide(index) {
    if (index >= totalSlides) currentSlideIndex = 0;
    else if (index < 0) currentSlideIndex = totalSlides - 1;
    else currentSlideIndex = index;

    slides.forEach((slide, i) => {
        if (i === currentSlideIndex) {
            slide.classList.add('active');
        } else {
            slide.classList.remove('active');
        }
    });

    dots.forEach((dot, i) => {
        if (i === currentSlideIndex) {
            dot.classList.add('active');
        } else {
            dot.classList.remove('active');
        }
    });
}

function moveSlide(direction) {
    resetSlideTimer();
    showSlide(currentSlideIndex + direction);
}

function goToSlide(index) {
    resetSlideTimer();
    showSlide(index);
}

function startSlideTimer() {
    slideInterval = setInterval(() => {
        showSlide(currentSlideIndex + 1);
    }, SLIDE_DURATION);
}

function resetSlideTimer() {
    clearInterval(slideInterval);
    startSlideTimer();
}

// Pause on hover
const carouselElem = document.getElementById('meHeroCarousel');
if (carouselElem) {
    carouselElem.addEventListener('mouseenter', () => clearInterval(slideInterval));
    carouselElem.addEventListener('mouseleave', () => startSlideTimer());

    // Mobile Swipe Support
    let touchStartX = 0;
    let touchEndX = 0;
    carouselElem.addEventListener('touchstart', e => {
        touchStartX = e.changedTouches[0].screenX;
    }, {passive: true});
    carouselElem.addEventListener('touchend', e => {
        touchEndX = e.changedTouches[0].screenX;
        if (touchStartX - touchEndX > 50) moveSlide(1);
        if (touchEndX - touchStartX > 50) moveSlide(-1);
    }, {passive: true});
}

startSlideTimer();
</script>

<style>
/* CSS GERAL DA HOME & MOBILE OPTIMIZATIONS */
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

/* BLOCO 1: SLIDER DINÂMICO */
.me-slider-section {
    margin-bottom: 45px;
}
.me-carousel-container {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    min-height: 480px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    background: #111;
}
@media (max-width: 768px) {
    .me-carousel-container {
        min-height: 420px;
        border-radius: 14px;
    }
}
.me-carousel-track {
    position: relative;
    width: 100%;
    min-height: 480px;
}
.me-slide {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.8s;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 50px;
}
.me-slide.active {
    opacity: 1;
    visibility: visible;
    z-index: 2;
}
@media (max-width: 768px) {
    .me-slide {
        padding: 25px 20px 45px;
    }
}
.slide-bg {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background-size: cover;
    background-position: center;
    transform: scale(1.02);
    transition: transform 7s ease;
}
.me-slide.active .slide-bg {
    transform: scale(1.08);
}
.slide-overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(180deg, rgba(13,6,18,0.15) 0%, rgba(13,6,18,0.7) 45%, rgba(13,6,18,0.95) 100%);
}
.slide-content {
    position: relative;
    z-index: 3;
    max-width: 820px;
    color: #fff;
}
.slide-cat-badge {
    display: inline-block;
    background: #e31c61;
    color: #fff;
    font-size: 0.75rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 6px 14px;
    border-radius: 4px;
    margin-bottom: 15px;
}
.slide-title {
    font-size: 2.3rem;
    font-weight: 900;
    line-height: 1.25;
    margin: 0 0 15px;
    letter-spacing: -0.5px;
}
.slide-title a {
    color: #fff;
    text-decoration: none;
    transition: color 0.2s;
}
.slide-title a:hover {
    color: #ff85ad;
}
@media (max-width: 768px) {
    .slide-title {
        font-size: 1.45rem;
        line-height: 1.3;
    }
}
.slide-excerpt {
    font-size: 1.05rem;
    color: #e5dce7;
    line-height: 1.55;
    margin: 0 0 20px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
@media (max-width: 768px) {
    .slide-excerpt {
        font-size: 0.9rem;
        display: none;
    }
}
.slide-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 0.88rem;
    color: #c4b5c7;
    flex-wrap: wrap;
}
.slide-read-btn {
    background: rgba(255,255,255,0.18);
    backdrop-filter: blur(5px);
    color: #fff;
    padding: 6px 16px;
    border-radius: 20px;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.85rem;
    margin-left: 10px;
    border: 1px solid rgba(255,255,255,0.25);
    transition: all 0.2s;
}
.slide-read-btn:hover {
    background: #e31c61;
    border-color: #e31c61;
    color: #fff;
}
.carousel-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10;
    background: rgba(0,0,0,0.4);
    backdrop-filter: blur(4px);
    color: #fff;
    border: none;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    font-size: 1.2rem;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    transition: background 0.2s, transform 0.2s;
}
.carousel-arrow:hover {
    background: #e31c61;
    transform: translateY(-50%) scale(1.1);
}
.prev-arrow { left: 20px; }
.next-arrow { right: 20px; }
@media (max-width: 768px) {
    .carousel-arrow { display: none; }
}
.carousel-dots {
    position: absolute;
    bottom: 20px;
    right: 35px;
    z-index: 10;
    display: flex;
    gap: 8px;
}
.dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(255,255,255,0.4);
    border: none;
    cursor: pointer;
    transition: all 0.25s ease;
}
.dot.active {
    width: 30px;
    border-radius: 8px;
    background: #e31c61;
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
    .callout-title {
        font-size: 1.35rem;
    }
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

/* BLOCO 8: RODAPÉ MODERNO */
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

/* ESTILOS DO BLOCO DE MAIS LIDOS */
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

</style>

<?php get_footer(); ?>
