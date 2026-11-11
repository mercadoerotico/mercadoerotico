<?php
/**
 * Plugin Name: Mercado Erótico - Colunistas & Colunas Editoriais
 * Description: Sistema editorial dos colunistas oficiais do Portal Mercado Erótico.
 * Version: 1.0.0
 */

if (!defined('ABSPATH')) exit;

function mercado_colunistas_get_list() {
    return array(
        array(
            'column_title' => 'Coluna Ká entre Nós',
            'author_name' => 'Karina Brum',
            'role' => 'Psicóloga & Sexóloga Clínica',
            'image' => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2025/04/WhatsApp-Image-2025-04-05-at-14.10.21-256x300.jpeg',
            'bio' => 'Psicóloga e sexóloga com o propósito de desmistificar tabus e preconceitos, abordando demandas sexuais e relacionamentos de forma divertida, científica, sensata e empática.',
            'badge' => '75 Artigos',
            'tag' => 'Comportamento & Emoções',
            'url' => home_url('/author/karina-brum/'),
            'category_url' => home_url('/category/coluna-ka-entre-nos/'),
            'highlight' => 'Solidão masculina, intimidade emocional, relacionamentos contemporâneos e saúde sexual.'
        ),
        array(
            'column_title' => 'Coluna De Pernas pro Ar',
            'author_name' => 'Érica Rambalde',
            'role' => 'Bióloga, Sexóloga & Educadora Sexual',
            'image' => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2026/11/erica_rambalde_oficial_v2.png',
            'bio' => 'Fundadora da Sexy Delícia há duas décadas no mercado de Sexual Wellness. Idealizadora do programa De Pernas pro Ar, voltado à formação de profissionais e desenvolvimento íntimo.',
            'badge' => 'Formação & Saúde',
            'tag' => 'Pompoarismo & Prazer',
            'url' => home_url('/author/erica-rambalde/'),
            'category_url' => home_url('/category/coluna-de-pernas-pro-ar-com-erica-rambalde/'),
            'highlight' => 'Exercícios pélvicos, ginástica íntima, empoderamento sexual e dinâmicas de casal.'
        ),
        array(
            'column_title' => 'Negócios, Mercado & Tendências',
            'author_name' => 'Paula Aguiar',
            'role' => 'Publicitária, Consultora & Autora',
            'image' => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2023/09/pa.png',
            'bio' => 'Ex-presidente da ABEME e pioneira do setor erótico desde o ano 2000. Autora de 28 livros de negócios e idealizadora do prestigiado Prêmio Mercado Erótico.',
            'badge' => '552 Análises',
            'tag' => 'Business & Varejo',
            'url' => home_url('/author/paula-aguiar/'),
            'highlight' => 'E-commerce íntimo, inteligência de compras, gestão comercial e tendências mundiais de feiras.'
        ),
        array(
            'column_title' => 'Radar Editorial & Comunicação',
            'author_name' => 'Julianna Santos',
            'role' => 'Relações Públicas & Esp. em Educação Sexual',
            'image' => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2023/09/IMG_20230414_130925_717-240x300.jpg',
            'bio' => 'Pós-graduada em Educação Sexual pelo ISEXP (FMABC), gestora de conteúdo e assessoria de imprensa especializada no ramo erótico desde 2002. Ex-assessora da Erótika Fair.',
            'badge' => '1.144 Matérias',
            'tag' => 'Jornalismo & Pautas',
            'url' => home_url('/author/julianna-santos/'),
            'highlight' => 'Lançamentos de produtos, pesquisas acadêmicas, eventos corporativos e dados do setor.'
        ),
        array(
            'column_title' => 'Coluna Dona do Próprio Poder',
            'author_name' => 'Marianna Kiss',
            'role' => 'Sexóloga & Terapeuta Tântrica Taoísta',
            'bio' => 'Professora de sexualidade na Formação em Sexcoach Oficial. Em sua coluna, aborda o autoconhecimento, a saúde íntima e a reconexão da mulher com sua energia e soberania pessoal.',
            'image' => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2024/08/marianna-kiss.jpg',
            'badge' => '23 Artigos',
            'tag' => 'Empoderamento Feminino',
            'url' => home_url('/author/marianna-kiss/'),
            'category_url' => home_url('/category/dona-do-proprio-poder/'),
            'highlight' => 'Despertar sensorial, tantra taoísta, autocuidado e liberação de culpas íntimas.'
        ),
        array(
            'column_title' => 'Pergunte para a Especialista',
            'author_name' => 'Alyne Meirelles',
            'role' => 'Mestranda em Sexualidade & Educadora Sexual',
            'image' => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2020/04/WhatsApp-Image-2020-04-07-at-16.51.19-1-300x293.jpeg',
            'bio' => 'Pós-graduada em Terapia Sexual e palestrante das maiores feiras do setor. Responde às dúvidas reais dos leitores com rigor científico, acolhimento e clareza clínica.',
            'badge' => 'Consultoria Íntima',
            'tag' => 'Dúvidas & Terapia',
            'url' => home_url('/author/pergunte-para-a-especialista/'),
            'highlight' => 'Queixas sexuais, uso correto de produtos, relacionamentos e orientação técnica.'
        ),
        array(
            'column_title' => 'Coluna Empresários Sex',
            'author_name' => 'Adriana Braga',
            'role' => 'MBA em Negócios, Startups & Lojista',
            'image' => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2023/08/WhatsApp-Image-2023-08-19-at-13.36.20.jpeg',
            'bio' => 'Coach de Relacionamento e dona da sex shop Queridinhas da Adri há 7 anos. Une visão prática de balcão e gestão estratégica para compartilhar lições de empreendedorismo íntimo.',
            'badge' => '11 Artigos',
            'tag' => 'Empreendedorismo',
            'url' => home_url('/author/adriana-braga/'),
            'category_url' => home_url('/category/coluna-empresarios-sex/'),
            'highlight' => 'Desafios do varejo, experiência do cliente, fluxo de caixa e rotina de sex shop.'
        ),
        array(
            'column_title' => 'Coluna SexAtivar',
            'author_name' => 'SexAtivação Editorial',
            'role' => 'Guia de Prazer & Sexual Wellness',
            'image' => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2026/11/logo_colunista_padrao_v2.jpg',
            'is_logo' => true,
            'bio' => 'Coluna dedicada a explorar novas formas de prazer, testes de cosméticos sensuais, técnicas de estimulação e novidades do universo dos toys com linguagem direta e inclusiva.',
            'badge' => '37 Artigos',
            'tag' => 'Prazer & Toys',
            'url' => home_url('/category/coluna-sexativar/'),
            'highlight' => 'Reviews de produtos, cosméticos sensuais, jogos eróticos e exploração a dois.'
        ),
        array(
            'column_title' => 'Coluna Cartas, Sexo e Diversão',
            'author_name' => 'Equipe Editorial & Correspondentes',
            'role' => 'Crônicas & Vivências Cotidianas',
            'image' => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2026/11/logo_colunista_padrao_v2.jpg',
            'is_logo' => true,
            'bio' => 'Histórias da vida real, crônicas afetivas, debates sobre novos modelos de relação e o lado bem-humorado da sexualidade humana.',
            'badge' => '37 Crônicas',
            'tag' => 'Crônicas & Vivências',
            'url' => home_url('/category/cartas-sexo-diversao/'),
            'highlight' => 'Cartas de leitores, dilemas conjugais, encontros inusitados e diversão adulta.'
        ),
        array(
            'column_title' => 'Coluna IASex (Inteligência & Sextechs)',
            'author_name' => 'Observatório Tecnológico',
            'role' => 'Inovação, IA & Futuro da Intimidade',
            'image' => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2026/11/logo_colunista_padrao_v2.jpg',
            'is_logo' => true,
            'bio' => 'Acompanhamento sistemático das inovações de ponta que estão transformando o bem-estar íntimo: inteligência artificial, realidade virtual, robótica e sextechs globais.',
            'badge' => '57 Relatórios',
            'tag' => 'Tecnologia & Sextech',
            'url' => home_url('/category/iasex/'),
            'highlight' => 'Dispositivos teledildônicos, IA generativa para educação sexual e tendências de inovação.'
        )
    );
}

function mercado_colunistas_shortcode() {
    $columnists = mercado_colunistas_get_list();
    $count_posts = wp_count_posts('post');
    $total_posts_num = !empty($count_posts->publish) ? (int)$count_posts->publish : 2116;
    $total_posts_formatted = number_format($total_posts_num, 0, ',', '.') . '+';

    ob_start();
    ?>
    <div class="me-internal-wrapper me-colunistas-page">
        <!-- Hero Banner -->
        <div class="me-internal-hero">
            <span class="me-internal-badge"><i class="fas fa-feather-alt"></i> VOZES DE AUTORIDADE</span>
            <h1 class="me-internal-title">Nossos Colunistas & Colunas Oficiais</h1>
            <p class="me-internal-subtitle">Especialistas renomados, sexólogos clínicos, pesquisadores e estrategistas de mercado que produzem conteúdo exclusivo com profundidade técnica e responsabilidade.</p>
        </div>

        <!-- Estatísticas das Colunas -->
        <div class="me-stats-grid">
            <div class="me-stat-card">
                <span class="stat-number"><?php echo count($columnists); ?></span>
                <span class="stat-label">Colunas Editoriais Ativas</span>
            </div>
            <div class="me-stat-card">
                <span class="stat-number"><?php echo esc_html($total_posts_formatted); ?></span>
                <span class="stat-label">Artigos & Análises Disponíveis</span>
            </div>
            <div class="me-stat-card">
                <span class="stat-number">Semanal</span>
                <span class="stat-label">Atualizações e Reflexões Inéditas</span>
            </div>
            <div class="me-stat-card">
                <span class="stat-number">100%</span>
                <span class="stat-label">Conteúdo Especializado & Autoral</span>
            </div>
        </div>

        <!-- Grid de Cards de Colunistas -->
        <div class="colunistas-grid">
            <?php foreach ($columnists as $col): ?>
            <div class="colunista-card">
                <div class="colunista-card-header">
                    <span class="col-pill-badge"><?php echo esc_html($col['column_title']); ?></span>
                    <span class="col-count-tag"><?php echo esc_html($col['badge']); ?></span>
                </div>

                <div class="colunista-profile">
                    <div class="col-avatar-wrap">
                        <?php $is_logo = !empty($col['is_logo']) || strpos($col['image'], 'colunista_padrao_logo') !== false; ?>
                        <img src="<?php echo esc_url($col['image']); ?>" alt="<?php echo esc_attr($col['author_name']); ?>" class="col-avatar <?php echo $is_logo ? 'is-logo' : ''; ?>" loading="lazy">
                    </div>
                    <div class="col-profile-info">
                        <span class="col-tag-label"><?php echo esc_html($col['tag']); ?></span>
                        <h3 class="col-author-name"><?php echo esc_html($col['author_name']); ?></h3>
                        <p class="col-role"><?php echo esc_html($col['role']); ?></p>
                    </div>
                </div>

                <div class="col-bio-wrap">
                    <p class="col-bio"><?php echo esc_html($col['bio']); ?></p>
                </div>

                <div class="col-topics">
                    <i class="fas fa-lightbulb"></i>
                    <span><strong>Temas:</strong> <?php echo esc_html($col['highlight']); ?></span>
                </div>

                <div class="col-footer">
                    <a href="<?php echo esc_url($col['url']); ?>" class="btn-read-column">
                        <span>Acessar Coluna & Artigos</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Callout Banner: Direcionamento para Guia de Profissionais -->
        <div class="colunistas-prof-callout">
            <div class="callout-icon">
                <i class="fas fa-user-md"></i>
            </div>
            <div class="callout-content">
                <h3>Busca Atendimento Clínico, Terapia Sexual ou Consultoria Individual?</h3>
                <p>Além dos nossos colunistas, o Portal Mercado Erótico mantém um <strong>Guia Oficial de Profissionais Certificados</strong> em todo o Brasil — com psicólogos, fisioterapeutas pélvicos, sexólogos e consultores disponíveis para agendamento presencial e online.</p>
            </div>
            <div class="callout-action">
                <a href="<?php echo home_url('/profissionais-especialistas-em-sexualidade/'); ?>" class="btn-callout-prof">
                    <i class="fas fa-search"></i> Ver Guia de Profissionais
                </a>
            </div>
        </div>
    </div>

    <style>
    .colunistas-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
        margin-bottom: 50px;
    }
    .colunista-card {
        background: #fff;
        border-radius: 18px;
        border: 1px solid #ebdfee;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        padding: 30px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        position: relative;
    }
    .colunista-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(227, 28, 97, 0.12);
        border-color: #e31c61;
    }
    .colunista-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-bottom: 22px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f3ebf4;
    }
    .col-pill-badge {
        background: linear-gradient(135deg, #1b0c1e, #33102c);
        color: #fff;
        font-size: 0.8rem;
        font-weight: 800;
        padding: 6px 16px;
        border-radius: 20px;
        letter-spacing: 0.5px;
        border: 1px solid rgba(227, 28, 97, 0.4);
    }
    .col-count-tag {
        font-size: 0.78rem;
        font-weight: 700;
        color: #e31c61;
        background: #fdf2f6;
        padding: 4px 12px;
        border-radius: 12px;
    }
    .colunista-profile {
        display: flex;
        gap: 20px;
        align-items: center;
        margin-bottom: 18px;
    }
    .col-avatar-wrap {
        width: 88px;
        height: 88px;
        border-radius: 50%;
        overflow: hidden;
        flex-shrink: 0;
        border: 3px solid #e31c61;
        box-shadow: 0 4px 15px rgba(227, 28, 97, 0.2);
        background: #f8f5f8;
    }
    .col-avatar {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .col-avatar.is-logo {
        object-fit: contain !important;
        background: #ffffff !important;
        padding: 12px !important;
    }
    .col-tag-label {
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        color: #9c1543;
        letter-spacing: 0.8px;
        display: block;
        margin-bottom: 4px;
    }
    .col-author-name {
        font-size: 1.35rem;
        font-weight: 800;
        color: #1a0f1d;
        margin: 0 0 4px;
        line-height: 1.25;
    }
    .col-role {
        font-size: 0.86rem;
        font-weight: 600;
        color: #635766;
        margin: 0;
        line-height: 1.4;
    }
    .col-bio-wrap {
        margin-bottom: 16px;
        flex-grow: 1;
    }
    .col-bio {
        font-size: 0.92rem;
        color: #4a3e4d;
        line-height: 1.65;
        margin: 0;
    }
    .col-topics {
        background: #faf8fa;
        border-left: 3px solid #e31c61;
        border-radius: 0 8px 8px 0;
        padding: 10px 14px;
        font-size: 0.83rem;
        color: #554857;
        margin-bottom: 22px;
        display: flex;
        align-items: flex-start;
        gap: 8px;
        line-height: 1.5;
    }
    .col-topics i {
        color: #e31c61;
        margin-top: 2px;
    }
    .col-footer {
        margin-top: auto;
    }
    .btn-read-column {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: linear-gradient(135deg, #1b0c1e, #2d0e26);
        color: #fff !important;
        padding: 12px 22px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.25s ease;
        border: 1px solid rgba(227, 28, 97, 0.3);
    }
    .btn-read-column:hover {
        background: #e31c61;
        border-color: #e31c61;
        color: #fff !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(227, 28, 97, 0.35);
    }
    .btn-read-column i {
        transition: transform 0.2s ease;
    }
    .btn-read-column:hover i {
        transform: translateX(4px);
    }

    /* Callout Banner Guia de Profissionais */
    .colunistas-prof-callout {
        background: linear-gradient(135deg, #120916 0%, #290d23 100%);
        border-radius: 18px;
        padding: 40px;
        color: #fff;
        border: 1px solid rgba(227, 28, 97, 0.3);
        display: flex;
        align-items: center;
        gap: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    .callout-icon {
        flex: 0 0 65px;
        height: 65px;
        border-radius: 18px;
        background: #e31c61;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        box-shadow: 0 6px 18px rgba(227,28,97,0.35);
    }
    .callout-content {
        flex-grow: 1;
    }
    .callout-content h3 {
        color: #fff !important;
        font-size: 1.35rem;
        font-weight: 800;
        margin: 0 0 8px;
    }
    .callout-content p {
        color: #e1d3e3;
        font-size: 0.94rem;
        line-height: 1.6;
        margin: 0;
    }
    .btn-callout-prof {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #e31c61;
        color: #fff !important;
        padding: 13px 26px;
        border-radius: 30px;
        font-weight: 800;
        font-size: 0.92rem;
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.2s;
        box-shadow: 0 6px 20px rgba(227, 28, 97, 0.4);
    }
    .btn-callout-prof:hover {
        background: #b5144b;
        transform: translateY(-2px);
    }

    @media (max-width: 991px) {
        .colunistas-grid {
            grid-template-columns: 1fr;
        }
        .colunistas-prof-callout {
            flex-direction: column;
            text-align: center;
        }
        .callout-icon {
            margin: 0 auto;
        }
        .btn-callout-prof {
            width: 100%;
            justify-content: center;
        }
    }
    @media (max-width: 576px) {
        .colunista-card {
            padding: 22px 18px;
        }
        .colunista-profile {
            flex-direction: column;
            text-align: center;
        }
        .col-avatar-wrap {
            margin: 0 auto;
        }
    }
    </style>
    <?php
    return ob_get_clean();
}
add_shortcode('mercado_colunistas', 'mercado_colunistas_shortcode');
