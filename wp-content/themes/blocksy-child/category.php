<?php
/**
 * Custom Editorial Category & Columns Archive Template
 * Blocksy Child - Portal Mercado Erótico
 */

get_header();

$cat = get_queried_object();
$cat_id = $cat->term_id ?? 0;
$cat_name = $cat->name ?? 'Categoria';
$cat_slug = $cat->slug ?? '';
$cat_desc = category_description($cat_id);
$post_count = $cat->count ?? 0;

// 1. Tentar mapear com a lista de colunistas oficiais
$col_data = null;
if (function_exists('mercado_colunistas_get_list')) {
    $col_list = mercado_colunistas_get_list();
    foreach ($col_list as $c) {
        if (!empty($c['category_url']) && strpos($c['category_url'], '/' . $cat_slug . '/') !== false) {
            $col_data = $c;
            break;
        }
        if (!empty($c['url']) && strpos($c['url'], '/' . $cat_slug . '/') !== false) {
            $col_data = $c;
            break;
        }
        if (strcasecmp(trim($c['column_title']), trim($cat_name)) === 0) {
            $col_data = $c;
            break;
        }
    }
}

// 2. Colunas conhecidas e institucionais adicionais
if (!$col_data) {
    $known_columns = array(
        'coluna-sexativar' => array(
            'column_title' => 'Coluna SexAtivar',
            'author_name'  => 'SexAtivação Editorial',
            'role'         => 'Guia de Prazer & Sexual Wellness',
            'image'        => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2026/11/logo_colunista_padrao_v2.jpg',
            'bio'          => 'Coluna dedicada a explorar novas formas de prazer, testes de cosméticos sensuais, técnicas de estimulação e novidades do universo dos toys com linguagem direta e inclusiva.',
            'tag'          => 'Prazer & Toys',
            'highlight'    => 'Reviews de produtos, cosméticos sensuais, jogos eróticos e exploração a dois.'
        ),
        'cartas-sexo-diversao' => array(
            'column_title' => 'Coluna Cartas, Sexo e Diversão',
            'author_name'  => 'Equipe Editorial & Correspondentes',
            'role'         => 'Crônicas & Vivências Cotidianas',
            'image'        => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2026/11/logo_colunista_padrao_v2.jpg',
            'bio'          => 'Histórias da vida real, crônicas afetivas, debates sobre novos modelos de relação e o lado bem-humorado da sexualidade humana.',
            'tag'          => 'Crônicas & Vivências',
            'highlight'    => 'Cartas de leitores, dilemas conjugais, encontros inusitados e diversão adulta.'
        ),
        'iasex' => array(
            'column_title' => 'Coluna IASex (Inteligência & Sextechs)',
            'author_name'  => 'Observatório Tecnológico',
            'role'         => 'Inovação, IA & Futuro da Intimidade',
            'image'        => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2026/11/logo_colunista_padrao_v2.jpg',
            'bio'          => 'Acompanhamento sistemático das inovações de ponta que estão transformando o bem-estar íntimo: inteligência artificial, realidade virtual, robótica e sextechs globais.',
            'tag'          => 'Tecnologia & Sextech',
            'highlight'    => 'Dispositivos teledildônicos, IA generativa para educação sexual e tendências de inovação.'
        ),
        'coluna-guia-de-sexshop' => array(
            'column_title' => 'Coluna Guia de Sexshop',
            'author_name'  => 'Redação Guia de Sexshop',
            'role'         => 'Varejo, E-commerce & Tendências Comerciais',
            'image'        => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2026/11/logo_colunista_padrao_v2.jpg',
            'bio'          => 'Análises de mercado, novidades das principais marcas e fornecedores, comportamento de compra dos clientes e estratégias de sucesso para sex shops físicas e virtuais.',
            'tag'          => 'Varejo & Mercado',
            'highlight'    => 'Gestão de estoque, experiência do cliente, vendas online e feiras setoriais.'
        ),
        'coluna-radar-livexa' => array(
            'column_title' => 'Coluna Radar Livexa',
            'author_name'  => 'Livexa Editorial',
            'role'         => 'Inovação & Desenvolvimento de Cosméticos Sensuais',
            'image'        => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2026/11/logo_colunista_padrao_v2.jpg',
            'bio'          => 'Espaço voltado às novidades em cosméticos corporais e íntimos, tendências sensoriais, matérias-primas nobres e mercado de bem-estar.',
            'tag'          => 'Cosméticos & Inovação',
            'highlight'    => 'Cosmética funcional, formulações atóxicas, aromas e tendências de beleza íntima.'
        ),
        'sexo-comida' => array(
            'column_title' => 'Coluna Sexo & Comida',
            'author_name'  => 'Curadoria Sensorial',
            'role'         => 'Gastronomia Sensorial & Experiências Afetivas',
            'image'        => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2026/11/logo_colunista_padrao_v2.jpg',
            'bio'          => 'A arte dos sentidos: como sabores, texturas, aromas e alimentos estimulantes se conectam com a intimidade, o prazer e a imaginação erótica.',
            'tag'          => 'Gastronomia & Sensualidade',
            'highlight'    => 'Afrodisíacos, receitas a dois, jantares sensoriais e estímulos gustativos.'
        ),
        'sexo-na-pratica' => array(
            'column_title' => 'Coluna Sexo na Prática',
            'author_name'  => 'Equipe Editorial & Especialistas',
            'role'         => 'Guia Prático, Comunicação & Desmistificação',
            'image'        => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2026/11/logo_colunista_padrao_v2.jpg',
            'bio'          => 'Orientações claras, acessíveis e diretas para transformar a vivência sexual em uma jornada de confiança, prazer mútuo e autoconhecimento sem julgamentos.',
            'tag'          => 'Práticas & Intimidade',
            'highlight'    => 'Dicas reais, comunicação de casal, quebra de tabus e uso seguro de produtos.'
        ),
        'sexo-e-arte' => array(
            'column_title' => 'Coluna Sexo e Arte',
            'author_name'  => 'Gisele Santos',
            'role'         => 'Arte Erótica, Literatura & Expressão Cultural',
            'image'        => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2026/11/logo_colunista_padrao_v2.jpg',
            'bio'          => 'O erotismo através das artes visuais, literatura sensual, cinema, poesia e manifestações culturais que celebram a paixão humana e a beleza do corpo.',
            'tag'          => 'Cultura & Arte',
            'highlight'    => 'Pintura, fotografia, literatura erótica clássica e contemporânea.'
        )
    );
    if (isset($known_columns[$cat_slug])) {
        $col_data = $known_columns[$cat_slug];
    }
}

$is_column = !empty($col_data) || strpos($cat_slug, 'coluna') !== false;

// Variáveis de exibição para a Coluna ou Editoria Geral
$display_title = !empty($col_data['column_title']) ? $col_data['column_title'] : $cat_name;
$display_role = !empty($col_data['role']) ? $col_data['role'] : ($is_column ? 'Coluna Editorial Especializada' : 'Editoria Oficial do Portal');
$display_author = !empty($col_data['author_name']) ? $col_data['author_name'] : 'Equipe Editorial';
$display_image = !empty($col_data['image']) ? $col_data['image'] : 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2026/11/logo_colunista_padrao_v2.jpg';
$display_tag = !empty($col_data['tag']) ? $col_data['tag'] : ($is_column ? 'Coluna Editorial' : 'Editoria Temática');
$display_highlight = !empty($col_data['highlight']) ? $col_data['highlight'] : '';
$display_bio = !empty($col_data['bio']) ? $col_data['bio'] : (
    !empty($cat_desc) ? strip_tags($cat_desc) : ($is_column ? 'Acompanhe as reflexões, análises técnicas e reportagens exclusivas desta coluna editorial no Portal Mercado Erótico.' : 'Acompanhe a cobertura jornalística, pesquisas e artigos exclusivos sobre ' . esc_html($cat_name) . ' no Portal Mercado Erótico.')
);

// Link de autor individual, se houver
$author_profile_url = !empty($col_data['url']) && strpos($col_data['url'], '/author/') !== false ? $col_data['url'] : '';
?>

<main id="main" class="site-main me-author-page-main me-category-page-main">
    <div class="me-author-container">
        
        <!-- BREADCRUMBS -->
        <nav class="me-author-breadcrumbs" aria-label="Navegação estrutural">
            <a href="<?php echo esc_url(home_url('/')); ?>"><i class="fas fa-home"></i> Início</a>
            <span class="sep"><i class="fas fa-chevron-right"></i></span>
            <?php if ($is_column): ?>
                <a href="<?php echo esc_url(home_url('/colunistas/')); ?>">Colunistas &amp; Colunas</a>
            <?php else: ?>
                <a href="<?php echo esc_url(home_url('/')); ?>">Editorias</a>
            <?php endif; ?>
            <span class="sep"><i class="fas fa-chevron-right"></i></span>
            <span class="current"><?php echo esc_html($display_title); ?></span>
        </nav>

        <!-- TOP HERO EDITORIAL CARD (SUBSTITUI O SIMPLES 'CATEGORIA') -->
        <header class="me-author-hero-card me-column-hero-card">
            <div class="author-hero-inner">
                <div class="author-avatar-col">
                    <div class="avatar-ring column-ring">
                        <img src="<?php echo esc_url($display_image); ?>" alt="<?php echo esc_attr($display_title); ?>" class="author-hero-img column-hero-img" loading="eager">
                    </div>
                    <?php if ($is_column): ?>
                        <span class="author-status-badge column-status-badge">
                            <i class="fas fa-feather-alt"></i> Coluna Oficial
                        </span>
                    <?php else: ?>
                        <span class="author-status-badge">
                            <i class="fas fa-check-circle"></i> Editoria Verificada
                        </span>
                    <?php endif; ?>
                </div>

                <div class="author-info-col">
                    <div class="author-eyebrow-wrap">
                        <span class="author-eyebrow">
                            <i class="fas fa-newspaper"></i> <?php echo $is_column ? 'COLUNA EDITORIAL' : 'EDITORIA OFICIAL'; ?>
                        </span>
                        <?php if (!empty($display_tag)): ?>
                            <span class="author-tag-pill"><?php echo esc_html($display_tag); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- TÍTULO LIMPO E IMPONENTE (SEM A PALAVRA FRIA 'CATEGORIA') -->
                    <h1 class="author-hero-name column-hero-title"><?php echo esc_html($display_title); ?></h1>
                    
                    <div class="author-hero-role">
                        <i class="fas fa-award"></i> <?php echo esc_html($display_role); ?>
                        <span class="author-curator-sep">•</span>
                        <span class="author-curator-name"><i class="fas fa-user-edit"></i> <?php echo esc_html($display_author); ?></span>
                    </div>

                    <!-- METRICS BAR -->
                    <div class="author-metrics-bar">
                        <div class="metric-pill">
                            <i class="fas fa-layer-group"></i>
                            <strong><?php echo number_format_i18n($post_count); ?></strong>
                            <span><?php echo $post_count == 1 ? 'Publicação' : 'Artigos Publicados'; ?></span>
                        </div>
                        <div class="metric-pill">
                            <i class="fas fa-shield-alt"></i>
                            <span>Editoria</span>
                            <strong>Portal Mercado Erótico</strong>
                        </div>
                        <div class="metric-pill">
                            <i class="fas fa-sync-alt"></i>
                            <span>Atualização</span>
                            <strong>Conteúdo Contínuo</strong>
                        </div>
                    </div>

                    <!-- BIO / MANIFESTO DA COLUNA -->
                    <div class="author-hero-bio column-hero-bio">
                        <?php echo esc_html($display_bio); ?>
                    </div>

                    <!-- HIGHLIGHT / TEMAS DE FOCO -->
                    <?php if (!empty($display_highlight)): ?>
                        <div class="author-focus-box">
                            <strong><i class="fas fa-bullseye"></i> Temas em Foco:</strong>
                            <span><?php echo esc_html($display_highlight); ?></span>
                        </div>
                    <?php endif; ?>

                    <!-- AÇÕES E LINKS DA COLUNA -->
                    <div class="author-social-row column-actions-row">
                        <a href="<?php echo esc_url(home_url('/colunistas/')); ?>" class="column-btn-all">
                            <i class="fas fa-th-large"></i> Ver Todas as Colunas &amp; Colunistas
                        </a>
                        <?php if (!empty($author_profile_url)): ?>
                            <a href="<?php echo esc_url($author_profile_url); ?>" class="column-btn-author">
                                <i class="fas fa-user-circle"></i> Ver Perfil Completo do Autor
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
                    <span class="sub-label"><?php echo $is_column ? 'ACERVO DA COLUNA' : 'ARQUIVO DE NOTÍCIAS'; ?></span>
                    <h2 class="section-title">Todas as Matérias &amp; Análises Publicadas</h2>
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
                        $primary_cat = !empty($cats) ? $cats[0]->name : $display_title;
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
                    <p>Esta coluna ainda não possui publicações ativas.</p>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="button button-primary">Voltar para a Página Inicial</a>
                </div>
            <?php endif; ?>
        </section>
    </div>
</main>

<style>
/* ==========================================================================
   EDITORIAL COLUMN & CATEGORY HERO STYLING - PORTAL MERCADO ERÓTICO
   ========================================================================== */
.me-category-page-main {
    background: #f8fafc;
    padding: 30px 20px 80px;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    color: #1e293b;
}
.me-column-hero-card {
    background: #ffffff;
    border-radius: 18px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
    padding: 36px 40px;
    margin-bottom: 40px;
    position: relative;
    overflow: hidden;
}
.me-column-hero-card::before {
    content: "";
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 5px;
    background: linear-gradient(90deg, #e31c61 0%, #7928ca 50%, #1e1b4b 100%);
}
.column-ring {
    background: linear-gradient(135deg, #e31c61 0%, #7928ca 100%) !important;
    box-shadow: 0 8px 25px rgba(227, 28, 97, 0.25) !important;
}
.column-status-badge {
    background: #fdf2f8 !important;
    color: #be185d !important;
    border-color: #fbcfe8 !important;
}
.column-hero-title {
    font-size: 2.1rem !important;
    font-weight: 800 !important;
    color: #0f172a !important;
    margin: 0 0 10px 0 !important;
    letter-spacing: -0.5px !important;
    line-height: 1.25 !important;
}
.author-curator-sep {
    color: #cbd5e1;
    margin: 0 4px;
}
.author-curator-name {
    color: #475569;
    font-weight: 600;
}
.column-hero-bio {
    font-size: 1.02rem !important;
    line-height: 1.65 !important;
    color: #334155 !important;
    margin-bottom: 20px !important;
}
.column-actions-row {
    display: flex;
    gap: 12px;
    margin-top: 18px;
    flex-wrap: wrap;
}
.column-btn-all {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #f1f5f9;
    color: #334155 !important;
    padding: 8px 18px;
    border-radius: 8px;
    font-size: 0.82rem;
    font-weight: 700;
    text-decoration: none !important;
    border: 1px solid #cbd5e1;
    transition: all 0.2s;
}
.column-btn-all:hover {
    background: #e2e8f0;
    color: #0f172a !important;
    transform: translateY(-1px);
}
.column-btn-author {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #e31c61 0%, #c0134f 100%);
    color: #fff !important;
    padding: 8px 18px;
    border-radius: 8px;
    font-size: 0.82rem;
    font-weight: 700;
    text-decoration: none !important;
    box-shadow: 0 4px 12px rgba(227, 28, 97, 0.25);
    transition: all 0.2s;
}
.column-btn-author:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(227, 28, 97, 0.4);
    color: #fff !important;
}

/* Grid & Cards */
.me-author-articles-section {
    margin-top: 10px;
}
.articles-section-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 28px;
    padding-bottom: 16px;
    border-bottom: 2px solid #e2e8f0;
    flex-wrap: wrap;
    gap: 16px;
}
.header-titles .sub-label {
    font-size: 0.72rem;
    font-weight: 800;
    color: #e31c61;
    letter-spacing: 1.2px;
    display: block;
    margin-bottom: 4px;
}
.header-titles .section-title {
    font-size: 1.6rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
    letter-spacing: -0.5px;
}
.header-count-badge {
    background: #fff;
    border: 1px solid #e2e8f0;
    padding: 8px 16px;
    border-radius: 30px;
    font-size: 0.82rem;
    color: #64748b;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.header-count-badge strong {
    color: #e31c61;
}

/* CARDS GRID */
.me-author-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 26px;
    margin-bottom: 40px;
}
.me-author-card {
    background: #ffffff;
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
    display: flex;
    flex-direction: column;
    transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
}
.me-author-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08);
    border-color: #cbd5e1;
}
.card-media-wrap {
    position: relative;
    width: 100%;
    aspect-ratio: 16 / 9;
    overflow: hidden;
    background: #0f172a;
}
.card-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.35s ease;
}
.me-author-card:hover .card-img {
    transform: scale(1.05);
}
.card-cat-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: rgba(15, 23, 42, 0.85);
    color: #fff;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 6px;
    backdrop-filter: blur(4px);
    text-decoration: none !important;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: background 0.2s;
}
.card-cat-badge:hover {
    background: #e31c61;
    color: #fff !important;
}
.card-body {
    padding: 20px;
    display: flex;
    flex-direction: column;
    flex: 1;
}
.card-meta-top {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.76rem;
    color: #94a3b8;
    margin-bottom: 10px;
}
.meta-dot {
    color: #cbd5e1;
}
.card-title {
    font-size: 1.15rem;
    font-weight: 700;
    line-height: 1.4;
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
    font-size: 0.88rem;
    color: #64748b;
    line-height: 1.55;
    margin: 0 0 16px 0;
    flex: 1;
}
.card-footer {
    margin-top: auto;
    padding-top: 14px;
    border-top: 1px solid #f1f5f9;
}
.btn-read-more {
    font-size: 0.82rem;
    font-weight: 700;
    color: #e31c61;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: gap 0.2s, color 0.2s;
}
.btn-read-more:hover {
    color: #b8144b;
    gap: 10px;
}

/* PAGINATION */
.me-author-pagination {
    margin: 40px 0 20px;
    display: flex;
    justify-content: center;
}
.me-author-pagination ul.page-numbers {
    display: flex;
    align-items: center;
    gap: 6px;
    list-style: none;
    padding: 0;
    margin: 0;
    flex-wrap: wrap;
}
.me-author-pagination .page-numbers {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    height: 40px;
    padding: 0 14px;
    border-radius: 8px;
    background: #fff;
    border: 1px solid #cbd5e1;
    color: #334155;
    font-size: 0.88rem;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s;
}
.me-author-pagination .page-numbers:hover {
    background: #f1f5f9;
    border-color: #94a3b8;
    color: #0f172a;
}
.me-author-pagination .page-numbers.current {
    background: #e31c61;
    border-color: #e31c61;
    color: #fff;
}

/* Empty State */
.me-no-articles-card {
    text-align: center;
    padding: 60px 20px;
    background: #fff;
    border-radius: 14px;
    border: 1px dashed #cbd5e1;
    color: #64748b;
}
.me-no-articles-card i {
    font-size: 3rem;
    color: #cbd5e1;
    margin-bottom: 16px;
}
.me-no-articles-card h3 {
    font-size: 1.3rem;
    color: #0f172a;
    margin-bottom: 8px;
}

/* Responsive */
@media (max-width: 768px) {
    .author-hero-inner {
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 20px;
    }
    .author-eyebrow-wrap,
    .author-metrics-bar,
    .column-actions-row {
        justify-content: center;
    }
    .column-hero-title {
        font-size: 1.6rem !important;
    }
    .me-column-hero-card {
        padding: 24px 20px;
    }
    .articles-section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
}
</style>

<?php get_footer(); ?>
