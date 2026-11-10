<?php
/**
 * Custom Luxury Editorial Single Post Template
 * Blocksy Child - Portal Mercado Erótico
 */

if (is_page()) {
    get_header();
    while (have_posts()) :
        the_post();
        ?>
        <main id="main" class="site-main me-page-main">
            <div class="me-page-entry-content">
                <?php the_content(); ?>
            </div>
        </main>
        <?php
    endwhile;
    get_footer();
    return;
}

get_header();
?>

<!-- Reading Progress Bar -->
<div id="me-reading-progress" class="me-reading-bar"></div>

<main id="main" class="site-main me-single-main">
<?php
while (have_posts()) :
    the_post();
    $post_id    = get_the_ID();
    $categories = get_the_category();
    $primary_cat = !empty($categories) ? $categories[0] : null;

    // Estimated reading time calculation (approx 200 words/min)
    $word_count   = str_word_count(strip_tags(get_the_content()));
    $reading_time = max(1, ceil($word_count / 200));

    // Author data
    $author_id   = get_the_author_meta('ID');
    $author_name = get_the_author_meta('display_name');
    $author_bio  = get_the_author_meta('description');
    $author_url  = get_author_posts_url($author_id);
    $author_img  = get_avatar_url($author_id, array('size' => 120));

    // Share URLs
    $post_url   = get_permalink();
    $post_title = get_the_title();
    $wa_url     = 'https://api.whatsapp.com/send?text=' . urlencode($post_title . ' ' . $post_url);
    $li_url     = 'https://www.linkedin.com/sharing/share-offsite/?url=' . urlencode($post_url);
    $fb_url     = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($post_url);
    $tw_url     = 'https://twitter.com/intent/tweet?text=' . urlencode($post_title) . '&url=' . urlencode($post_url);
?>
    <article id="post-<?php the_ID(); ?>" <?php post_class('me-article-single'); ?>>
        
        <!-- ARTICLE HEADER / HERO -->
        <header class="me-single-header">
            <!-- Breadcrumbs -->
            <nav class="me-breadcrumbs" aria-label="Navegação estrutural">
                <a href="<?php echo home_url('/'); ?>">Início</a>
                <span class="sep"><i class="fas fa-chevron-right"></i></span>
                <?php if ($primary_cat): ?>
                    <a href="<?php echo esc_url(get_category_link($primary_cat->term_id)); ?>"><?php echo esc_html($primary_cat->name); ?></a>
                    <span class="sep"><i class="fas fa-chevron-right"></i></span>
                <?php endif; ?>
                <span class="current">Artigo</span>
            </nav>

            <!-- Meta Top: Category Badge & Reading Time -->
            <div class="me-header-meta-top">
                <?php if ($primary_cat): ?>
                    <a href="<?php echo esc_url(get_category_link($primary_cat->term_id)); ?>" class="me-cat-badge">
                        <?php echo esc_html($primary_cat->name); ?>
                    </a>
                <?php endif; ?>
                <span class="me-read-time">
                    <i class="far fa-clock"></i> <?php echo $reading_time; ?> min de leitura
                </span>
                <span class="me-pub-date">
                    <i class="far fa-calendar-alt"></i> <?php echo get_the_date('d \d\e F \d\e Y'); ?>
                </span>
            </div>

            <!-- Main Title -->
            <h1 class="me-single-title"><?php the_title(); ?></h1>

            <!-- Lead / Subtitle if excerpt exists -->
            <?php if (has_excerpt()): ?>
                <div class="me-single-lead">
                    <?php echo wp_strip_all_tags(get_the_excerpt()); ?>
                </div>
            <?php endif; ?>

            <!-- Author & Share Bar Header -->
            <div class="me-author-share-bar">
                <div class="me-author-left">
                    <a href="<?php echo esc_url($author_url); ?>" class="me-author-avatar-link">
                        <img src="<?php echo esc_url($author_img); ?>" alt="<?php echo esc_attr($author_name); ?>" class="me-author-avatar">
                    </a>
                    <div class="me-author-info-text">
                        <span class="author-label">Por</span>
                        <a href="<?php echo esc_url($author_url); ?>" class="author-name"><?php echo esc_html($author_name); ?></a>
                        <span class="post-date-sub"><?php echo get_the_date('d/m/Y \à\s H:i'); ?></span>
                    </div>
                </div>

                <!-- Top Share Buttons -->
                <div class="me-top-share">
                    <span class="share-lbl">Compartilhar:</span>
                    <a href="<?php echo esc_url($wa_url); ?>" target="_blank" rel="noopener" class="share-btn wa" title="Compartilhar no WhatsApp" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    <a href="<?php echo esc_url($li_url); ?>" target="_blank" rel="noopener" class="share-btn li" title="Compartilhar no LinkedIn" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="<?php echo esc_url($tw_url); ?>" target="_blank" rel="noopener" class="share-btn tw" title="Compartilhar no X (Twitter)" aria-label="Twitter"><i class="fab fa-x-twitter"></i></a>
                    <button type="button" class="share-btn copy me-copy-link-btn" data-url="<?php echo esc_url($post_url); ?>" title="Copiar link" aria-label="Copiar link"><i class="fas fa-link"></i></button>
                </div>
            </div>
        </header>

        <!-- FEATURED IMAGE (FLYER / FOTO) -->
        <?php if (has_post_thumbnail()): ?>
            <div class="me-featured-image-container">
                <figure class="me-featured-figure">
                    <?php the_post_thumbnail('full', array('class' => 'me-featured-img', 'loading' => 'eager')); ?>
                    <?php 
                    $thumb_caption = get_the_post_thumbnail_caption();
                    if ($thumb_caption): ?>
                        <figcaption class="me-featured-caption"><?php echo esc_html($thumb_caption); ?></figcaption>
                    <?php endif; ?>
                </figure>
            </div>
        <?php endif; ?>

        <!-- ARTICLE BODY CONTENT -->
        <div class="me-article-body-wrapper">
            <div class="me-article-content">
                <?php 
                $content = apply_filters('the_content', get_the_content());
                // Remove redundant plain "Por Author" line from top of body since it is now in the header author bar
                $content = preg_replace('/^<p>\s*Por\s+.*?<\/p>/ius', '', trim($content));
                echo $content;
                ?>
            </div>

            <!-- POST TAGS -->
            <?php
            $tags = get_the_tags();
            if ($tags): ?>
                <div class="me-post-tags">
                    <span class="tags-title"><i class="fas fa-hashtag"></i> Tópicos:</span>
                    <div class="tags-list">
                        <?php foreach ($tags as $tag): ?>
                            <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="tag-pill">#<?php echo esc_html($tag->name); ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- BOTTOM SHARE CALLOUT -->
            <div class="me-bottom-share-callout">
                <div class="callout-text">
                    <h4><i class="fas fa-heart" style="color:#e31c61;"></i> Gostou deste artigo do Mercado Erótico?</h4>
                    <p>Compartilhe informação de qualidade com seus colegas, parceiros e rede de contatos.</p>
                </div>
                <div class="callout-buttons">
                    <a href="<?php echo esc_url($wa_url); ?>" target="_blank" rel="noopener" class="btn-share-big wa">
                        <i class="fab fa-whatsapp"></i> Compartilhar no WhatsApp
                    </a>
                    <a href="<?php echo esc_url($li_url); ?>" target="_blank" rel="noopener" class="btn-share-big li">
                        <i class="fab fa-linkedin-in"></i> LinkedIn
                    </a>
                    <button type="button" class="btn-share-big copy me-copy-link-btn" data-url="<?php echo esc_url($post_url); ?>">
                        <i class="fas fa-link"></i> Copiar Link
                    </button>
                </div>
            </div>

            <!-- AUTHOR BIO BOX -->
            <div class="me-author-bio-card">
                <div class="bio-avatar-wrap">
                    <img src="<?php echo esc_url($author_img); ?>" alt="<?php echo esc_attr($author_name); ?>" class="bio-avatar">
                </div>
                <div class="bio-content">
                    <span class="bio-eyebrow">Sobre o Autor &amp; Colunista</span>
                    <h3 class="bio-name"><?php echo esc_html($author_name); ?></h3>
                    <p class="bio-desc">
                        <?php 
                        if (!empty($author_bio)) {
                            echo esc_html($author_bio);
                        } else {
                            echo 'Colunista e colaborador oficial do Portal Mercado Erótico, cobrindo saúde íntima, negócios, dados do setor e comportamento.';
                        }
                        ?>
                    </p>
                    <a href="<?php echo esc_url($author_url); ?>" class="bio-link">
                        Ver todas as matérias de <?php echo esc_html($author_name); ?> <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- NEXT & PREVIOUS ARTICLE NAVIGATION -->
            <?php
            $prev_post = get_previous_post();
            $next_post = get_next_post();
            if ($prev_post || $next_post): ?>
                <nav class="me-post-nav-grid" aria-label="Navegação entre matérias">
                    <?php if ($prev_post): ?>
                        <a href="<?php echo get_permalink($prev_post->ID); ?>" class="nav-card prev-card">
                            <span class="nav-dir"><i class="fas fa-arrow-left"></i> Matéria Anterior</span>
                            <span class="nav-title"><?php echo wp_trim_words(get_the_title($prev_post->ID), 9, '...'); ?></span>
                        </a>
                    <?php else: ?>
                        <div class="nav-card empty"></div>
                    <?php endif; ?>

                    <?php if ($next_post): ?>
                        <a href="<?php echo get_permalink($next_post->ID); ?>" class="nav-card next-card">
                            <span class="nav-dir">Próxima Matéria <i class="fas fa-arrow-right"></i></span>
                            <span class="nav-title"><?php echo wp_trim_words(get_the_title($next_post->ID), 9, '...'); ?></span>
                        </a>
                    <?php endif; ?>
                </nav>
            <?php endif; ?>

        </div><!-- .me-article-body-wrapper -->

        <!-- RELATED POSTS SECTION -->
        <?php
        $related_args = array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => 3,
            'post__not_in'   => array($post_id),
            'orderby'        => 'rand'
        );
        if ($primary_cat) {
            $related_args['cat'] = $primary_cat->term_id;
        }
        $related_query = new WP_Query($related_args);

        if ($related_query->have_posts()): ?>
            <section class="me-related-posts-section">
                <div class="related-inner">
                    <div class="related-header">
                        <span class="related-eyebrow">CONTINUE LENDO</span>
                        <h3 class="related-title">Artigos Recomendados para Você</h3>
                    </div>
                    <div class="related-grid">
                        <?php while ($related_query->have_posts()): $related_query->the_post(); 
                            $rel_cats = get_the_category();
                            $rel_cat_name = !empty($rel_cats) ? $rel_cats[0]->name : 'Mercado Erótico';
                            $rel_thumb = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'medium_large') : 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2026/11/colunista_padrao_logo.png';
                        ?>
                            <article class="related-card">
                                <a href="<?php the_permalink(); ?>" class="rel-thumb-link">
                                    <img src="<?php echo esc_url($rel_thumb); ?>" alt="<?php the_title_attribute(); ?>" class="rel-thumb" loading="lazy">
                                    <span class="rel-badge"><?php echo esc_html($rel_cat_name); ?></span>
                                </a>
                                <div class="rel-body">
                                    <span class="rel-date"><i class="far fa-calendar-alt"></i> <?php echo get_the_date('d/m/Y'); ?></span>
                                    <h4 class="rel-heading">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h4>
                                    <a href="<?php the_permalink(); ?>" class="rel-read-more">Ler Artigo ➔</a>
                                </div>
                            </article>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

    </article>
<?php endwhile; ?>
</main>

<!-- STYLES & INTERACTIVE SCRIPT -->
<style>
/* READING PROGRESS BAR */
.me-reading-bar {
    position: fixed;
    top: 0;
    left: 0;
    height: 4px;
    width: 0%;
    background: linear-gradient(90deg, #e31c61, #ff659c, #9c1543);
    z-index: 99999;
    transition: width 0.1s ease-out;
}

/* SINGLE CONTAINER */
.me-single-main {
    background: #fbfbfd;
    padding-bottom: 80px;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
}
.me-article-single {
    max-width: 100%;
    margin: 0 auto;
}

/* HEADER / HERO */
.me-single-header {
    max-width: 860px;
    margin: 40px auto 30px auto;
    padding: 0 20px;
}
.me-breadcrumbs {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.82rem;
    color: #64748b;
    margin-bottom: 18px;
    flex-wrap: wrap;
}
.me-breadcrumbs a {
    color: #475569;
    text-decoration: none;
    transition: color 0.2s;
}
.me-breadcrumbs a:hover {
    color: #e31c61;
}
.me-breadcrumbs .sep {
    font-size: 0.65rem;
    color: #cbd5e1;
}
.me-breadcrumbs .current {
    color: #94a3b8;
}

.me-header-meta-top {
    display: flex;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
    margin-bottom: 16px;
    font-size: 0.85rem;
    color: #64748b;
}
.me-cat-badge {
    background: #fdf2f8;
    color: #be185d !important;
    border: 1px solid rgba(227, 28, 97, 0.25);
    font-weight: 700;
    font-size: 0.75rem;
    padding: 4px 12px;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    text-decoration: none;
    transition: all 0.2s;
}
.me-cat-badge:hover {
    background: #e31c61;
    color: #fff !important;
}
.me-read-time, .me-pub-date {
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.me-read-time i, .me-pub-date i {
    color: #e31c61;
}

.me-single-title {
    font-size: 2.8rem;
    font-weight: 900;
    color: #0f172a;
    line-height: 1.2;
    letter-spacing: -0.5px;
    margin: 0 0 18px 0;
}
@media (max-width: 768px) {
    .me-single-title { font-size: 2rem; }
}

.me-single-lead {
    font-size: 1.2rem;
    color: #475569;
    line-height: 1.6;
    margin-bottom: 24px;
    padding-left: 18px;
    border-left: 4px solid #e31c61;
    font-style: italic;
}

/* AUTHOR & SHARE BAR */
.me-author-share-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 0;
    border-top: 1px solid #e2e8f0;
    border-bottom: 1px solid #e2e8f0;
    margin-top: 25px;
    flex-wrap: wrap;
    gap: 15px;
}
.me-author-left {
    display: flex;
    align-items: center;
    gap: 12px;
}
.me-author-avatar-link {
    display: block;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid #e31c61;
}
.me-author-avatar {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.me-author-info-text {
    display: flex;
    flex-direction: column;
}
.author-label {
    font-size: 0.72rem;
    color: #94a3b8;
    text-transform: uppercase;
    font-weight: 600;
}
.author-name {
    font-size: 0.98rem;
    font-weight: 700;
    color: #0f172a;
    text-decoration: none;
    transition: color 0.2s;
}
.author-name:hover {
    color: #e31c61;
}
.post-date-sub {
    font-size: 0.78rem;
    color: #64748b;
}

.me-top-share {
    display: flex;
    align-items: center;
    gap: 8px;
}
.share-lbl {
    font-size: 0.8rem;
    font-weight: 700;
    color: #64748b;
    margin-right: 4px;
}
.share-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #fff !important;
    text-decoration: none;
    font-size: 0.9rem;
    transition: transform 0.2s, box-shadow 0.2s;
    border: none;
    cursor: pointer;
}
.share-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}
.share-btn.wa { background: #25d366; }
.share-btn.li { background: #0077b5; }
.share-btn.tw { background: #0f172a; }
.share-btn.copy { background: #475569; }

/* FEATURED IMAGE */
.me-featured-image-container {
    max-width: 960px;
    margin: 30px auto 40px auto;
    padding: 0 20px;
}
.me-featured-figure {
    margin: 0;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    background: #0f172a;
}
.me-featured-img {
    width: 100%;
    height: auto;
    max-height: 540px;
    object-fit: cover;
    display: block;
}
.me-featured-caption {
    padding: 10px 16px;
    font-size: 0.8rem;
    color: #64748b;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    text-align: center;
}

/* ARTICLE BODY */
.me-article-body-wrapper {
    max-width: 820px;
    margin: 0 auto;
    padding: 0 20px;
}
.me-article-content {
    font-size: 1.12rem;
    line-height: 1.85;
    color: #1e293b;
}
.me-article-content p {
    margin-bottom: 24px;
}
/* Drop-cap on first letter */
.me-article-content > p:first-of-type::first-letter {
    font-size: 3.6rem;
    float: left;
    line-height: 0.85;
    padding-right: 12px;
    padding-top: 4px;
    font-weight: 900;
    color: #e31c61;
}
.me-article-content h2 {
    font-size: 1.85rem;
    font-weight: 800;
    color: #0f172a;
    margin: 45px 0 18px 0;
    line-height: 1.3;
    padding-bottom: 8px;
    border-bottom: 2px solid #f1f5f9;
}
.me-article-content h3 {
    font-size: 1.45rem;
    font-weight: 700;
    color: #0f172a;
    margin: 35px 0 14px 0;
    line-height: 1.35;
}
.me-article-content blockquote {
    background: #fff5f8;
    border-left: 4px solid #e31c61;
    margin: 35px 0;
    padding: 22px 28px;
    border-radius: 0 12px 12px 0;
    font-size: 1.2rem;
    font-style: italic;
    color: #334155;
    position: relative;
}
.me-article-content blockquote p {
    margin: 0;
}
.me-article-content ul, .me-article-content ol {
    margin: 20px 0 25px 25px;
    padding: 0;
}
.me-article-content li {
    margin-bottom: 10px;
}
.me-article-content a {
    color: #e31c61;
    text-decoration: underline;
    text-underline-offset: 3px;
    transition: color 0.2s;
}
.me-article-content a:hover {
    color: #b91c1c;
}
.me-article-content img {
    max-width: 100%;
    height: auto;
    border-radius: 12px;
    margin: 25px auto;
    display: block;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
}

/* POST TAGS */
.me-post-tags {
    margin: 35px 0;
    padding: 16px 0;
    border-top: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}
.tags-title {
    font-size: 0.88rem;
    font-weight: 700;
    color: #64748b;
}
.tags-list {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}
.tag-pill {
    background: #f1f5f9;
    color: #334155 !important;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.82rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}
.tag-pill:hover {
    background: #e31c61;
    color: #fff !important;
}

/* BOTTOM SHARE CALLOUT */
.me-bottom-share-callout {
    background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 60%, #311029 100%);
    border-radius: 16px;
    padding: 30px;
    color: #fff;
    margin: 40px 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}
.callout-text h4 {
    color: #fff;
    margin: 0 0 6px 0;
    font-size: 1.15rem;
    font-weight: 800;
}
.callout-text p {
    color: #cbd5e1;
    margin: 0;
    font-size: 0.88rem;
}
.callout-buttons {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}
.btn-share-big {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    border-radius: 25px;
    font-size: 0.88rem;
    font-weight: 700;
    color: #fff !important;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
}
.btn-share-big:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.3);
}
.btn-share-big.wa { background: #25d366; }
.btn-share-big.li { background: #0077b5; }
.btn-share-big.copy { background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); }

/* AUTHOR BIO CARD */
.me-author-bio-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 28px;
    margin: 40px 0;
    display: flex;
    align-items: center;
    gap: 24px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
}
.bio-avatar-wrap {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
    border: 3px solid #e31c61;
}
.bio-avatar {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.bio-content {
    flex: 1;
}
.bio-eyebrow {
    font-size: 0.72rem;
    font-weight: 800;
    text-transform: uppercase;
    color: #e31c61;
    letter-spacing: 0.8px;
    display: block;
    margin-bottom: 4px;
}
.bio-name {
    font-size: 1.35rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 6px 0;
}
.bio-desc {
    font-size: 0.92rem;
    color: #475569;
    line-height: 1.6;
    margin: 0 0 12px 0;
}
.bio-link {
    font-size: 0.88rem;
    font-weight: 700;
    color: #e31c61;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: gap 0.2s;
}
.bio-link:hover {
    gap: 10px;
}

/* POST NAV PREV / NEXT */
.me-post-nav-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
    margin: 40px 0 20px 0;
}
@media (max-width: 640px) {
    .me-post-nav-grid { grid-template-columns: 1fr; }
    .me-author-bio-card { flex-direction: column; text-align: center; }
}
.nav-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 16px 20px;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    gap: 6px;
    transition: all 0.2s;
}
.nav-card:hover {
    border-color: #e31c61;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.06);
}
.nav-card.next-card {
    text-align: right;
}
.nav-dir {
    font-size: 0.75rem;
    font-weight: 700;
    color: #e31c61;
    text-transform: uppercase;
}
.nav-title {
    font-size: 0.95rem;
    font-weight: 700;
    color: #0f172a;
    line-height: 1.4;
}

/* RELATED POSTS */
.me-related-posts-section {
    background: #f1f5f9;
    border-top: 1px solid #e2e8f0;
    padding: 50px 20px;
    margin-top: 50px;
}
.related-inner {
    max-width: 1100px;
    margin: 0 auto;
}
.related-header {
    text-align: center;
    margin-bottom: 35px;
}
.related-eyebrow {
    font-size: 0.75rem;
    font-weight: 800;
    color: #e31c61;
    letter-spacing: 1px;
    display: block;
    margin-bottom: 6px;
}
.related-title {
    font-size: 1.85rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
}
.related-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 22px;
}
@media (max-width: 860px) {
    .related-grid { grid-template-columns: 1fr; }
}
.related-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.2s, box-shadow 0.2s;
}
.related-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 22px rgba(0,0,0,0.08);
}
.rel-thumb-link {
    position: relative;
    display: block;
    height: 170px;
    overflow: hidden;
    background: #0f172a;
}
.rel-thumb {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}
.related-card:hover .rel-thumb {
    transform: scale(1.05);
}
.rel-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background: rgba(15,23,42,0.85);
    color: #fff;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 4px;
    text-transform: uppercase;
}
.rel-body {
    padding: 16px;
    display: flex;
    flex-direction: column;
    flex: 1;
}
.rel-date {
    font-size: 0.78rem;
    color: #64748b;
    margin-bottom: 6px;
}
.rel-heading {
    font-size: 1.05rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 12px 0;
    line-height: 1.35;
    flex: 1;
}
.rel-heading a {
    color: #0f172a;
    text-decoration: none;
    transition: color 0.2s;
}
.rel-heading a:hover {
    color: #e31c61;
}
.rel-read-more {
    font-size: 0.82rem;
    font-weight: 700;
    color: #e31c61;
    text-decoration: none;
}
.rel-read-more:hover {
    text-decoration: underline;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Reading Progress Bar
    const progressBar = document.getElementById('me-reading-progress');
    window.addEventListener('scroll', function() {
        const totalHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        if (totalHeight > 0) {
            const scrollPos = window.scrollY;
            const progress = (scrollPos / totalHeight) * 100;
            if (progressBar) progressBar.style.width = Math.min(100, Math.max(0, progress)) + '%';
        }
    });

    // Copy Link Buttons
    document.querySelectorAll('.me-copy-link-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const url = this.getAttribute('data-url') || window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                const originalHtml = this.innerHTML;
                this.innerHTML = '<i class="fas fa-check"></i>';
                alert('Link copiado para a área de transferência!');
                setTimeout(() => {
                    this.innerHTML = originalHtml;
                }, 2000);
            }).catch(err => {
                console.error('Erro ao copiar link:', err);
            });
        });
    });
});
</script>

<?php
get_footer();
