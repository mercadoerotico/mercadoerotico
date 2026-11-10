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
            if (strpos($norm, 'sexual') !== false || strpos($norm, 'saude') !== false) {
                $has_sexualidade = true;
            }
            if (strpos($norm, 'gratuito') !== false && !in_array('gratuito', $slugs)) {
                $slugs[] = 'gratuito';
                $gratuito_count++;
            }
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
            <div class="livraria-badge">★ LIVRARIA DIGITAL &amp; FORMAÇÃO PROFISSIONAL</div>
            <h1 class="livraria-title">Livraria Mercado Erótico</h1>
            <p class="livraria-subtitle">E-books especializados, manuais de negócios, calendários para redes sociais e cursos práticos para o mercado íntimo e bem-estar sexual.</p>
            
            <div class="livraria-stats-bar">
                <div class="stat-item"><span class="stat-num"><?php echo $total_count; ?></span><span class="stat-lbl">Títulos &amp; Manuais</span></div>
                <div class="stat-sep">•</div>
                <div class="stat-item"><span class="stat-num">Digital</span><span class="stat-lbl">Acesso Imediato</span></div>
                <div class="stat-sep">•</div>
                <div class="stat-item"><span class="stat-num">100%</span><span class="stat-lbl">Conteúdo Exclusivo</span></div>
            </div>

            <!-- Search Bar -->
            <div class="livraria-search-box">
                <i class="fas fa-search search-icon" aria-hidden="true"></i>
                <input type="text" id="livraria-search-input" placeholder="Pesquisar por título, autor ou tema (ex: Pompoarismo, Negócios, SexPack)..." autocomplete="off" oninput="onLivrariaSearchInput(this.value)">
                <button type="button" id="livraria-search-btn" class="livraria-btn-search" onclick="onLivrariaSearchClick()">Buscar</button>
            </div>
        </div>

        <!-- Category Filter Tabs -->
        <div class="livraria-filter-section">
            <div class="filter-header">
                <span class="filter-label"><i class="fas fa-layer-group"></i> Categorias &amp; Formatos:</span>
            </div>
            <div class="tabs-wrap" id="livraria-tabs">
                <button type="button" class="livraria-tab active" data-slug="all" onclick="selectLivrariaTab('all', this)">
                    📚 Todos os Títulos (<?php echo $total_count; ?>)
                </button>
                <button type="button" class="livraria-tab" data-slug="negocios" onclick="selectLivrariaTab('negocios', this)">
                    💼 Negócios &amp; SexShop (<?php echo $negocios_count; ?>)
                </button>
                <button type="button" class="livraria-tab" data-slug="manuais" onclick="selectLivrariaTab('manuais', this)">
                    📖 Manuais &amp; Guias (<?php echo $manuais_count; ?>)
                </button>
                <button type="button" class="livraria-tab" data-slug="cursos" onclick="selectLivrariaTab('cursos', this)">
                    🎓 Cursos &amp; Workshops (<?php echo $cursos_count; ?>)
                </button>
                <button type="button" class="livraria-tab" data-slug="sexualidade" onclick="selectLivrariaTab('sexualidade', this)">
                    ❤️ Saúde &amp; Sexualidade (<?php echo $sexualidade_count; ?>)
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
                                if (!empty($p['is_free'])) {
                                    if (!empty($p['buy_type']) && $p['buy_type'] === 'download') {
                                        $btn_text = 'Baixar PDF';
                                        $btn_icon = 'fa-download';
                                    } else {
                                        $btn_text = 'Acessar Grátis';
                                        $btn_icon = 'fa-arrow-right';
                                    }
                                }
                            ?>
                            <button type="button" class="btn-action <?php echo !empty($p['is_free']) ? 'btn-action-free' : ''; ?>" onclick="openBookModal(<?php echo $pid; ?>)">
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
    .badge-platform.hotmart {
        position: absolute;
        top: 15px;
        left: 15px;
        background: #F04E23;
        color: #fff;
        font-size: 0.68rem;
        font-weight: 800;
        padding: 4px 9px;
        border-radius: 20px;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px rgba(240,78,35,0.3);
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
            } else if (buyType === 'external') {
                actionButtonsHtml = `
                    <a href="${buyUrl}" target="_blank" rel="noopener" class="modal-btn-external">
                        <i class="fas fa-external-link-alt"></i> Acessar no Site Oficial <i class="fas fa-arrow-right"></i>
                    </a>
                `;
            } else if (isFree || buyType === 'download') {
                const isPdf = buyUrl && (buyUrl.toLowerCase().endsWith('.pdf') || buyType === 'download');
                if (isPdf) {
                    actionButtonsHtml = `
                        <a href="${buyUrl}" target="_blank" download rel="noopener" class="modal-btn-free">
                            <i class="fas fa-file-pdf" style="font-size:1.25rem;"></i> Baixar PDF Agora (Gratuito) <i class="fas fa-download"></i>
                        </a>
                    `;
                } else {
                    actionButtonsHtml = `
                        <a href="${mailUrl}" class="modal-btn-free">
                            <i class="fas fa-envelope" style="font-size:1.15rem;"></i> Solicitar Envio do PDF por E-mail <i class="fas fa-arrow-right"></i>
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
