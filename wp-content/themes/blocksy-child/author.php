<?php
/**
 * Custom Luxury Editorial Author Archive Template
 * Blocksy Child - Portal Mercado Erótico
 */

get_header();

$author = get_queried_object();
$author_id = $author->ID ?? 0;
$author_name = $author->display_name ?? 'Autor';
$author_bio = get_user_meta($author_id, 'description', true);
$author_reg = !empty($author->user_registered) ? date_i18n('F \d\e Y', strtotime($author->user_registered)) : '';
$post_count = count_user_posts($author_id, 'post', true);

// Check if author is registered in Colunistas module
$col_data = null;
if (function_exists('mercado_colunistas_get_list')) {
    $col_list = mercado_colunistas_get_list();
    foreach ($col_list as $col) {
        if (strcasecmp(trim($col['author_name']), trim($author_name)) === 0) {
            $col_data = $col;
            break;
        }
    }
}

// Avatar image: use custom photo if available, otherwise get_avatar_url
$author_avatar = !empty($col_data['image']) ? $col_data['image'] : get_avatar_url($author_id, array('size' => 260));
$author_role = !empty($col_data['role']) ? $col_data['role'] : 'Colunista & Especialista';
$author_col_title = !empty($col_data['column_title']) ? $col_data['column_title'] : '';
$author_highlight = !empty($col_data['highlight']) ? $col_data['highlight'] : '';
$author_tag = !empty($col_data['tag']) ? $col_data['tag'] : 'Editorial';

// Social links
$fb_url = get_user_meta($author_id, 'facebook', true);
$tw_url = get_user_meta($author_id, 'twitter', true);
$li_url = get_user_meta($author_id, 'linkedin', true);
$ig_url = get_user_meta($author_id, 'instagram', true);
$web_url = $author->user_url ?? '';
if (!empty($tw_url) && strpos($tw_url, 'http') === false) {
    $tw_url = 'https://twitter.com/' . ltrim($tw_url, '@');
}
if (!empty($ig_url) && strpos($ig_url, 'http') === false) {
    $ig_url = 'https://instagram.com/' . ltrim($ig_url, '@');
}
?>

<main id="main" class="site-main me-author-page-main">
    <div class="me-author-container">
        
        <!-- BREADCRUMBS -->
        <nav class="me-author-breadcrumbs" aria-label="Navegação estrutural">
            <a href="<?php echo esc_url(home_url('/')); ?>"><i class="fas fa-home"></i> Início</a>
            <span class="sep"><i class="fas fa-chevron-right"></i></span>
            <a href="<?php echo esc_url(home_url('/colunistas/')); ?>">Colunistas &amp; Autores</a>
            <span class="sep"><i class="fas fa-chevron-right"></i></span>
            <span class="current"><?php echo esc_html($author_name); ?></span>
        </nav>

        <!-- AUTHOR HERO PROFILE CARD -->
        <header class="me-author-hero-card">
            <div class="author-hero-inner">
                <div class="author-avatar-col">
                    <div class="avatar-ring">
                        <img src="<?php echo esc_url($author_avatar); ?>" alt="<?php echo esc_attr($author_name); ?>" class="author-hero-img" loading="eager">
                    </div>
                    <?php if ($col_data): ?>
                        <span class="author-status-badge"><i class="fas fa-check-circle"></i> Colunista Verificado</span>
                    <?php endif; ?>
                </div>

                <div class="author-info-col">
                    <div class="author-eyebrow-wrap">
                        <span class="author-eyebrow">
                            <i class="fas fa-pen-nib"></i> <?php echo !empty($author_col_title) ? esc_html($author_col_title) : 'Colunista Oficial'; ?>
                        </span>
                        <?php if (!empty($author_tag)): ?>
                            <span class="author-tag-pill"><?php echo esc_html($author_tag); ?></span>
                        <?php endif; ?>
                    </div>

                    <h1 class="author-hero-name"><?php echo esc_html($author_name); ?></h1>
                    
                    <div class="author-hero-role">
                        <i class="fas fa-award"></i> <?php echo esc_html($author_role); ?>
                    </div>

                    <!-- METRICS PILLS -->
                    <div class="author-metrics-bar">
                        <div class="metric-pill">
                            <i class="fas fa-newspaper"></i>
                            <strong><?php echo number_format_i18n($post_count); ?></strong>
                            <span><?php echo $post_count == 1 ? 'Matéria' : 'Matérias Publicadas'; ?></span>
                        </div>
                        <?php if (!empty($author_reg)): ?>
                            <div class="metric-pill">
                                <i class="far fa-calendar-alt"></i>
                                <span>No Portal desde</span>
                                <strong><?php echo esc_html($author_reg); ?></strong>
                            </div>
                        <?php endif; ?>
                        <div class="metric-pill">
                            <i class="fas fa-certificate"></i>
                            <span>Editoria</span>
                            <strong>Mercado Erótico</strong>
                        </div>
                    </div>

                    <!-- BIO TEXT -->
                    <?php if (!empty($author_bio)): ?>
                        <div class="author-hero-bio">
                            <?php echo esc_html($author_bio); ?>
                        </div>
                    <?php else: ?>
                        <div class="author-hero-bio">
                            Colunista e colaborador oficial do Portal Mercado Erótico, cobrindo saúde íntima, negócios, dados do setor e comportamento.
                        </div>
                    <?php endif; ?>

                    <!-- HIGHLIGHT / TEMAS DE FOCO -->
                    <?php if (!empty($author_highlight)): ?>
                        <div class="author-focus-box">
                            <strong><i class="fas fa-bullseye"></i> Temas em Foco:</strong>
                            <span><?php echo esc_html($author_highlight); ?></span>
                        </div>
                    <?php endif; ?>

                    <!-- SOCIAL NETWORKS -->
                    <div class="author-social-row">
                        <?php if (!empty($ig_url)): ?>
                            <a href="<?php echo esc_url($ig_url); ?>" target="_blank" rel="noopener noreferrer" class="author-social-btn ig" title="Instagram">
                                <i class="fab fa-instagram"></i> Instagram
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($li_url)): ?>
                            <a href="<?php echo esc_url($li_url); ?>" target="_blank" rel="noopener noreferrer" class="author-social-btn li" title="LinkedIn">
                                <i class="fab fa-linkedin-in"></i> LinkedIn
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($fb_url)): ?>
                            <a href="<?php echo esc_url($fb_url); ?>" target="_blank" rel="noopener noreferrer" class="author-social-btn fb" title="Facebook">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($tw_url)): ?>
                            <a href="<?php echo esc_url($tw_url); ?>" target="_blank" rel="noopener noreferrer" class="author-social-btn tw" title="Twitter / X">
                                <i class="fab fa-x-twitter"></i> Twitter
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($web_url) && strpos($web_url, 'hostingersite.com') === false): ?>
                            <a href="<?php echo esc_url($web_url); ?>" target="_blank" rel="noopener noreferrer" class="author-social-btn web" title="Site Oficial">
                                <i class="fas fa-globe"></i> Website
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </header>

        <!-- SECTION DIVIDER & FEED HEADER -->
        <section class="me-author-articles-section">
            <div class="articles-section-header">
                <div class="header-titles">
                    <span class="sub-label">ACERVO EDITORIAL DO AUTOR</span>
                    <h2 class="section-title">Todas as Matérias &amp; Análises</h2>
                </div>
                <div class="header-count-badge">
                    <i class="fas fa-layer-group"></i> <strong><?php echo number_format_i18n($post_count); ?></strong> artigos encontrados
                </div>
            </div>

            <!-- ARTICLES GRID -->
            <?php if (have_posts()) : ?>
                <div class="me-author-grid">
                    <?php 
                    while (have_posts()) : the_post(); 
                        $pid = get_the_ID();
                        $cats = get_the_category($pid);
                        $primary_cat = !empty($cats) ? $cats[0]->name : 'Mercado Erótico';
                        $cat_link = !empty($cats) ? get_category_link($cats[0]->term_id) : '#';
                        $thumb = get_the_post_thumbnail_url($pid, 'large');
                        if (empty($thumb)) {
                            $thumb = 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2026/11/banner_livraria_vitrine_digital.webp';
                        }
                        $word_count = str_word_count(strip_tags(get_the_content()));
                        $reading_time = max(1, ceil($word_count / 200));
                        $excerpt = get_the_excerpt($pid);
                        if (empty($excerpt)) {
                            $excerpt = wp_trim_words(strip_tags(get_the_content()), 20, '...');
                        } else {
                            $excerpt = wp_trim_words($excerpt, 20, '...');
                        }
                    ?>
                        <article class="me-author-card">
                            <div class="card-media-wrap">
                                <a href="<?php the_permalink(); ?>" class="card-img-link" tabindex="-1" aria-hidden="true">
                                    <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>" class="card-img" loading="lazy">
                                </a>
                                <a href="<?php echo esc_url($cat_link); ?>" class="card-cat-badge">
                                    <?php echo esc_html($primary_cat); ?>
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="card-meta-top">
                                    <span class="meta-date"><i class="far fa-calendar-alt"></i> <?php echo get_the_date('d/m/Y'); ?></span>
                                    <span class="meta-dot">•</span>
                                    <span class="meta-time"><i class="far fa-clock"></i> <?php echo $reading_time; ?> min</span>
                                </div>
                                <h3 class="card-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <p class="card-excerpt">
                                    <?php echo esc_html($excerpt); ?>
                                </p>
                                <div class="card-footer">
                                    <a href="<?php the_permalink(); ?>" class="btn-read-more">
                                        Ler Matéria Completa <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <!-- PAGINATION -->
                <div class="me-author-pagination">
                    <?php
                    echo paginate_links(array(
                        'prev_text' => '<i class="fas fa-arrow-left"></i> Anterior',
                        'next_text' => 'Próxima <i class="fas fa-arrow-right"></i>',
                        'type'      => 'list'
                    ));
                    ?>
                </div>

            <?php else : ?>
                <div class="me-no-articles-card">
                    <i class="fas fa-folder-open"></i>
                    <h3>Nenhuma matéria encontrada</h3>
                    <p>Este autor ainda não possui artigos públicos publicados.</p>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="button button-primary">Voltar para a Página Inicial</a>
                </div>
            <?php endif; ?>
        </section>
    </div>
</main>

<style>
/* ==========================================================================
   LUXURY AUTHOR ARCHIVE STYLING - PORTAL MERCADO ERÓTICO
   ========================================================================== */
.me-author-page-main {
    background: #f8fafc;
    padding: 30px 20px 80px;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    color: #1e293b;
}
.me-author-container {
    max-width: 1240px;
    margin: 0 auto;
}

/* Breadcrumbs */
.me-author-breadcrumbs {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.85rem;
    color: #64748b;
    margin-bottom: 24px;
    flex-wrap: wrap;
}
.me-author-breadcrumbs a {
    color: #64748b;
    text-decoration: none;
    transition: color 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.me-author-breadcrumbs a:hover {
    color: #e31c61;
}
.me-author-breadcrumbs .sep {
    font-size: 0.7rem;
    color: #cbd5e1;
}
.me-author-breadcrumbs .current {
    color: #0f172a;
    font-weight: 700;
}

/* AUTHOR HERO PROFILE CARD */
.me-author-hero-card {
    background: #ffffff;
    border-radius: 18px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
    padding: 36px 40px;
    margin-bottom: 40px;
    position: relative;
    overflow: hidden;
}
.me-author-hero-card::before {
    content: "";
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 5px;
    background: linear-gradient(90deg, #e31c61 0%, #b8144b 50%, #1e1b4b 100%);
}
.author-hero-inner {
    display: flex;
    align-items: flex-start;
    gap: 36px;
}
.author-avatar-col {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex-shrink: 0;
}
.avatar-ring {
    width: 135px;
    height: 135px;
    border-radius: 50%;
    overflow: hidden;
    padding: 4px;
    background: linear-gradient(135deg, #e31c61 0%, #ff4d6d 100%);
    box-shadow: 0 8px 25px rgba(227, 28, 97, 0.25);
    margin-bottom: 12px;
}
.author-hero-img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    background: #fff;
    display: block;
}
.author-status-badge {
    font-size: 0.74rem;
    font-weight: 700;
    color: #065f46;
    background: #ecfdf5;
    border: 1px solid #a7f3d0;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    white-space: nowrap;
}

/* Info Column */
.author-info-col {
    flex: 1;
}
.author-eyebrow-wrap {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
    flex-wrap: wrap;
}
.author-eyebrow {
    font-size: 0.75rem;
    font-weight: 800;
    color: #e31c61;
    text-transform: uppercase;
    letter-spacing: 1px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.author-tag-pill {
    background: rgba(227, 28, 97, 0.08);
    color: #e31c61;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 2px 10px;
    border-radius: 12px;
    border: 1px solid rgba(227, 28, 97, 0.2);
}
.author-hero-name {
    font-size: 2.2rem;
    font-weight: 900;
    color: #0f172a;
    line-height: 1.15;
    margin: 0 0 6px 0;
    letter-spacing: -0.5px;
}
.author-hero-role {
    font-size: 1.05rem;
    color: #64748b;
    font-weight: 600;
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.author-hero-role i {
    color: #f59e0b;
}

/* Metrics Bar */
.author-metrics-bar {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}
.metric-pill {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    padding: 8px 14px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.84rem;
    color: #475569;
}
.metric-pill i {
    color: #e31c61;
    font-size: 0.95rem;
}
.metric-pill strong {
    color: #0f172a;
    font-weight: 800;
}

/* Bio Text */
.author-hero-bio {
    font-size: 1.02rem;
    line-height: 1.7;
    color: #334155;
    margin-bottom: 20px;
    white-space: pre-line;
}

/* Focus Box */
.author-focus-box {
    background: #f1f5f9;
    border-left: 3px solid #e31c61;
    padding: 10px 16px;
    border-radius: 6px;
    font-size: 0.88rem;
    color: #334155;
    margin-bottom: 22px;
}
.author-focus-box strong {
    color: #0f172a;
    margin-right: 6px;
}
.author-focus-box strong i {
    color: #e31c61;
}

/* Social Row */
.author-social-row {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}
.author-social-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 7px 16px;
    border-radius: 8px;
    font-size: 0.82rem;
    font-weight: 700;
    text-decoration: none !important;
    transition: all 0.2s ease;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
}
.author-social-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
}
.author-social-btn.ig { background: #e1306c; color: #fff !important; }
.author-social-btn.li { background: #0077b5; color: #fff !important; }
.author-social-btn.fb { background: #1877f2; color: #fff !important; }
.author-social-btn.tw { background: #0f172a; color: #fff !important; }
.author-social-btn.web { background: #059669; color: #fff !important; }

/* ==========================================================================
   ARTICLES SECTION & CARDS GRID
   ========================================================================== */
.me-author-articles-section {
    margin-top: 20px;
}
.articles-section-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #e2e8f0;
    flex-wrap: wrap;
    gap: 15px;
}
.articles-section-header .sub-label {
    font-size: 0.72rem;
    font-weight: 800;
    color: #e31c61;
    letter-spacing: 1.2px;
    display: block;
    margin-bottom: 4px;
}
.articles-section-header .section-title {
    font-size: 1.6rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
}
.header-count-badge {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.86rem;
    color: #64748b;
    box-shadow: 0 1px 3px rgba(0,0,0,0.03);
}
.header-count-badge strong {
    color: #e31c61;
}

/* Grid */
.me-author-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 26px;
}

/* Card */
.me-author-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
}
.me-author-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 14px 30px rgba(0, 0, 0, 0.08);
    border-color: #cbd5e1;
}
.card-media-wrap {
    position: relative;
    width: 100%;
    aspect-ratio: 16 / 9;
    overflow: hidden;
    background: #0f172a;
}
.card-img-link {
    display: block;
    width: 100%;
    height: 100%;
}
.card-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
    display: block;
}
.me-author-card:hover .card-img {
    transform: scale(1.06);
}
.card-cat-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: rgba(15, 23, 42, 0.85);
    backdrop-filter: blur(4px);
    color: #fff !important;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 6px;
    text-decoration: none !important;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: background 0.2s;
}
.card-cat-badge:hover {
    background: #e31c61;
    border-color: #e31c61;
}

/* Card Body */
.card-body {
    padding: 20px;
    display: flex;
    flex-direction: column;
    flex: 1;
}
.card-meta-top {
    font-size: 0.78rem;
    color: #94a3b8;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.card-meta-top .meta-date i,
.card-meta-top .meta-time i {
    color: #e31c61;
}
.card-meta-top .meta-dot {
    color: #cbd5e1;
}
.card-title {
    font-size: 1.15rem;
    font-weight: 800;
    line-height: 1.35;
    margin: 0 0 10px 0;
}
.card-title a {
    color: #0f172a;
    text-decoration: none !important;
    transition: color 0.2s;
}
.card-title a:hover {
    color: #e31c61;
}
.card-excerpt {
    font-size: 0.88rem;
    line-height: 1.55;
    color: #64748b;
    margin: 0 0 18px 0;
    flex: 1;
}
.card-footer {
    border-top: 1px solid #f1f5f9;
    padding-top: 14px;
    margin-top: auto;
}
.btn-read-more {
    font-size: 0.84rem;
    font-weight: 700;
    color: #e31c61;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: gap 0.2s;
}
.btn-read-more:hover {
    gap: 10px;
    color: #b8144b;
}

/* Pagination */
.me-author-pagination {
    margin-top: 45px;
    display: flex;
    justify-content: center;
}
.me-author-pagination ul.page-numbers {
    display: flex;
    gap: 8px;
    list-style: none;
    padding: 0;
    margin: 0;
    align-items: center;
}
.me-author-pagination .page-numbers {
    padding: 8px 16px;
    border-radius: 8px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    color: #334155;
    font-size: 0.9rem;
    font-weight: 700;
    text-decoration: none !important;
    transition: all 0.2s;
}
.me-author-pagination .page-numbers:hover {
    background: #f1f5f9;
    border-color: #cbd5e1;
}
.me-author-pagination .page-numbers.current {
    background: #e31c61;
    border-color: #e31c61;
    color: #fff;
    box-shadow: 0 4px 12px rgba(227, 28, 97, 0.3);
}

/* Empty State */
.me-no-articles-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 60px 20px;
    text-align: center;
    color: #64748b;
}
.me-no-articles-card i {
    font-size: 3rem;
    color: #cbd5e1;
    margin-bottom: 15px;
}
.me-no-articles-card h3 {
    color: #0f172a;
    font-size: 1.3rem;
    margin-bottom: 8px;
}

/* Responsiveness */
@media (max-width: 1024px) {
    .me-author-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
}
@media (max-width: 768px) {
    .me-author-page-main {
        padding: 20px 15px 60px;
    }
    .me-author-hero-card {
        padding: 24px 20px;
    }
    .author-hero-inner {
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 20px;
    }
    .author-hero-role {
        justify-content: center;
    }
    .author-metrics-bar {
        justify-content: center;
    }
    .author-social-row {
        justify-content: center;
    }
    .author-eyebrow-wrap {
        justify-content: center;
    }
    .articles-section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    .me-author-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php
get_footer();
