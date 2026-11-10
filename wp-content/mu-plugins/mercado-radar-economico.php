<?php
/**
 * Plugin Name: Mercado Erótico - Pesquisas de Mercado & Radar Econômico
 * Description: Observatório de inteligência setorial, pesquisas de dados internacionais e radar econômico do mercado erótico no Brasil e no mundo.
 * Version: 2.0.0
 * Author: Equipe Portal Mercado Erótico
 */

if (!defined('ABSPATH')) exit;

/**
 * 1. SINGLE-LINE CALLOUT FOR HOMEPAGE
 */
add_shortcode('mercado_radar_home_callout', 'me_radar_home_callout_render');
function me_radar_home_callout_render() {
    $page_url = home_url('/pesquisas-de-mercado/');
    ob_start();
    ?>
    <!-- RADAR ECONÔMICO: LINHA DE CHAMADA COMPACTA -->
    <div class="me-radar-callout-strip">
        <div class="radar-strip-inner">
            <div class="radar-strip-badge">
                <span class="radar-pulse-dot"></span>
                <i class="fas fa-chart-line"></i> RADAR ECONÔMICO
            </div>
            <div class="radar-strip-content">
                <span class="radar-strip-label">Pesquisa de Dados Internacionais:</span>
                <span class="radar-strip-text">Indicadores globais (US$ 42+ Bi) e mercado brasileiro (R$ 2,5+ Bi) com projeções atualizadas.</span>
            </div>
            <div class="radar-strip-action">
                <a href="<?php echo esc_url($page_url); ?>" class="radar-strip-btn">
                    <span>Acessar Pesquisas de Mercado</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
    <style>
    .me-radar-callout-strip {
        background: linear-gradient(90deg, #18091f 0%, #290a2a 50%, #15081b 100%);
        border: 1px solid rgba(227, 28, 97, 0.4);
        border-radius: 12px;
        margin: 25px auto 35px;
        padding: 14px 22px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
        position: relative;
        overflow: hidden;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }
    .me-radar-callout-strip::before {
        content: "";
        position: absolute;
        top: 0; left: 0; bottom: 0;
        width: 4px;
        background: #e31c61;
    }
    .radar-strip-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
    }
    .radar-strip-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(227, 28, 97, 0.2);
        color: #ff3b7e;
        border: 1px solid rgba(227, 28, 97, 0.5);
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 0.78rem;
        font-weight: 800;
        letter-spacing: 1px;
        white-space: nowrap;
    }
    .radar-pulse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #10b981;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        animation: radarPulse 1.8s infinite;
        display: inline-block;
    }
    @keyframes radarPulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }
    .radar-strip-content {
        flex: 1;
        min-width: 280px;
        font-size: 0.95rem;
        color: #e2e8f0;
        line-height: 1.4;
    }
    .radar-strip-label {
        font-weight: 700;
        color: #fff;
        margin-right: 6px;
    }
    .radar-strip-text {
        color: #cbd5e1;
    }
    .radar-strip-action {
        white-space: nowrap;
    }
    .radar-strip-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #e31c61 0%, #b8144b 100%);
        color: #fff !important;
        padding: 9px 20px;
        border-radius: 8px;
        font-size: 0.88rem;
        font-weight: 700;
        text-decoration: none !important;
        transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(227, 28, 97, 0.35);
    }
    .radar-strip-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(227, 28, 97, 0.55);
        color: #fff !important;
    }
    @media (max-width: 768px) {
        .radar-strip-inner {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }
        .radar-strip-action {
            width: 100%;
        }
        .radar-strip-btn {
            width: 100%;
            justify-content: center;
        }
    }
    </style>
    <?php
    return ob_get_clean();
}

/**
 * 2. FULL DEDICATED PAGE: PESQUISAS DE MERCADO & RADAR ECONÔMICO
 */
add_shortcode('mercado_pesquisas_mercado', 'me_pesquisas_mercado_render');
// Backwards compatibility for old shortcode
add_shortcode('mercado_numeros_setor', 'me_pesquisas_mercado_render');

function me_pesquisas_mercado_render() {
    $cards = array(
        array(
            'id' => 'card-1',
            'cats' => 'all,global,consumo',
            'cat_label' => 'Mercado Global',
            'icon' => '🌐',
            'value' => 'US$ 42+ Bi',
            'tag' => 'Faturamento Global',
            'title' => 'Valor do Mercado Mundial de Sexual Wellness',
            'desc' => 'A indústria internacional de bem-estar sexual consolidou mais de US$ 40 bilhões nos últimos levantamentos internacionais, impulsionada pela legitimação médica, produtos ergonômicos e rápida digitalização do consumo.',
            'source' => 'Grand View Research & Statista Global',
            'date' => 'Projeção 2024–2030'
        ),
        array(
            'id' => 'card-2',
            'cats' => 'all,global,inovacao',
            'cat_label' => 'Projeção 2030',
            'icon' => '🚀',
            'value' => 'US$ 80 a 115 Bi',
            'tag' => 'Expansão Composta',
            'title' => 'Previsão Global até o Final da Década (CAGR 8,4%)',
            'desc' => 'Estudos mundiais projetam salto exponencial com taxa composta de crescimento anual (CAGR) entre 7,9% e 8,4% ao ano até 2030, puxado pela expansão em farmácias, grandes redes de cosméticos e adesão massiva da Geração Z.',
            'source' => 'Research and Markets / Allied Market Research',
            'date' => 'Projeção 2024–2030'
        ),
        array(
            'id' => 'card-3',
            'cats' => 'all,brasil,varejo',
            'cat_label' => 'Panorama Brasil',
            'icon' => '🇧🇷',
            'value' => 'R$ 2,5+ Bi',
            'tag' => 'Movimentação Anual',
            'title' => 'Movimentação Financeira no Mercado Brasileiro',
            'desc' => 'O setor brasileiro movimenta mais de R$ 2,5 bilhões ao ano somando sex shops físicas e e-commerces, farmácias, grandes redes varejistas, distribuidores atacadistas e a força da venda direta domiciliar.',
            'source' => 'Censo ABIPEA & Mapeamento Setorial',
            'date' => 'Dado Consolidado'
        ),
        array(
            'id' => 'card-4',
            'cats' => 'all,brasil,consumo',
            'cat_label' => 'Empreendedorismo',
            'icon' => '👩‍💼',
            'value' => '77,9%',
            'tag' => 'Liderança Feminina',
            'title' => 'Liderança Feminina na Gestão de Negócios',
            'desc' => 'Quase 8 em cada 10 negócios do setor no Brasil são fundados ou comandados por mulheres, transformando o segmento de Sexual Wellness em um dos maiores propulsores de emancipação financeira e liderança feminina.',
            'source' => 'Censo Oficial da ABIPEA',
            'date' => 'Levantamento Nacional'
        ),
        array(
            'id' => 'card-5',
            'cats' => 'all,inovacao,global',
            'cat_label' => 'Sextech & IoT',
            'icon' => '⚡',
            'value' => '+22% a.a.',
            'tag' => 'Inovação Tecnológica',
            'title' => 'Dispositivos Conectados, Teledildônica & IA',
            'desc' => 'O segmento de sextech registra a expansão mais veloz do setor. Dispositivos integrados a aplicativos Bluetooth, controle a longa distância para casais e algoritmos de estimulação personalizada lideram o registro de novas patentes.',
            'source' => 'Market Research Future (MRFR)',
            'date' => 'Estudo Sextech Global'
        ),
        array(
            'id' => 'card-6',
            'cats' => 'all,global,varejo',
            'cat_label' => 'Estados Unidos',
            'icon' => '🇺🇸',
            'value' => 'US$ 20 Bi',
            'tag' => 'Maior Mercado',
            'title' => 'Consumo e Ticket Médio nos Estados Unidos',
            'desc' => 'Maior polo mundial em ticket médio e adoção de novas categorias. O mercado norte-americano caminha para ultrapassar US$ 20,1 bilhões até 2030, impulsionado pela venda aberta em grandes redes como Target e CVS.',
            'source' => 'U.S. Sexual Wellness Report (GVR)',
            'date' => 'Índice de Consumo'
        ),
        array(
            'id' => 'card-7',
            'cats' => 'all,brasil,varejo',
            'cat_label' => 'Mix de Produtos',
            'icon' => '🧴',
            'value' => '31,3%',
            'tag' => 'Categoria Líder Brasil',
            'title' => 'Cosméticos Sensuais & Lubrificantes Funcionais',
            'desc' => 'Óleos beijáveis, lubrificantes térmicos, géis funcionais e hidratantes íntimos continuam liderando o ranking de vendas no Brasil, servindo como porta de entrada de novos consumidores no universo do autocuidado íntimo.',
            'source' => 'Ranking de Vendas ABIPEA',
            'date' => 'Auditoria Setorial'
        ),
        array(
            'id' => 'card-8',
            'cats' => 'all,brasil,varejo',
            'cat_label' => 'Venda Direta',
            'icon' => '🛍️',
            'value' => '+150 Mil',
            'tag' => 'Consultoras Ativas',
            'title' => 'Consultoras Independentes & Venda Domiciliar',
            'desc' => 'Mais de 150 mil profissionais atuam no modelo de venda domiciliar e eventos privativos como chás de lingerie, levando consultoria personalizada, educação corporal e desmistificação para lares de todo o território brasileiro.',
            'source' => 'Levantamento da Indústria Íntima',
            'date' => 'Censo de Atuação'
        ),
        array(
            'id' => 'card-9',
            'cats' => 'all,global,consumo',
            'cat_label' => 'Europa',
            'icon' => '🇪🇺',
            'value' => '€ 9,8 Bi',
            'tag' => 'Saúde & Fisioterapia',
            'title' => 'Mercado Europeu e Enquadramento de Saúde Íntima',
            'desc' => 'Alemanha, Reino Unido e França lideram a Europa com forte posicionamento de sex toys e estimuladores pélvicos como equipamentos de bem-estar corporal e saúde preventiva, comercializados amplamente em farmácias.',
            'source' => 'Eurostat & Statista Europe',
            'date' => 'Relatório Europeu'
        ),
        array(
            'id' => 'card-10',
            'cats' => 'all,global,inovacao',
            'cat_label' => 'Ásia-Pacífico',
            'icon' => '🌏',
            'value' => '9,2% CAGR',
            'tag' => 'Aceleração Regional',
            'title' => 'Ásia-Pacífico: Região com Maior Ritmo de Expansão',
            'desc' => 'Japão, Coreia do Sul, Austrália e China registram a taxa de expansão mais rápida do planeta, estimulada pela rápida urbanização, forte poder de compra da juventude e normalização cultural do autocuidado pessoal.',
            'source' => 'Allied Market Research Asia',
            'date' => 'Projeção Ásia-Pacífico'
        ),
        array(
            'id' => 'card-11',
            'cats' => 'all,consumo,global',
            'cat_label' => 'Consumo Consciente',
            'icon' => '🌱',
            'value' => '68%',
            'tag' => 'Sustentabilidade',
            'title' => 'Exigência por Materiais Atóxicos e Sustentáveis',
            'desc' => '68% dos novos compradores globais priorizam produtos fabricados em silicone de grau médico atóxico, livres de ftalatos, com baterias recarregáveis por indução e embalagens ecológicas com neutralização de carbono.',
            'source' => 'Global Eco-Intimacy Survey',
            'date' => 'Painel Internacional'
        ),
        array(
            'id' => 'card-12',
            'cats' => 'all,varejo,global',
            'cat_label' => 'Varejo Global',
            'icon' => '🏬',
            'value' => 'Mainstream',
            'tag' => 'Canais de Luxo',
            'title' => 'Entrada em Grandes Cadeias Globais de Beleza',
            'desc' => 'Grandes magazines e redes mundiais como Sephora, Ulta Beauty, Boots e Nordstrom abriram corredores dedicados exclusivamente ao Sexual Wellness ao lado de skincare e perfumaria de prestígio.',
            'source' => 'Retail Trends International',
            'date' => 'Mapeamento de Gôndolas'
        )
    );

    ob_start();
    ?>
    <div id="radar-pesquisas-app" class="radar-pesquisas-wrapper">
        <!-- Hero Header -->
        <div class="radar-hero">
            <div class="radar-hero-badge">
                <span class="radar-pulse-dot"></span>
                ★ OBSERVATÓRIO ECONÔMICO &amp; DADOS INTERNACIONAIS
            </div>
            <h1 class="radar-hero-title">Pesquisas de Mercado &amp; Radar Econômico</h1>
            <p class="radar-hero-subtitle">
                Monitoramento analítico contínuo e consolidação de <strong>pesquisas e dados internacionais</strong> sobre a indústria de Sexual Wellness e Saúde Íntima. Levantamento dinâmico atualizado pela redação a partir de institutos globais e censos setoriais.
            </p>
            
            <div class="radar-dynamic-tag">
                <i class="fas fa-sync-alt fa-spin" style="--fa-animation-duration: 4s;"></i>
                <span>Painel Dinâmico: Dados e projeções do setor no Brasil e no Mundo | Atualizado continuamente</span>
            </div>

            <!-- 4 Big Key Figures -->
            <div class="radar-kpi-grid">
                <div class="kpi-box">
                    <span class="kpi-num">US$ 42+ Bi</span>
                    <span class="kpi-lbl">Mercado Global Atual</span>
                </div>
                <div class="kpi-sep"></div>
                <div class="kpi-box">
                    <span class="kpi-num">R$ 2,5+ Bi</span>
                    <span class="kpi-lbl">Faturamento Anual Brasil</span>
                </div>
                <div class="kpi-sep"></div>
                <div class="kpi-box">
                    <span class="kpi-num">+8,4% a.a.</span>
                    <span class="kpi-lbl">Projeção Média até 2030</span>
                </div>
                <div class="kpi-sep"></div>
                <div class="kpi-box">
                    <span class="kpi-num">77,9%</span>
                    <span class="kpi-lbl">Gestão Feminina no Brasil</span>
                </div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="radar-filter-bar">
            <div class="filter-headline">
                <i class="fas fa-filter"></i> <strong>Filtrar Indicadores:</strong>
            </div>
            <div class="radar-tabs-nav" id="radarTabsNav">
                <button type="button" class="radar-tab-btn active" data-filter="all" onclick="filterRadarCards('all', this)">
                    📊 Todos os Indicadores (<?php echo count($cards); ?>)
                </button>
                <button type="button" class="radar-tab-btn" data-filter="global" onclick="filterRadarCards('global', this)">
                    🌍 Internacional &amp; Global
                </button>
                <button type="button" class="radar-tab-btn" data-filter="brasil" onclick="filterRadarCards('brasil', this)">
                    🇧🇷 Brasil &amp; América Latina
                </button>
                <button type="button" class="radar-tab-btn" data-filter="inovacao" onclick="filterRadarCards('inovacao', this)">
                    ⚡ Sextech &amp; Inovação IoT
                </button>
                <button type="button" class="radar-tab-btn" data-filter="varejo" onclick="filterRadarCards('varejo', this)">
                    🛒 Varejo &amp; Distribuição
                </button>
                <button type="button" class="radar-tab-btn" data-filter="consumo" onclick="filterRadarCards('consumo', this)">
                    👥 Comportamento &amp; Demografia
                </button>
            </div>
        </div>

        <!-- Cards Grid -->
        <div class="radar-cards-grid" id="radarCardsGrid">
            <?php foreach ($cards as $c): ?>
                <div class="radar-card" data-cats="<?php echo esc_attr($c['cats']); ?>" id="<?php echo esc_attr($c['id']); ?>">
                    <div class="radar-card-top">
                        <div class="card-icon-tag">
                            <span class="card-icon"><?php echo $c['icon']; ?></span>
                            <span class="card-category"><?php echo esc_html($c['cat_label']); ?></span>
                        </div>
                        <span class="card-badge-pill"><?php echo esc_html($c['tag']); ?></span>
                    </div>

                    <div class="radar-card-main-val">
                        <?php echo esc_html($c['value']); ?>
                    </div>

                    <h3 class="radar-card-title"><?php echo esc_html($c['title']); ?></h3>

                    <p class="radar-card-desc"><?php echo esc_html($c['desc']); ?></p>

                    <div class="radar-card-meta">
                        <div class="card-source">
                            <i class="fas fa-chart-pie"></i> <strong>Fonte:</strong> <?php echo esc_html($c['source']); ?>
                        </div>
                        <div class="card-period">
                            <i class="fas fa-calendar-alt"></i> <?php echo esc_html($c['date']); ?>
                        </div>
                    </div>

                    <div class="radar-card-footer">
                        <button type="button" class="btn-solicitar-editorial" onclick="openEditorialModal('<?php echo esc_js($c['title']); ?>', '<?php echo esc_js($c['value']); ?>', '<?php echo esc_js($c['source']); ?>')">
                            <i class="fas fa-file-contract"></i> Solicitar Detalhes à Equipe Editorial
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Editorial Banner & Contact Box -->
        <div class="radar-editorial-banner">
            <div class="editorial-banner-content">
                <div class="editorial-banner-icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <div class="editorial-banner-texts">
                    <span class="editorial-badge">SERVIÇO DE INTELIGÊNCIA EDITORIAL</span>
                    <h3 class="editorial-title">Precisa de dados completos, censos históricos ou consultoria setorial?</h3>
                    <p class="editorial-desc">
                        A equipe editorial e de inteligência do <strong>Portal Mercado Erótico</strong> disponibiliza relatórios aprofundados, recortes metodológicos customizados e análises de mercado sob demanda para veículos de imprensa, investidores, marcas e pesquisadores acadêmicos.
                    </p>
                </div>
                <div class="editorial-banner-actions">
                    <a href="https://wa.me/5562982763039?text=Ol%C3%A1%21+Gostaria+de+solicitar+um+relat%C3%B3rio+completo+de+pesquisa+de+mercado+com+a+equipe+editorial+do+Portal+Mercado+Er%C3%B3tico." target="_blank" rel="noopener noreferrer" class="btn-editorial-wa">
                        <i class="fab fa-whatsapp"></i> Falar com a Redação
                    </a>
                    <a href="mailto:contato@mercadoerotico.org?subject=Solicita%C3%A7%C3%A3o%20de%20Pesquisa%20de%20Mercado%20-%20Dados%20Setoriais" class="btn-editorial-mail">
                        <i class="fas fa-envelope"></i> Pedir por E-mail
                    </a>
                </div>
            </div>
        </div>

        <!-- Modal for Requesting Editorial Details -->
        <div id="radarModalBackdrop" class="radar-modal-backdrop" onclick="closeRadarModal(event)">
            <div class="radar-modal-card" onclick="event.stopPropagation()">
                <button type="button" class="radar-modal-close" onclick="closeRadarModal()">&times;</button>
                <div class="radar-modal-header">
                    <span class="modal-pretitle"><i class="fas fa-lock-open"></i> SOLICITAÇÃO DE DADOS EDITORIAIS</span>
                    <h3 id="modalIndicatorTitle" class="modal-indicator-title">Pesquisa de Mercado</h3>
                    <div id="modalIndicatorValue" class="modal-indicator-badge">US$ 42+ Bi</div>
                </div>
                <div class="radar-modal-body">
                    <p class="modal-intro">
                        Para acessar a documentação metodológica, recortes analíticos completos ou solicitar entrevistas com especialistas sobre este indicador, entre em contato direto com a <strong>equipe editorial do Portal Mercado Erótico</strong>:
                    </p>
                    <div class="modal-source-box">
                        <i class="fas fa-database"></i> <strong>Base de Dados / Fonte:</strong> <span id="modalIndicatorSource">Grand View Research</span>
                    </div>

                    <div class="modal-actions-list">
                        <a id="modalWaBtn" href="#" target="_blank" rel="noopener noreferrer" class="modal-btn-wa">
                            <i class="fab fa-whatsapp"></i>
                            <div>
                                <strong>Solicitar Detalhes via WhatsApp</strong>
                                <span>Atendimento direto com a redação (+55 62 98276-3039)</span>
                            </div>
                        </a>
                        <a id="modalMailBtn" href="#" class="modal-btn-mail">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <strong>Solicitar por E-mail Institucional</strong>
                                <span>contato@mercadoerotico.org</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="radar-modal-footer">
                    <small><i class="fas fa-shield-alt"></i> Portal Mercado Erótico • Jornalismo e Inteligência de Mercado desde 2000</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts and Styles -->
    <script>
    function filterRadarCards(filter, btn) {
        const buttons = document.querySelectorAll('#radarTabsNav .radar-tab-btn');
        buttons.forEach(b => b.classList.remove('active'));
        if (btn) btn.classList.add('active');

        const cards = document.querySelectorAll('#radarCardsGrid .radar-card');
        cards.forEach(card => {
            const cats = (card.getAttribute('data-cats') || '').split(',');
            if (filter === 'all' || cats.includes(filter)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function openEditorialModal(title, value, source) {
        document.getElementById('modalIndicatorTitle').innerText = title;
        document.getElementById('modalIndicatorValue').innerText = value;
        document.getElementById('modalIndicatorSource').innerText = source;

        const phone = '5562982763039';
        const msg = 'Olá equipe editorial do Portal Mercado Erótico! Gostaria de receber os dados detalhados e relatório completo sobre a pesquisa "' + title + '" (Valor: ' + value + ', Fonte: ' + source + ').';
        
        const waUrl = 'https://wa.me/' + phone + '?text=' + encodeURIComponent(msg);
        const mailUrl = 'mailto:contato@mercadoerotico.org?subject=' + encodeURIComponent('Solicitação Editorial: ' + title) + '&body=' + encodeURIComponent(msg);

        document.getElementById('modalWaBtn').setAttribute('href', waUrl);
        document.getElementById('modalMailBtn').setAttribute('href', mailUrl);

        const backdrop = document.getElementById('radarModalBackdrop');
        if (backdrop) {
            backdrop.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeRadarModal(e) {
        if (e && e.target && e.target !== document.getElementById('radarModalBackdrop') && !e.target.classList.contains('radar-modal-close')) {
            return;
        }
        const backdrop = document.getElementById('radarModalBackdrop');
        if (backdrop) {
            backdrop.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeRadarModal();
    });
    </script>

    <style>
    .radar-pesquisas-wrapper {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        color: #1e293b;
        max-width: 1240px;
        margin: 0 auto;
        padding: 20px 20px 80px;
    }
    
    /* Hero */
    .radar-hero {
        background: radial-gradient(circle at 50% 25%, #240c26 0%, #0d0413 100%);
        border-radius: 20px;
        padding: 55px 35px 45px;
        text-align: center;
        color: #fff;
        margin-bottom: 40px;
        box-shadow: 0 20px 45px rgba(0,0,0,0.35);
        border: 1px solid rgba(227, 28, 97, 0.3);
        position: relative;
    }
    .radar-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(227, 28, 97, 0.22);
        color: #ff3b7e;
        border: 1px solid rgba(227, 28, 97, 0.5);
        padding: 7px 18px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 800;
        letter-spacing: 1.2px;
        margin-bottom: 20px;
    }
    .radar-hero-title {
        font-size: 2.7rem;
        font-weight: 900;
        letter-spacing: -0.5px;
        color: #fff;
        margin: 0 0 16px;
        line-height: 1.18;
    }
    .radar-hero-subtitle {
        font-size: 1.15rem;
        color: #cbd5e1;
        max-width: 860px;
        margin: 0 auto 25px;
        line-height: 1.6;
    }
    .radar-hero-subtitle strong {
        color: #fff;
    }
    .radar-dynamic-tag {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 0.85rem;
        color: #94a3b8;
        margin-bottom: 35px;
    }
    .radar-dynamic-tag i {
        color: #10b981;
    }
    .radar-kpi-grid {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
        background: rgba(0,0,0,0.35);
        padding: 22px 30px;
        border-radius: 14px;
        border: 1px solid rgba(255,255,255,0.08);
    }
    .kpi-box {
        text-align: center;
        padding: 5px 15px;
    }
    .kpi-num {
        display: block;
        font-size: 2rem;
        font-weight: 900;
        color: #e31c61;
        line-height: 1.1;
    }
    .kpi-lbl {
        display: block;
        font-size: 0.8rem;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-top: 4px;
        font-weight: 600;
    }
    .kpi-sep {
        width: 1px;
        height: 38px;
        background: rgba(255,255,255,0.15);
    }

    /* Filter Bar */
    .radar-filter-bar {
        background: #fff;
        border-radius: 14px;
        padding: 16px 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid #e2e8f0;
        margin-bottom: 35px;
        display: flex;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
    }
    .filter-headline {
        color: #475569;
        font-size: 0.95rem;
        white-space: nowrap;
    }
    .filter-headline i {
        color: #e31c61;
        margin-right: 4px;
    }
    .radar-tabs-nav {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    .radar-tab-btn {
        background: #f1f5f9;
        color: #334155;
        border: 1px solid #cbd5e1;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 0.86rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .radar-tab-btn:hover {
        background: #e2e8f0;
        color: #0f172a;
    }
    .radar-tab-btn.active {
        background: #e31c61 !important;
        color: #fff !important;
        border-color: #e31c61 !important;
        box-shadow: 0 4px 12px rgba(227, 28, 97, 0.35);
    }

    /* Cards Grid */
    .radar-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
        gap: 25px;
        margin-bottom: 50px;
    }
    .radar-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(0,0,0,0.04);
        padding: 26px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        position: relative;
    }
    .radar-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.1);
        border-color: #cbd5e1;
    }
    .radar-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
    }
    .card-icon-tag {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .card-icon {
        font-size: 1.4rem;
    }
    .card-category {
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #64748b;
        letter-spacing: 0.8px;
    }
    .card-badge-pill {
        background: #fdf2f6;
        color: #e31c61;
        border: 1px solid rgba(227, 28, 97, 0.2);
        padding: 4px 10px;
        border-radius: 50px;
        font-size: 0.74rem;
        font-weight: 700;
    }
    .radar-card-main-val {
        font-size: 2.2rem;
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -0.5px;
        margin-bottom: 8px;
        line-height: 1.1;
    }
    .radar-card-title {
        font-size: 1.15rem;
        font-weight: 800;
        color: #1e293b;
        margin: 0 0 12px;
        line-height: 1.35;
    }
    .radar-card-desc {
        font-size: 0.92rem;
        color: #475569;
        line-height: 1.55;
        margin-bottom: 20px;
        flex: 1;
    }
    .radar-card-meta {
        background: #f8fafc;
        border-radius: 8px;
        padding: 10px 14px;
        margin-bottom: 18px;
        font-size: 0.82rem;
        color: #64748b;
        border: 1px solid #f1f5f9;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .radar-card-meta i {
        color: #e31c61;
        margin-right: 4px;
    }
    .radar-card-footer {
        padding-top: 5px;
    }
    .btn-solicitar-editorial {
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: #f8fafc;
        color: #e31c61;
        border: 1.5px solid #e31c61;
        padding: 10px 16px;
        border-radius: 8px;
        font-size: 0.86rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-solicitar-editorial:hover {
        background: #e31c61;
        color: #fff;
        box-shadow: 0 4px 14px rgba(227, 28, 97, 0.35);
    }

    /* Editorial Banner */
    .radar-editorial-banner {
        background: linear-gradient(135deg, #1e0d21 0%, #110515 100%);
        border-radius: 18px;
        padding: 40px;
        border: 1px solid rgba(227, 28, 97, 0.4);
        box-shadow: 0 15px 35px rgba(0,0,0,0.25);
        color: #fff;
    }
    .editorial-banner-content {
        display: flex;
        align-items: center;
        gap: 30px;
        flex-wrap: wrap;
    }
    .editorial-banner-icon {
        font-size: 3rem;
        color: #ff3b7e;
        flex-shrink: 0;
    }
    .editorial-banner-texts {
        flex: 1;
        min-width: 300px;
    }
    .editorial-badge {
        display: inline-block;
        background: rgba(227, 28, 97, 0.3);
        color: #ff5a92;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.74rem;
        font-weight: 800;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }
    .editorial-title {
        font-size: 1.45rem;
        font-weight: 800;
        margin: 0 0 10px;
        color: #fff;
    }
    .editorial-desc {
        font-size: 0.95rem;
        color: #cbd5e1;
        line-height: 1.5;
        margin: 0;
    }
    .editorial-banner-actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
        flex-shrink: 0;
    }
    .btn-editorial-wa {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: #25D366;
        color: #fff !important;
        font-weight: 700;
        font-size: 0.92rem;
        padding: 12px 24px;
        border-radius: 8px;
        text-decoration: none !important;
        transition: all 0.2s ease;
        box-shadow: 0 4px 15px rgba(37, 211, 102, 0.35);
    }
    .btn-editorial-wa:hover {
        background: #1eb956;
        transform: translateY(-2px);
    }
    .btn-editorial-mail {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.1);
        color: #fff !important;
        font-weight: 600;
        font-size: 0.88rem;
        padding: 10px 24px;
        border-radius: 8px;
        text-decoration: none !important;
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.2s ease;
    }
    .btn-editorial-mail:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    /* Modal Backdrop */
    .radar-modal-backdrop {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.75);
        backdrop-filter: blur(5px);
        z-index: 999999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.25s ease;
    }
    .radar-modal-backdrop.active {
        opacity: 1;
        pointer-events: auto;
    }
    .radar-modal-card {
        background: #fff;
        border-radius: 18px;
        max-width: 580px;
        width: 100%;
        box-shadow: 0 25px 60px rgba(0,0,0,0.35);
        padding: 35px 30px 25px;
        position: relative;
        transform: scale(0.95);
        transition: transform 0.25s ease;
        border: 1px solid #e2e8f0;
    }
    .radar-modal-backdrop.active .radar-modal-card {
        transform: scale(1);
    }
    .radar-modal-close {
        position: absolute;
        top: 18px;
        right: 20px;
        background: none;
        border: none;
        font-size: 1.8rem;
        color: #94a3b8;
        cursor: pointer;
        line-height: 1;
    }
    .radar-modal-close:hover {
        color: #e31c61;
    }
    .modal-pretitle {
        display: inline-block;
        font-size: 0.75rem;
        font-weight: 800;
        color: #e31c61;
        letter-spacing: 1px;
        margin-bottom: 6px;
    }
    .modal-indicator-title {
        font-size: 1.35rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 10px;
        line-height: 1.3;
    }
    .modal-indicator-badge {
        display: inline-block;
        background: #fdf2f6;
        color: #e31c61;
        font-weight: 900;
        font-size: 1.15rem;
        padding: 4px 14px;
        border-radius: 8px;
        border: 1px solid rgba(227, 28, 97, 0.25);
        margin-bottom: 18px;
    }
    .modal-intro {
        font-size: 0.94rem;
        color: #475569;
        line-height: 1.5;
        margin-bottom: 15px;
    }
    .modal-source-box {
        background: #f8fafc;
        padding: 10px 14px;
        border-radius: 8px;
        font-size: 0.85rem;
        color: #334155;
        border-left: 3px solid #e31c61;
        margin-bottom: 22px;
    }
    .modal-actions-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 20px;
    }
    .modal-btn-wa {
        display: flex;
        align-items: center;
        gap: 14px;
        background: #25D366;
        color: #fff !important;
        padding: 14px 20px;
        border-radius: 10px;
        text-decoration: none !important;
        font-size: 0.95rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 4px 14px rgba(37, 211, 102, 0.35);
    }
    .modal-btn-wa i {
        font-size: 1.8rem;
    }
    .modal-btn-wa div {
        display: flex;
        flex-direction: column;
        text-align: left;
    }
    .modal-btn-wa span {
        font-size: 0.78rem;
        opacity: 0.9;
        font-weight: normal;
    }
    .modal-btn-wa:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 211, 102, 0.45);
    }
    .modal-btn-mail {
        display: flex;
        align-items: center;
        gap: 14px;
        background: #0f172a;
        color: #fff !important;
        padding: 12px 20px;
        border-radius: 10px;
        text-decoration: none !important;
        font-size: 0.92rem;
        transition: transform 0.2s ease;
    }
    .modal-btn-mail i {
        font-size: 1.5rem;
        color: #e31c61;
    }
    .modal-btn-mail div {
        display: flex;
        flex-direction: column;
        text-align: left;
    }
    .modal-btn-mail span {
        font-size: 0.78rem;
        opacity: 0.8;
        font-weight: normal;
    }
    .modal-btn-mail:hover {
        transform: translateY(-2px);
    }
    .radar-modal-footer {
        border-top: 1px solid #f1f5f9;
        padding-top: 14px;
        text-align: center;
        color: #94a3b8;
    }

    @media (max-width: 768px) {
        .radar-hero {
            padding: 35px 20px 30px;
        }
        .radar-hero-title {
            font-size: 1.8rem;
        }
        .radar-hero-subtitle {
            font-size: 1rem;
        }
        .kpi-sep {
            display: none;
        }
        .radar-cards-grid {
            grid-template-columns: 1fr;
        }
        .editorial-banner-content {
            flex-direction: column;
            text-align: center;
        }
        .editorial-banner-actions {
            width: 100%;
        }
    }
    </style>
    <?php
    return ob_get_clean();
}
