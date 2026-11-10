<?php
/**
 * Plugin Name: Mercado Erótico - Livraria Digital
 * Description: Vitrine moderna e catálogo digital de livros, manuais e cursos do Mercado Erótico.
 * Version: 1.0.0
 * Author: Equipe Mercado Erótico
 */

if (!defined('ABSPATH')) exit;

function mercado_livraria_get_data() {
    $file = WP_CONTENT_DIR . '/uploads/livraria/livraria_clean.json';
    if (!file_exists($file)) return array();
    $content = file_get_contents($file);
    return json_decode($content, true) ?: array();
}

function mercado_livraria_shortcode() {
    $products = mercado_livraria_get_data();
    ob_start();
    ?>
    <div id="livraria-app" class="livraria-wrapper">
        <!-- Hero Header -->
        <div class="livraria-hero">
            <div class="livraria-badge">★ LIVRARIA DIGITAL & FORMAÇÃO PROFISSIONAL</div>
            <h1 class="livraria-title">Livraria Mercado Erótico</h1>
            <p class="livraria-subtitle">E-books especializados, manuais de negócios, calendários para redes sociais e cursos práticos para o mercado íntimo e bem-estar sexual.</p>
            
            <div class="livraria-stats-bar">
                <div class="stat-item"><span class="stat-num">54</span><span class="stat-lbl">Títulos & Manuais</span></div>
                <div class="stat-sep">•</div>
                <div class="stat-item"><span class="stat-num">Digital</span><span class="stat-lbl">Acesso Imediato</span></div>
                <div class="stat-sep">•</div>
                <div class="stat-item"><span class="stat-num">100%</span><span class="stat-lbl">Conteúdo Exclusivo</span></div>
            </div>

            <!-- Search Bar -->
            <div class="livraria-search-box">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="livraria-search-input" placeholder="Pesquisar por título, tema ou tipo (ex: Pompoarismo, Negócios, SexPack, Fornecedores)...">
                <button type="button" id="livraria-search-btn" class="livraria-btn-search">Buscar</button>
            </div>
        </div>

        <!-- Category Filter Tabs -->
        <div class="livraria-filter-section">
            <div class="filter-header">
                <span class="filter-label"><i class="fas fa-layer-group"></i> Categorias & Formatos:</span>
            </div>
            <div class="tabs-wrap" id="livraria-tabs">
                <button class="livraria-tab active" data-cat="all">📚 Todos os Títulos (54)</button>
                <button class="livraria-tab" data-cat="Negócios">💼 Negócios & SexShop (15)</button>
                <button class="livraria-tab" data-cat="Manuais e etc">📖 Manuais & Guias (17)</button>
                <button class="livraria-tab" data-cat="Cursos">🎓 Cursos & Workshops (11)</button>
                <button class="livraria-tab" data-cat="Sexualidade">❤️ Saúde & Sexualidade (18)</button>
                <button class="livraria-tab" data-cat="Gratuito">🎁 Gratuitos (7)</button>
            </div>
        </div>

        <!-- Results Counter -->
        <div class="livraria-results-bar">
            <div id="livraria-count" class="results-count">Exibindo <strong>54</strong> itens</div>
            <button id="livraria-clear-btn" class="clear-filters-btn" style="display:none;"><i class="fas fa-times"></i> Limpar Filtro</button>
        </div>

        <!-- Products Grid -->
        <div id="livraria-grid" class="livraria-grid">
            <?php foreach ($products as $p): ?>
                <div class="book-card" 
                     data-id="<?php echo esc_attr($p['id']); ?>" 
                     data-name="<?php echo esc_attr(strtolower($p['name'])); ?>"
                     data-cats="<?php echo esc_attr(implode(',', $p['categories'])); ?>"
                     data-free="<?php echo $p['is_free'] ? '1' : '0'; ?>">
                    <div class="book-cover-wrap">
                        <?php if ($p['image']): ?>
                            <img src="<?php echo esc_url($p['image']); ?>" alt="<?php echo esc_attr($p['name']); ?>" class="book-cover-img" loading="lazy">
                        <?php else: ?>
                            <div class="book-no-cover"><i class="fas fa-book"></i></div>
                        <?php endif; ?>
                        
                        <?php if ($p['is_free']): ?>
                            <span class="badge-free">GRATUITO</span>
                        <?php endif; ?>

                        <div class="book-hover-overlay">
                            <button class="btn-quick-view" onclick="openBookModal(<?php echo esc_attr($p['id']); ?>)"><i class="fas fa-eye"></i> Ver Detalhes</button>
                        </div>
                    </div>

                    <div class="book-info">
                        <div class="book-cats">
                            <?php foreach (array_slice($p['categories'], 0, 2) as $cat): ?>
                                <span class="cat-pill"><?php echo esc_html($cat); ?></span>
                            <?php endforeach; ?>
                        </div>
                        <h3 class="book-title" onclick="openBookModal(<?php echo esc_attr($p['id']); ?>)"><?php echo esc_html($p['name']); ?></h3>
                        <p class="book-excerpt"><?php echo esc_html($p['excerpt']); ?></p>
                        
                        <div class="book-footer">
                            <div class="book-price-block">
                                <span class="price-val <?php echo $p['is_free'] ? 'free-text' : ''; ?>"><?php echo esc_html($p['price_formatted']); ?></span>
                            </div>
                            <button class="btn-action" onclick="openBookModal(<?php echo esc_attr($p['id']); ?>)">
                                <?php echo $p['is_free'] ? 'Acessar' : 'Detalhes'; ?> <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Modal Details -->
        <div id="book-modal-backdrop" class="book-modal-backdrop" onclick="closeBookModal(event)">
            <div class="book-modal-content" onclick="event.stopPropagation()">
                <button class="modal-close-btn" onclick="closeBookModal()">&times;</button>
                <div class="modal-body" id="modal-body-content">
                    <!-- Dynamic modal content -->
                </div>
            </div>
        </div>
    </div>

    <!-- Embedded Products Data for Instant Filtering and Modal -->
    <script>
    const LIVRARIA_PRODUCTS = <?php echo json_encode($products); ?>;
    </script>

    <style>
    /* LIVRARIA STYLES */
    .livraria-wrapper {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        color: #222;
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 20px 80px;
    }
    .livraria-hero {
        background: radial-gradient(circle at 50% 30%, #201322 0%, #0d0612 100%);
        border-radius: 20px;
        padding: 50px 30px;
        text-align: center;
        color: #fff;
        margin-bottom: 40px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        border: 1px solid rgba(227, 28, 97, 0.2);
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
    }
    .livraria-search-box input {
        width: 100%;
        padding: 16px 130px 16px 50px;
        border-radius: 50px;
        border: 2px solid rgba(255,255,255,0.15);
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

    /* FILTERS */
    .livraria-filter-section {
        margin-bottom: 25px;
    }
    .filter-header {
        font-size: 0.95rem;
        font-weight: 700;
        color: #555;
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
        background: #f4f4f7;
        color: #444;
        border: 1px solid #e1e1e8;
        padding: 10px 18px;
        border-radius: 30px;
        font-size: 0.92rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .livraria-tab:hover {
        background: #e9e9f0;
        border-color: #ccc;
    }
    .livraria-tab.active {
        background: #111;
        color: #fff;
        border-color: #111;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
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
    }
    .cat-pill {
        background: #f0f0f5;
        color: #666;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 4px;
        text-transform: uppercase;
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

    /* MODAL */
    .book-modal-backdrop {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.75);
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
        max-width: 850px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        box-shadow: 0 25px 60px rgba(0,0,0,0.4);
        padding: 35px;
    }
    .modal-close-btn {
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 2rem;
        background: none;
        border: none;
        color: #888;
        cursor: pointer;
        line-height: 1;
    }
    .modal-close-btn:hover {
        color: #111;
    }
    .modal-grid {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 30px;
    }
    @media (max-width: 768px) {
        .modal-grid {
            grid-template-columns: 1fr;
        }
        .livraria-title {
            font-size: 1.9rem;
        }
    }
    .modal-cover-wrap img {
        width: 100%;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }
    .modal-title {
        font-size: 1.6rem;
        font-weight: 900;
        color: #111;
        margin: 0 0 15px;
        line-height: 1.3;
    }
    .modal-price {
        font-size: 1.8rem;
        font-weight: 900;
        color: #e31c61;
        margin-bottom: 20px;
    }
    .modal-desc {
        font-size: 0.95rem;
        color: #444;
        line-height: 1.65;
        margin-bottom: 25px;
    }
    .modal-btn-buy {
        display: inline-block;
        background: linear-gradient(135deg, #10b981, #059669);
        color: #fff;
        font-size: 1.05rem;
        font-weight: 800;
        padding: 14px 30px;
        border-radius: 8px;
        text-decoration: none;
        box-shadow: 0 6px 18px rgba(16, 185, 129, 0.4);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .modal-btn-buy:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(16, 185, 129, 0.5);
        color: #fff;
    }
    </style>

    <script>
    let currentLivrariaCat = 'all';
    let currentLivrariaSearch = '';

    function filterLivraria() {
        const cards = document.querySelectorAll('.book-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const name = card.getAttribute('data-name');
            const cats = card.getAttribute('data-cats');
            const isFree = card.getAttribute('data-free') === '1';

            let matchCat = true;
            if (currentLivrariaCat === 'Gratuito') {
                matchCat = isFree;
            } else if (currentLivrariaCat !== 'all') {
                matchCat = cats.includes(currentLivrariaCat);
            }

            let matchSearch = true;
            if (currentLivrariaSearch) {
                matchSearch = name.includes(currentLivrariaSearch.toLowerCase());
            }

            if (matchCat && matchSearch) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        document.getElementById('livraria-count').innerHTML = `Exibindo <strong>${visibleCount}</strong> itens`;
        const clearBtn = document.getElementById('livraria-clear-btn');
        if (currentLivrariaCat !== 'all' || currentLivrariaSearch) {
            clearBtn.style.display = 'inline-block';
        } else {
            clearBtn.style.display = 'none';
        }
    }

    document.querySelectorAll('#livraria-tabs .livraria-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            document.querySelectorAll('#livraria-tabs .livraria-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            currentLivrariaCat = this.getAttribute('data-cat');
            filterLivraria();
        });
    });

    const searchInput = document.getElementById('livraria-search-input');
    searchInput.addEventListener('input', function() {
        currentLivrariaSearch = this.value.trim();
        filterLivraria();
    });
    document.getElementById('livraria-search-btn').addEventListener('click', function() {
        currentLivrariaSearch = searchInput.value.trim();
        filterLivraria();
    });

    document.getElementById('livraria-clear-btn').addEventListener('click', function() {
        currentLivrariaCat = 'all';
        currentLivrariaSearch = '';
        searchInput.value = '';
        document.querySelectorAll('#livraria-tabs .livraria-tab').forEach(t => t.classList.remove('active'));
        document.querySelector('#livraria-tabs .livraria-tab[data-cat="all"]').classList.add('active');
        filterLivraria();
    });

    function openBookModal(id) {
        const p = LIVRARIA_PRODUCTS.find(item => item.id === id);
        if (!p) return;

        const body = document.getElementById('modal-body-content');
        body.innerHTML = `
            <div class="modal-grid">
                <div class="modal-cover-wrap">
                    <img src="${p.image}" alt="${p.name}">
                </div>
                <div class="modal-details">
                    <div class="book-cats" style="margin-bottom:12px;">
                        ${p.categories.map(c => `<span class="cat-pill">${c}</span>`).join(' ')}
                    </div>
                    <h2 class="modal-title">${p.name}</h2>
                    <div class="modal-price">${p.price_formatted}</div>
                    <div class="modal-desc">
                        ${p.short_description || p.description}
                    </div>
                    <div style="margin-top:25px;">
                        <a href="https://wa.me/5511999999999?text=Ol%C3%A1%2C+tenho+interesse+no+material+${encodeURIComponent(p.name)}" target="_blank" class="modal-btn-buy">
                            <i class="fas fa-check-circle"></i> Adquirir / Acessar Agora
                        </a>
                    </div>
                </div>
            </div>
        `;
        document.getElementById('book-modal-backdrop').classList.add('active');
    }

    function closeBookModal(e) {
        document.getElementById('book-modal-backdrop').classList.remove('active');
    }
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('mercado_livraria', 'mercado_livraria_shortcode');
