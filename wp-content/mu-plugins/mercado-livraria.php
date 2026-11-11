<?php
/**
 * Plugin Name: Mercado Erótico - Livraria Digital
 * Description: Vitrine moderna e catálogo digital de livros, manuais e cursos do Mercado Erótico com links diretos Hotmart e canais oficiais.
 * Version: 1.3.0
 * Author: Equipe Mercado Erótico
 */

if (!defined('ABSPATH')) exit;

function me_slugify_cat($text) {
    $text = mb_strtolower($text, 'UTF-8');
    $unwanted = array(
        'á'=>'a', 'à'=>'a', 'ã'=>'a', 'â'=>'a', 'é'=>'e', 'ê'=>'e',
        'í'=>'i', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ú'=>'u', 'ç'=>'c',
        '&'=>'', '-'=>'', ' '=>''
    );
    return strtr($text, $unwanted);
}

function mercado_livraria_get_data() {
    $file = WP_CONTENT_DIR . '/uploads/livraria/livraria_clean.json';
    if (!file_exists($file)) return array();
    $content = file_get_contents($file);
    return json_decode($content, true) ?: array();
}

global $mercado_livraria_rendered;
$mercado_livraria_rendered = false;

function mercado_livraria_shortcode() {
    global $mercado_livraria_rendered;
    $mercado_livraria_rendered = true;

    $products = mercado_livraria_get_data();
    $total_count = count($products);

    // Pre-calculate products with clean ASCII slugs for 100% reliable filtering
    $processed_products = array();
    $negocios_count = 0;
    $manuais_count = 0;
    $cursos_count = 0;
    $sexualidade_count = 0;
    $gratuito_count = 0;

    foreach ($products as $p) {
        $slugs = array('all');
        $raw_cats = !empty($p['categories']) ? (array)$p['categories'] : array();

        if (!empty($p['is_free'])) {
            $slugs[] = 'gratuito';
            $gratuito_count++;
        }

        $has_negocios = false;
        $has_manuais = false;
        $has_cursos = false;
        $has_sexualidade = false;

        foreach ($raw_cats as $rc) {
            $norm = me_slugify_cat($rc);
            if (strpos($norm, 'negocio') !== false || strpos($norm, 'venda') !== false) {
                $has_negocios = true;
            }
            if (strpos($norm, 'manual') !== false || strpos($norm, 'manuais') !== false || strpos($norm, 'guia') !== false) {
                $has_manuais = true;
            }
            if (strpos($norm, 'curso') !== false || strpos($norm, 'workshop') !== false) {
                $has_cursos = true;
            }
            if (strpos($norm, 'sexual') !== false || strpos($norm, 'saude') !== false || strpos($norm, 'produto') !== false || strpos($norm, 'prazer') !== false) {
                $has_sexualidade = true;
            }
            if (strpos($norm, 'gratuito') !== false && !in_array('gratuito', $slugs)) {
                $slugs[] = 'gratuito';
                $gratuito_count++;
            }
        }

        // Reconhecimento semântico de temas de sexualidade e consumidor final
        $p_name_lower = strtolower($p['name']);
        if (preg_match('/(pompoar|vibrador|tantra|orgasmo|fetiche|striptease|sexo\s+anal|kama\s+sutra|fantasias|desejo|corpo\s+org|lingam|yoni|penisfit|my\s+vibe|sair\s+da\s+rotina|dicionario\s+do\s+sexo)/i', $p_name_lower) && strpos($p_name_lower, 'para lojistas') === false) {
            $has_sexualidade = true;
        }

        if ($has_negocios) { $slugs[] = 'negocios'; $negocios_count++; }
        if ($has_manuais) { $slugs[] = 'manuais'; $manuais_count++; }
        if ($has_cursos) { $slugs[] = 'cursos'; $cursos_count++; }
        if ($has_sexualidade) { $slugs[] = 'sexualidade'; $sexualidade_count++; }

        $p['slug_str'] = implode(',', array_unique($slugs));
        $processed_products[] = $p;
    }

    ob_start();
    ?>
    <div id="livraria-app" class="livraria-wrapper">
        <!-- Hero Header -->
        <div class="livraria-hero">
            <div class="livraria-badge">★ LIVRARIA DIGITAL • SEXUALIDADE, AUTOCONHECIMENTO &amp; MERCADO ÍNTIMO</div>
            <h1 class="livraria-title">Livraria Mercado Erótico</h1>
            <p class="livraria-subtitle">O mais completo acervo de e-books, cursos e guias sobre sexualidade humana, bem-estar íntimo, tantra e autoconhecimento para consumidores finais, além de manuais completos para profissionais do mercado íntimo.</p>
            
            <div class="livraria-stats-bar">
                <div class="stat-item"><span class="stat-num"><?php echo $total_count; ?></span><span class="stat-lbl">Títulos &amp; Obras</span></div>
                <div class="stat-sep">•</div>
                <div class="stat-item"><span class="stat-num"><?php echo $manuais_count; ?></span><span class="stat-lbl">Manuais &amp; Guias</span></div>
                <div class="stat-sep">•</div>
                <div class="stat-item"><span class="stat-num"><?php echo $gratuito_count; ?></span><span class="stat-lbl">Materiais Gratuitos</span></div>
            </div>

            <!-- Search Bar -->
            <div class="livraria-search-box">
                <i class="fas fa-search search-icon" aria-hidden="true"></i>
                <input type="text" id="livraria-search-input" placeholder="Pesquisar por tema, título ou autor (ex: Tantra, Pompoarismo, Orgasmo, Vibrador, Negócios)..." autocomplete="off" oninput="onLivrariaSearchInput(this.value)">
                <button type="button" id="livraria-search-btn" class="livraria-btn-search" onclick="onLivrariaSearchClick()">Buscar</button>
            </div>
        </div>

        <!-- Audience Navigation Cards (Para Você vs Para o Seu Negócio) -->
        <div class="livraria-audience-bar">
            <div class="audience-card for-consumer" onclick="filterByAudience('sexualidade')">
                <div class="audience-icon"><i class="fas fa-heart"></i></div>
                <div class="audience-info">
                    <div class="audience-tag">Para Você • Consumidor Final</div>
                    <div class="audience-title">Sexualidade, Prazer &amp; Autoconhecimento <i class="fas fa-arrow-right"></i></div>
                    <div class="audience-desc">Cursos e e-books sobre Tantra, Pompoarismo, Orgasmo, Fetiches, Guias de Vibradores e Práticas a Dois.</div>
                </div>
            </div>
            <div class="audience-card for-business" onclick="filterByAudience('negocios')">
                <div class="audience-icon"><i class="fas fa-briefcase"></i></div>
                <div class="audience-info">
                    <div class="audience-tag">Para Seu Negócio • B2B &amp; Lojistas</div>
                    <div class="audience-title">Mercado Íntimo, Gestão &amp; Vendas <i class="fas fa-arrow-right"></i></div>
                    <div class="audience-desc">Manuais de abertura de Sex Shop, atendimento profissional, normas técnicas ISO, calendários e marketing.</div>
                </div>
            </div>
        </div>

        <!-- Category Filter Tabs -->
        <div class="livraria-filter-section">
            <div class="filter-header">
                <span class="filter-label"><i class="fas fa-layer-group"></i> Categorias &amp; Temas:</span>
            </div>
            <div class="tabs-wrap" id="livraria-tabs">
                <button type="button" class="livraria-tab active" data-slug="all" onclick="selectLivrariaTab('all', this)">
                    📚 Todos os Títulos (<?php echo $total_count; ?>)
                </button>
                <button type="button" class="livraria-tab" data-slug="sexualidade" onclick="selectLivrariaTab('sexualidade', this)">
                    ❤️ Sexualidade &amp; Consumidor Final (<?php echo $sexualidade_count; ?>)
                </button>
                <button type="button" class="livraria-tab" data-slug="cursos" onclick="selectLivrariaTab('cursos', this)">
                    🎓 Cursos &amp; Workshops (<?php echo $cursos_count; ?>)
                </button>
                <button type="button" class="livraria-tab" data-slug="negocios" onclick="selectLivrariaTab('negocios', this)">
                    💼 Negócios &amp; SexShop (<?php echo $negocios_count; ?>)
                </button>
                <button type="button" class="livraria-tab" data-slug="manuais" onclick="selectLivrariaTab('manuais', this)">
                    📖 Manuais &amp; Guias (<?php echo $manuais_count; ?>)
                </button>
                <button type="button" class="livraria-tab" data-slug="gratuito" onclick="selectLivrariaTab('gratuito', this)">
                    🎁 Gratuitos (<?php echo $gratuito_count; ?>)
                </button>
            </div>
        </div>

        <!-- Results Counter -->
        <div class="livraria-results-bar">
            <div id="livraria-count" class="results-count">Exibindo <strong><?php echo $total_count; ?></strong> itens</div>
            <button type="button" id="livraria-clear-btn" class="clear-filters-btn" style="display:none;" onclick="resetLivrariaFilters()"><i class="fas fa-times"></i> Limpar Filtro</button>
        </div>

        <!-- Products Grid -->
        <div id="livraria-grid" class="livraria-grid">
            <?php foreach ($processed_products as $p): ?>
                <?php
                $pid = esc_attr($p['id']);
                $pname = esc_attr($p['name']);
                $slug_str = esc_attr($p['slug_str']);
                $pfree = !empty($p['is_free']) ? '1' : '0';
                $pimg = !empty($p['image']) ? esc_url($p['image']) : '';
                $buy_type = !empty($p['buy_type']) ? $p['buy_type'] : 'whatsapp';
                ?>
                <div class="book-card" 
                     data-id="<?php echo $pid; ?>" 
                     data-name="<?php echo strtolower($pname); ?>"
                     data-slugs="<?php echo $slug_str; ?>"
                     data-free="<?php echo $pfree; ?>"
                     data-buytype="<?php echo esc_attr($buy_type); ?>">
                    <div class="book-cover-wrap" onclick="openBookModal(<?php echo $pid; ?>)">
                        <?php if ($pimg): ?>
                            <img src="<?php echo $pimg; ?>" alt="<?php echo $pname; ?>" class="book-cover-img" loading="lazy">
                        <?php else: ?>
                            <div class="book-no-cover"><i class="fas fa-book"></i></div>
                        <?php endif; ?>
                        
                        <?php if (!empty($p['is_free'])): ?>
                            <span class="badge-free" onclick="event.stopPropagation(); selectLivrariaTab('gratuito');">GRATUITO</span>
                        <?php elseif ($buy_type === 'hotmart'): ?>
                            <span class="badge-platform hotmart">HOTMART</span>
                        <?php elseif ($buy_type === 'mercadopago' || (!empty($p['buy_url']) && strpos($p['buy_url'], 'mpago.la') !== false)): ?>
                            <span class="badge-platform mercadopago">MERCADO PAGO</span>
                        <?php elseif ($buy_type === 'loja_propria' || (!empty($p['buy_url']) && strpos($p['buy_url'], 'malasecreta.com.br') !== false) || (!empty($p['id']) && $p['id'] == 2673)): ?>
                            <span class="badge-platform loja-propria">LOJA PRÓPRIA</span>
                        <?php endif; ?>

                        <div class="book-hover-overlay">
                            <button type="button" class="btn-quick-view"><i class="fas fa-eye"></i> Ver Detalhes</button>
                        </div>
                    </div>

                    <div class="book-info">
                        <div class="book-cats">
                            <?php foreach (array_slice($p['categories'], 0, 2) as $cat): ?>
                                <?php 
                                $cat_norm = me_slugify_cat($cat);
                                $cat_target_slug = 'all';
                                if (strpos($cat_norm, 'negocio') !== false || strpos($cat_norm, 'venda') !== false) $cat_target_slug = 'negocios';
                                elseif (strpos($cat_norm, 'manual') !== false || strpos($cat_norm, 'guia') !== false) $cat_target_slug = 'manuais';
                                elseif (strpos($cat_norm, 'curso') !== false) $cat_target_slug = 'cursos';
                                elseif (strpos($cat_norm, 'sexual') !== false) $cat_target_slug = 'sexualidade';
                                ?>
                                <span class="cat-pill clickable" onclick="event.stopPropagation(); selectLivrariaTab('<?php echo $cat_target_slug; ?>');" title="Filtrar por <?php echo esc_attr($cat); ?>">
                                    <?php echo esc_html($cat); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                        <h3 class="book-title" onclick="openBookModal(<?php echo $pid; ?>)"><?php echo esc_html($p['name']); ?></h3>
                        <p class="book-excerpt"><?php echo esc_html($p['excerpt']); ?></p>
                        
                        <div class="book-footer">
                            <div class="book-price-block">
                                <span class="price-val <?php echo !empty($p['is_free']) ? 'free-text' : ''; ?>"><?php echo esc_html($p['price_formatted']); ?></span>
                            </div>
                            <?php 
                                $btn_text = 'Detalhes';
                                $btn_icon = 'fa-arrow-right';
                                $btn_cls = '';
                                if (!empty($p['is_free'])) {
                                    if (!empty($p['download_pptx']) && (empty($p['buy_url']) || strpos($p['buy_url'], '.pdf') === false)) {
                                        $btn_text = 'Baixar PPTX';
                                        $btn_icon = 'fa-file-powerpoint';
                                    } elseif (!empty($p['buy_type']) && $p['buy_type'] === 'download') {
                                        $btn_text = 'Baixar PDF';
                                        $btn_icon = 'fa-download';
                                    } else {
                                        $btn_text = 'Acessar Grátis';
                                        $btn_icon = 'fa-arrow-right';
                                    }
                                    $btn_cls = 'btn-action-free';
                                } elseif (!empty($p['buy_type']) && ($p['buy_type'] === 'mercadopago' || (!empty($p['buy_url']) && strpos($p['buy_url'], 'mpago.la') !== false))) {
                                    $btn_text = 'Comprar';
                                    $btn_icon = 'fa-shopping-cart';
                                    $btn_cls = 'btn-action-mp';
                                } elseif ($buy_type === 'hotmart') {
                                    $btn_text = 'Hotmart';
                                    $btn_icon = 'fa-fire';
                                    $btn_cls = 'btn-action-hotmart';
                                } elseif ($buy_type === 'loja_propria' || (!empty($p['buy_url']) && strpos($p['buy_url'], 'malasecreta.com.br') !== false) || (!empty($p['id']) && $p['id'] == 2673)) {
                                    $btn_text = 'Loja própria';
                                    $btn_icon = 'fa-store';
                                    $btn_cls = 'btn-action-loja';
                                }
                            ?>
                            <button type="button" class="btn-action <?php echo esc_attr($btn_cls); ?>" onclick="openBookModal(<?php echo $pid; ?>)">
                                <?php echo esc_html($btn_text); ?> <i class="fas <?php echo esc_attr($btn_icon); ?>"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div id="livraria-no-results" class="livraria-no-results" style="display:none;">
            <i class="fas fa-search" style="font-size:3rem; color:#cbd5e1; margin-bottom:15px;"></i>
            <h3>Nenhum material encontrado</h3>
            <p>Tente buscar por outro termo ou selecione outra categoria.</p>
            <button type="button" class="livraria-btn-search" onclick="resetLivrariaFilters()" style="position:static; margin-top:15px;">Ver Todos os Títulos</button>
        </div>

        <!-- Modal Details Backdrop -->
        <div id="book-modal-backdrop" class="book-modal-backdrop" onclick="closeBookModal(event)">
            <div class="book-modal-content" onclick="event.stopPropagation()">
                <button type="button" class="modal-close-btn" onclick="closeBookModal()">&times;</button>
                <div class="modal-body" id="modal-body-content">
                    <!-- Populated dynamically via JS -->
                </div>
            </div>
        </div>
    </div>

    <!-- Inline Filter Logic Available Immediately -->
    <script>
    window.currentLivrariaSlug = 'all';
    window.currentLivrariaSearch = '';

    window.filterByAudience = function(slug) {
        window.selectLivrariaTab(slug);
        const filterSec = document.querySelector('.livraria-filter-section');
        if (filterSec) {
            filterSec.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    };

    window.selectLivrariaTab = function(slug, btn) {
        window.currentLivrariaSlug = slug || 'all';

        const tabs = document.querySelectorAll('#livraria-tabs .livraria-tab');
        tabs.forEach(function(t) {
            if (t.getAttribute('data-slug') === slug) {
                t.classList.add('active');
            } else {
                t.classList.remove('active');
            }
        });

        window.applyLivrariaFilter();
    };

    window.applyLivrariaFilter = function() {
        const slug = window.currentLivrariaSlug || 'all';
        const query = (window.currentLivrariaSearch || '').toLowerCase().trim();
        const cards = document.querySelectorAll('.book-card');
        const noResults = document.getElementById('livraria-no-results');
        let visibleCount = 0;

        cards.forEach(function(card) {
            const slugs = (card.getAttribute('data-slugs') || '').split(',');
            const name = card.getAttribute('data-name') || '';

            const matchCat = (slug === 'all') || (slugs.indexOf(slug) !== -1);
            const matchSearch = !query || (name.indexOf(query) !== -1);

            if (matchCat && matchSearch) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        const countEl = document.getElementById('livraria-count');
        if (countEl) {
            countEl.innerHTML = 'Exibindo <strong>' + visibleCount + '</strong> itens';
        }

        const clearBtn = document.getElementById('livraria-clear-btn');
        if (clearBtn) {
            clearBtn.style.display = (slug !== 'all' || query) ? 'inline-block' : 'none';
        }

        if (noResults) {
            noResults.style.display = (visibleCount === 0) ? 'block' : 'none';
        }
    };

    window.onLivrariaSearchInput = function(val) {
        window.currentLivrariaSearch = val || '';
        window.applyLivrariaFilter();
    };

    window.onLivrariaSearchClick = function() {
        const input = document.getElementById('livraria-search-input');
        if (input) {
            window.currentLivrariaSearch = input.value || '';
            window.applyLivrariaFilter();
        }
    };

    window.resetLivrariaFilters = function() {
        window.currentLivrariaSlug = 'all';
        window.currentLivrariaSearch = '';
        const input = document.getElementById('livraria-search-input');
        if (input) input.value = '';

        const tabs = document.querySelectorAll('#livraria-tabs .livraria-tab');
        tabs.forEach(function(t) {
            if (t.getAttribute('data-slug') === 'all') {
                t.classList.add('active');
            } else {
                t.classList.remove('active');
            }
        });

        window.applyLivrariaFilter();
    };

    // Auto-ativar aba via hash da URL (ex: #gratuito)
    function checkLivrariaHash() {
        const hash = (window.location.hash || '').replace('#', '').toLowerCase();
        if (hash === 'gratuito' || hash === 'gratuitos' || hash === 'free') {
            window.selectLivrariaTab('gratuito');
        } else if (hash && ['negocios', 'manuais', 'cursos', 'sexualidade'].indexOf(hash) !== -1) {
            window.selectLivrariaTab(hash);
        }
    }
    document.addEventListener('DOMContentLoaded', checkLivrariaHash);
    window.addEventListener('hashchange', checkLivrariaHash);
    setTimeout(checkLivrariaHash, 300);
    setTimeout(checkLivrariaHash, 800);
    </script>

    <style>
    /* LIVRARIA STYLES */
    .livraria-wrapper {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        color: #222;
        max-width: 1280px;
        margin: 0 auto;
        padding: 10px 20px 80px;
    }
    .livraria-hero {
        background: radial-gradient(circle at 50% 30%, #201322 0%, #0d0612 100%);
        border-radius: 20px;
        padding: 50px 30px;
        text-align: center;
        color: #fff;
        margin-bottom: 40px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        border: 1px solid rgba(227, 28, 97, 0.25);
    }
    .livraria-badge {
        display: inline-block;
        background: linear-gradient(135deg, #e31c61, #9c1543);
        color: #fff;
        font-size: 0.78rem;
        font-weight: 800;
        letter-spacing: 1.5px;
        padding: 6px 16px;
        border-radius: 50px;
        margin-bottom: 20px;
    }
    .livraria-title {
        font-size: 2.6rem;
        font-weight: 900;
        letter-spacing: -0.5px;
        color: #fff;
        margin: 0 0 15px;
        line-height: 1.2;
    }
    .livraria-subtitle {
        font-size: 1.15rem;
        color: #d1c7d4;
        max-width: 780px;
        margin: 0 auto 30px;
        line-height: 1.6;
    }
    .livraria-stats-bar {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 25px;
        margin-bottom: 35px;
        flex-wrap: wrap;
    }
    .livraria-stats-bar .stat-item {
        display: flex;
        align-items: baseline;
        gap: 8px;
    }
    .livraria-stats-bar .stat-num {
        font-size: 1.5rem;
        font-weight: 900;
        color: #e31c61;
    }
    .livraria-stats-bar .stat-lbl {
        font-size: 0.9rem;
        color: #b3a5b6;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .livraria-stats-bar .stat-sep {
        color: rgba(255,255,255,0.2);
    }
    .livraria-search-box {
        max-width: 650px;
        margin: 0 auto;
        position: relative;
        display: flex;
        align-items: center;
    }
    .livraria-search-box .search-icon {
        position: absolute;
        left: 20px;
        color: #8e8293;
        font-size: 1.1rem;
        pointer-events: none;
    }
    .livraria-search-box input {
        width: 100%;
        padding: 16px 130px 16px 50px;
        border-radius: 50px;
        border: 2px solid rgba(255,255,255,0.18);
        background: rgba(255,255,255,0.08);
        color: #fff;
        font-size: 1rem;
        outline: none;
        transition: all 0.25s ease;
    }
    .livraria-search-box input:focus {
        background: rgba(255,255,255,0.15);
        border-color: #e31c61;
        box-shadow: 0 0 20px rgba(227, 28, 97, 0.4);
    }
    .livraria-search-box input::placeholder {
        color: #9f91a5;
    }
    .livraria-btn-search {
        position: absolute;
        right: 8px;
        background: #e31c61;
        color: #fff;
        border: none;
        padding: 10px 24px;
        border-radius: 40px;
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        transition: background 0.2s;
    }
    .livraria-btn-search:hover {
        background: #b8144c;
    }

    /* AUDIENCE HIGHLIGHT BAR */
    .livraria-audience-bar {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin: -10px auto 25px auto;
    }
    .audience-card {
        background: #ffffff;
        border: 2px solid #f1f5f9;
        border-radius: 16px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        text-align: left;
    }
    .audience-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }
    .audience-card.for-consumer {
        border-color: #fbcfe8;
        background: linear-gradient(135deg, #ffffff 0%, #fff1f2 100%);
    }
    .audience-card.for-consumer:hover {
        border-color: #e31c61;
    }
    .audience-card.for-business {
        border-color: #e2e8f0;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    }
    .audience-card.for-business:hover {
        border-color: #3b82f6;
    }
    .audience-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }
    .audience-card.for-consumer .audience-icon {
        background: #ffe4e6;
        color: #e31c61;
    }
    .audience-card.for-business .audience-icon {
        background: #e0f2fe;
        color: #0284c7;
    }
    .audience-info {
        flex: 1;
        min-width: 0;
    }
    .audience-tag {
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }
    .audience-card.for-consumer .audience-tag { color: #e11d48; }
    .audience-card.for-business .audience-tag { color: #0284c7; }
    .audience-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .audience-desc {
        font-size: 0.82rem;
        color: #64748b;
        line-height: 1.35;
    }
    @media (max-width: 768px) {
        .livraria-audience-bar {
            grid-template-columns: 1fr;
            gap: 10px;
            margin-top: 5px;
        }
        .audience-card {
            padding: 12px 16px;
        }
        .audience-icon {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }
        .audience-title {
            font-size: 0.95rem;
        }
        .audience-desc {
            font-size: 0.78rem;
        }
    }

    /* FILTERS - HIGH CONTRAST & RESPONSIVE */
    .livraria-filter-section {
        margin-bottom: 25px;
    }
    .filter-header {
        font-size: 0.92rem;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .tabs-wrap {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .livraria-tab {
        background: #ffffff;
        color: #334155;
        border: 1.5px solid #cbd5e1;
        padding: 10px 20px;
        border-radius: 30px;
        font-size: 0.94rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
        outline: none;
        box-shadow: 0 2px 6px rgba(0,0,0,0.04);
    }
    .livraria-tab:hover {
        background: #f8fafc;
        border-color: #e31c61;
        color: #e31c61;
        transform: translateY(-1px);
    }
    .livraria-tab.active {
        background: #e31c61 !important;
        color: #ffffff !important;
        border-color: #e31c61 !important;
        box-shadow: 0 4px 14px rgba(227, 28, 97, 0.4) !important;
    }

    .livraria-results-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 5px;
        border-bottom: 2px solid #eee;
        margin-bottom: 30px;
        font-size: 0.95rem;
        color: #666;
    }
    .clear-filters-btn {
        background: none;
        border: none;
        color: #e31c61;
        font-weight: 700;
        cursor: pointer;
        font-size: 0.9rem;
    }

    /* GRID */
    .livraria-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
        gap: 30px;
    }
    .book-card {
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid #eaeaea;
        box-shadow: 0 6px 18px rgba(0,0,0,0.04);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        display: flex;
        flex-direction: column;
    }
    .book-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.12);
        border-color: #ddd;
    }
    .book-cover-wrap {
        position: relative;
        background: #f8f8fb;
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 280px;
        overflow: hidden;
        cursor: pointer;
    }
    .book-cover-img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
        border-radius: 6px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.18);
        transition: transform 0.3s ease;
    }
    .book-card:hover .book-cover-img {
        transform: scale(1.04);
    }
    .badge-free {
        position: absolute;
        top: 15px;
        left: 15px;
        background: #10b981;
        color: #fff;
        font-size: 0.72rem;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 20px;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px rgba(16,185,129,0.3);
        cursor: pointer;
    }
    .badge-platform {
        position: absolute;
        top: 15px;
        left: 15px;
        color: #fff;
        font-size: 0.68rem;
        font-weight: 800;
        padding: 4px 9px;
        border-radius: 20px;
        letter-spacing: 0.5px;
        z-index: 2;
        text-transform: uppercase;
        pointer-events: none;
    }
    .badge-platform.hotmart {
        background: #F04E23;
        box-shadow: 0 2px 8px rgba(240,78,35,0.3);
    }
    .badge-platform.mercadopago {
        background: #009ee3;
        box-shadow: 0 2px 8px rgba(0,158,227,0.35);
    }
    .badge-platform.loja-propria {
        background: linear-gradient(135deg, #e31c61 0%, #be123c 100%);
        box-shadow: 0 2px 8px rgba(227,28,97,0.35);
    }
    .book-hover-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(13, 6, 18, 0.65);
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: opacity 0.2s ease;
    }
    .book-card:hover .book-hover-overlay {
        opacity: 1;
    }
    .btn-quick-view {
        background: #fff;
        color: #111;
        border: none;
        padding: 10px 20px;
        border-radius: 30px;
        font-weight: 700;
        font-size: 0.88rem;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    }

    .book-info {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .book-cats {
        display: flex;
        gap: 6px;
        margin-bottom: 8px;
        flex-wrap: wrap;
    }
    .cat-pill {
        background: #f0f0f5;
        color: #666;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 4px;
        text-transform: uppercase;
        transition: all 0.2s;
    }
    .cat-pill.clickable {
        cursor: pointer;
    }
    .cat-pill.clickable:hover {
        background: #e31c61;
        color: #fff;
    }
    .book-title {
        font-size: 1.05rem;
        font-weight: 800;
        color: #1a1a1a;
        margin: 0 0 10px;
        line-height: 1.35;
        cursor: pointer;
        transition: color 0.2s;
    }
    .book-title:hover {
        color: #e31c61;
    }
    .book-excerpt {
        font-size: 0.85rem;
        color: #666;
        line-height: 1.5;
        margin: 0 0 15px;
        flex-grow: 1;
    }
    .book-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #f0f0f0;
        padding-top: 15px;
        margin-top: auto;
    }
    .price-val {
        font-size: 1.25rem;
        font-weight: 900;
        color: #111;
    }
    .price-val.free-text {
        color: #10b981;
    }
    .btn-action {
        background: #111;
        color: #fff;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-action:hover {
        background: #e31c61;
    }
    .btn-action-free {
        background: #059669;
    }
    .btn-action-free:hover {
        background: #047857;
    }
    .btn-action-mp {
        background: #009ee3;
    }
    .btn-action-mp:hover {
        background: #0081bb;
    }
    .btn-action-hotmart {
        background: #F04E23;
    }
    .btn-action-hotmart:hover {
        background: #d4380d;
    }
    .btn-action-loja {
        background: linear-gradient(135deg, #e31c61 0%, #be123c 100%);
    }
    .btn-action-loja:hover {
        background: #9f1239;
    }

    .livraria-no-results {
        text-align: center;
        padding: 60px 20px;
        background: #f8fafc;
        border-radius: 16px;
        margin-top: 20px;
    }
    .livraria-no-results h3 {
        font-size: 1.4rem;
        color: #334155;
        margin: 0 0 10px;
    }
    .livraria-no-results p {
        color: #64748b;
        margin: 0;
    }

    /* MODAL */
    .book-modal-backdrop {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.78);
        backdrop-filter: blur(4px);
        z-index: 999999;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }
    .book-modal-backdrop.active {
        display: flex;
    }
    .book-modal-content {
        background: #fff;
        border-radius: 18px;
        max-width: 860px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        box-shadow: 0 25px 60px rgba(0,0,0,0.45);
        padding: 35px;
        animation: livModalPop 0.25s ease-out;
    }
    @keyframes livModalPop {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    .modal-close-btn {
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 2.2rem;
        background: none;
        border: none;
        color: #888;
        cursor: pointer;
        line-height: 1;
        transition: color 0.2s;
    }
    .modal-close-btn:hover {
        color: #e31c61;
    }
    .modal-grid {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 30px;
    }
    .modal-cover-wrap img {
        width: 100%;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.18);
        object-fit: cover;
    }
    .modal-title {
        font-size: 1.6rem;
        font-weight: 900;
        color: #111;
        margin: 0 0 12px;
        line-height: 1.3;
    }
    .modal-price {
        font-size: 1.7rem;
        font-weight: 900;
        color: #e31c61;
        margin-bottom: 20px;
    }
    .modal-price.free {
        color: #10b981;
    }
    .modal-desc {
        font-size: 0.95rem;
        color: #444;
        line-height: 1.65;
        margin-bottom: 25px;
        max-height: 250px;
        overflow-y: auto;
        padding-right: 10px;
    }
    .modal-desc p {
        margin-bottom: 12px;
    }

    /* PAYMENT CTA BUTTONS */
    .modal-btn-group {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: center;
        margin-top: 20px;
    }
    .modal-btn-hotmart {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, #F04E23 0%, #d4380d 100%);
        color: #fff !important;
        font-size: 1.05rem;
        font-weight: 800;
        padding: 14px 28px;
        border-radius: 8px;
        text-decoration: none !important;
        box-shadow: 0 6px 20px rgba(240, 78, 35, 0.4);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .modal-btn-hotmart:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(240, 78, 35, 0.55);
        color: #fff !important;
    }
    .modal-btn-external {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
        color: #fff !important;
        font-size: 1rem;
        font-weight: 800;
        padding: 14px 26px;
        border-radius: 8px;
        text-decoration: none !important;
        box-shadow: 0 6px 18px rgba(2, 132, 199, 0.35);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .modal-btn-external:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(2, 132, 199, 0.5);
        color: #fff !important;
    }
    .modal-btn-loja {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, #e31c61 0%, #be123c 100%);
        color: #fff !important;
        font-size: 1.05rem;
        font-weight: 800;
        padding: 14px 28px;
        border-radius: 8px;
        text-decoration: none !important;
        box-shadow: 0 6px 20px rgba(227, 28, 97, 0.4);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .modal-btn-loja:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(227, 28, 97, 0.55);
        color: #fff !important;
    }
    .modal-btn-mp {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, #009ee3 0%, #007eb5 100%);
        color: #fff !important;
        font-size: 1.05rem;
        font-weight: 800;
        padding: 14px 28px;
        border-radius: 8px;
        text-decoration: none !important;
        box-shadow: 0 6px 20px rgba(0, 158, 227, 0.4);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .modal-btn-mp:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 158, 227, 0.55);
        color: #fff !important;
    }
    .modal-btn-free {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: #fff !important;
        font-size: 1rem;
        font-weight: 800;
        padding: 14px 26px;
        border-radius: 8px;
        text-decoration: none !important;
        box-shadow: 0 6px 18px rgba(16, 185, 129, 0.35);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .modal-btn-free:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(16, 185, 129, 0.45);
        color: #fff !important;
    }
    .modal-btn-whatsapp {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, #25D366, #128C7E);
        color: #fff !important;
        font-size: 1rem;
        font-weight: 800;
        padding: 14px 26px;
        border-radius: 8px;
        text-decoration: none !important;
        box-shadow: 0 6px 18px rgba(37, 211, 102, 0.35);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .modal-btn-whatsapp:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(37, 211, 102, 0.45);
        color: #fff !important;
    }
    .modal-btn-whatsapp-secondary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f8fafc;
        color: #128C7E !important;
        font-size: 0.92rem;
        font-weight: 700;
        padding: 13px 18px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        text-decoration: none !important;
        transition: background 0.2s, border-color 0.2s;
    }
    .modal-btn-whatsapp-secondary:hover {
        background: #e2e8f0;
        border-color: #94a3b8;
    }
    .modal-btn-email {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f1f5f9;
        color: #475569 !important;
        font-size: 0.92rem;
        font-weight: 700;
        padding: 13px 18px;
        border-radius: 8px;
        text-decoration: none !important;
        transition: background 0.2s;
    }
    .modal-btn-email:hover {
        background: #e2e8f0;
    }

    @media (max-width: 768px) {
        .modal-grid {
            grid-template-columns: 1fr;
        }
        .modal-cover-wrap {
            text-align: center;
        }
        .modal-cover-wrap img {
            max-width: 220px;
        }
        .livraria-title {
            font-size: 1.9rem;
        }
        .livraria-stats-bar {
            gap: 15px;
        }
        .livraria-search-box input {
            padding: 14px 100px 14px 45px;
            font-size: 0.9rem;
        }
        .livraria-btn-search {
            padding: 8px 16px;
            font-size: 0.85rem;
        }
        .book-modal-content {
            padding: 25px 20px;
        }
        .livraria-tab {
            padding: 8px 14px;
            font-size: 0.85rem;
        }
    }
    </style>
    <?php
    return ob_get_clean();
}
add_shortcode('mercado_livraria', 'mercado_livraria_shortcode');

/**
 * Output JavaScript and Data Island in wp_footer
 */
function mercado_livraria_footer_scripts() {
    global $mercado_livraria_rendered;
    if (!$mercado_livraria_rendered && !is_page('livraria')) {
        return;
    }

    $products = mercado_livraria_get_data();
    ?>
    <!-- Livraria JSON Data Island -->
    <script type="application/json" id="livraria-data-json">
    <?php echo json_encode($products, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>
    </script>

    <!-- Livraria Modal Script -->
    <script>
    (function() {
        let livrariaProducts = [];
        try {
            const rawEl = document.getElementById('livraria-data-json');
            if (rawEl) {
                livrariaProducts = JSON.parse(rawEl.textContent);
            }
        } catch (e) {
            console.error('Error parsing livraria JSON:', e);
        }

        // Modal Functionality
        window.openBookModal = function(id) {
            const p = livrariaProducts.find(function(item) {
                return String(item.id) === String(id);
            });
            if (!p) {
                console.warn('Product not found for id:', id);
                return;
            }

            const body = document.getElementById('modal-body-content');
            if (!body) return;

            const isFree = !!p.is_free;
            const buyType = p.buy_type || 'whatsapp';
            const buyUrl = p.buy_url || '';
            const waPhone = '5562982763039';

            const waMsg = isFree
                ? 'Olá! Gostaria de receber o material gratuito "' + p.name + '" (ID ' + p.id + ') do Portal Mercado Erótico.'
                : 'Olá! Tenho dúvidas sobre o material "' + p.name + '" (ID ' + p.id + ') do Portal Mercado Erótico.';

            const waUrl = 'https://wa.me/' + waPhone + '?text=' + encodeURIComponent(waMsg);
            const mailUrl = 'mailto:contato@mercadoerotico.org?subject=' + encodeURIComponent('Interesse: ' + p.name) + '&body=' + encodeURIComponent(waMsg);

            let catsHtml = '';
            if (Array.isArray(p.categories)) {
                catsHtml = p.categories.map(function(c) {
                    return '<span class="cat-pill">' + c + '</span>';
                }).join(' ');
            }

            const imgHtml = p.image 
                ? '<img src="' + p.image + '" alt="' + (p.name || '') + '">'
                : '<div class="book-no-cover" style="height:250px;"><i class="fas fa-book" style="font-size:3rem;"></i></div>';

            const priceClass = isFree ? 'modal-price free' : 'modal-price';
            const fullDesc = (p.description || p.short_description || p.excerpt || 'Sem descrição detalhada.').replace(/`/g, "'").replace(/\${/g, '{');

            // Construct Buttons based on Product Checkout Destination (sem WhatsApp)
            let actionButtonsHtml = '';
            if (buyType === 'hotmart') {
                actionButtonsHtml = `
                    <a href="${buyUrl}" target="_blank" rel="noopener sponsored" class="modal-btn-hotmart">
                        <i class="fas fa-fire" style="font-size:1.15rem;"></i> Comprar Agora no Hotmart <i class="fas fa-arrow-right"></i>
                    </a>
                `;
            } else if (buyType === 'loja_propria' || (buyUrl && buyUrl.includes('malasecreta.com.br')) || (p.id == 2673)) {
                actionButtonsHtml = `
                    <div style="width:100%;">
                        <a href="${buyUrl}" target="_blank" rel="noopener" class="modal-btn-loja">
                            <i class="fas fa-store" style="font-size:1.15rem;"></i> Comprar na Loja Própria <i class="fas fa-arrow-right"></i>
                        </a>
                        <div style="margin-top:10px; font-size:0.85rem; color:#64748b; text-align:center;">
                            🛍️ Produto oficial com envio físico para sua casa pela nossa Loja Própria (Mala Secreta).
                        </div>
                    </div>
                `;
            } else if (buyType === 'external') {
                actionButtonsHtml = `
                    <a href="${buyUrl}" target="_blank" rel="noopener" class="modal-btn-external">
                        <i class="fas fa-external-link-alt"></i> Acessar no Site Oficial <i class="fas fa-arrow-right"></i>
                    </a>
                `;
            } else if (buyType === 'mercadopago' || (buyUrl && buyUrl.includes('mpago.la'))) {
                actionButtonsHtml = `
                    <div style="width:100%;">
                        <a href="${buyUrl}" target="_blank" rel="noopener sponsored" class="modal-btn-mp">
                            <i class="fas fa-lock" style="font-size:1.15rem;"></i> Pagar com Mercado Pago (PIX / Cartão) <i class="fas fa-arrow-right"></i>
                        </a>
                        <div style="margin-top:10px; font-size:0.85rem; color:#64748b; text-align:center;">
                            🔒 Pagamento 100% seguro pelo Mercado Pago. Liberação imediata e envio do PDF por e-mail.
                        </div>
                    </div>
                `;
            } else if (isFree || buyType === 'download') {
                const hasPdf = Boolean(buyUrl && buyUrl.toLowerCase().endsWith('.pdf'));
                const hasPptx = Boolean(p.download_pptx);

                actionButtonsHtml = '';
                if (hasPdf) {
                    actionButtonsHtml += `
                        <a href="${buyUrl}" target="_blank" download rel="noopener" class="modal-btn-free">
                            <i class="fas fa-file-pdf" style="font-size:1.25rem;"></i> Baixar PDF Agora (Gratuito) <i class="fas fa-download"></i>
                        </a>
                    `;
                }

                if (hasPptx) {
                    actionButtonsHtml += `
                        <a href="${p.download_pptx}" target="_blank" download rel="noopener" class="modal-btn-free" style="background:#b7410e; border-color:#b7410e; ${hasPdf ? 'margin-top:10px;' : ''}">
                            <i class="fas fa-file-powerpoint" style="font-size:1.25rem;"></i> Baixar Apresentação Slides (.PPTX) <i class="fas fa-download"></i>
                        </a>
                    `;
                }

                if (!hasPdf && !hasPptx) {
                    actionButtonsHtml = `
                        <a href="${mailUrl}" class="modal-btn-free">
                            <i class="fas fa-envelope" style="font-size:1.15rem;"></i> Solicitar Envio do Material por E-mail <i class="fas fa-arrow-right"></i>
                        </a>
                    `;
                }
            } else {
                actionButtonsHtml = `
                    <a href="${mailUrl}" class="modal-btn-email">
                        <i class="fas fa-envelope"></i> Solicitar por E-mail
                    </a>
                `;
            }

            body.innerHTML = `
                <div class="modal-grid">
                    <div class="modal-cover-wrap">
                        ${imgHtml}
                    </div>
                    <div class="modal-details">
                        <div class="book-cats" style="margin-bottom:12px;">
                            ${catsHtml}
                        </div>
                        <h2 class="modal-title">${p.name}</h2>
                        <div class="${priceClass}">${p.price_formatted}</div>
                        <div class="modal-desc">
                            ${fullDesc}
                        </div>
                        <div class="modal-btn-group">
                            ${actionButtonsHtml}
                        </div>
                    </div>
                </div>
            `;

            const backdrop = document.getElementById('book-modal-backdrop');
            if (backdrop) {
                backdrop.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        };

        window.closeBookModal = function(e) {
            if (e && e.target && e.target !== document.getElementById('book-modal-backdrop') && !e.target.classList.contains('modal-close-btn')) {
                return;
            }
            const backdrop = document.getElementById('book-modal-backdrop');
            if (backdrop) {
                backdrop.classList.remove('active');
                document.body.style.overflow = '';
            }
        };

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                window.closeBookModal();
            }
        });
    })();
    </script>
    <?php
}
add_action('wp_footer', 'mercado_livraria_footer_scripts', 99);



/**
 * ============================================================================
 * PAINEL DE GESTÃO DO ACERVO DIGITAL & ENVIO DE E-MAILS (PIX / MERCADO PAGO)
 * ============================================================================
 */

function mercado_livraria_admin_menu() {
    add_menu_page(
        'Livraria Digital',
        'Livraria Digital',
        'manage_options',
        'mercado-acervo-digital',
        'mercado_livraria_admin_page',
        'dashicons-book-alt',
        26
    );
    add_submenu_page(
        'mercado-acervo-digital',
        'Catálogo de Livros',
        'Catálogo de Livros',
        'manage_options',
        'mercado-acervo-digital',
        'mercado_livraria_admin_page'
    );
    add_submenu_page(
        'mercado-acervo-digital',
        'Envios & PDFs',
        'Envios & PDFs',
        'manage_options',
        'mercado-acervo-digital&tab=envios',
        'mercado_livraria_admin_page'
    );
}
add_action('admin_menu', 'mercado_livraria_admin_menu');

// Salvar / Editar Livro
function mercado_livraria_handle_save_book() {
    if (!current_user_can('manage_options')) {
        wp_die('Acesso não autorizado.');
    }
    check_admin_referer('mercado_livraria_save_action', 'mercado_livraria_save_nonce');

    $file_path = WP_CONTENT_DIR . '/uploads/livraria/livraria_clean.json';
    $books = file_exists($file_path) ? json_decode(file_get_contents($file_path), true) : array();
    if (!is_array($books)) $books = array();

    $book_id = isset($_POST['book_id']) ? intval($_POST['book_id']) : 0;
    $name    = isset($_POST['book_name']) ? sanitize_text_field($_POST['book_name']) : '';
    $price   = isset($_POST['book_price']) ? floatval(str_replace(',', '.', $_POST['book_price'])) : 0.0;
    $is_free = ($price <= 0.0 || !empty($_POST['book_is_free']));

    if (empty($name)) {
        wp_redirect(admin_url('admin.php?page=mercado-acervo-digital&status=error_name'));
        exit;
    }

    $buy_type  = isset($_POST['book_buy_type']) ? sanitize_text_field($_POST['book_buy_type']) : 'mercadopago';
    $buy_url   = isset($_POST['book_buy_url']) ? esc_url_raw($_POST['book_buy_url']) : '';
    $image     = isset($_POST['book_image']) ? esc_url_raw($_POST['book_image']) : '';
    $short_desc = isset($_POST['book_short_desc']) ? wp_kses_post($_POST['book_short_desc']) : '';
    $desc       = isset($_POST['book_desc']) ? wp_kses_post($_POST['book_desc']) : '';

    // Categorias
    $categories = array();
    if (!empty($_POST['book_categories'])) {
        if (is_array($_POST['book_categories'])) {
            $categories = array_map('sanitize_text_field', $_POST['book_categories']);
        } else {
            $categories = array_filter(array_map('trim', explode(',', sanitize_text_field($_POST['book_categories']))));
        }
    }
    if (empty($categories)) {
        $categories = array('Sexualidade');
    }

    // Buy label dinâmico
    $buy_label = 'Comprar no Hotmart';
    if ($is_free) {
        $buy_label = 'Acessar Grátis';
    } elseif ($buy_type === 'mercadopago') {
        $buy_label = 'Comprar com Mercado Pago (PIX / Cartão)';
    } elseif ($buy_type === 'loja_propria') {
        $buy_label = 'Comprar na Loja';
    } elseif ($buy_type === 'whatsapp') {
        $buy_label = 'Adquirir via WhatsApp / PIX';
    }

    $price_formatted = $is_free ? 'Gratuito' : 'R$ ' . number_format($price, 2, ',', '.');

    if ($book_id > 0) {
        // Editar existente
        $found = false;
        foreach ($books as &$b) {
            if ($b['id'] == $book_id) {
                $b['name'] = $name;
                $b['slug'] = sanitize_title($name);
                $b['price'] = $is_free ? 0 : $price;
                $b['price_formatted'] = $price_formatted;
                $b['is_free'] = $is_free;
                $b['categories'] = array_values($categories);
                if (!empty($image)) $b['image'] = $image;
                if (!empty($buy_url)) $b['buy_url'] = $buy_url;
                $b['buy_type'] = $buy_type;
                $b['buy_label'] = $buy_label;
                if (!empty($short_desc)) $b['short_description'] = $short_desc;
                if (!empty($desc)) $b['description'] = $desc;
                $found = true;
                break;
            }
        }
        unset($b);
        if (!$found) {
            $book_id = 0; // Se não encontrou, insere
        }
    }

    if ($book_id <= 0) {
        // Criar novo ID
        $max_id = 0;
        foreach ($books as $b) {
            if (isset($b['id']) && $b['id'] > $max_id) $max_id = $b['id'];
        }
        $new_id = $max_id > 0 ? $max_id + 1 : 2700;

        $new_book = array(
            'id' => $new_id,
            'name' => $name,
            'slug' => sanitize_title($name),
            'price' => $is_free ? 0 : $price,
            'price_formatted' => $price_formatted,
            'is_free' => $is_free,
            'categories' => array_values($categories),
            'image' => $image ?: '/wp-content/uploads/livraria/default-book.webp',
            'excerpt' => wp_trim_words(strip_tags($short_desc ?: $desc), 25, '...'),
            'description' => $desc,
            'short_description' => $short_desc,
            'buy_url' => $buy_url,
            'buy_type' => $buy_type,
            'buy_label' => $buy_label
        );

        array_unshift($books, $new_book); // Inserir no topo
        $book_id = $new_id;
    }

    // Salvar JSON
    file_put_contents($file_path, json_encode($books, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

    // Limpar caches
    if (defined('LSCWP_V')) {
        do_action('litespeed_purge_all');
    }
    wp_cache_flush();

    wp_redirect(admin_url('admin.php?page=mercado-acervo-digital&status=success_save&book_id=' . $book_id));
    exit;
}
add_action('admin_post_mercado_livraria_save_book', 'mercado_livraria_handle_save_book');

// Excluir Livro
function mercado_livraria_handle_delete_book() {
    if (!current_user_can('manage_options')) {
        wp_die('Acesso não autorizado.');
    }
    check_admin_referer('mercado_livraria_delete_action', 'mercado_livraria_delete_nonce');

    $book_id = isset($_GET['book_id']) ? intval($_GET['book_id']) : 0;
    if ($book_id <= 0) {
        wp_redirect(admin_url('admin.php?page=mercado-acervo-digital&status=error_invalid'));
        exit;
    }

    $file_path = WP_CONTENT_DIR . '/uploads/livraria/livraria_clean.json';
    $books = file_exists($file_path) ? json_decode(file_get_contents($file_path), true) : array();

    $new_books = array();
    $deleted = false;
    foreach ($books as $b) {
        if ($b['id'] == $book_id) {
            $deleted = true;
            continue;
        }
        $new_books[] = $b;
    }

    if ($deleted) {
        file_put_contents($file_path, json_encode($new_books, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        if (defined('LSCWP_V')) {
            do_action('litespeed_purge_all');
        }
        wp_cache_flush();
        wp_redirect(admin_url('admin.php?page=mercado-acervo-digital&status=success_delete'));
        exit;
    } else {
        wp_redirect(admin_url('admin.php?page=mercado-acervo-digital&status=error_not_found'));
        exit;
    }
}
add_action('admin_post_mercado_livraria_delete_book', 'mercado_livraria_handle_delete_book');

// Handle PDF upload
function mercado_livraria_handle_pdf_upload() {
    if (!current_user_can('manage_options')) {
        wp_die('Acesso não autorizado.');
    }
    check_admin_referer('mercado_upload_acervo_action', 'mercado_upload_nonce');

    $book_id = isset($_POST['book_id']) ? intval($_POST['book_id']) : 0;
    $book_name = isset($_POST['book_name']) ? sanitize_text_field($_POST['book_name']) : 'ebook';

    if ($book_id <= 0 || empty($_FILES['pdf_file']['name'])) {
        wp_redirect(admin_url('admin.php?page=mercado-acervo-digital&tab=envios&status=error_invalid'));
        exit;
    }

    $file = $_FILES['pdf_file'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if ($ext !== 'pdf') {
        wp_redirect(admin_url('admin.php?page=mercado-acervo-digital&tab=envios&status=error_not_pdf'));
        exit;
    }

    $dir = WP_CONTENT_DIR . '/uploads/acervo-digital';
    if (!file_exists($dir)) {
        wp_mkdir_p($dir);
        file_put_contents($dir . '/index.php', '<?php // Silence is golden.');
    }

    $clean_slug = sanitize_title($book_name);
    $target_name = $book_id . '-' . $clean_slug . '.pdf';
    $target_path = $dir . '/' . $target_name;

    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        chmod($target_path, 0644);
        wp_redirect(admin_url('admin.php?page=mercado-acervo-digital&tab=envios&status=success_upload&book_id=' . $book_id));
        exit;
    } else {
        wp_redirect(admin_url('admin.php?page=mercado-acervo-digital&tab=envios&status=error_upload'));
        exit;
    }
}
add_action('admin_post_mercado_upload_acervo_pdf', 'mercado_livraria_handle_pdf_upload');

function mercado_livraria_find_acervo_file($book_id, $book_slug) {
    $dir = WP_CONTENT_DIR . '/uploads/acervo-digital';
    if (!is_dir($dir)) return null;

    $files = scandir($dir);
    foreach ($files as $f) {
        if ($f === '.' || $f === '..' || $f === 'index.php') continue;
        if (strpos($f, (string)$book_id . '-') === 0 && substr($f, -4) === '.pdf') {
            return $f;
        }
    }
    return null;
}

// PÁGINA PRINCIPAL DO PAINEL DA LIVRARIA
function mercado_livraria_admin_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    wp_enqueue_media();

    $products = mercado_livraria_get_data();
    $acervo_url = content_url('uploads/acervo-digital');
    $status = $_GET['status'] ?? '';
    $current_tab = $_GET['tab'] ?? 'catalogo';

    // Lista de categorias conhecidas
    $all_cats = array('Sexualidade', 'Negócios', 'Vendas', 'Manuais e etc', 'Pompoarismo', 'Consultoria', 'Cursos & Treinamentos');
    ?>
    <div class="wrap" style="max-width:1300px; margin-top:20px;">
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:15px; margin-bottom:15px;">
            <h1 style="font-size:1.8rem; font-weight:800; display:flex; align-items:center; gap:10px; margin:0;">
                <span class="dashicons dashicons-book-alt" style="font-size:2.2rem; width:2.2rem; height:2.2rem; color:#e31c61;"></span>
                Livraria Digital — Gestão de Catálogo & Acervo
            </h1>
            <div style="display:flex; gap:10px;">
                <a href="<?php echo home_url('/livraria/'); ?>" target="_blank" class="button" style="display:inline-flex; align-items:center; gap:6px;">
                    <span class="dashicons dashicons-external" style="margin-top:2px;"></span> Ver Livraria no Site
                </a>
                <button type="button" class="button button-primary" style="background:#e31c61; border-color:#e31c61; font-weight:700; padding:4px 16px;" onclick="openBookModalForNew()">
                    + Adicionar Novo Livro
                </button>
            </div>
        </div>

        <!-- Notificações -->
        <?php if ($status === 'success_save'): ?>
            <div class="notice notice-success is-dismissible" style="padding:12px; font-weight:600;">
                ✅ Livro salvo com sucesso no catálogo e publicado na Livraria!
            </div>
        <?php elseif ($status === 'success_delete'): ?>
            <div class="notice notice-success is-dismissible" style="padding:12px; font-weight:600;">
                🗑️ Livro excluído com sucesso do catálogo da Livraria.
            </div>
        <?php elseif ($status === 'success_upload'): ?>
            <div class="notice notice-success is-dismissible" style="padding:12px; font-weight:600;">
                ✅ Arquivo PDF enviado com sucesso e arquivado no acervo digital!
            </div>
        <?php elseif ($status === 'error_name'): ?>
            <div class="notice notice-error is-dismissible" style="padding:12px; font-weight:600;">
                ❌ Erro: O título do livro não pode ficar em branco.
            </div>
        <?php endif; ?>

        <!-- Navegação por Abas -->
        <h2 class="nav-tab-wrapper" style="margin-bottom:20px;">
            <a href="<?php echo admin_url('admin.php?page=mercado-acervo-digital&tab=catalogo'); ?>" class="nav-tab <?php echo $current_tab === 'catalogo' ? 'nav-tab-active' : ''; ?>">
                📚 Catálogo de Livros (<?php echo count($products); ?> títulos)
            </a>
            <a href="<?php echo admin_url('admin.php?page=mercado-acervo-digital&tab=envios'); ?>" class="nav-tab <?php echo $current_tab === 'envios' ? 'nav-tab-active' : ''; ?>">
                ✉️ Acervo de PDFs & Envios para Compradores
            </a>
        </h2>

        <?php if ($current_tab === 'catalogo'): ?>
            <!-- ABA 1: CATÁLOGO COMPLETO (INCLUIR / EDITAR / EXCLUIR) -->
            <div style="background:#fff; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.06); padding:15px; margin-bottom:20px;">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                    <div style="display:flex; gap:10px; align-items:center; flex:1; max-width:400px;">
                        <input type="text" id="catalogo-search" placeholder="Buscar livro por título, autor ou ID..." style="width:100%; padding:6px 12px; border-radius:6px; border:1px solid #cbd5e1;" oninput="filterCatalogoTable()">
                    </div>
                    <div style="font-size:0.88rem; color:#64748b;">
                        Total: <strong><?php echo count($products); ?></strong> materiais cadastrados
                    </div>
                </div>
            </div>

            <div style="background:#fff; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.06); overflow:hidden;">
                <table class="wp-list-table widefat fixed striped" id="table-catalogo" style="border:none;">
                    <thead>
                        <tr style="background:#f8fafc;">
                            <th style="width:65px; font-weight:700; padding:12px 14px;">Capa</th>
                            <th style="width:38%; font-weight:700; padding:12px 14px;">Título & Detalhes</th>
                            <th style="width:110px; font-weight:700; padding:12px 14px;">Preço</th>
                            <th style="width:180px; font-weight:700; padding:12px 14px;">Plataforma / Checkout</th>
                            <th style="font-weight:700; padding:12px 14px;">Categorias</th>
                            <th style="width:180px; font-weight:700; padding:12px 14px; text-align:right;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $p): 
                            $pid = $p['id'];
                            $title = $p['name'];
                            $price = $p['price_formatted'];
                            $is_free = !empty($p['is_free']);
                            $img = $p['image'] ?? '';
                            $buy_type = $p['buy_type'] ?? 'whatsapp';
                            $buy_url = $p['buy_url'] ?? '';
                            $cats = $p['categories'] ?? array();
                            $cats_str = implode(', ', $cats);
                        ?>
                        <tr class="catalogo-row" data-search="<?php echo esc_attr(strtolower($title . ' ' . $pid . ' ' . $cats_str)); ?>">
                            <td style="padding:10px 14px; vertical-align:middle;">
                                <?php if ($img): ?>
                                    <img src="<?php echo esc_url($img); ?>" style="width:44px; height:60px; object-fit:cover; border-radius:4px; box-shadow:0 1px 3px rgba(0,0,0,0.2);">
                                <?php else: ?>
                                    <div style="width:44px; height:60px; background:#f1f5f9; border-radius:4px; display:flex; align-items:center; justify-content:center; color:#94a3b8;"><span class="dashicons dashicons-book"></span></div>
                                <?php endif; ?>
                            </td>
                            <td style="padding:10px 14px; vertical-align:middle;">
                                <strong style="font-size:0.95rem; color:#0f172a; display:block; margin-bottom:3px;"><?php echo esc_html($title); ?></strong>
                                <span style="font-size:0.75rem; color:#64748b;">ID: <code><?php echo $pid; ?></code></span>
                            </td>
                            <td style="padding:10px 14px; vertical-align:middle; font-weight:700; color:<?php echo $is_free ? '#10b981' : '#e31c61'; ?>;">
                                <?php echo esc_html($price); ?>
                            </td>
                            <td style="padding:10px 14px; vertical-align:middle;">
                                <?php if ($buy_type === 'mercadopago'): ?>
                                    <span style="display:inline-block; background:#009ee3; color:#fff; font-size:0.75rem; font-weight:800; padding:3px 8px; border-radius:4px;">MERCADO PAGO</span>
                                <?php elseif ($buy_type === 'hotmart'): ?>
                                    <span style="display:inline-block; background:#f04e23; color:#fff; font-size:0.75rem; font-weight:800; padding:3px 8px; border-radius:4px;">HOTMART</span>
                                <?php elseif ($is_free || $buy_type === 'download'): ?>
                                    <span style="display:inline-block; background:#10b981; color:#fff; font-size:0.75rem; font-weight:800; padding:3px 8px; border-radius:4px;">GRATUITO</span>
                                <?php elseif ($buy_type === 'loja_propria'): ?>
                                    <span style="display:inline-block; background:#8b5cf6; color:#fff; font-size:0.75rem; font-weight:800; padding:3px 8px; border-radius:4px;">LOJA PRÓPRIA</span>
                                <?php else: ?>
                                    <span style="display:inline-block; background:#25d366; color:#fff; font-size:0.75rem; font-weight:800; padding:3px 8px; border-radius:4px;">WHATSAPP</span>
                                <?php endif; ?>
                                <?php if (!empty($buy_url)): ?>
                                    <a href="<?php echo esc_url($buy_url); ?>" target="_blank" style="display:block; font-size:0.75rem; color:#64748b; margin-top:4px; text-decoration:none; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; max-width:160px;" title="<?php echo esc_attr($buy_url); ?>">🔗 <?php echo esc_html($buy_url); ?></a>
                                <?php endif; ?>
                            </td>
                            <td style="padding:10px 14px; vertical-align:middle; font-size:0.85rem; color:#475569;">
                                <?php foreach ($cats as $c): ?>
                                    <span style="background:#f1f5f9; padding:2px 6px; border-radius:3px; font-size:0.75rem; margin-right:4px; display:inline-block; margin-bottom:2px;"><?php echo esc_html($c); ?></span>
                                <?php endforeach; ?>
                            </td>
                            <td style="padding:10px 14px; vertical-align:middle; text-align:right;">
                                <div style="display:flex; justify-content:flex-end; gap:6px;">
                                    <button type="button" class="button button-small" onclick="openBookModalForEdit(<?php echo htmlspecialchars(json_encode($p), ENT_QUOTES, 'UTF-8'); ?>)" style="color:#0284c7; border-color:#bae6fd;">
                                        ✏️ Editar
                                    </button>
                                    <a href="<?php echo wp_nonce_url(admin_url('admin-post.php?action=mercado_livraria_delete_book&book_id=' . $pid), 'mercado_livraria_delete_action', 'mercado_livraria_delete_nonce'); ?>" class="button button-small" onclick="return confirm('Tem certeza que deseja excluir o livro '<?php echo esc_js($title); ?>' da Livraria?')" style="color:#e11d48; border-color:#fecdd3;">
                                        🗑️ Excluir
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php else: ?>
            <!-- ABA 2: ENVIOS DE PDF & COMPRADORES -->
            <p style="font-size:1rem; color:#555; margin-bottom:20px;">
                Este painel permite consultar o arquivo PDF de cada e-book, copiar os links de download direto ou preparar na hora o e-mail de entrega para o comprador após a confirmação do pagamento.
            </p>
            <div style="background:#fff; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.06); overflow:hidden;">
                <table class="wp-list-table widefat fixed striped" style="border:none;">
                    <thead>
                        <tr style="background:#f8fafc;">
                            <th style="width:70px; font-weight:700; padding:12px 16px;">Capa</th>
                            <th style="font-weight:700; padding:12px 16px;">Livro / Material</th>
                            <th style="width:110px; font-weight:700; padding:12px 16px;">Preço</th>
                            <th style="width:170px; font-weight:700; padding:12px 16px;">Status no Acervo</th>
                            <th style="width:340px; font-weight:700; padding:12px 16px; text-align:right;">Ações de Envio & Gestão</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $target_products = array_filter($products, function($p) {
                            $bt = $p['buy_type'] ?? '';
                            return ($bt === 'whatsapp' || !empty($p['is_free']) || $bt === 'free' || $bt === 'download' || $bt === 'mercadopago');
                        });
                        foreach ($target_products as $p): 
                            $pid = $p['id'];
                            $title = $p['name'];
                            $slug = $p['slug'] ?? sanitize_title($title);
                            $price = $p['price_formatted'];
                            $is_free = !empty($p['is_free']);
                            $img = $p['image'] ?? '';
                            $acervo_file = mercado_livraria_find_acervo_file($pid, $slug);
                            $file_url = $acervo_file ? $acervo_url . '/' . $acervo_file : ($p['buy_url'] ?? '');
                            $has_file = !empty($acervo_file) || (strpos($file_url, '.pdf') !== false);
                        ?>
                        <tr>
                            <td style="padding:12px 16px; vertical-align:middle;">
                                <?php if ($img): ?>
                                    <img src="<?php echo esc_url($img); ?>" style="width:48px; height:64px; object-fit:cover; border-radius:4px; box-shadow:0 1px 3px rgba(0,0,0,0.2);">
                                <?php else: ?>
                                    <div style="width:48px; height:64px; background:#f1f5f9; border-radius:4px; display:flex; align-items:center; justify-content:center; color:#94a3b8;"><span class="dashicons dashicons-book"></span></div>
                                <?php endif; ?>
                            </td>
                            <td style="padding:12px 16px; vertical-align:middle;">
                                <div style="font-weight:700; color:#1e293b; font-size:0.95rem; margin-bottom:4px;"><?php echo esc_html($title); ?></div>
                                <div style="font-size:0.8rem; color:#64748b;">ID: <?php echo $pid; ?> • <?php echo $is_free ? '<span style="color:#10b981; font-weight:700;">Material Gratuito</span>' : 'Venda Direta (PIX / MP)'; ?></div>
                                <?php if ($has_file): ?>
                                    <div style="font-size:0.75rem; color:#059669; margin-top:4px; font-family:monospace; word-break:break-all;">
                                        📁 <?php echo esc_html($acervo_file ?: basename($file_url)); ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td style="padding:12px 16px; vertical-align:middle; font-weight:700; color:<?php echo $is_free ? '#10b981' : '#e31c61'; ?>;">
                                <?php echo esc_html($price); ?>
                            </td>
                            <td style="padding:12px 16px; vertical-align:middle;">
                                <?php if ($has_file): ?>
                                    <span style="display:inline-flex; align-items:center; gap:5px; background:#ecfdf5; color:#065f46; padding:5px 10px; border-radius:20px; font-size:0.8rem; font-weight:700;">
                                        <span class="dashicons dashicons-yes-alt" style="font-size:16px; width:16px; height:16px;"></span> PDF Arquivado
                                    </span>
                                <?php else: ?>
                                    <span style="display:inline-flex; align-items:center; gap:5px; background:#fffbeb; color:#92400e; padding:5px 10px; border-radius:20px; font-size:0.8rem; font-weight:700;">
                                        <span class="dashicons dashicons-warning" style="font-size:16px; width:16px; height:16px;"></span> PDF Pendente
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td style="padding:12px 16px; vertical-align:middle; text-align:right;">
                                <div style="display:flex; justify-content:flex-end; gap:8px; flex-wrap:wrap; align-items:center;">
                                    <?php if ($has_file): ?>
                                        <button type="button" class="button button-primary" style="background:#e31c61; border-color:#e31c61; font-weight:600;" onclick="openEmailModal(<?php echo htmlspecialchars(json_encode(array(
                                            'id' => $pid,
                                            'title' => $title,
                                            'file_url' => $file_url,
                                            'price' => $price
                                        )), ENT_QUOTES, 'UTF-8'); ?>)">
                                            ✉️ Enviar p/ Comprador
                                        </button>
                                        <a href="<?php echo esc_url($file_url); ?>" target="_blank" download class="button button-secondary" title="Baixar arquivo agora">
                                            📥 Baixar
                                        </a>
                                        <button type="button" class="button button-secondary" onclick="copyToClipboard('<?php echo esc_js($file_url); ?>', 'Link do PDF copiado!')" title="Copiar link direto do PDF">
                                            🔗 Copiar Link
                                        </button>
                                    <?php else: ?>
                                        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" enctype="multipart/form-data" style="display:inline-flex; gap:6px; align-items:center;">
                                            <?php wp_nonce_field('mercado_upload_acervo_action', 'mercado_upload_nonce'); ?>
                                            <input type="hidden" name="action" value="mercado_upload_acervo_pdf">
                                            <input type="hidden" name="book_id" value="<?php echo $pid; ?>">
                                            <input type="hidden" name="book_name" value="<?php echo esc_attr($title); ?>">
                                            <input type="file" name="pdf_file" accept=".pdf" required style="font-size:0.75rem; max-width:140px;">
                                            <button type="submit" class="button button-secondary" style="font-size:0.75rem;">
                                                ⬆️ Subir PDF
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- MODAL DE INCLUSÃO & EDIÇÃO DE LIVRO -->
    <div id="book-edit-modal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.65); z-index:999999; align-items:center; justify-content:center; padding:20px;">
        <div style="background:#fff; border-radius:12px; width:100%; max-width:700px; max-height:90vh; display:flex; flex-direction:column; box-shadow:0 25px 50px rgba(0,0,0,0.3); overflow:hidden;">
            <div style="background:#0f172a; color:#fff; padding:18px 24px; display:flex; justify-content:space-between; align-items:center;">
                <h3 id="modal-form-title" style="margin:0; font-size:1.2rem; color:#fff; font-weight:700;">📚 Adicionar Novo Livro</h3>
                <button type="button" onclick="closeBookModal()" style="background:none; border:none; color:#94a3b8; font-size:1.8rem; cursor:pointer; line-height:1;">&times;</button>
            </div>
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" style="display:flex; flex-direction:column; flex:1; overflow:hidden;">
                <?php wp_nonce_field('mercado_livraria_save_action', 'mercado_livraria_save_nonce'); ?>
                <input type="hidden" name="action" value="mercado_livraria_save_book">
                <input type="hidden" name="book_id" id="form-book-id" value="0">

                <div style="padding:24px; overflow-y:auto; flex:1;">
                    <div style="margin-bottom:18px;">
                        <label style="display:block; font-weight:700; margin-bottom:6px; font-size:0.9rem; color:#1e293b;">Título do Livro / Material *</label>
                        <input type="text" name="book_name" id="form-book-name" required placeholder="Ex: Manual de Vendas para Sexshop" style="width:100%; padding:8px 12px; border:1px solid #cbd5e1; border-radius:6px; font-size:0.95rem;">
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:18px;">
                        <div>
                            <label style="display:block; font-weight:700; margin-bottom:6px; font-size:0.9rem; color:#1e293b;">Preço (R$)</label>
                            <input type="text" name="book_price" id="form-book-price" placeholder="Ex: 19.80 (0 para Grátis)" style="width:100%; padding:8px 12px; border:1px solid #cbd5e1; border-radius:6px; font-size:0.95rem;">
                        </div>
                        <div>
                            <label style="display:block; font-weight:700; margin-bottom:6px; font-size:0.9rem; color:#1e293b;">Plataforma de Checkout</label>
                            <select name="book_buy_type" id="form-book-buy-type" style="width:100%; padding:8px 12px; border:1px solid #cbd5e1; border-radius:6px; font-size:0.95rem;" onchange="updateBuyTypeNotice()">
                                <option value="mercadopago">Mercado Pago (PIX / Cartão)</option>
                                <option value="hotmart">Hotmart</option>
                                <option value="download">Download Gratuito (PDF Direto)</option>
                                <option value="loja_propria">Loja Própria</option>
                                <option value="whatsapp">Atendimento WhatsApp</option>
                            </select>
                        </div>
                    </div>

                    <div style="margin-bottom:18px;">
                        <label style="display:block; font-weight:700; margin-bottom:6px; font-size:0.9rem; color:#1e293b;" id="label-buy-url">Link de Pagamento / Checkout (Mercado Pago ou Hotmart)</label>
                        <input type="url" name="book_buy_url" id="form-book-buy-url" placeholder="Ex: https://mpago.la/... ou https://pay.hotmart.com/..." style="width:100%; padding:8px 12px; border:1px solid #cbd5e1; border-radius:6px; font-size:0.95rem;">
                        <span id="buy-url-hint" style="display:block; font-size:0.78rem; color:#64748b; margin-top:4px;">Cole aqui o link de pagamento do Mercado Pago gerado para este e-book.</span>
                    </div>

                    <div style="margin-bottom:18px;">
                        <label style="display:block; font-weight:700; margin-bottom:6px; font-size:0.9rem; color:#1e293b;">Imagem de Capa (URL)</label>
                        <div style="display:flex; gap:8px;">
                            <input type="text" name="book_image" id="form-book-image" placeholder="https://.../capa.jpg" style="flex:1; padding:8px 12px; border:1px solid #cbd5e1; border-radius:6px; font-size:0.95rem;">
                            <button type="button" class="button" onclick="chooseCoverMedia()" style="padding:4px 12px;">📁 Escolher da Mídia</button>
                        </div>
                    </div>

                    <div style="margin-bottom:18px;">
                        <label style="display:block; font-weight:700; margin-bottom:6px; font-size:0.9rem; color:#1e293b;">Categorias</label>
                        <div style="display:flex; flex-wrap:wrap; gap:10px; background:#f8fafc; padding:10px; border-radius:6px; border:1px solid #e2e8f0;">
                            <?php foreach ($all_cats as $c): ?>
                                <label style="font-size:0.85rem; display:inline-flex; align-items:center; gap:5px; cursor:pointer;">
                                    <input type="checkbox" name="book_categories[]" value="<?php echo esc_attr($c); ?>" class="cat-checkbox"> <?php echo esc_html($c); ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div style="margin-bottom:18px;">
                        <label style="display:block; font-weight:700; margin-bottom:6px; font-size:0.9rem; color:#1e293b;">Sinopse Curta (Exibida no Card)</label>
                        <textarea name="book_short_desc" id="form-book-short-desc" rows="3" placeholder="Resumo em 1 ou 2 parágrafos sobre o material..." style="width:100%; padding:8px 12px; border:1px solid #cbd5e1; border-radius:6px; font-size:0.9rem;"></textarea>
                    </div>

                    <div>
                        <label style="display:block; font-weight:700; margin-bottom:6px; font-size:0.9rem; color:#1e293b;">Descrição Completa (Exibida no Modal de Detalhes)</label>
                        <textarea name="book_desc" id="form-book-desc" rows="6" placeholder="Informações completas, sumário, público-alvo, número de páginas..." style="width:100%; padding:8px 12px; border:1px solid #cbd5e1; border-radius:6px; font-size:0.9rem;"></textarea>
                    </div>
                </div>

                <div style="background:#f8fafc; border-top:1px solid #e2e8f0; padding:16px 24px; display:flex; justify-content:flex-end; gap:12px;">
                    <button type="button" class="button button-secondary" onclick="closeBookModal()">Cancelar</button>
                    <button type="submit" class="button button-primary" style="background:#e31c61; border-color:#e31c61; font-weight:700; padding:4px 20px;">
                        💾 Salvar Livro
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Envio de E-mail -->
    <div id="email-helper-modal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:999999; align-items:center; justify-content:center; padding:20px;">
        <div style="background:#fff; border-radius:12px; width:100%; max-width:650px; box-shadow:0 20px 40px rgba(0,0,0,0.25); overflow:hidden;">
            <div style="background:#1e293b; color:#fff; padding:18px 24px; display:flex; justify-content:space-between; align-items:center;">
                <h3 style="margin:0; font-size:1.15rem; color:#fff; font-weight:700;">✉️ Preparar E-mail de Entrega do Livro</h3>
                <button type="button" onclick="closeEmailModal()" style="background:none; border:none; color:#fff; font-size:1.5rem; cursor:pointer; line-height:1;">&times;</button>
            </div>
            <div style="padding:24px;">
                <div style="margin-bottom:15px;">
                    <label style="display:block; font-weight:700; margin-bottom:5px; font-size:0.85rem; color:#334155;">E-mail do Comprador (opcional para abrir cliente de e-mail):</label>
                    <input type="email" id="modal-buyer-email" placeholder="comprador@email.com" style="width:100%; padding:8px 12px; border:1px solid #cbd5e1; border-radius:6px; font-size:0.9rem;" oninput="updateMailtoLink()">
                </div>
                <div style="margin-bottom:15px;">
                    <label style="display:block; font-weight:700; margin-bottom:5px; font-size:0.85rem; color:#334155;">Assunto do E-mail:</label>
                    <input type="text" id="modal-email-subject" style="width:100%; padding:8px 12px; border:1px solid #cbd5e1; border-radius:6px; font-size:0.9rem;" readonly>
                </div>
                <div style="margin-bottom:20px;">
                    <label style="display:block; font-weight:700; margin-bottom:5px; font-size:0.85rem; color:#334155;">Mensagem Pronta para Envio:</label>
                    <textarea id="modal-email-body" rows="9" style="width:100%; padding:10px 12px; border:1px solid #cbd5e1; border-radius:6px; font-size:0.85rem; line-height:1.5; font-family:monospace; background:#f8fafc;"></textarea>
                </div>
                <div style="display:flex; justify-content:space-between; gap:12px; align-items:center; border-top:1px solid #f1f5f9; padding-top:18px;">
                    <button type="button" class="button button-secondary" onclick="closeEmailModal()">Fechar</button>
                    <div style="display:flex; gap:10px;">
                        <button type="button" class="button" onclick="copyEmailContent()" style="background:#f1f5f9; font-weight:600;">
                            📋 Copiar Mensagem
                        </button>
                        <a id="modal-mailto-btn" href="#" class="button button-primary" style="background:#10b981; border-color:#10b981; font-weight:700;">
                            🚀 Abrir no Meu E-mail
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Filtro rápido no catálogo
    function filterCatalogoTable() {
        const q = document.getElementById('catalogo-search').value.toLowerCase().trim();
        const rows = document.querySelectorAll('#table-catalogo .catalogo-row');
        rows.forEach(r => {
            const search = r.getAttribute('data-search') || '';
            r.style.display = search.includes(q) ? '' : 'none';
        });
    }

    // Modal de Livro (Novo / Editar)
    function openBookModalForNew() {
        document.getElementById('modal-form-title').innerText = '📚 Adicionar Novo Livro / E-book';
        document.getElementById('form-book-id').value = '0';
        document.getElementById('form-book-name').value = '';
        document.getElementById('form-book-price').value = '';
        document.getElementById('form-book-buy-type').value = 'mercadopago';
        document.getElementById('form-book-buy-url').value = '';
        document.getElementById('form-book-image').value = '';
        document.getElementById('form-book-short-desc').value = '';
        document.getElementById('form-book-desc').value = '';

        document.querySelectorAll('.cat-checkbox').forEach(cb => cb.checked = false);
        updateBuyTypeNotice();
        document.getElementById('book-edit-modal').style.display = 'flex';
    }

    function openBookModalForEdit(book) {
        document.getElementById('modal-form-title').innerText = '✏️ Editar Livro: ' + book.name;
        document.getElementById('form-book-id').value = book.id || 0;
        document.getElementById('form-book-name').value = book.name || '';
        document.getElementById('form-book-price').value = book.price !== undefined ? book.price : '';
        document.getElementById('form-book-buy-type').value = book.buy_type || 'mercadopago';
        document.getElementById('form-book-buy-url').value = book.buy_url || '';
        document.getElementById('form-book-image').value = book.image || '';
        document.getElementById('form-book-short-desc').value = book.short_description || '';
        document.getElementById('form-book-desc').value = book.description || '';

        const cats = Array.isArray(book.categories) ? book.categories : [];
        document.querySelectorAll('.cat-checkbox').forEach(cb => {
            cb.checked = cats.includes(cb.value);
        });

        updateBuyTypeNotice();
        document.getElementById('book-edit-modal').style.display = 'flex';
    }

    function closeBookModal() {
        document.getElementById('book-edit-modal').style.display = 'none';
    }

    function updateBuyTypeNotice() {
        const type = document.getElementById('form-book-buy-type').value;
        const hint = document.getElementById('buy-url-hint');
        const label = document.getElementById('label-buy-url');
        if (type === 'mercadopago') {
            label.innerText = 'Link de Pagamento Mercado Pago (mpago.la)';
            hint.innerText = 'Cole o link encurtado gerado no Mercado Pago (ex: https://mpago.la/...).';
        } else if (type === 'hotmart') {
            label.innerText = 'Link de Checkout Hotmart';
            hint.innerText = 'Cole o link de checkout ou da página do Hotmart.';
        } else if (type === 'download') {
            label.innerText = 'Link Direto do Arquivo PDF';
            hint.innerText = 'Cole a URL do arquivo PDF hospedado para download direto.';
        } else if (type === 'loja_propria') {
            label.innerText = 'Link do Produto na Loja Própria';
            hint.innerText = 'Cole a URL da página de vendas da sua loja.';
        } else {
            label.innerText = 'Link do WhatsApp ou Atendimento';
            hint.innerText = 'Deixe em branco para usar o número padrão ou cole o link wa.me.';
        }
    }

    // Media library selector
    function chooseCoverMedia() {
        const mediaFrame = wp.media({
            title: 'Selecionar Capa do Livro',
            button: { text: 'Usar como Capa' },
            multiple: false
        });
        mediaFrame.on('select', function() {
            const attachment = mediaFrame.state().get('selection').first().toJSON();
            document.getElementById('form-book-image').value = attachment.url;
        });
        mediaFrame.open();
    }

    // Modal de E-mail de entrega
    let currentModalBook = null;
    function openEmailModal(book) {
        currentModalBook = book;
        const subject = '[Mercado Erótico] Seu E-book: ' + book.title + ' - Acesso Liberado! 📚';
        const body = `Olá! Tudo bem?

Confirmamos com sucesso o recebimento do seu pagamento referente ao e-book:
"${book.title}".

Você já pode acessar e baixar o seu exemplar digital diretamente no link seguro abaixo:
` + book.file_url + `

(Recomendamos salvar o arquivo em seu computador, tablet ou celular para ler sempre que desejar).

Se precisar de qualquer suporte ou preferir receber o arquivo anexado diretamente nesta conversa, basta responder a este e-mail.

Desejamos uma excelente leitura e muito sucesso!

Atenciosamente,
Equipe Mercado Erótico
contato@mercadoerotico.org | mercadoerotico.org`;

        document.getElementById('modal-buyer-email').value = '';
        document.getElementById('modal-email-subject').value = subject;
        document.getElementById('modal-email-body').value = body;

        updateMailtoLink();
        document.getElementById('email-helper-modal').style.display = 'flex';
    }

    function updateMailtoLink() {
        if (!currentModalBook) return;
        const buyerEmail = document.getElementById('modal-buyer-email').value.trim();
        const subject = document.getElementById('modal-email-subject').value;
        const body = document.getElementById('modal-email-body').value;
        const mailto = 'mailto:' + encodeURIComponent(buyerEmail) + '?subject=' + encodeURIComponent(subject) + '&body=' + encodeURIComponent(body);
        document.getElementById('modal-mailto-btn').href = mailto;
    }

    function closeEmailModal() {
        document.getElementById('email-helper-modal').style.display = 'none';
        currentModalBook = null;
    }

    function copyToClipboard(text, msg) {
        navigator.clipboard.writeText(text).then(function() {
            alert(msg || 'Copiado para a área de transferência!');
        });
    }

    function copyEmailContent() {
        const body = document.getElementById('modal-email-body').value;
        navigator.clipboard.writeText(body).then(function() {
            alert('Mensagem copiada com sucesso! Agora é só colar no seu e-mail.');
        });
    }
    </script>
    <?php
}
