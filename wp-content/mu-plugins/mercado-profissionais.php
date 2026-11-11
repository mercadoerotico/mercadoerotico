<?php
/**
 * Plugin Name: Mercado Erótico - Guia de Profissionais
 * Description: Diretório moderno de profissionais, terapeutas e sexólogos especializados.
 * Version: 1.0.0
 */

if (!defined('ABSPATH')) exit;

function mercado_profissionais_shortcode() {
    $professionals = array(
        array(
            'name' => 'Alyne Meirelles',
            'specialty' => 'Sexóloga & Educadora Sexual',
            'image' => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2020/04/WhatsApp-Image-2020-04-07-at-16.51.19-1-300x293.jpeg',
            'bio' => 'Mestranda em Sexualidade Humana, Pós-graduada em Terapia Sexual e palestrante das principais feiras do setor. Presta consultoria a sex shops, consultores e atendimento clínico individual.',
            'instagram' => 'https://www.instagram.com/alyne.meirelles',
            'insta_label' => '@alyne.meirelles',
            'email' => 'falecom@alynemeirelles.com.br'
        ),
        array(
            'name' => 'Andreia Salustiano',
            'specialty' => 'Pompoarismo & Terapia Breve (PNL)',
            'image' => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2020/04/IMG-20200403-WA0028-293x300.jpg',
            'bio' => 'Ajuda mulheres a desenvolverem prazer, libido e autoestima através de (Re)Educação Sexual, Ginástica Íntima e PNL. Atendimentos com sigilo, ética e sensibilidade.',
            'instagram' => 'https://www.instagram.com/andreia_mulherliderdesi',
            'insta_label' => '@andreia_mulherliderdesi'
        ),
        array(
            'name' => 'Diego Zahori (Diego Sampaio)',
            'specialty' => 'Psicólogo & Terapeuta Tântrico',
            'image' => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2020/04/WhatsApp-Image-2020-03-22-at-15.36.16-300x300.jpeg',
            'bio' => 'Psicólogo com pós-graduação em Sexualidade Humana Aplicada e Terapia Tântrica. Atua auxiliando pessoas a superarem bloqueios e julgamentos para vivenciarem relações plenas e saudáveis.',
            'instagram' => 'https://www.instagram.com/psi_diegosampaio',
            'insta_label' => '@psi_diegosampaio',
            'whatsapp' => '5519978236302'
        ),
        array(
            'name' => 'Fátima Mourah',
            'specialty' => 'Eventos Femininos & Consultoria Sensual',
            'image' => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2020/04/20952916_1478934835506474_442912303442649816_n.jpg',
            'bio' => 'Pioneira em palestras e encontros femininos, fundadora da Chá de Lingerie Oficial. Especialista em empoderamento, dinâmicas de casal e eventos sensuais corporativos.',
            'instagram' => 'https://www.instagram.com/chadelingerie_oficial',
            'insta_label' => '@chadelingerie_oficial',
            'whatsapp' => '5511993294324'
        ),
        array(
            'name' => 'Karina Brum',
            'specialty' => 'Psicóloga & Sexóloga Clínica',
            'image' => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2025/04/WhatsApp-Image-2025-04-05-at-14.10.21-256x300.jpeg',
            'bio' => 'Atendimento psicológico e sexológico com foco em inteligência emocional, resolução de conflitos conjugais e desmistificação do prazer feminino.',
            'instagram' => 'https://www.instagram.com/karinabrumoficial/',
            'insta_label' => '@karinabrumoficial',
            'whatsapp' => '5511964920033'
        ),
        array(
            'name' => 'Kátia Arruda',
            'specialty' => 'Especialista em Sexualidade (Abrasex)',
            'image' => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2020/04/WhatsApp-Image-2020-12-07-at-12.51.34-225x300.jpeg',
            'bio' => 'Filiada à Abrasex, atua no desenvolvimento pessoal e conjugal com workshops, cursos e atendimentos para autoconhecimento íntimo e quebra de tabus.',
            'instagram' => 'https://www.instagram.com/katiaarrudaoficial',
            'insta_label' => '@katiaarrudaoficial',
            'whatsapp' => '5561986531333'
        ),
                array(
            'name' => 'Neusa Pandolfo',
            'specialty' => 'Educadora Sexual & Palestrante',
            'image' => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2026/11/neusa_pandolfo_avatar.webp',
            'bio' => 'Publicitária formada pela Unisinos e pós-graduada em Educação Sexual pela Unisal-SP. Palestrante e consultora de renome nacional com passagens pela TV (Amor & Sexo na Globo), especialista em autoestima, intimidade, comunicação de casais e quebra de tabus.',
            'instagram' => 'https://www.instagram.com/neusapandolfo/',
            'insta_label' => '@neusapandolfo',
            'website' => 'https://neusapandolfo.com.br/',
            'whatsapp' => '5551999690009'
        ),
array(
            'name' => 'Lucimara Siqueira (Lu Pompoar)',
            'specialty' => 'Fisioterapia Pélvica & Pompoarismo',
            'image' => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2021/06/lu-pompoar.jpg',
            'bio' => 'Referência internacional em pompoarismo e ginástica íntima. Pós-graduada em Terapia Sexual e Saúde da Mulher, criadora de método exclusivo com milhares de alunas formadas.',
            'instagram' => 'https://www.instagram.com/lupompoar/',
            'insta_label' => '@lupompoar',
            'whatsapp' => '5511986368294'
        ),
        array(
            'name' => 'Pablo Cruz (Pablito)',
            'specialty' => 'Expressão Corporal & Stiletto Dance',
            'image' => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2021/06/WhatsApp-Image-2021-06-19-at-15.45.04-1024x1024.jpeg',
            'bio' => 'Bailarino profissional e professor de dança no salto (Stiletto) e jazz musical. Conduz vivências corporais voltadas para sensualidade, postura e autoconfiança.',
            'instagram' => 'https://www.instagram.com/pablituou',
            'insta_label' => '@pablituou',
            'whatsapp' => '5521968298282'
        ),
        array(
            'name' => 'Rani Muniz',
            'specialty' => 'Sexóloga Humana & Terapia Sexual',
            'image' => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2024/06/sXZpwjyQR0CjItUIVuBX_N66CQpWT7bFQec09.webp',
            'bio' => 'Pós-graduada em Sexologia Humana e Terapia Sexual. Dedica-se a desmistificar a sexualidade com leveza, embasamento científico e respeito à diversidade.',
            'instagram' => 'https://www.instagram.com/rani.muniz',
            'insta_label' => '@rani.muniz',
            'whatsapp' => '5521970204899'
        ),
        array(
            'name' => 'Thiago Souza',
            'specialty' => 'Personal Dancer & Sexy Dance',
            'image' => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2020/04/thiago-souza-personal-dancer-quarentena.png',
            'bio' => 'Criador de metodologia de dança sensual voltada para mulheres reais. Ensina a liberar a sensualidade natural e elevar a autoestima através da dança e do movimento.',
            'instagram' => 'https://www.instagram.com/thiagosouza_academy/',
            'insta_label' => '@thiagosouza_academy',
            'whatsapp' => '5521966898787'
        ),
        array(
            'name' => 'Dra. Vivian Santana',
            'specialty' => 'Fisioterapeuta Pélvica & Menopausa',
            'image' => 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2021/07/WhatsApp-Image-2021-07-10-at-19.32.06.jpeg',
            'bio' => 'Especialista em reabilitação do assoalho pélvico e sexualidade feminina há mais de 10 anos. Conscientiza mulheres sobre climatério, menopausa e prevenção de disfunções sexuais.',
            'instagram' => 'https://www.instagram.com/dra_vivian_santana',
            'insta_label' => '@dra_vivian_santana',
            'phone' => '(11) 4723-8590'
        )
    );

    ob_start();
    ?>
    <div class="prof-wrapper">
        <div class="prof-hero">
            <div class="prof-badge">★ GUIA DE ESPECIALISTAS & SAÚDE ÍNTIMA</div>
            <h1 class="prof-title">Profissionais Especialistas em Sexualidade</h1>
            <p class="prof-subtitle">Conheça terapeutas sexuais, psicólogos, fisioterapeutas pélvicos e educadores corporais de referência para atendimentos, consultorias e palestras.</p>
            
            <div class="prof-stats-bar">
                <span><i class="fas fa-user-check"></i> Especialistas Certificados</span>
                <span>•</span>
                <span><i class="fas fa-lock"></i> Ética & Sigilo Profissional</span>
                <span>•</span>
                <span><i class="fas fa-globe-americas"></i> Atendimento Presencial & Online</span>
            </div>
        </div>

        <div class="prof-grid">
            <?php foreach ($professionals as $p): ?>
                <div class="prof-card">
                    <div class="prof-card-top">
                        <div class="prof-avatar-wrap">
                            <img src="<?php echo esc_url($p['image']); ?>" alt="<?php echo esc_attr($p['name']); ?>" class="prof-avatar" loading="lazy">
                        </div>
                        <span class="prof-specialty-badge"><?php echo esc_html($p['specialty']); ?></span>
                        <h3 class="prof-name"><?php echo esc_html($p['name']); ?></h3>
                    </div>

                    <div class="prof-card-body">
                        <p class="prof-bio"><?php echo esc_html($p['bio']); ?></p>
                    </div>

                    <div class="prof-card-footer">
                        <?php if (!empty($p['instagram'])): ?>
                            <a href="<?php echo esc_url($p['instagram']); ?>" target="_blank" rel="noopener noreferrer" class="btn-prof-insta">
                                <i class="fab fa-instagram"></i> <?php echo esc_html($p['insta_label']); ?>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($p['website'])): ?>
                            <a href="<?php echo esc_url($p['website']); ?>" target="_blank" rel="noopener noreferrer" class="btn-prof-web" title="Visitar Site Oficial">
                                <i class="fas fa-globe"></i>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($p['whatsapp'])): ?>
                            <a href="https://api.whatsapp.com/send?phone=<?php echo esc_attr($p['whatsapp']); ?>&text=Ol%C3%A1%2C+encontrei+seu+perfil+no+Portal+Mercado+Er%C3%B3tico" target="_blank" rel="noopener" class="btn-prof-wpp" title="Conversar no WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        <?php elseif (!empty($p['phone'])): ?>
                            <a href="tel:<?php echo esc_attr($p['phone']); ?>" class="btn-prof-wpp" title="Ligar">
                                <i class="fas fa-phone"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <style>
    .prof-wrapper {
        max-width: 1240px;
        margin: 0 auto;
        padding: 10px 20px 80px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }
    .prof-hero {
        background: radial-gradient(circle at 50% 30%, #1f1122 0%, #0d0612 100%);
        border-radius: 20px;
        padding: 50px 30px;
        text-align: center;
        color: #fff;
        margin-bottom: 45px;
        border: 1px solid rgba(227, 28, 97, 0.25);
        box-shadow: 0 15px 35px rgba(0,0,0,0.25);
    }
    .prof-badge {
        display: inline-block;
        background: linear-gradient(135deg, #e31c61, #9c1543);
        color: #fff;
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 1.5px;
        padding: 5px 16px;
        border-radius: 30px;
        margin-bottom: 15px;
    }
    .prof-title {
        font-size: 2.4rem;
        font-weight: 900;
        color: #fff;
        margin: 0 0 12px;
        line-height: 1.25;
    }
    .prof-subtitle {
        font-size: 1.1rem;
        color: #d1c7d4;
        max-width: 750px;
        margin: 0 auto 25px;
        line-height: 1.6;
    }
    .prof-stats-bar {
        display: flex;
        justify-content: center;
        gap: 20px;
        font-size: 0.88rem;
        color: #e31c61;
        font-weight: 600;
        flex-wrap: wrap;
    }
    .prof-stats-bar span i { margin-right: 6px; }
    .prof-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 28px;
    }
    .prof-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #eaeaea;
        box-shadow: 0 6px 20px rgba(0,0,0,0.04);
        display: flex;
        flex-direction: column;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        padding: 30px 24px 24px;
        text-align: center;
    }
    .prof-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 14px 30px rgba(0,0,0,0.1);
        border-color: #ddd;
    }
    .prof-avatar-wrap {
        width: 110px;
        height: 110px;
        margin: 0 auto 16px;
        border-radius: 50%;
        overflow: hidden;
        border: 4px solid #fff;
        box-shadow: 0 6px 18px rgba(227, 28, 97, 0.25);
        background: #f0f0f5;
    }
    .prof-avatar {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .prof-specialty-badge {
        display: inline-block;
        background: #fdf2f4;
        color: #e31c61;
        font-size: 0.75rem;
        font-weight: 800;
        padding: 4px 12px;
        border-radius: 20px;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .prof-name {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1a1a1a;
        margin: 0 0 14px;
        line-height: 1.3;
    }
    .prof-bio {
        font-size: 0.9rem;
        color: #666;
        line-height: 1.6;
        margin: 0 0 20px;
        flex-grow: 1;
        text-align: left;
    }
    .prof-card-footer {
        display: flex;
        align-items: center;
        gap: 10px;
        border-top: 1px solid #f0f0f0;
        padding-top: 18px;
        margin-top: auto;
    }
    .btn-prof-insta {
        flex-grow: 1;
        background: #f8f8fb;
        color: #333;
        border: 1px solid #e2e2ec;
        padding: 9px 14px;
        border-radius: 25px;
        font-size: 0.85rem;
        font-weight: 700;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
    }
    .btn-prof-insta:hover {
        background: #e31c61;
        color: #fff;
        border-color: #e31c61;
    }
        .btn-prof-web {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #2563eb;
        color: #fff !important;
        display: flex;
        justify-content: center;
        align-items: center;
        text-decoration: none !important;
        font-size: 1rem;
        flex-shrink: 0;
        transition: transform 0.2s, background 0.2s;
    }
    .btn-prof-web:hover {
        background: #1d4ed8;
        transform: scale(1.08);
        color: #fff !important;
    }
    .btn-prof-wpp {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #10b981;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        text-decoration: none;
        font-size: 1.1rem;
        flex-shrink: 0;
        transition: transform 0.2s, background 0.2s;
    }
    .btn-prof-wpp:hover {
        background: #059669;
        transform: scale(1.08);
        color: #fff;
    }
    @media (max-width: 768px) {
        .prof-title { font-size: 1.8rem; }
        .prof-grid { grid-template-columns: 1fr; }
    }
    </style>
    <?php
    return ob_get_clean();
}
add_shortcode('mercado_profissionais', 'mercado_profissionais_shortcode');
