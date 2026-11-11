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

/**
 * Helper: Metadados das 3 Tipologias de Dados do Observatório
 * - terceiros: Institutos e consultorias internacionais
 * - proprios: Pesquisas exclusivas MercadoErótico.org
 * - setoriais: Censos e associações da indústria (ABIPEA)
 */
function mercado_get_radar_provenance_info($prov) {
    switch ($prov) {
        case 'proprios':
            return array(
                'slug'        => 'proprios',
                'label'       => 'Dados Próprios',
                'short_label' => 'Próprio',
                'subtitle'    => 'Pesquisas Exclusivas MercadoErótico.org',
                'icon'        => '★',
                'fa_icon'     => 'fas fa-certificate',
                'color'       => '#e31c61',
                'bg_badge'    => '#fff1f5',
                'border'      => 'rgba(227, 28, 97, 0.35)',
                'badge_class' => 'prov-proprios',
                'desc'        => 'Pesquisas empíricas, censos de consultoras, auditorias de varejo e painéis exclusivos de consumidores conduzidos diretamente pela equipe de inteligência e jornalismo do MercadoErótico.org.'
            );
        case 'setoriais':
            return array(
                'slug'        => 'setoriais',
                'label'       => 'Dados Setoriais',
                'short_label' => 'Setorial',
                'subtitle'    => 'Censos & Associações da Indústria',
                'icon'        => '🏛️',
                'fa_icon'     => 'fas fa-landmark',
                'color'       => '#0284c7',
                'bg_badge'    => '#f0f9ff',
                'border'      => 'rgba(2, 132, 199, 0.35)',
                'badge_class' => 'prov-setoriais',
                'desc'        => 'Informações obtidas em censos oficiais, rankings de categorias e levantamentos promovidos por associações representativas da indústria (como a ABIPEA) e entidades setoriais brasileiras.'
            );
        case 'terceiros':
        default:
            return array(
                'slug'        => 'terceiros',
                'label'       => 'Dados de Terceiros',
                'short_label' => 'Terceiros',
                'subtitle'    => 'Institutos & Consultorias Globais',
                'icon'        => '🌐',
                'fa_icon'     => 'fas fa-globe',
                'color'       => '#7c3aed',
                'bg_badge'    => '#f5f3ff',
                'border'      => 'rgba(124, 58, 237, 0.35)',
                'badge_class' => 'prov-terceiros',
                'desc'        => 'Pesquisas macroeconômicas de consultorias e institutos internacionais (Grand View Research, Statista, Allied Market Research, Eurostat, MRFR). Valores em dólar/euro com paridade PTAX oficial do Banco Central.'
            );
    }
}

function mercado_get_default_radar_kpis() {
    return array(
        array('num' => 'US$ 42+ Bi', 'label' => 'Mercado Global Atual'),
        array('num' => 'R$ 2,5+ Bi', 'label' => 'Faturamento Anual Brasil'),
        array('num' => '+8,4% a.a.', 'label' => 'Projeção Média até 2030'),
        array('num' => '77,9%', 'label' => 'Gestão Feminina no Brasil'),
    );
}

function mercado_get_default_radar_cards() {
    return array(
        array(
            'id' => 'card-1',
            'cats' => 'all,global,consumo',
            'cat_label' => 'Mercado Global',
            'provenance' => 'terceiros',
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
            'provenance' => 'terceiros',
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
            'provenance' => 'setoriais',
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
            'provenance' => 'setoriais',
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
            'provenance' => 'terceiros',
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
            'provenance' => 'terceiros',
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
            'provenance' => 'setoriais',
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
            'provenance' => 'proprios',
            'icon' => '🛍️',
            'value' => '+150 Mil',
            'tag' => 'Consultoras Ativas',
            'title' => 'Consultoras Independentes & Venda Domiciliar',
            'desc' => 'Levantamento exclusivo realizado pelo MercadoErótico.org mapeando mais de 150 mil profissionais na venda domiciliar, eventos privativos e consultoria de bem-estar corporal em todas as regiões do Brasil.',
            'source' => 'Censo de Consultoras MercadoErótico.org',
            'date' => 'Levantamento Próprio'
        ),
        array(
            'id' => 'card-9',
            'cats' => 'all,global,consumo',
            'cat_label' => 'Europa',
            'provenance' => 'terceiros',
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
            'provenance' => 'terceiros',
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
            'provenance' => 'proprios',
            'icon' => '🌱',
            'value' => '68%',
            'tag' => 'Sustentabilidade',
            'title' => 'Exigência por Materiais Atóxicos e Sustentáveis',
            'desc' => 'Pesquisa conduzida pela redação do MercadoErótico.org com leitores e compradores: 68% priorizam itens em silicone de grau médico atóxico, livres de ftalatos, com carregamento magnético e embalagens ecológicas.',
            'source' => 'Painel de Consumidores MercadoErótico.org',
            'date' => 'Pesquisa Editorial Exclusiva'
        ),
        array(
            'id' => 'card-12',
            'cats' => 'all,varejo,global',
            'cat_label' => 'Varejo Global',
            'provenance' => 'proprios',
            'icon' => '🏬',
            'value' => 'Mainstream',
            'tag' => 'Canais de Luxo',
            'title' => 'Entrada em Grandes Cadeias Globais de Beleza',
            'desc' => 'Monitoramento contínuo da redação sobre o varejo mainstream: grandes redes como Sephora, Boots e redes farmacêuticas abriram seções exclusivas de Sexual Wellness integradas a skincare e autocuidado.',
            'source' => 'Auditoria de Varejo MercadoErótico.org',
            'date' => 'Monitoramento Contínuo'
        )
    );
}

function mercado_get_radar_cards() {
    $cards = get_option('mercado_radar_cards', null);
    if (!is_array($cards) || empty($cards)) {
        return mercado_get_default_radar_cards();
    }
    // Garantir retrocompatibilidade caso algum card salvo não tenha 'provenance'
    foreach ($cards as &$c) {
        if (empty($c['provenance'])) {
            $src = strtolower($c['source'] ?? '');
            if (strpos($src, 'mercadoerótico') !== false || strpos($src, 'mercado erótico') !== false || strpos($src, 'painel de consumidores') !== false || strpos($src, 'censo de consultoras') !== false) {
                $c['provenance'] = 'proprios';
            } elseif (strpos($src, 'abipea') !== false || strpos($src, 'associação') !== false || strpos($src, 'censo oficial') !== false) {
                $c['provenance'] = 'setoriais';
            } else {
                $c['provenance'] = 'terceiros';
            }
        }
    }
    return $cards;
}

function mercado_get_radar_kpis() {
    $kpis = get_option('mercado_radar_kpis', null);
    if (!is_array($kpis) || empty($kpis)) {
        return mercado_get_default_radar_kpis();
    }
    return $kpis;
}


/**
 * INTEGRAÇÃO OFICIAL BANCO CENTRAL DO BRASIL (BACEN PTAX - SÉRIE 10813)
 * Cotação oficial do dólar comercial para conversão automática em tempo real.
 * Caching inteligente via WordPress Transients (12 horas) para ZERO sobrecarga.
 */
function mercado_get_bacen_dollar_info() {
    $cached = get_transient('mercado_bacen_dollar_info');
    if ($cached && is_array($cached) && !empty($cached['rate'])) {
        return $cached;
    }

    $rate = 5.58;
    $date = date('d/m/Y');
    $url = 'https://api.bcb.gov.br/dados/serie/bcdata.sgs.10813/dados/ultimos/1?formato=json';
    $resp = wp_remote_get($url, array('timeout' => 4, 'sslverify' => false));

    if (!is_wp_error($resp) && wp_remote_retrieve_response_code($resp) === 200) {
        $data = json_decode(wp_remote_retrieve_body($resp), true);
        if (!empty($data[0]['valor'])) {
            $rate = floatval($data[0]['valor']);
            $date = $data[0]['data'];
        }
    }

    $res = array(
        'rate'   => $rate,
        'date'   => $date,
        'source' => 'Banco Central do Brasil (BACEN SGS/PTAX)'
    );
    set_transient('mercado_bacen_dollar_info', $res, 12 * HOUR_IN_SECONDS);
    return $res;
}

/**
 * Converte valores em Dólar (US$) para Reais (R$) com base na taxa BACEN
 */
function mercado_format_usd_brl($value_str, $dollar_rate) {
    if (empty($value_str) || strpos($value_str, 'US$') === false) {
        return '';
    }

    // Ex: US$ 42+ Bi
    if (preg_match('/US\$\s*([0-9]+(?:\.[0-9]+)?)\+?\s*Bi/i', $value_str, $m)) {
        $usd = floatval($m[1]);
        $brl = $usd * $dollar_rate;
        return '~R$ ' . number_format($brl, 1, ',', '.') . '+ Bilhões (Câmbio BACEN)';
    }

    // Ex: US$ 80 a 115 Bi
    if (preg_match('/US\$\s*([0-9]+)\s*a\s*([0-9]+)\s*Bi/i', $value_str, $m)) {
        $min = floatval($m[1]) * $dollar_rate;
        $max = floatval($m[2]) * $dollar_rate;
        return '~R$ ' . number_format($min, 0, ',', '.') . ' a ' . number_format($max, 0, ',', '.') . ' Bi (Câmbio BACEN)';
    }

    // Ex: US$ 650 Mi
    if (preg_match('/US\$\s*([0-9]+)\s*Mi/i', $value_str, $m)) {
        $usd = floatval($m[1]);
        $brl = ($usd * $dollar_rate) / 1000;
        return '~R$ ' . number_format($brl, 1, ',', '.') . '+ Bilhões (Câmbio BACEN)';
    }

    return '';
}

function me_pesquisas_mercado_render() {
    $cards = mercado_get_radar_cards();
    $kpis = mercado_get_radar_kpis();

    // Contagem por proveniência para as abas e matriz metodológica
    $count_terceiros = 0;
    $count_proprios = 0;
    $count_setoriais = 0;
    foreach ($cards as $c) {
        $p = $c['provenance'] ?? 'terceiros';
        if ($p === 'proprios') $count_proprios++;
        elseif ($p === 'setoriais') $count_setoriais++;
        else $count_terceiros++;
    }

    // Dados automatizados do portal
    $pesquisas_cat = get_category_by_slug('pesquisas');
    $pesquisas_count = $pesquisas_cat ? intval($pesquisas_cat->count) : 153;
    $mes_atual = date_i18n('F \d\e Y');

    // Câmbio oficial BACEN (PTAX) em tempo real (utilizado na conversão dos cards)
    $dollar_info = mercado_get_bacen_dollar_info();

    ob_start();
    ?>
    <div id="radar-pesquisas-app" class="radar-pesquisas-wrapper">
        <!-- Hero Header -->
        <div class="radar-hero">
            <div class="radar-hero-badge">
                <span class="radar-pulse-dot"></span>
                ★ OBSERVATÓRIO ECONÔMICO &bull; <?php echo $pesquisas_count; ?> PESQUISAS CATALOGADAS
            </div>
            <h1 class="radar-hero-title">Pesquisas de Mercado &amp; Radar Econômico</h1>
            <p class="radar-hero-subtitle">
                Monitoramento analítico contínuo e consolidação de <strong>pesquisas e dados internacionais</strong> sobre a indústria de Sexual Wellness e Saúde Íntima. Levantamento dinâmico atualizado pela redação a partir de institutos globais e censos setoriais.
            </p>
            
            <div class="radar-dynamic-tag">
                <i class="fas fa-sync-alt fa-spin" style="--fa-animation-duration: 4s;"></i>
                <span>Painel Analítico • Atualizado em <?php echo esc_html(ucfirst($mes_atual)); ?></span>
            </div>

            <!-- 4 Big Key Figures Dinâmicos -->
            <div class="radar-kpi-grid">
                <?php foreach ($kpis as $idx => $kp): ?>
                    <?php if ($idx > 0): ?><div class="kpi-sep"></div><?php endif; ?>
                    <div class="kpi-box">
                        <span class="kpi-num"><?php echo esc_html($kp['num']); ?></span>
                        <span class="kpi-lbl"><?php echo esc_html($kp['label']); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- MATRIZ METODOLÓGICA: CRITÉRIOS DE RIGOR & CLASSIFICAÇÃO DOS DADOS -->
        <section class="radar-methodology-section" aria-label="Matriz de Rigor Metodológico">
            <div class="methodology-card-panel">
                <div class="methodology-panel-header">
                    <div class="methodology-badge">
                        <i class="fas fa-microscope"></i> RIGOR METODOLÓGICO &bull; TRANSPARÊNCIA ANALÍTICA
                    </div>
                    <h2 class="methodology-title">Classificação &amp; Segregação das Informações</h2>
                    <p class="methodology-subtitle">
                        Para assegurar a máxima credibilidade do observatório, distinguimos com precisão a natureza de cada dado. Clique em qualquer um dos blocos para filtrar instantaneamente os indicadores correspondentes:
                    </p>
                </div>

                <div class="methodology-grid">
                    <!-- 1. Dados de Terceiros -->
                    <div class="methodology-col col-terceiros" onclick="filterRadarCards('prov', 'terceiros', document.querySelector('.radar-prov-btn[data-prov=\'terceiros\']'))" role="button" tabindex="0" title="Clique para filtrar apenas Dados de Terceiros">
                        <div class="methodology-col-top">
                            <span class="methodology-icon"><i class="fas fa-globe"></i></span>
                            <div class="methodology-col-labels">
                                <span class="methodology-type-pill prov-terceiros">DADOS DE TERCEIROS</span>
                                <h3 class="methodology-col-name">Institutos Internacionais</h3>
                            </div>
                        </div>
                        <p class="methodology-col-desc">
                            Pesquisas macroeconômicas consolidadas por institutos e consultorias globais de alta autoridade (como <strong>Grand View Research</strong>, <strong>Statista</strong>, <strong>Eurostat</strong> e <strong>Allied Market Research</strong>). Inclui conversão em tempo real pelo câmbio oficial BACEN.
                        </p>
                        <div class="methodology-col-foot">
                            <span class="methodology-stat-badge"><strong><?php echo $count_terceiros; ?></strong> Indicadores Globais</span>
                            <span class="methodology-click-hint">Filtrar <i class="fas fa-arrow-right"></i></span>
                        </div>
                    </div>

                    <!-- 2. Dados Próprios -->
                    <div class="methodology-col col-proprios" onclick="filterRadarCards('prov', 'proprios', document.querySelector('.radar-prov-btn[data-prov=\'proprios\']'))" role="button" tabindex="0" title="Clique para filtrar apenas Dados Próprios">
                        <div class="methodology-col-top">
                            <span class="methodology-icon"><i class="fas fa-certificate"></i></span>
                            <div class="methodology-col-labels">
                                <span class="methodology-type-pill prov-proprios">DADOS PRÓPRIOS</span>
                                <h3 class="methodology-col-name">MercadoErótico.org</h3>
                            </div>
                        </div>
                        <p class="methodology-col-desc">
                            Levantamentos empíricos exclusivos produzidos pela redação e inteligência do <strong>MercadoErótico.org</strong>, englobando censos de venda direta/consultoras, auditorias contínuas de gôndolas de varejo e painéis diretos com consumidores.
                        </p>
                        <div class="methodology-col-foot">
                            <span class="methodology-stat-badge"><strong><?php echo $count_proprios; ?></strong> Pesquisas Exclusivas</span>
                            <span class="methodology-click-hint">Filtrar <i class="fas fa-arrow-right"></i></span>
                        </div>
                    </div>

                    <!-- 3. Dados Setoriais -->
                    <div class="methodology-col col-setoriais" onclick="filterRadarCards('prov', 'setoriais', document.querySelector('.radar-prov-btn[data-prov=\'setoriais\']'))" role="button" tabindex="0" title="Clique para filtrar apenas Dados Setoriais">
                        <div class="methodology-col-top">
                            <span class="methodology-icon"><i class="fas fa-landmark"></i></span>
                            <div class="methodology-col-labels">
                                <span class="methodology-type-pill prov-setoriais">DADOS SETORIAIS</span>
                                <h3 class="methodology-col-name">Censos &amp; Associações</h3>
                            </div>
                        </div>
                        <p class="methodology-col-desc">
                            Informações e censos estatísticos oficiais obtidos junto a entidades de classe e associações representativas da indústria e do comércio brasileiro (como a <strong>ABIPEA</strong>), auditando faturamento nacional e liderança por categorias.
                        </p>
                        <div class="methodology-col-foot">
                            <span class="methodology-stat-badge"><strong><?php echo $count_setoriais; ?></strong> Censos Oficiais</span>
                            <span class="methodology-click-hint">Filtrar <i class="fas fa-arrow-right"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Filter Bar Interativo: Proveniência + Segmento -->
        <div class="radar-filter-bar">
            <!-- Nível 1: Origem / Proveniência dos Dados -->
            <div class="filter-provenance-row">
                <div class="filter-headline">
                    <i class="fas fa-layer-group"></i> <strong>Filtrar por Origem:</strong>
                </div>
                <div class="radar-prov-tabs" id="radarProvTabs">
                    <button type="button" class="radar-prov-btn active" data-prov="all" onclick="filterRadarCards('prov', 'all', this)">
                        <span>📊 Todas as Origens (<?php echo count($cards); ?>)</span>
                    </button>
                    <button type="button" class="radar-prov-btn btn-terceiros" data-prov="terceiros" onclick="filterRadarCards('prov', 'terceiros', this)">
                        <i class="fas fa-globe"></i>
                        <span>Dados de Terceiros (<?php echo $count_terceiros; ?>)</span>
                    </button>
                    <button type="button" class="radar-prov-btn btn-proprios" data-prov="proprios" onclick="filterRadarCards('prov', 'proprios', this)">
                        <i class="fas fa-certificate"></i>
                        <span>Dados Próprios (<?php echo $count_proprios; ?>)</span>
                    </button>
                    <button type="button" class="radar-prov-btn btn-setoriais" data-prov="setoriais" onclick="filterRadarCards('prov', 'setoriais', this)">
                        <i class="fas fa-landmark"></i>
                        <span>Dados Setoriais (<?php echo $count_setoriais; ?>)</span>
                    </button>
                </div>
            </div>

            <!-- Nível 2: Recorte Temático -->
            <div class="filter-topic-row">
                <div class="filter-headline">
                    <i class="fas fa-tags"></i> <strong>Recorte Temático:</strong>
                </div>
                <div class="radar-topic-tabs" id="radarTopicTabs">
                    <button type="button" class="radar-topic-btn active" data-topic="all" onclick="filterRadarCards('topic', 'all', this)">
                        Todos os Segmentos
                    </button>
                    <button type="button" class="radar-topic-btn" data-topic="global" onclick="filterRadarCards('topic', 'global', this)">
                        🌍 Internacional
                    </button>
                    <button type="button" class="radar-topic-btn" data-topic="brasil" onclick="filterRadarCards('topic', 'brasil', this)">
                        🇧🇷 Brasil &amp; Latam
                    </button>
                    <button type="button" class="radar-topic-btn" data-topic="inovacao" onclick="filterRadarCards('topic', 'inovacao', this)">
                        ⚡ Sextech &amp; IoT
                    </button>
                    <button type="button" class="radar-topic-btn" data-topic="varejo" onclick="filterRadarCards('topic', 'varejo', this)">
                        🛒 Varejo &amp; Distribuição
                    </button>
                    <button type="button" class="radar-topic-btn" data-topic="consumo" onclick="filterRadarCards('topic', 'consumo', this)">
                        👥 Comportamento
                    </button>
                </div>
            </div>
        </div>

        <!-- Cards Grid com Segregação Visual de Proveniência -->
        <div class="radar-cards-grid" id="radarCardsGrid">
            <?php foreach ($cards as $c): 
                $prov_slug = $c['provenance'] ?? 'terceiros';
                $prov_info = mercado_get_radar_provenance_info($prov_slug);
            ?>
                <div class="radar-card card-prov-<?php echo esc_attr($prov_info['slug']); ?>" 
                     data-cats="<?php echo esc_attr($c['cats']); ?>" 
                     data-provenance="<?php echo esc_attr($prov_info['slug']); ?>" 
                     id="<?php echo esc_attr($c['id']); ?>">
                    
                    <!-- Provenance Header Ribbon -->
                    <div class="card-prov-ribbon ribbon-<?php echo esc_attr($prov_info['slug']); ?>">
                        <span class="ribbon-label">
                            <i class="<?php echo esc_attr($prov_info['fa_icon']); ?>"></i>
                            <?php echo esc_html($prov_info['label']); ?>
                        </span>
                        <span class="ribbon-sub"><?php echo esc_html($prov_info['subtitle']); ?></span>
                    </div>

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
                    <?php 
                    $converted_brl = mercado_format_usd_brl($c['value'], $dollar_info['rate']);
                    if (!empty($converted_brl)): ?>
                        <div class="radar-card-converted-val" title="Conversão automática pelo câmbio oficial BACEN">
                            <i class="fas fa-calculator"></i> <?php echo esc_html($converted_brl); ?>
                        </div>
                    <?php endif; ?>

                    <h3 class="radar-card-title"><?php echo esc_html($c['title']); ?></h3>

                    <p class="radar-card-desc"><?php echo esc_html($c['desc']); ?></p>

                    <div class="radar-card-meta">
                        <div class="card-source">
                            <span class="source-prov-chip chip-<?php echo esc_attr($prov_info['slug']); ?>">
                                <i class="<?php echo esc_attr($prov_info['fa_icon']); ?>"></i> <?php echo esc_html($prov_info['short_label']); ?>
                            </span>
                            <span class="source-text"><strong>Fonte:</strong> <?php echo esc_html($c['source']); ?></span>
                        </div>
                        <div class="card-period">
                            <i class="fas fa-calendar-alt"></i> <?php echo esc_html($c['date']); ?>
                        </div>
                    </div>

                    <div class="radar-card-footer">
                        <button type="button" class="btn-solicitar-editorial" onclick="openEditorialModal('<?php echo esc_js($c['title']); ?>', '<?php echo esc_js($c['value']); ?>', '<?php echo esc_js($c['source']); ?>', '<?php echo esc_js($prov_info['label']); ?>')">
                            <i class="fas fa-file-contract"></i> Solicitar Detalhes à Equipe Editorial
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div id="radarNoResults" class="radar-no-results" style="display:none;">
            <i class="fas fa-search" style="font-size:2rem;color:#94a3b8;margin-bottom:12px;"></i>
            <h3>Nenhum indicador encontrado para esta combinação</h3>
            <p>Tente selecionar outro segmento ou clique abaixo para ver todos os dados.</p>
            <button type="button" class="btn-radar-reset-filter" onclick="resetRadarFilters()">
                <i class="fas fa-undo"></i> Redefinir Todos os Filtros
            </button>
        </div>
        <!-- SEÇÃO DINÂMICA: ÚLTIMAS PESQUISAS & ESTUDOS PUBLICADOS PELA REDAÇÃO -->
                <!-- SEÇÃO EDITORIAL: PESQUISAS & ESTUDOS DA REDAÇÃO -->
        <?php
        $pesquisas_query = new WP_Query(array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'category_name'  => 'pesquisas',
            'posts_per_page' => 6,
            'orderby'        => 'date',
            'order'          => 'DESC'
        ));
        if ($pesquisas_query->have_posts()):
        ?>
        <section class="radar-news-section">
            <div class="radar-news-header">
                <div class="radar-news-titles">
                    <span class="radar-news-overline">COBERTURA &amp; INTELIGÊNCIA EDITORIAL</span>
                    <h2 class="radar-news-heading">Reportagens &amp; Pesquisas Recentes</h2>
                    <p class="radar-news-sub">Estudos comportamentais, censos setoriais e investigações jornalísticas apuradas pelo Mercado Erótico.</p>
                </div>
                <div class="radar-news-counter">
                    <i class="fas fa-layer-group"></i> <strong><?php echo $pesquisas_count; ?></strong> estudos catalogados
                </div>
            </div>

            <div class="radar-news-grid">
                <?php while ($pesquisas_query->have_posts()): $pesquisas_query->the_post(); 
                    $post_thumb = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
                    if (empty($post_thumb)) {
                        $post_thumb = 'https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2026/11/banner_livraria_vitrine_digital.webp';
                    }
                    $post_date = get_the_date('d/m/Y');
                    $post_author = get_the_author();
                ?>
                    <article class="radar-news-card">
                        <a href="<?php the_permalink(); ?>" class="news-card-media" tabindex="-1" aria-hidden="true">
                            <img src="<?php echo esc_url($post_thumb); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" class="news-card-img">
                            <span class="news-card-tag">Pesquisa</span>
                        </a>
                        <div class="news-card-content">
                            <div class="news-card-meta">
                                <span><i class="far fa-calendar-alt"></i> <?php echo esc_html($post_date); ?></span>
                                <span class="meta-dot">•</span>
                                <span><i class="far fa-user"></i> <?php echo esc_html($post_author); ?></span>
                            </div>
                            <h3 class="news-card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <p class="news-card-excerpt">
                                <?php echo esc_html(wp_trim_words(get_the_excerpt(), 15, '...')); ?>
                            </p>
                            <a href="<?php the_permalink(); ?>" class="news-card-link">
                                <span>Ler pesquisa completa</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>

            <div class="radar-news-footer">
                <a href="<?php echo home_url('/acervo/?tema=pesquisas#acervo-recorte'); ?>" class="btn-radar-news-more">
                    <span>Ver todas as <?php echo $pesquisas_count; ?> pesquisas no Acervo Histórico</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </section>
        <?php endif; ?>

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
                    <small><i class="fas fa-shield-alt"></i> Portal Mercado Erótico • Jornalismo e Inteligência de Mercado desde 2000 | Acervo Digital desde 2018</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts and Styles -->
    <script>
    let currentProvFilter = 'all';
    let currentTopicFilter = 'all';

    function filterRadarCards(type, val, btn) {
        if (type === 'prov') {
            currentProvFilter = val;
            const provButtons = document.querySelectorAll('#radarProvTabs .radar-prov-btn');
            provButtons.forEach(b => b.classList.remove('active'));
            if (btn) btn.classList.add('active');
        } else if (type === 'topic') {
            currentTopicFilter = val;
            const topicButtons = document.querySelectorAll('#radarTopicTabs .radar-topic-btn');
            topicButtons.forEach(b => b.classList.remove('active'));
            if (btn) btn.classList.add('active');
        }

        let visibleCount = 0;
        const cards = document.querySelectorAll('#radarCardsGrid .radar-card');
        cards.forEach(card => {
            const cardProv = card.getAttribute('data-provenance') || 'terceiros';
            const cardCats = (card.getAttribute('data-cats') || '').split(',');

            const matchProv = (currentProvFilter === 'all' || cardProv === currentProvFilter);
            const matchTopic = (currentTopicFilter === 'all' || cardCats.includes(currentTopicFilter));

            if (matchProv && matchTopic) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        const noRes = document.getElementById('radarNoResults');
        if (noRes) {
            noRes.style.display = (visibleCount === 0) ? 'block' : 'none';
        }
    }

    function resetRadarFilters() {
        currentProvFilter = 'all';
        currentTopicFilter = 'all';
        document.querySelectorAll('#radarProvTabs .radar-prov-btn').forEach(b => {
            b.classList.toggle('active', b.getAttribute('data-prov') === 'all');
        });
        document.querySelectorAll('#radarTopicTabs .radar-topic-btn').forEach(b => {
            b.classList.toggle('active', b.getAttribute('data-topic') === 'all');
        });
        document.querySelectorAll('#radarCardsGrid .radar-card').forEach(card => {
            card.style.display = 'flex';
        });
        const noRes = document.getElementById('radarNoResults');
        if (noRes) noRes.style.display = 'none';
    }

    function openEditorialModal(title, value, source, provLabel) {
        document.getElementById('modalIndicatorTitle').innerText = title;
        document.getElementById('modalIndicatorValue').innerText = value;
        document.getElementById('modalIndicatorSource').innerText = source + (provLabel ? ' [' + provLabel + ']' : '');

        const phone = '5562982763039';
        const msg = 'Olá equipe editorial do Portal Mercado Erótico! Gostaria de receber os dados detalhados e relatório completo sobre a pesquisa "' + title + '" (Valor: ' + value + ', Fonte: ' + source + (provLabel ? ', Tipo: ' + provLabel : '') + ').';
        
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
    
    
    /* MATRIZ METODOLÓGICA & CREDIBILIDADE EDITORIAL */
    .radar-methodology-section {
        margin: 35px 0 30px;
    }
    .methodology-card-panel {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        padding: 35px 30px 30px;
        position: relative;
        overflow: hidden;
    }
    .methodology-card-panel::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(90deg, #7c3aed 0%, #e31c61 50%, #0284c7 100%);
    }
    .methodology-panel-header {
        text-align: center;
        max-width: 820px;
        margin: 0 auto 30px;
    }
    .methodology-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 5px 14px;
        border-radius: 50px;
        font-size: 0.74rem;
        font-weight: 800;
        letter-spacing: 1px;
        margin-bottom: 12px;
    }
    .methodology-badge i {
        color: #e31c61;
    }
    .methodology-title {
        font-size: 1.85rem;
        font-weight: 900;
        color: #0f172a;
        margin: 0 0 10px;
        line-height: 1.25;
        letter-spacing: -0.3px;
    }
    .methodology-subtitle {
        font-size: 0.98rem;
        color: #64748b;
        line-height: 1.6;
        margin: 0;
    }
    .methodology-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 22px;
    }
    .methodology-col {
        border-radius: 14px;
        padding: 24px 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        cursor: pointer;
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        position: relative;
    }
    .methodology-col:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08);
    }
    /* Coluna Terceiros */
    .methodology-col.col-terceiros {
        background: linear-gradient(180deg, #faf5ff 0%, #ffffff 100%);
        border: 1.5px solid #e9d5ff;
    }
    .methodology-col.col-terceiros:hover {
        border-color: #7c3aed;
    }
    .methodology-col.col-terceiros .methodology-icon {
        background: #7c3aed;
        color: #ffffff;
    }
    /* Coluna Próprios */
    .methodology-col.col-proprios {
        background: linear-gradient(180deg, #fff1f5 0%, #ffffff 100%);
        border: 1.5px solid #fbcfe8;
    }
    .methodology-col.col-proprios:hover {
        border-color: #e31c61;
    }
    .methodology-col.col-proprios .methodology-icon {
        background: #e31c61;
        color: #ffffff;
    }
    /* Coluna Setoriais */
    .methodology-col.col-setoriais {
        background: linear-gradient(180deg, #f0f9ff 0%, #ffffff 100%);
        border: 1.5px solid #bae6fd;
    }
    .methodology-col.col-setoriais:hover {
        border-color: #0284c7;
    }
    .methodology-col.col-setoriais .methodology-icon {
        background: #0284c7;
        color: #ffffff;
    }

    .methodology-col-top {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 14px;
    }
    .methodology-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12);
    }
    .methodology-col-labels {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .methodology-type-pill {
        font-size: 0.68rem;
        font-weight: 800;
        letter-spacing: 0.8px;
        text-transform: uppercase;
    }
    .methodology-type-pill.prov-terceiros { color: #7c3aed; }
    .methodology-type-pill.prov-proprios  { color: #e31c61; }
    .methodology-type-pill.prov-setoriais { color: #0284c7; }
    .methodology-col-name {
        font-size: 1.15rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        line-height: 1.2;
    }
    .methodology-col-desc {
        font-size: 0.88rem;
        color: #475569;
        line-height: 1.55;
        margin: 0 0 18px;
        flex: 1;
    }
    .methodology-col-desc strong {
        color: #1e293b;
    }
    .methodology-col-foot {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 12px;
        border-top: 1px dashed #e2e8f0;
    }
    .methodology-stat-badge {
        font-size: 0.78rem;
        color: #64748b;
    }
    .methodology-stat-badge strong {
        color: #0f172a;
    }
    .methodology-click-hint {
        font-size: 0.76rem;
        font-weight: 700;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: color 0.2s ease, transform 0.2s ease;
    }
    .methodology-col:hover .methodology-click-hint {
        color: #0f172a;
        transform: translateX(3px);
    }

    /* FILTER BAR DUPLA */
    .radar-filter-bar {
        background: #ffffff;
        border-radius: 16px;
        padding: 22px 24px;
        box-shadow: 0 6px 25px rgba(0,0,0,0.05);
        border: 1px solid #e2e8f0;
        margin: 0 0 35px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .filter-provenance-row,
    .filter-topic-row {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }
    .filter-provenance-row {
        padding-bottom: 14px;
        border-bottom: 1px solid #f1f5f9;
    }
    .filter-headline {
        font-size: 0.86rem;
        color: #475569;
        white-space: nowrap;
        min-width: 155px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .filter-headline i {
        color: #e31c61;
    }
    .radar-prov-tabs,
    .radar-topic-tabs {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        flex: 1;
    }
    .radar-prov-btn {
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        color: #334155;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: all 0.2s ease;
    }
    .radar-prov-btn:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
    }
    .radar-prov-btn.active {
        background: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
        box-shadow: 0 3px 12px rgba(15, 23, 42, 0.25);
    }
    .radar-prov-btn.btn-terceiros.active {
        background: #7c3aed;
        border-color: #7c3aed;
        box-shadow: 0 3px 12px rgba(124, 58, 237, 0.35);
    }
    .radar-prov-btn.btn-proprios.active {
        background: #e31c61;
        border-color: #e31c61;
        box-shadow: 0 3px 12px rgba(227, 28, 97, 0.35);
    }
    .radar-prov-btn.btn-setoriais.active {
        background: #0284c7;
        border-color: #0284c7;
        box-shadow: 0 3px 12px rgba(2, 132, 199, 0.35);
    }

    .radar-topic-btn {
        background: transparent;
        border: 1px solid transparent;
        color: #64748b;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 0.84rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .radar-topic-btn:hover {
        background: #f1f5f9;
        color: #1e293b;
    }
    .radar-topic-btn.active {
        background: #f1f5f9;
        color: #0f172a;
        font-weight: 800;
        border: 1px solid #cbd5e1;
    }

    /* CARDS: SEGREGAÇÃO VISUAL POR PROVENIÊNCIA */
    .radar-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(0,0,0,0.04);
        padding: 20px 24px 24px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        position: relative;
        overflow: hidden;
    }
    .radar-card.card-prov-terceiros {
        border-top: 4px solid #7c3aed;
    }
    .radar-card.card-prov-terceiros:hover {
        border-color: #c4b5fd;
        box-shadow: 0 12px 30px rgba(124, 58, 237, 0.12);
        transform: translateY(-4px);
    }
    .radar-card.card-prov-proprios {
        border-top: 4px solid #e31c61;
    }
    .radar-card.card-prov-proprios:hover {
        border-color: #fbcfe8;
        box-shadow: 0 12px 30px rgba(227, 28, 97, 0.12);
        transform: translateY(-4px);
    }
    .radar-card.card-prov-setoriais {
        border-top: 4px solid #0284c7;
    }
    .radar-card.card-prov-setoriais:hover {
        border-color: #bae6fd;
        box-shadow: 0 12px 30px rgba(2, 132, 199, 0.12);
        transform: translateY(-4px);
    }

    /* CARD HEADER RIBBON */
    .card-prov-ribbon {
        margin: -20px -24px 16px -24px;
        padding: 8px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.72rem;
        letter-spacing: 0.5px;
        border-bottom: 1px solid;
    }
    .card-prov-ribbon.ribbon-terceiros {
        background: #faf5ff;
        border-bottom-color: #ede9fe;
        color: #6d28d9;
    }
    .card-prov-ribbon.ribbon-proprios {
        background: #fff1f5;
        border-bottom-color: #ffe4e6;
        color: #be185d;
    }
    .card-prov-ribbon.ribbon-setoriais {
        background: #f0f9ff;
        border-bottom-color: #e0f2fe;
        color: #0369a1;
    }
    .ribbon-label {
        font-weight: 800;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .ribbon-sub {
        font-weight: 600;
        opacity: 0.85;
    }

    /* SOURCE PROVENANCE CHIPS */
    .source-prov-chip {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 7px;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-right: 6px;
    }
    .source-prov-chip.chip-terceiros {
        background: #ede9fe;
        color: #6d28d9;
        border: 1px solid #ddd6fe;
    }
    .source-prov-chip.chip-proprios {
        background: #fce7f3;
        color: #be185d;
        border: 1px solid #fbcfe8;
    }
    .source-prov-chip.chip-setoriais {
        background: #e0f2fe;
        color: #0369a1;
        border: 1px solid #bae6fd;
    }

    /* NO RESULTS BLOCK */
    .radar-no-results {
        background: #f8fafc;
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        padding: 50px 25px;
        text-align: center;
        margin: 30px auto;
        max-width: 550px;
    }
    .radar-no-results h3 {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1e293b;
        margin: 0 0 8px;
    }
    .radar-no-results p {
        font-size: 0.95rem;
        color: #64748b;
        margin: 0 0 20px;
    }
    .btn-radar-reset-filter {
        background: #e31c61;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 50px;
        font-size: 0.88rem;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background 0.2s ease, transform 0.2s ease;
    }
    .btn-radar-reset-filter:hover {
        background: #c21550;
        transform: translateY(-2px);
    }

    @media (max-width: 900px) {
        .methodology-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        .filter-provenance-row,
        .filter-topic-row {
            flex-direction: column;
            align-items: flex-start;
        }
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

    /* Conversão Automática BACEN */
    .radar-card-converted-val {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.78rem;
        font-weight: 700;
        margin-bottom: 12px;
    }
    .radar-card-converted-val i {
        color: #10b981;
    }

    /* Editorial News Section (Sleek Magazine Standard) */
    .radar-news-section {
        margin: 60px 0 50px;
        padding-top: 35px;
        border-top: 1px solid #e2e8f0;
    }
    .radar-news-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 20px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }
    .radar-news-overline {
        display: block;
        font-size: 0.74rem;
        font-weight: 800;
        letter-spacing: 1.5px;
        color: #e31c61;
        margin-bottom: 6px;
        text-transform: uppercase;
    }
    .radar-news-heading {
        font-size: 1.85rem;
        font-weight: 900;
        color: #0f172a;
        margin: 0 0 6px;
        letter-spacing: -0.5px;
        line-height: 1.25;
    }
    .radar-news-sub {
        font-size: 0.95rem;
        color: #64748b;
        margin: 0;
        line-height: 1.5;
    }
    .radar-news-counter {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f1f5f9;
        color: #475569;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.82rem;
        border: 1px solid #e2e8f0;
        white-space: nowrap;
    }
    .radar-news-counter i {
        color: #e31c61;
    }
    .radar-news-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 25px;
        margin-bottom: 35px;
    }
    .radar-news-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }
    .radar-news-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        border-color: #cbd5e1;
    }
    .news-card-media {
        position: relative;
        display: block;
        width: 100%;
        aspect-ratio: 16 / 9;
        overflow: hidden;
        background: #f8fafc;
    }
    .news-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .radar-news-card:hover .news-card-img {
        transform: scale(1.03);
    }
    .news-card-tag {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(15, 23, 42, 0.85);
        color: #fff;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding: 3px 8px;
        border-radius: 4px;
        backdrop-filter: blur(4px);
    }
    .news-card-content {
        padding: 18px 20px 20px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .news-card-meta {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.78rem;
        color: #94a3b8;
        margin-bottom: 8px;
    }
    .news-card-meta .meta-dot {
        opacity: 0.5;
    }
    .news-card-title {
        font-size: 1.05rem;
        font-weight: 700;
        line-height: 1.4;
        margin: 0 0 8px;
    }
    .news-card-title a {
        color: #0f172a !important;
        text-decoration: none !important;
        transition: color 0.2s ease;
    }
    .news-card-title a:hover {
        color: #e31c61 !important;
    }
    .news-card-excerpt {
        font-size: 0.88rem;
        color: #64748b;
        line-height: 1.5;
        margin: 0 0 16px;
        flex: 1;
    }
    .news-card-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        font-weight: 700;
        color: #e31c61 !important;
        text-decoration: none !important;
        margin-top: auto;
        transition: gap 0.2s ease;
    }
    .news-card-link:hover {
        gap: 10px;
    }
    .radar-news-footer {
        text-align: center;
    }
    .btn-radar-news-more {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        color: #0f172a !important;
        border: 1px solid #cbd5e1;
        padding: 10px 22px;
        border-radius: 25px;
        font-size: 0.88rem;
        font-weight: 700;
        text-decoration: none !important;
        transition: all 0.2s ease;
    }
    .btn-radar-news-more:hover {
        background: #e31c61;
        color: #fff !important;
        border-color: #e31c61;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(227, 28, 97, 0.25);
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
        .radar-news-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }
        .radar-news-grid {
            grid-template-columns: 1fr;
        }
        .btn-radar-news-more {
            width: 100%;
            justify-content: center;
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


/**
 * ============================================================================
 * 3. PAINEL DE CONTROLE WORDPRESS: GESTÃO DO RADAR & PESQUISAS DE MERCADO
 * ============================================================================
 */
add_action('admin_menu', 'mercado_pesquisas_register_admin_menu');
function mercado_pesquisas_register_admin_menu() {
    add_menu_page(
        'Pesquisas & Radar Econômico',
        'Pesquisas & Radar',
        'manage_options',
        'mercado-pesquisas-radar',
        'mercado_pesquisas_render_admin_dashboard',
        'dashicons-chart-area',
        28
    );
}

/**
 * Admin Action Handlers (Save KPIs, Add/Edit Card, Delete Card, Reset)
 */
add_action('admin_init', 'mercado_pesquisas_handle_admin_actions');
function mercado_pesquisas_handle_admin_actions() {
    if (!current_user_can('manage_options')) return;

    // A. Salvar KPIs do Topo
    if (isset($_POST['mercado_pesquisas_action']) && $_POST['mercado_pesquisas_action'] === 'save_kpis') {
        check_admin_referer('mercado_pesquisas_kpis_verify', 'mercado_kpis_nonce');

        $kpis = array();
        if (isset($_POST['kpi_num']) && is_array($_POST['kpi_num'])) {
            foreach ($_POST['kpi_num'] as $i => $num) {
                $lbl = isset($_POST['kpi_label'][$i]) ? sanitize_text_field($_POST['kpi_label'][$i]) : '';
                $num = sanitize_text_field($num);
                if (!empty($num) || !empty($lbl)) {
                    $kpis[] = array('num' => $num, 'label' => $lbl);
                }
            }
        }
        if (!empty($kpis)) {
            update_option('mercado_radar_kpis', $kpis);
        }
        wp_redirect(admin_url('admin.php?page=mercado-pesquisas-radar&msg=kpis_saved'));
        exit;
    }

    // B. Salvar / Atualizar Card
    if (isset($_POST['mercado_pesquisas_action']) && $_POST['mercado_pesquisas_action'] === 'save_card') {
        check_admin_referer('mercado_pesquisas_card_verify', 'mercado_card_nonce');

        $cards = mercado_get_radar_cards();
        $card_id = sanitize_title($_POST['card_id']);
        if (empty($card_id)) {
            $card_id = 'card-' . time();
        }

        $cats = isset($_POST['card_cats']) && is_array($_POST['card_cats']) ? implode(',', array_map('sanitize_key', $_POST['card_cats'])) : 'all';
        if (strpos($cats, 'all') === false) {
            $cats = 'all,' . $cats;
        }

        $prov = isset($_POST['card_provenance']) ? sanitize_key($_POST['card_provenance']) : 'terceiros';
        if (!in_array($prov, array('terceiros', 'proprios', 'setoriais'))) {
            $prov = 'terceiros';
        }

        $new_card = array(
            'id'         => $card_id,
            'cats'       => $cats,
            'cat_label'  => sanitize_text_field($_POST['card_cat_label']),
            'provenance' => $prov,
            'icon'       => sanitize_text_field($_POST['card_icon']),
            'value'      => sanitize_text_field($_POST['card_value']),
            'tag'        => sanitize_text_field($_POST['card_tag']),
            'title'      => sanitize_text_field($_POST['card_title']),
            'desc'       => sanitize_textarea_field($_POST['card_desc']),
            'source'     => sanitize_text_field($_POST['card_source']),
            'date'       => sanitize_text_field($_POST['card_date']),
        );

        $exists = false;
        foreach ($cards as $idx => $c) {
            if ($c['id'] === $card_id) {
                $cards[$idx] = $new_card;
                $exists = true;
                break;
            }
        }
        if (!$exists) {
            array_unshift($cards, $new_card);
        }

        update_option('mercado_radar_cards', $cards);
        wp_redirect(admin_url('admin.php?page=mercado-pesquisas-radar&msg=card_saved'));
        exit;
    }

    // C. Excluir Card
    if (isset($_GET['action']) && $_GET['action'] === 'delete_card' && isset($_GET['card_id'])) {
        check_admin_referer('delete_card_' . $_GET['card_id']);

        $cards = mercado_get_radar_cards();
        $target_id = sanitize_title($_GET['card_id']);
        $filtered = array();
        foreach ($cards as $c) {
            if ($c['id'] !== $target_id) {
                $filtered[] = $c;
            }
        }
        update_option('mercado_radar_cards', $filtered);
        wp_redirect(admin_url('admin.php?page=mercado-pesquisas-radar&msg=card_deleted'));
        exit;
    }

    // D. Restaurar Padrões Originais
    if (isset($_POST['mercado_pesquisas_action']) && $_POST['mercado_pesquisas_action'] === 'reset_defaults') {
        check_admin_referer('mercado_pesquisas_reset_verify', 'mercado_reset_nonce');

        delete_option('mercado_radar_cards');
        delete_option('mercado_radar_kpis');

        wp_redirect(admin_url('admin.php?page=mercado-pesquisas-radar&msg=reset_done'));
        exit;
    }
}

/**
 * Render Admin Dashboard
 */
function mercado_pesquisas_render_admin_dashboard() {
    $cards = mercado_get_radar_cards();
    $kpis  = mercado_get_radar_kpis();
    $pesquisas_cat = get_category_by_slug('pesquisas');
    $pesquisas_count = $pesquisas_cat ? intval($pesquisas_cat->count) : 0;
    $mes_atual = date_i18n('F \d\e Y');

    // Edit mode
    $editing_card = null;
    if (isset($_GET['edit_card'])) {
        $edit_id = sanitize_title($_GET['edit_card']);
        foreach ($cards as $c) {
            if ($c['id'] === $edit_id) {
                $editing_card = $c;
                break;
            }
        }
    }
    ?>
    <div class="wrap me-admin-wrap">
        <h1 class="wp-heading-inline"><span class="dashicons dashicons-chart-area" style="font-size:30px;width:30px;height:30px;margin-right:8px;color:#e31c61;"></span> Gestão do Radar Econômico &amp; Pesquisas</h1>
        <hr class="wp-header-end">

        <?php if (isset($_GET['msg'])): ?>
            <?php if ($_GET['msg'] === 'kpis_saved'): ?>
                <div class="notice notice-success is-dismissible"><p><strong>Sucesso:</strong> Indicadores macroeconômicos do topo (KPIs) atualizados com sucesso!</p></div>
            <?php elseif ($_GET['msg'] === 'card_saved'): ?>
                <div class="notice notice-success is-dismissible"><p><strong>Sucesso:</strong> Indicador de pesquisa salvo e atualizado no Radar!</p></div>
            <?php elseif ($_GET['msg'] === 'card_deleted'): ?>
                <div class="notice notice-warning is-dismissible"><p><strong>Aviso:</strong> Indicador excluído do Radar.</p></div>
            <?php elseif ($_GET['msg'] === 'reset_done'): ?>
                <div class="notice notice-info is-dismissible"><p><strong>Restaurado:</strong> Todos os indicadores e KPIs foram restaurados para a base analítica original da redação.</p></div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Automated Status Banner -->
        <?php
        $dollar_info = mercado_get_bacen_dollar_info();
        $posts_count = wp_count_posts('agenda_evento');
        $agenda_count = !empty($posts_count->publish) ? intval($posts_count->publish) : 336;
        $livraria_count = function_exists('mercado_livraria_get_data') ? count(mercado_livraria_get_data()) : 54;
        ?>
        <div class="me-status-box">
            <div class="me-status-item">
                <span class="me-status-dot"></span>
                <strong>Página Ativa:</strong>
                <a href="<?php echo esc_url(home_url('/pesquisas-de-mercado/')); ?>" target="_blank" class="button button-small" style="margin-left:8px;">
                    Ver /pesquisas-de-mercado/ <span class="dashicons dashicons-external" style="font-size:14px;vertical-align:middle;"></span>
                </a>
            </div>
            <div class="me-status-item">
                <span class="dashicons dashicons-chart-line" style="color:#10b981;"></span>
                <strong>Câmbio Oficial BACEN:</strong>
                <span>US$ 1 = <strong>R$ <?php echo number_format($dollar_info['rate'], 2, ',', '.'); ?></strong> (Série 10813 PTAX &bull; Caching 12h &bull; Custo R$ 0,00).</span>
            </div>
            <div class="me-status-item">
                <span class="dashicons dashicons-calendar" style="color:#f59e0b;"></span>
                <strong>Agenda Conectada:</strong>
                <span><strong><?php echo $agenda_count; ?></strong> eventos ao vivo.</span>
            </div>
            <div class="me-status-item">
                <span class="dashicons dashicons-book" style="color:#8b5cf6;"></span>
                <strong>Acervo Conectado:</strong>
                <span><strong><?php echo $livraria_count; ?></strong> manuais/e-books.</span>
            </div>
            <div class="me-status-item">
                <span class="dashicons dashicons-category" style="color:#3b82f6;"></span>
                <strong>Feed Pesquisas:</strong>
                <span><strong><?php echo $pesquisas_count; ?></strong> matérias ativas.</span>
            </div>
        </div>

        <div class="me-admin-columns">
            <!-- Left Column: KPIs & Indicators List -->
            <div class="me-col-main">

                <!-- 1. KPIs Top Bar -->
                <div class="postbox me-postbox">
                    <div class="postbox-header">
                        <h2><span class="dashicons dashicons-performance"></span> 1. Os 4 Indicadores Macroeconômicos do Topo (Hero KPIs)</h2>
                    </div>
                    <div class="inside">
                        <p class="description">Estes 4 números aparecem com grande destaque no topo da página de pesquisas. Você pode alterar os valores e rótulos a qualquer momento.</p>
                        <form method="post" action="">
                            <?php wp_nonce_field('mercado_pesquisas_kpis_verify', 'mercado_kpis_nonce'); ?>
                            <input type="hidden" name="mercado_pesquisas_action" value="save_kpis">

                            <div class="me-kpis-grid">
                                <?php for ($i = 0; $i < 4; $i++): 
                                    $num_val = isset($kpis[$i]['num']) ? $kpis[$i]['num'] : '';
                                    $lbl_val = isset($kpis[$i]['label']) ? $kpis[$i]['label'] : '';
                                ?>
                                    <div class="me-kpi-card-edit">
                                        <div class="me-kpi-badge">KPI #<?php echo ($i+1); ?></div>
                                        <label>Valor / Número:</label>
                                        <input type="text" name="kpi_num[<?php echo $i; ?>]" value="<?php echo esc_attr($num_val); ?>" placeholder="Ex: US$ 42+ Bi" class="regular-text" style="width:100%;font-weight:700;">
                                        
                                        <label style="margin-top:8px;display:block;">Descrição / Legenda:</label>
                                        <input type="text" name="kpi_label[<?php echo $i; ?>]" value="<?php echo esc_attr($lbl_val); ?>" placeholder="Ex: Mercado Global Atual" class="regular-text" style="width:100%;">
                                    </div>
                                <?php endfor; ?>
                            </div>

                            <p style="margin-top:20px;text-align:right;">
                                <button type="submit" class="button button-primary button-large">
                                    <span class="dashicons dashicons-saved" style="vertical-align:middle;"></span> Salvar KPIs do Topo
                                </button>
                            </p>
                        </form>
                    </div>
                </div>

                <!-- 2. Active Research Cards List -->
                <div class="postbox me-postbox">
                    <div class="postbox-header">
                        <h2><span class="dashicons dashicons-grid-view"></span> 2. Indicadores &amp; Cards Cadastrados (<?php echo count($cards); ?> no Total)</h2>
                    </div>
                    <div class="inside">
                        <p class="description">Estes são os cards interativos que aparecem no grid da página de pesquisas com filtros e modal de contato editorial.</p>
                        <table class="wp-list-table widefat fixed striped">
                            <thead>
                                <tr>
                                    <th style="width:50px;">Ícone</th>
                                    <th style="width:130px;">Valor Principal</th>
                                    <th>Título &amp; Categoria</th>
                                    <th style="width:140px;">Tipologia</th>
                                    <th style="width:160px;">Fonte &amp; Ano</th>
                                    <th style="width:120px;text-align:right;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($cards)): ?>
                                    <?php foreach ($cards as $c): ?>
                                        <tr>
                                            <td style="font-size:24px;text-align:center;"><?php echo $c['icon']; ?></td>
                                            <td><strong style="color:#e31c61;font-size:15px;"><?php echo esc_html($c['value']); ?></strong><br><small style="color:#64748b;"><?php echo esc_html($c['tag']); ?></small></td>
                                            <td>
                                                <strong><?php echo esc_html($c['title']); ?></strong><br>
                                                <span class="me-cat-pill"><?php echo esc_html($c['cat_label']); ?></span>
                                                <small style="color:#94a3b8;margin-left:6px;">Filtros: <code><?php echo esc_html($c['cats']); ?></code></small>
                                            </td>
                                            <td>
                                                <?php 
                                                $p_info = mercado_get_radar_provenance_info($c['provenance'] ?? 'terceiros'); 
                                                $badge_styles = array(
                                                    'terceiros' => 'background:#ede9fe;color:#6d28d9;border:1px solid #ddd6fe;',
                                                    'proprios'  => 'background:#fce7f3;color:#be185d;border:1px solid #fbcfe8;',
                                                    'setoriais' => 'background:#e0f2fe;color:#0369a1;border:1px solid #bae6fd;'
                                                );
                                                $bstyle = $badge_styles[$p_info['slug']] ?? $badge_styles['terceiros'];
                                                ?>
                                                <span style="<?php echo $bstyle; ?>padding:4px 8px;border-radius:12px;font-size:11px;font-weight:700;display:inline-block;">
                                                    <?php echo $p_info['icon'] . ' ' . esc_html($p_info['label']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <small><strong><?php echo esc_html($c['source']); ?></strong></small><br>
                                                <small style="color:#64748b;"><?php echo esc_html($c['date']); ?></small>
                                            </td>
                                            <td style="text-align:right;">
                                                <a href="<?php echo admin_url('admin.php?page=mercado-pesquisas-radar&edit_card=' . esc_attr($c['id'])); ?>" class="button button-small">
                                                    Editar
                                                </a>
                                                <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=mercado-pesquisas-radar&action=delete_card&card_id=' . esc_attr($c['id'])), 'delete_card_' . $c['id']); ?>" class="button button-small button-link-delete" onclick="return confirm('Tem certeza que deseja excluir este indicador?');">
                                                    Excluir
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5">Nenhum card cadastrado. Clique no formulário ao lado ou restaure os padrões.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- Right Column: Add / Edit Form & Reset -->
            <div class="me-col-side">

                <!-- Add/Edit Form -->
                <div class="postbox me-postbox" style="border-top: 3px solid #e31c61;">
                    <div class="postbox-header">
                        <h2>
                            <?php if ($editing_card): ?>
                                <span class="dashicons dashicons-edit"></span> Editar Indicador: <em><?php echo esc_html($editing_card['title']); ?></em>
                            <?php else: ?>
                                <span class="dashicons dashicons-plus-alt"></span> Cadastrar Novo Indicador
                            <?php endif; ?>
                        </h2>
                    </div>
                    <div class="inside">
                        <form method="post" action="">
                            <?php wp_nonce_field('mercado_pesquisas_card_verify', 'mercado_card_nonce'); ?>
                            <input type="hidden" name="mercado_pesquisas_action" value="save_card">
                            <input type="hidden" name="card_id" value="<?php echo $editing_card ? esc_attr($editing_card['id']) : ''; ?>">

                            <p>
                                <label><strong>Valor em Destaque (Destaque visual):</strong></label><br>
                                <input type="text" name="card_value" value="<?php echo $editing_card ? esc_attr($editing_card['value']) : ''; ?>" placeholder="Ex: US$ 42+ Bi ou 77,9%" class="widefat" required>
                            </p>

                            <p>
                                <label><strong>Título da Pesquisa:</strong></label><br>
                                <input type="text" name="card_title" value="<?php echo $editing_card ? esc_attr($editing_card['title']) : ''; ?>" placeholder="Ex: Faturamento do Mercado Brasileiro" class="widefat" required>
                            </p>

                            <p>
                                <label><strong>Tag / Subtítulo Curto:</strong></label><br>
                                <input type="text" name="card_tag" value="<?php echo $editing_card ? esc_attr($editing_card['tag']) : ''; ?>" placeholder="Ex: Mercado Nacional ou E-commerce" class="widefat" required>
                            </p>

                            <p>
                                <label><strong>Ícone Visual (Emoji ou Caractere):</strong></label><br>
                                <input type="text" name="card_icon" value="<?php echo $editing_card ? esc_attr($editing_card['icon']) : '📊'; ?>" placeholder="Ex: 🌐, 🇧🇷, ⚡, 🛒, 👥, 📈" class="regular-text" style="width:80px;font-size:18px;">
                                <small style="color:#64748b;display:block;margin-top:4px;">Copie e cole um emoji representativo.</small>
                            </p>

                            <p>
                                <label><strong>Origem / Tipologia da Informação:</strong></label><br>
                                <?php $cur_prov = $editing_card ? ($editing_card['provenance'] ?? 'terceiros') : 'terceiros'; ?>
                                <select name="card_provenance" class="widefat" style="font-weight:700;">
                                    <option value="terceiros" <?php selected($cur_prov, 'terceiros'); ?>>🌐 Dados de Terceiros (Institutos e consultorias internacionais)</option>
                                    <option value="proprios" <?php selected($cur_prov, 'proprios'); ?>>★ Dados Próprios (Pesquisas exclusivas MercadoErótico.org)</option>
                                    <option value="setoriais" <?php selected($cur_prov, 'setoriais'); ?>>🏛️ Dados Setoriais (Censos, levantamentos e associações)</option>
                                </select>
                                <small style="color:#64748b;display:block;margin-top:4px;">Fundamental para a separação visual e credibilidade do observatório.</small>
                            </p>

                            <p>
                                <label><strong>Categoria (Rótulo no Card):</strong></label><br>
                                <input type="text" name="card_cat_label" value="<?php echo $editing_card ? esc_attr($editing_card['cat_label']) : 'Mercado Global'; ?>" placeholder="Ex: Mercado Global, Brasil, Sextech..." class="widefat" required>
                            </p>

                            <p>
                                <label><strong>Filtros por Aba (Selecione onde aparece):</strong></label><br>
                                <?php
                                $selected_cats = $editing_card ? explode(',', $editing_card['cats']) : array('all', 'global');
                                $available_filters = array(
                                    'global'   => '🌐 Internacional & Global',
                                    'brasil'   => '🇧🇷 Brasil & América Latina',
                                    'inovacao' => '⚡ Sextech & Inovação IoT',
                                    'varejo'   => '🛒 Varejo & Distribuição',
                                    'consumo'  => '👥 Comportamento & Demografia'
                                );
                                foreach ($available_filters as $fkey => $flabel):
                                    $checked = in_array($fkey, $selected_cats) ? 'checked' : '';
                                ?>
                                    <label style="display:block;margin:4px 0;">
                                        <input type="checkbox" name="card_cats[]" value="<?php echo esc_attr($fkey); ?>" <?php echo $checked; ?>>
                                        <?php echo esc_html($flabel); ?>
                                    </label>
                                <?php endforeach; ?>
                            </p>

                            <p>
                                <label><strong>Fonte Oficial / Instituto:</strong></label><br>
                                <input type="text" name="card_source" value="<?php echo $editing_card ? esc_attr($editing_card['source']) : ''; ?>" placeholder="Ex: Grand View Research, ABEME, Statista" class="widefat" required>
                            </p>

                            <p>
                                <label><strong>Período / Ano / Projeção:</strong></label><br>
                                <input type="text" name="card_date" value="<?php echo $editing_card ? esc_attr($editing_card['date']) : ''; ?>" placeholder="Ex: Censo 2024 ou Projeção 2024–2030" class="widefat" required>
                            </p>

                            <p>
                                <label><strong>Resumo Analítico / Metodologia:</strong></label><br>
                                <textarea name="card_desc" rows="4" class="widefat" placeholder="Texto explicativo com os principais insights da pesquisa..."><?php echo $editing_card ? esc_textarea($editing_card['desc']) : ''; ?></textarea>
                            </p>

                            <p style="margin-top:15px;">
                                <button type="submit" class="button button-primary button-large" style="width:100%;">
                                    <span class="dashicons <?php echo $editing_card ? 'dashicons-update' : 'dashicons-plus'; ?>" style="vertical-align:middle;"></span>
                                    <?php echo $editing_card ? 'Atualizar Indicador' : 'Adicionar ao Radar'; ?>
                                </button>
                                <?php if ($editing_card): ?>
                                    <a href="<?php echo admin_url('admin.php?page=mercado-pesquisas-radar'); ?>" class="button button-secondary" style="width:100%;margin-top:8px;text-align:center;">
                                        Cancelar Edição
                                    </a>
                                <?php endif; ?>
                            </p>
                        </form>
                    </div>
                </div>

                <!-- Reset Box -->
                <div class="postbox me-postbox">
                    <div class="postbox-header">
                        <h2><span class="dashicons dashicons-image-rotate"></span> Restaurar Dados Padrão</h2>
                    </div>
                    <div class="inside">
                        <p class="description">Se desejar voltar aos 12 indicadores analíticos originais e aos 4 KPIs recomendados pela equipe do Mercado Erótico, clique abaixo.</p>
                        <form method="post" action="" onsubmit="return confirm('Atenção: Todos os dados personalizados serão substituídos pelos 12 indicadores e 4 KPIs padrão. Continuar?');">
                            <?php wp_nonce_field('mercado_pesquisas_reset_verify', 'mercado_reset_nonce'); ?>
                            <input type="hidden" name="mercado_pesquisas_action" value="reset_defaults">
                            <button type="submit" class="button button-secondary" style="color:#d63638;border-color:#d63638;width:100%;">
                                Restaurar Padrões da Redação
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
    .me-admin-wrap {
        max-width: 1300px;
        margin-top: 20px;
    }
    .me-status-box {
        background: #fff;
        border: 1px solid #c3c4c7;
        border-radius: 8px;
        padding: 16px 20px;
        margin: 20px 0 25px;
        display: flex;
        align-items: center;
        gap: 30px;
        flex-wrap: wrap;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .me-status-item {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: #1d2327;
    }
    .me-status-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #10b981;
        display: inline-block;
    }
    .me-admin-columns {
        display: flex;
        gap: 25px;
        align-items: flex-start;
    }
    .me-col-main {
        flex: 1 1 65%;
        min-width: 0;
    }
    .me-col-side {
        flex: 1 1 35%;
        min-width: 320px;
    }
    .me-postbox {
        background: #fff;
        border: 1px solid #c3c4c7;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        margin-bottom: 25px;
        overflow: hidden;
    }
    .me-postbox .postbox-header {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 14px 20px;
    }
    .me-postbox .postbox-header h2 {
        font-size: 14px;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .me-postbox .inside {
        padding: 20px;
        margin: 0;
    }
    .me-kpis-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }
    .me-kpi-card-edit {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 14px;
        position: relative;
    }
    .me-kpi-badge {
        display: inline-block;
        background: #e31c61;
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 4px;
        margin-bottom: 8px;
    }
    .me-cat-pill {
        display: inline-block;
        background: #f1f5f9;
        color: #0f172a;
        font-size: 11px;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 4px;
        border: 1px solid #e2e8f0;
    }
    @media (max-width: 960px) {
        .me-admin-columns {
            flex-direction: column;
        }
        .me-col-side {
            width: 100%;
        }
    }
    </style>
    <?php
}
