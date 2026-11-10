<?php
/**
 * Plugin Name: Mercado Erótico - Estatísticas & Números do Setor
 * Description: Módulo com os números e estatísticas consolidadas do mercado erótico no Brasil e no mundo.
 * Version: 1.0.0
 * Author: Equipe Portal Mercado Erótico
 */

if (!defined('ABSPATH')) exit;

add_shortcode('mercado_numeros_setor', 'me_numeros_setor_render');

function me_numeros_setor_render() {
    ob_start();
    ?>
    <section class="me-market-stats-section" id="mercado-em-numeros">
        <div class="me-stats-container">
            <!-- Header -->
            <div class="me-stats-header">
                <span class="me-stats-badge">★ RADAR ECONÔMICO &amp; DADOS DE MERCADO</span>
                <h2 class="me-stats-main-title">O Mercado Erótico em Números: Brasil &amp; Mundo</h2>
                <p class="me-stats-subtitle">
                    Levantamento analítico e estatístico consolidado pela redação com base nos censos oficiais da <strong>ABIPEA</strong>, <strong>Grand View Research</strong>, <strong>Statista</strong> e no acervo de cobertura contínua do Portal Mercado Erótico.
                </p>

                <!-- Tabs Toggle -->
                <div class="me-stats-tabs">
                    <button type="button" class="me-tab-btn active" data-tab="brasil">
                        <span class="tab-flag">🇧🇷</span> Panorama Brasil <span class="tab-sub">(R$ 2,5+ Bilhões)</span>
                    </button>
                    <button type="button" class="me-tab-btn" data-tab="mundo">
                        <span class="tab-flag">🌍</span> Panorama Global <span class="tab-sub">(US$ 42+ Bilhões)</span>
                    </button>
                </div>
            </div>

            <!-- TAB 1: BRASIL -->
            <div class="me-tab-content active" id="tab-brasil">
                <div class="me-stats-cards-grid">
                    <!-- Card 1 -->
                    <div class="me-num-card highlight-card">
                        <div class="num-card-top">
                            <span class="num-card-icon">💰</span>
                            <span class="num-card-tag">Faturamento Anual</span>
                        </div>
                        <div class="num-card-value">R$ 2,5+ Bi</div>
                        <h4 class="num-card-title">Movimentação Financeira no Brasil</h4>
                        <p class="num-card-desc">O mercado brasileiro movimenta mais de R$ 2,5 bilhões ao ano, somando vendas em e-commerces, sex shops físicas, farmácias, grandes marketplaces e venda direta.</p>
                        <div class="num-card-source">Fonte: Censo ABIPEA &amp; Projeções Setoriais</div>
                    </div>

                    <!-- Card 2 -->
                    <div class="me-num-card">
                        <div class="num-card-top">
                            <span class="num-card-icon">👩‍💼</span>
                            <span class="num-card-tag">Empreendedorismo</span>
                        </div>
                        <div class="num-card-value">77,9%</div>
                        <h4 class="num-card-title">Liderança Feminina na Gestão</h4>
                        <p class="num-card-desc">Quase 8 em cada 10 negócios do setor adulto no Brasil são fundados ou comandados por mulheres, transformando o segmento em um dos maiores motores de emancipação financeira feminina.</p>
                        <div class="num-card-source">Fonte: Censo Oficial da ABIPEA</div>
                    </div>

                    <!-- Card 3 -->
                    <div class="me-num-card">
                        <div class="num-card-top">
                            <span class="num-card-icon">📈</span>
                            <span class="num-card-tag">Crescimento</span>
                        </div>
                        <div class="num-card-value">+8% a 12%</div>
                        <h4 class="num-card-title">Expansão Anual Contínua</h4>
                        <p class="num-card-desc">Taxa média de crescimento anual impulsionada pela quebra de tabus, ampla digitalização e migração do setor tradicional para o conceito de <em>Sexual Wellness</em>.</p>
                        <div class="num-card-source">Fonte: Análises de Mercado ABIPEA</div>
                    </div>

                    <!-- Card 4 -->
                    <div class="me-num-card">
                        <div class="num-card-top">
                            <span class="num-card-icon">🧴</span>
                            <span class="num-card-tag">Categoria Líder</span>
                        </div>
                        <div class="num-card-value">31,3%</div>
                        <h4 class="num-card-title">Cosméticos Sensuais &amp; Íntimos</h4>
                        <p class="num-card-desc">Óleos beijáveis, lubrificantes térmicos, géis funcionais e hidratantes íntimos lideram as vendas nacionais, sendo a porta de entrada para a maioria dos consumidores.</p>
                        <div class="num-card-source">Fonte: Ranking de Vendas ABIPEA</div>
                    </div>

                    <!-- Card 5 -->
                    <div class="me-num-card">
                        <div class="num-card-top">
                            <span class="num-card-icon">⚡</span>
                            <span class="num-card-tag">Tecnologia do Prazer</span>
                        </div>
                        <div class="num-card-value">23,9%</div>
                        <h4 class="num-card-title">Vibradores &amp; Estimuladores</h4>
                        <p class="num-card-desc">Segunda maior fatia de receita nacional. Sugadores de clitóris por ondas de pressão e massageadores ergonômicos mantêm alta demanda de recompra e upgrades.</p>
                        <div class="num-card-source">Fonte: Dados de Distribuição Nacional</div>
                    </div>

                    <!-- Card 6 -->
                    <div class="me-num-card">
                        <div class="num-card-top">
                            <span class="num-card-icon">🛍️</span>
                            <span class="num-card-tag">Venda Domiciliar</span>
                        </div>
                        <div class="num-card-value">+150 Mil</div>
                        <h4 class="num-card-title">Consultoras Independentes</h4>
                        <p class="num-card-desc">Mais de 150 mil profissionais atuam no modelo de venda direta e chá de lingerie, levando consultoria personalizada e desmistificação para lares de todo o país.</p>
                        <div class="num-card-source">Fonte: Levantamento da Indústria Íntima</div>
                    </div>
                </div>
            </div>

            <!-- TAB 2: MUNDO -->
            <div class="me-tab-content" id="tab-mundo">
                <div class="me-stats-cards-grid">
                    <!-- Card 1 -->
                    <div class="me-num-card highlight-card">
                        <div class="num-card-top">
                            <span class="num-card-icon">🌐</span>
                            <span class="num-card-tag">Mercado Mundial</span>
                        </div>
                        <div class="num-card-value">US$ 42+ Bi</div>
                        <h4 class="num-card-title">Valor do Mercado Global Atual</h4>
                        <p class="num-card-desc">A indústria internacional de Sexual Wellness movimentou mais de US$ 40 bilhões nos últimos levantamentos, englobando sextechs, cosméticos corporais e dispositivos de saúde íntima.</p>
                        <div class="num-card-source">Fonte: Grand View Research &amp; Statista</div>
                    </div>

                    <!-- Card 2 -->
                    <div class="me-num-card">
                        <div class="num-card-top">
                            <span class="num-card-icon">🚀</span>
                            <span class="num-card-tag">Projeção 2030</span>
                        </div>
                        <div class="num-card-value">US$ 80 a 115 Bi</div>
                        <h4 class="num-card-title">Previsão até o Final da Década</h4>
                        <p class="num-card-desc">Projeções mundiais estimam crescimento composto (CAGR) de 7,9% a 8,4% ao ano até 2030, impulsionado pela legitimação médica e adesão de grandes varejistas globais.</p>
                        <div class="num-card-source">Fonte: Research and Markets / Allied Market Research</div>
                    </div>

                    <!-- Card 3 -->
                    <div class="me-num-card">
                        <div class="num-card-top">
                            <span class="num-card-icon">🇺🇸</span>
                            <span class="num-card-tag">Maior Consumidor</span>
                        </div>
                        <div class="num-card-value">US$ 20 Bi</div>
                        <h4 class="num-card-title">Mercado dos Estados Unidos</h4>
                        <p class="num-card-desc">O mercado norte-americano lidera o consumo global em ticket médio e adoção de inovações tecnológicas de bem-estar sexual, com projeção de US$ 20,1 bilhões até 2030.</p>
                        <div class="num-card-source">Fonte: U.S. Sexual Wellness Report (GVR)</div>
                    </div>

                    <!-- Card 4 -->
                    <div class="me-num-card">
                        <div class="num-card-top">
                            <span class="num-card-icon">📱</span>
                            <span class="num-card-tag">Sextech &amp; IoT</span>
                        </div>
                        <div class="num-card-value">+22% a.a.</div>
                        <h4 class="num-card-title">Dispositivos Inteligentes &amp; Apps</h4>
                        <p class="num-card-desc">Brinquedos conectados por Bluetooth, inteligência artificial e tecnologias de teledildônica (controle a distância para casais) registram a taxa de expansão mais veloz do setor.</p>
                        <div class="num-card-source">Fonte: Market Research Future (MRFR)</div>
                    </div>

                    <!-- Card 5 -->
                    <div class="me-num-card">
                        <div class="num-card-top">
                            <span class="num-card-icon">🎯</span>
                            <span class="num-card-tag">Decisão de Compra</span>
                        </div>
                        <div class="num-card-value">75%</div>
                        <h4 class="num-card-title">Público Feminino no Comando</h4>
                        <p class="num-card-desc">Mulheres respondem por cerca de três quartos das decisões de compra no setor globalmente, exigindo materiais corporais seguros (silicone médico), sustentabilidade e embalagens elegantes.</p>
                        <div class="num-card-source">Fonte: Global Consumer Demographics</div>
                    </div>

                    <!-- Card 6 -->
                    <div class="me-num-card">
                        <div class="num-card-top">
                            <span class="num-card-icon">🏬</span>
                            <span class="num-card-tag">Varejo Mainstream</span>
                        </div>
                        <div class="num-card-value">Mainstream</div>
                        <h4 class="num-card-title">Entrada em Grandes Redes</h4>
                        <p class="num-card-desc">Grandes magazines internacionais como Sephora, Ulta Beauty, Boots e Nordstrom integraram sessões dedicadas ao Sexual Wellness ao lado de skincare e perfumaria de luxo.</p>
                        <div class="num-card-source">Fonte: Retail Trends International</div>
                    </div>
                </div>
            </div>

            <!-- Footer / CTA -->
            <div class="me-stats-footer">
                <div class="me-stats-sources-info">
                    <i class="fas fa-database"></i> Fontes consolidadas: <strong>ABIPEA</strong> (Associação Brasileira das Empresas do Mercado Erótico), <strong>Grand View Research</strong>, <strong>Statista</strong> e acervo jornalístico do <strong>Portal Mercado Erótico</strong>.
                </div>
                <a href="<?php echo home_url('/acervo/?theme=pesquisas'); ?>" class="btn-stats-acervo">
                    <i class="fas fa-chart-line"></i> Acessar Pesquisas &amp; Censos Completos no Acervo ➔
                </a>
            </div>
        </div>
    </section>

    <style>
    /* MARKET STATS COMPONENT STYLES */
    .me-market-stats-section {
        background: #0f172a;
        color: #ffffff;
        padding: 60px 20px;
        margin: 45px 0;
        border-radius: 20px;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(227, 28, 97, 0.25);
        box-shadow: 0 15px 40px rgba(0,0,0,0.3);
    }
    .me-market-stats-section::before {
        content: '';
        position: absolute;
        top: -100px;
        left: -100px;
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(227, 28, 97, 0.2) 0%, transparent 70%);
        pointer-events: none;
    }
    .me-stats-container {
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
    }
    .me-stats-header {
        text-align: center;
        max-width: 820px;
        margin: 0 auto 40px auto;
    }
    .me-stats-badge {
        display: inline-block;
        background: rgba(227, 28, 97, 0.2);
        color: #ff659c;
        border: 1px solid rgba(227, 28, 97, 0.4);
        font-size: 0.78rem;
        font-weight: 800;
        padding: 5px 16px;
        border-radius: 20px;
        letter-spacing: 1px;
        margin-bottom: 14px;
    }
    .me-stats-main-title {
        font-size: 2.6rem;
        font-weight: 900;
        color: #ffffff !important;
        margin: 0 0 14px 0;
        line-height: 1.2;
    }
    @media (max-width: 768px) {
        .me-stats-main-title { font-size: 1.9rem; }
    }
    .me-stats-subtitle {
        font-size: 1.05rem;
        color: #94a3b8;
        line-height: 1.6;
        margin: 0 auto 30px auto;
    }
    .me-stats-subtitle strong {
        color: #e2e8f0;
    }

    /* TABS */
    .me-stats-tabs {
        display: inline-flex;
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 50px;
        padding: 5px;
        gap: 6px;
        flex-wrap: wrap;
        justify-content: center;
    }
    .me-tab-btn {
        background: transparent;
        color: #94a3b8;
        border: none;
        padding: 10px 22px;
        border-radius: 40px;
        font-size: 0.95rem;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.25s ease;
    }
    .me-tab-btn .tab-flag {
        font-size: 1.15rem;
    }
    .me-tab-btn .tab-sub {
        font-size: 0.8rem;
        opacity: 0.8;
    }
    .me-tab-btn:hover {
        color: #ffffff;
    }
    .me-tab-btn.active {
        background: linear-gradient(135deg, #e31c61 0%, #c4124e 100%);
        color: #ffffff !important;
        box-shadow: 0 4px 15px rgba(227, 28, 97, 0.4);
    }

    /* CARDS GRID */
    .me-tab-content {
        display: none;
    }
    .me-tab-content.active {
        display: block;
        animation: fadeInTab 0.3s ease;
    }
    @keyframes fadeInTab {
        from { opacity: 0; transform: translateY(6px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .me-stats-cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 22px;
        margin-bottom: 35px;
    }
    @media (max-width: 991px) {
        .me-stats-cards-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 640px) {
        .me-stats-cards-grid { grid-template-columns: 1fr; }
    }
    .me-num-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 16px;
        padding: 24px;
        display: flex;
        flex-direction: column;
        transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
    }
    .me-num-card:hover {
        transform: translateY(-4px);
        border-color: #e31c61;
        box-shadow: 0 10px 25px rgba(0,0,0,0.25);
    }
    .me-num-card.highlight-card {
        background: linear-gradient(145deg, #1e293b 0%, #2e1025 100%);
        border: 1px solid rgba(227, 28, 97, 0.4);
    }
    .num-card-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
    }
    .num-card-icon {
        font-size: 1.6rem;
    }
    .num-card-tag {
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        background: rgba(255,255,255,0.08);
        color: #e2e8f0;
        padding: 3px 10px;
        border-radius: 20px;
        letter-spacing: 0.5px;
    }
    .num-card-value {
        font-size: 2.3rem;
        font-weight: 900;
        color: #ff659c;
        line-height: 1.1;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }
    .num-card-title {
        font-size: 1.15rem;
        font-weight: 800;
        color: #ffffff;
        margin: 0 0 10px 0;
        line-height: 1.3;
    }
    .num-card-desc {
        font-size: 0.88rem;
        color: #94a3b8;
        line-height: 1.55;
        margin: 0 0 16px 0;
        flex: 1;
    }
    .num-card-source {
        font-size: 0.75rem;
        color: #64748b;
        border-top: 1px solid rgba(255,255,255,0.06);
        padding-top: 10px;
        font-style: italic;
    }

    /* FOOTER */
    .me-stats-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 25px;
        border-top: 1px solid #334155;
        flex-wrap: wrap;
        gap: 15px;
    }
    .me-stats-sources-info {
        font-size: 0.82rem;
        color: #94a3b8;
        max-width: 650px;
        line-height: 1.5;
    }
    .me-stats-sources-info i {
        color: #e31c61;
        margin-right: 4px;
    }
    .btn-stats-acervo {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #ffffff !important;
        font-weight: 700;
        font-size: 0.88rem;
        padding: 10px 22px;
        border-radius: 30px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }
    .btn-stats-acervo:hover {
        background: #e31c61;
        border-color: #e31c61;
        color: #ffffff !important;
        transform: translateY(-2px);
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabBtns = document.querySelectorAll('.me-tab-btn');
        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const target = this.getAttribute('data-tab');
                tabBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                document.querySelectorAll('.me-tab-content').forEach(c => {
                    c.classList.remove('active');
                });
                const targetContent = document.getElementById('tab-' + target);
                if (targetContent) targetContent.classList.add('active');
            });
        });
    });
    </script>
    <?php
    return ob_get_clean();
}
