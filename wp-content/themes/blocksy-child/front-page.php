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

// 5. Recent Feed Posts (Block 6, offset 6)
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

    <!-- BLOCO 1: SLIDER DINÂMICO DE ÚLTIMAS MATÉRIAS -->
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

    <!-- BLOCO 2: ACERVO HISTÓRICO -->
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

    <!-- BLOCO NOVO: 🔥 OS MAIS LIDOS DE TODOS OS TEMPOS (CAMPEÕES DE AUDIÊNCIA) -->
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

    <!-- BLOCO 6: FEED RECENTE DE REPORTAGENS -->
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

<!-- RODAPÉ MODERNO COM REDES SOCIAIS -->
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
// SLIDER DINÂMICO
let currentSlideIndex = 0;
const slides = document.querySelectorAll('.me-slide');
const dots = document.querySelectorAll('#carouselDots .dot');
const totalSlides = slides.length;
let slideInterval = null;
const SLIDE_DURATION = 6500;

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

const carouselElem = document.getElementById('meHeroCarousel');
if (carouselElem) {
    carouselElem.addEventListener('mouseenter', () => clearInterval(slideInterval));
    carouselElem.addEventListener('mouseleave', () => startSlideTimer());

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
