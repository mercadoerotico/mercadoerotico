<?php
/**
 * Plugin Name: Mercado Erótico - Mídia Kit & Comercial
 * Description: Página comercial oficial do Portal Mercado Erótico (Mídia Kit 2026, Soluções de Publicidade e Branded Content).
 * Version: 1.0.0
 * Author: MercadoErótico.org
 */

if (!defined('ABSPATH')) exit;

add_shortcode('mercado_midiakit', 'me_midiakit_render_shortcode');

function me_midiakit_render_shortcode() {
    ob_start();
    ?>
    <div class="me-mk-wrapper">
        <!-- HERO BANNER -->
        <section class="me-mk-hero">
            <div class="me-mk-hero-inner">
                <div class="me-mk-badge">
                    <i class="fas fa-bullhorn"></i> MÍDIA KIT 2026 &bull; OPORTUNIDADES CORPORATIVAS &bull; MERCADOERÓTICO.ORG
                </div>
                <h1 class="me-mk-title">
                    Conecte sua Marca ao Maior Ecossistema de Inteligência e Negócios do Setor Íntimo Brasileiro
                </h1>
                <p class="me-mk-subtitle">
                    O canal de referência para tomadores de decisão, fabricantes, distribuidores atacadistas, donos de sex shops, redes farmacêuticas e especialistas em Sexual Wellness. Associação estratégica de marca com 26 anos de história editorial e autoridade orgânica incomparável.
                </p>

                <div class="me-mk-hero-actions">
                    <a href="https://api.whatsapp.com/send?phone=5562982763039&text=Ol%C3%A1%21+Gostaria+de+solicitar+uma+proposta+comercial+de+publicidade+no+MercadoEr%C3%B3tico.org" target="_blank" rel="noopener" class="me-mk-btn-primary">
                        <i class="fab fa-whatsapp"></i> Falar com Atendimento Comercial
                    </a>
                    <a href="#solucoes-comerciais" class="me-mk-btn-secondary">
                        <i class="fas fa-layer-group"></i> Ver Formatos &amp; Soluções
                    </a>
                </div>

                <div class="me-mk-hero-trust">
                    <span><i class="fas fa-check-circle"></i> Tráfego Qualificado B2B &amp; B2C</span>
                    <span><i class="fas fa-shield-alt"></i> Ambiente 100% Livre de Restrições de Ads</span>
                    <span><i class="fas fa-chart-line"></i> SEO Vitalício &amp; Backlinks de Autoridade</span>
                    <span><i class="fas fa-award"></i> Credibilidade Editorial Desde 2000</span>
                </div>
            </div>
        </section>

        <!-- NÚMEROS ESTATÍSTICOS DE IMPACTO -->
        <section class="me-mk-stats-strip">
            <div class="me-mk-stats-grid">
                <div class="me-mk-stat-card">
                    <div class="me-mk-stat-icon"><i class="fas fa-database"></i></div>
                    <div class="me-mk-stat-val">2.116+</div>
                    <div class="me-mk-stat-lbl">Artigos Documentados</div>
                    <p class="me-mk-stat-desc">O maior acervo jornalístico contínuo e especializado da América Latina.</p>
                </div>
                <div class="me-mk-stat-card">
                    <div class="me-mk-stat-icon"><i class="fas fa-hourglass-start"></i></div>
                    <div class="me-mk-stat-val">26 Anos</div>
                    <div class="me-mk-stat-lbl">Pioneirismo Setorial</div>
                    <p class="me-mk-stat-desc">Produção de conhecimento desde 2000 e registro digital contínuo desde 2018.</p>
                </div>
                <div class="me-mk-stat-card">
                    <div class="me-mk-stat-icon"><i class="fas fa-chart-pie"></i></div>
                    <div class="me-mk-stat-val">153+</div>
                    <div class="me-mk-stat-lbl">Pesquisas &amp; Censos</div>
                    <p class="me-mk-stat-desc">Hub exclusivo de estudos econômicos, comportamento do consumidor e dados de mercado.</p>
                </div>
                <div class="me-mk-stat-card">
                    <div class="me-mk-stat-icon"><i class="fas fa-user-tie"></i></div>
                    <div class="me-mk-stat-val">68% B2B</div>
                    <div class="me-mk-stat-lbl">Tomadores de Decisão</div>
                    <p class="me-mk-stat-desc">Donos de lojas, diretores de indústrias, distribuidores e compradores corporativos.</p>
                </div>
            </div>
        </section>

        <!-- PERFIL DA AUDIÊNCIA E SEGMENTAÇÃO -->
        <section class="me-mk-section">
            <div class="me-mk-section-header">
                <span class="me-mk-tag"><i class="fas fa-users"></i> QUEM LEVA SUA MENSAGEM A SÉRIO</span>
                <h2 class="me-mk-section-title">Perfil Altamente Qualificado da Audiência</h2>
                <p class="me-mk-section-sub">Diferente das redes sociais genéricas, quem acessa o MercadoErótico.org tem intenção comercial direta, busca fornecedores, pesquisa tendências de compra e pesquisa produtos.</p>
            </div>

            <div class="me-mk-audience-grid">
                <!-- Coluna 1: Divisão B2B vs B2C -->
                <div class="me-mk-audience-card">
                    <h3 class="me-mk-card-title"><i class="fas fa-briefcase"></i> Segmentação por Perfil de Decisão</h3>
                    <div class="me-mk-bar-item">
                        <div class="me-mk-bar-header">
                            <span>Lojistas de Sex Shop (Físicas e E-commerce)</span>
                            <strong>34%</strong>
                        </div>
                        <div class="me-mk-bar-bg"><div class="me-mk-bar-fill" style="width:34%;"></div></div>
                    </div>
                    <div class="me-mk-bar-item">
                        <div class="me-mk-bar-header">
                            <span>Fabricantes, Indústrias &amp; Cosméticos Sensuais</span>
                            <strong>19%</strong>
                        </div>
                        <div class="me-mk-bar-bg"><div class="me-mk-bar-fill" style="width:19%; background:#ff3b7e;"></div></div>
                    </div>
                    <div class="me-mk-bar-item">
                        <div class="me-mk-bar-header">
                            <span>Distribuidores Atacadistas &amp; Representantes</span>
                            <strong>15%</strong>
                        </div>
                        <div class="me-mk-bar-bg"><div class="me-mk-bar-fill" style="width:15%; background:#06b6d4;"></div></div>
                    </div>
                    <div class="me-mk-bar-item">
                        <div class="me-mk-bar-header">
                            <span>Especialistas (Sexólogos, Terapeutas, Médicos)</span>
                            <strong>18%</strong>
                        </div>
                        <div class="me-mk-bar-bg"><div class="me-mk-bar-fill" style="width:18%; background:#f59e0b;"></div></div>
                    </div>
                    <div class="me-mk-bar-item">
                        <div class="me-mk-bar-header">
                            <span>Consultoras Independentes &amp; Consumidores Exigentes</span>
                            <strong>14%</strong>
                        </div>
                        <div class="me-mk-bar-bg"><div class="me-mk-bar-fill" style="width:14%; background:#10b981;"></div></div>
                    </div>
                </div>

                <!-- Coluna 2: Abrangência Geográfica -->
                <div class="me-mk-audience-card">
                    <h3 class="me-mk-card-title"><i class="fas fa-globe-americas"></i> Distribuição Geográfica &amp; Alcance</h3>
                    <p style="color:#cbd5e1; font-size:0.95rem; line-height:1.6; margin-bottom:18px;">
                        Cobertura nacional sólida nos principais polos produtores e consumidores de Sexual Wellness, com presença estratégica em mercados internacionais:
                    </p>
                    <div class="me-mk-geo-grid">
                        <div class="me-mk-geo-pill"><strong>Sudeste</strong> <span>48%</span></div>
                        <div class="me-mk-geo-pill"><strong>Sul</strong> <span>22%</span></div>
                        <div class="me-mk-geo-pill"><strong>Nordeste</strong> <span>16%</span></div>
                        <div class="me-mk-geo-pill"><strong>Centro-Oeste</strong> <span>9%</span></div>
                        <div class="me-mk-geo-pill"><strong>Norte</strong> <span>5%</span></div>
                        <div class="me-mk-geo-pill international"><strong>Internacional</strong> <span>Portugal, EUA, Europa e LatAm</span></div>
                    </div>
                    <div class="me-mk-callout-box">
                        <i class="fas fa-lightbulb"></i>
                        <div>
                            <strong>Sem Dispersão:</strong> Seu investimento não é queimado em visualizações acidentais. Cada impressão atinge diretamente quem opera, compra, vende ou pesquisa no mercado adulto.
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- O DIFERENCIAL COMPETITIVO -->
        <section class="me-mk-section me-mk-diff-bg">
            <div class="me-mk-section-header">
                <span class="me-mk-tag"><i class="fas fa-gem"></i> O DIFERENCIAL ESTRATÉGICO</span>
                <h2 class="me-mk-section-title">Por que Anunciar no MercadoErótico.org?</h2>
                <p class="me-mk-section-sub">Três razões que transformam nosso portal no investimento de maior retorno e segurança do setor.</p>
            </div>

            <div class="me-mk-diff-grid">
                <div class="me-mk-diff-card">
                    <div class="me-mk-diff-icon" style="background:rgba(227, 28, 97, 0.15); color:#e31c61;"><i class="fas fa-shield-virus"></i></div>
                    <h3>Segurança &bull; Livre de Bloqueios de Ads</h3>
                    <p>Meta Ads e Google Ads bloqueiam ou penalizam constantemente anúncios de brinquedos íntimos, lubrificantes e produtos sensuais. No MercadoErótico.org, sua marca comunica diretamente sem restrições algorítmicas ou risco de banimento de conta.</p>
                </div>
                <div class="me-mk-diff-card">
                    <div class="me-mk-diff-icon" style="background:rgba(6, 182, 212, 0.15); color:#06b6d4;"><i class="fas fa-search-dollar"></i></div>
                    <h3>SEO Vitalício &bull; Backlinks de Autoridade</h3>
                    <p>Seus artigos e matérias de marca permanecem ativos no acervo histórico permanentemente, gerando relevância perene no Google, autoridade de domínio (PageRank) e tráfego qualificado contínuo ano após ano.</p>
                </div>
                <div class="me-mk-diff-card">
                    <div class="me-mk-diff-icon" style="background:rgba(245, 158, 11, 0.15); color:#f59e0b;"><i class="fas fa-medal"></i></div>
                    <h3>Associação à Liderança do Setor</h3>
                    <p>O portal é construído pela trajetória de pioneiros como Paula Aguiar (32+ livros, referência histórica desde 2000) e Julianna Santos (jornalismo setorial com mais de 1.144 investigações). Sua marca ganha o respaldo dessa autoridade.</p>
                </div>
            </div>
        </section>

        <!-- FORMATOS & SOLUÇÕES COMERCIAIS -->
        <section class="me-mk-section" id="solucoes-comerciais">
            <div class="me-mk-section-header">
                <span class="me-mk-tag"><i class="fas fa-th"></i> SOLUÇÕES COMERCIAIS</span>
                <h2 class="me-mk-section-title">Formatos de Mídia &amp; Projetos Especiais</h2>
                <p class="me-mk-section-sub">Soluções integradas de visibilidade, conteúdo aprofundado e patrocínio institucional para todos os objetivos.</p>
            </div>

            <div class="me-mk-formats-grid">
                <!-- FORMATO 1: SUPER BILLBOARD -->
                <div class="me-mk-format-card">
                    <div class="me-mk-format-badge">MÁXIMO IMPACTO</div>
                    <div class="me-mk-format-media">
                        <i class="fas fa-desktop"></i>
                        <span class="me-mk-format-dim">970 x 250 px (Desktop) / 300 x 250 px (Mobile)</span>
                    </div>
                    <div class="me-mk-format-body">
                        <h3>Super Billboard Home (Topo de Abertura)</h3>
                        <p>Posição nobre acima de todas as matérias da página inicial do portal. Primeira impressão visual garantida para 100% dos visitantes corporativos.</p>
                        <ul class="me-mk-format-feats">
                            <li><i class="fas fa-check"></i> Exclusividade por período ou rodízio premium</li>
                            <li><i class="fas fa-check"></i> Formatos JPG, PNG, GIF animado ou HTML5</li>
                            <li><i class="fas fa-check"></i> Relatório mensal de impressões e cliques</li>
                        </ul>
                    </div>
                </div>

                <!-- FORMATO 2: LEADERBOARD UNIVERSAL -->
                <div class="me-mk-format-card">
                    <div class="me-mk-format-badge" style="background:#06b6d4;">ALTA VISIBILIDADE</div>
                    <div class="me-mk-format-media">
                        <i class="fas fa-window-maximize"></i>
                        <span class="me-mk-format-dim">728 x 90 px (Desktop) / 320 x 50 px (Mobile)</span>
                    </div>
                    <div class="me-mk-format-body">
                        <h3>Leaderboard Universal (Todas as Páginas)</h3>
                        <p>Banner horizontal de cabeçalho exibido em todas as notícias, páginas temáticas, artigos do acervo e pesquisas de mercado.</p>
                        <ul class="me-mk-format-feats">
                            <li><i class="fas fa-check"></i> Presença perene em todo o inventário do portal</li>
                            <li><i class="fas fa-check"></i> Altíssima taxa de lembrança de marca (Top of Mind)</li>
                            <li><i class="fas fa-check"></i> Integração responsiva mobile fluida</li>
                        </ul>
                    </div>
                </div>

                <!-- FORMATO 3: BRANDED CONTENT -->
                <div class="me-mk-format-card featured-border">
                    <div class="me-mk-format-badge" style="background:#ff3b7e;">MAIS RECOMENDADO</div>
                    <div class="me-mk-format-media">
                        <i class="fas fa-newspaper"></i>
                        <span class="me-mk-format-dim">Artigo Especial de Redação + Fotos + SEO</span>
                    </div>
                    <div class="me-mk-format-body">
                        <h3>Branded Content &amp; Publieditorial de Autoridade</h3>
                        <p>Matéria exclusiva escrita pela equipe jornalística com foco em lançamento de produtos, expansão de fábrica ou posicionamento de mercado.</p>
                        <ul class="me-mk-format-feats">
                            <li><i class="fas fa-check"></i> Destaque prioritário na Home e na editoria Negócios</li>
                            <li><i class="fas fa-check"></i> Links diretos 'DoFollow' para o seu site oficial</li>
                            <li><i class="fas fa-check"></i> Indexação no Google Notícias e permanência no Acervo</li>
                        </ul>
                    </div>
                </div>

                <!-- FORMATO 4: RETÂNGULO SIDEBAR & IN-READ -->
                <div class="me-mk-format-card">
                    <div class="me-mk-format-badge" style="background:#f59e0b;">ENGAGEMENT ALTO</div>
                    <div class="me-mk-format-media">
                        <i class="fas fa-columns"></i>
                        <span class="me-mk-format-dim">300 x 250 px (Medium Rectangle IAB)</span>
                    </div>
                    <div class="me-mk-format-body">
                        <h3>Retângulo Lateral &amp; Mídia In-Article</h3>
                        <p>Banner posicionado na coluna fixa lateral das notícias e inserido estrategicamente entre os parágrafos das matérias mais lidas.</p>
                        <ul class="me-mk-format-feats">
                            <li><i class="fas fa-check"></i> CTR superior em leituras de artigos aprofundados</li>
                            <li><i class="fas fa-check"></i> Excelente custo-benefício para campanhas contínuas</li>
                            <li><i class="fas fa-check"></i> Visibilidade consistente no desktop e mobile</li>
                        </ul>
                    </div>
                </div>

                <!-- FORMATO 5: PATROCÍNIO DE DOSSIÊ -->
                <div class="me-mk-format-card">
                    <div class="me-mk-format-badge" style="background:#10b981;">COTA MASTER</div>
                    <div class="me-mk-format-media">
                        <i class="fas fa-bookmark"></i>
                        <span class="me-mk-format-dim">Patrocínio Anual de Linha Estratégica</span>
                    </div>
                    <div class="me-mk-format-body">
                        <h3>Patrocínio Exclusivo de Dossiê Temático</h3>
                        <p>Sua marca como patrocinadora master permanente de um dos 7 Dossiês Estratégicos do Acervo (ex: Cosméticos Sensuais, Legislação, Sextech).</p>
                        <ul class="me-mk-format-feats">
                            <li><i class="fas fa-check"></i> Selo 'Oferecimento Especial' no topo de todos os artigos</li>
                            <li><i class="fas fa-check"></i> Exclusividade de categoria contra concorrentes diretos</li>
                            <li><i class="fas fa-check"></i> Citação em estudos e compilações setoriais</li>
                        </ul>
                    </div>
                </div>

                <!-- FORMATO 6: PATROCÍNIO DO OBSERVATÓRIO & AGENDA -->
                <div class="me-mk-format-card">
                    <div class="me-mk-format-badge" style="background:#8b5cf6;">INTELIGÊNCIA</div>
                    <div class="me-mk-format-media">
                        <i class="fas fa-chart-line"></i>
                        <span class="me-mk-format-dim">Painel de Pesquisas &amp; Calendário de Feiras</span>
                    </div>
                    <div class="me-mk-format-body">
                        <h3>Patrocínio do Radar Econômico &amp; Agenda</h3>
                        <p>Associação da sua empresa ao radar de cotações, estatísticas de câmbio e ao calendário oficial das principais feiras e congressos do setor.</p>
                        <ul class="me-mk-format-feats">
                            <li><i class="fas fa-check"></i> Exposição de marca junto a tomadores de decisão financeira</li>
                            <li><i class="fas fa-check"></i> Destaque em relatórios de cobertura de feiras globais</li>
                            <li><i class="fas fa-check"></i> Posição fixa de grande relevância institucional</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- PACOTES CORPORATIVOS ESTRATÉGICOS -->
        <section class="me-mk-section me-mk-pricing-bg">
            <div class="me-mk-section-header">
                <span class="me-mk-tag"><i class="fas fa-tags"></i> PACOTES EMPRESARIAIS</span>
                <h2 class="me-mk-section-title">Pacotes Estratégicos de Campanha</h2>
                <p class="me-mk-section-sub">Opções desenhadas sob medida para fabricantes, marcas de cosméticos, distribuidores e redes de sex shops.</p>
            </div>

            <div class="me-mk-pricing-grid">
                <!-- PACOTE 1: ESSENCIAL -->
                <div class="me-mk-price-card">
                    <div class="me-mk-price-header">
                        <h3>Visibilidade Essencial</h3>
                        <p>Presença contínua e institucional para fixação de marca.</p>
                    </div>
                    <div class="me-mk-price-features">
                        <ul>
                            <li><i class="fas fa-check"></i> <strong>Leaderboard 728x90</strong> em todas as páginas</li>
                            <li><i class="fas fa-check"></i> <strong>1 Publieditorial Bimestral</strong> com SEO</li>
                            <li><i class="fas fa-check"></i> Inclusão no <strong>Anuário de Fornecedores</strong></li>
                            <li><i class="fas fa-check"></i> Relatório bimestral de métricas</li>
                        </ul>
                    </div>
                    <div class="me-mk-price-footer">
                        <a href="https://api.whatsapp.com/send?phone=5562982763039&text=Ol%C3%A1%2C+gostaria+de+saber+mais+sobre+o+Pacote+Visibilidade+Essencial+do+MercadoEr%C3%B3tico.org" target="_blank" rel="noopener" class="me-mk-btn-outline">
                            Consultar Valores &bull; WhatsApp
                        </a>
                    </div>
                </div>

                <!-- PACOTE 2: PERFORMANCE (DESTAQUE) -->
                <div class="me-mk-price-card me-mk-card-highlight">
                    <div class="me-mk-card-ribbon">MAIS PROCURADO</div>
                    <div class="me-mk-price-header">
                        <h3>Performance &amp; Lançamento</h3>
                        <p>Para indústrias e marcas que desejam alavancar novas linhas e conquistar lojistas.</p>
                    </div>
                    <div class="me-mk-price-features">
                        <ul>
                            <li><i class="fas fa-check"></i> <strong>Super Billboard 970x250</strong> no topo da Home</li>
                            <li><i class="fas fa-check"></i> <strong>Retângulo Lateral 300x250</strong> em matérias</li>
                            <li><i class="fas fa-check"></i> <strong>1 Publieditorial Mensal</strong> com link DoFollow</li>
                            <li><i class="fas fa-check"></i> Destaque especial na <strong>Agenda de Eventos</strong></li>
                            <li><i class="fas fa-check"></i> Disparo de informe para rede de contatos B2B</li>
                        </ul>
                    </div>
                    <div class="me-mk-price-footer">
                        <a href="https://api.whatsapp.com/send?phone=5562982763039&text=Ol%C3%A1%2C+gostaria+de+uma+proposta+para+o+Pacote+Performance+%26+Lan%C3%A7amento+no+MercadoEr%C3%B3tico.org" target="_blank" rel="noopener" class="me-mk-btn-primary">
                            <i class="fab fa-whatsapp"></i> Solicitar Proposta de Lançamento
                        </a>
                    </div>
                </div>

                <!-- PACOTE 3: COTA MASTER -->
                <div class="me-mk-price-card">
                    <div class="me-mk-price-header">
                        <h3>Cota Master de Liderança</h3>
                        <p>Domínio absoluto de categoria e autoridade setorial incontestável.</p>
                    </div>
                    <div class="me-mk-price-features">
                        <ul>
                            <li><i class="fas fa-check"></i> <strong>Patrocínio Exclusivo</strong> de 1 Dossiê Temático</li>
                            <li><i class="fas fa-check"></i> <strong>Super Billboard + Leaderboard</strong> permanentes</li>
                            <li><i class="fas fa-check"></i> <strong>Entrevista de Capa</strong> com Fundador/CEO</li>
                            <li><i class="fas fa-check"></i> <strong>Publieditoriais Ilimitados</strong> de lançamentos</li>
                            <li><i class="fas fa-check"></i> Exclusividade de segmento (bloqueio de concorrentes)</li>
                        </ul>
                    </div>
                    <div class="me-mk-price-footer">
                        <a href="https://api.whatsapp.com/send?phone=5562982763039&text=Ol%C3%A1%2C+gostaria+de+informar-me+sobre+a+Cota+Master+de+Lideran%C3%A7a+no+MercadoEr%C3%B3tico.org" target="_blank" rel="noopener" class="me-mk-btn-outline">
                            Conversar com a Diretoria
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ESPECIFICAÇÕES TÉCNICAS E BOAS PRÁTICAS -->
        <section class="me-mk-section">
            <div class="me-mk-section-header">
                <span class="me-mk-tag"><i class="fas fa-cogs"></i> DIRETRIZES TÉCNICAS</span>
                <h2 class="me-mk-section-title">Especificações de Material &amp; Rigor Ético</h2>
                <p class="me-mk-section-sub">Padrões de produção que asseguram o carregamento ultrarrápido do portal e a máxima credibilidade jornalística.</p>
            </div>

            <div class="me-mk-specs-grid">
                <div class="me-mk-spec-card">
                    <h4><i class="fas fa-file-image"></i> Formatos e Tamanhos dos Arquivos</h4>
                    <p>Formatos aceitos: <strong>JPG, PNG, WebP e GIF animado</strong> (máximo de 3 loops ou 15 segundos). Peso máximo recomendado: <strong>180 KB</strong> para garantir carregamento instantâneo no mobile. Tags de terceiros aceitas mediante homologação técnica.</p>
                </div>
                <div class="me-mk-spec-card">
                    <h4><i class="fas fa-balance-scale"></i> Transparência &amp; Ética Publicitária</h4>
                    <p>Todo conteúdo comercial, branded content ou publieditorial é sinalizado com a etiqueta oficial <strong>[PUBLICIDADE / CONTEÚDO PATROCINADO]</strong>, conforme os preceitos do CONAR e as boas práticas internacionais de jornalismo, o que protege a credibilidade tanto da marca anunciante quanto do portal.</p>
                </div>
                <div class="me-mk-spec-card">
                    <h4><i class="fas fa-clock"></i> Prazos de Veiculação &amp; Produção</h4>
                    <p>Para banners prontos: envio com até <strong>48 horas úteis</strong> de antecedência. Para matérias e branded content produzidos pela nossa redação: envio do briefing e material de apoio com antecedência mínima de <strong>5 dias úteis</strong> para redação, aprovação e agendamento.</p>
                </div>
            </div>
        </section>

        <!-- FORMULÁRIO DE CONTATO COMERCIAL E ATENDIMENTO -->
        <section class="me-mk-contact-section" id="contato-comercial">
            <div class="me-mk-contact-box">
                <div class="me-mk-contact-info">
                    <span class="me-mk-tag" style="background:rgba(255,255,255,0.15); color:#fff;"><i class="fas fa-headset"></i> ATENDIMENTO DEDICADO</span>
                    <h2>Vamos Construir uma Campanha de Sucesso para a sua Marca?</h2>
                    <p>Entre em contato diretamente com nossa equipe comercial para desenhar uma proposta customizada com os melhores formatos para os seus objetivos de negócio.</p>
                    
                    <div class="me-mk-direct-channels">
                        <div class="me-mk-channel-item">
                            <i class="fab fa-whatsapp"></i>
                            <div>
                                <strong>WhatsApp Comercial Direto</strong>
                                <a href="https://api.whatsapp.com/send?phone=5562982763039" target="_blank" rel="noopener">+55 (62) 98276-3039</a>
                            </div>
                        </div>
                        <div class="me-mk-channel-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <strong>E-mail Comercial &amp; Parcerias</strong>
                                <a href="mailto:contato@mercadoerotico.org">contato@mercadoerotico.org</a>
                            </div>
                        </div>
                        <div class="me-mk-channel-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <strong>Redação e Sede Editorial</strong>
                                <span>MercadoErótico.org &bull; Brasil</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="me-mk-contact-form-side">
                    <div class="me-mk-form-card">
                        <h3>Solicite uma Proposta Sob Medida</h3>
                        <p>Preencha os dados e receba nossa grade completa de tarifas e disponibilidades:</p>

                        <form id="me-midiakit-form" onsubmit="event.preventDefault(); submitMediaKitForm();">
                            <div class="me-mk-field">
                                <label for="mk-name">Seu Nome Completo *</label>
                                <input type="text" id="mk-name" required placeholder="Ex: Rodrigo Silva">
                            </div>

                            <div class="me-mk-field-row">
                                <div class="me-mk-field">
                                    <label for="mk-company">Empresa / Marca *</label>
                                    <input type="text" id="mk-company" required placeholder="Ex: Minha Marca Sensual">
                                </div>
                                <div class="me-mk-field">
                                    <label for="mk-segment">Segmento *</label>
                                    <select id="mk-segment" required>
                                        <option value="">Selecione...</option>
                                        <option value="Fabricante / Indústria">Fabricante / Indústria</option>
                                        <option value="Sex Shop Físico / E-commerce">Sex Shop Físico / E-commerce</option>
                                        <option value="Cosméticos Sensuais">Cosméticos Sensuais</option>
                                        <option value="Distribuidora / Atacado">Distribuidora / Atacado</option>
                                        <option value="Agência de Publicidade">Agência de Publicidade</option>
                                        <option value="Profissional / Terapeuta">Profissional / Terapeuta</option>
                                        <option value="Outro Segmento">Outro Segmento</option>
                                    </select>
                                </div>
                            </div>

                            <div class="me-mk-field-row">
                                <div class="me-mk-field">
                                    <label for="mk-email">E-mail Corporativo *</label>
                                    <input type="email" id="mk-email" required placeholder="voce@empresa.com.br">
                                </div>
                                <div class="me-mk-field">
                                    <label for="mk-phone">WhatsApp / Telefone *</label>
                                    <input type="tel" id="mk-phone" required placeholder="(11) 99999-9999">
                                </div>
                            </div>

                            <div class="me-mk-field">
                                <label for="mk-interest">Formato de Maior Interesse</label>
                                <select id="mk-interest">
                                    <option value="Super Billboard Home (970x250)">Super Billboard Home (970x250)</option>
                                    <option value="Leaderboard em Todas as Páginas (728x90)">Leaderboard em Todas as Páginas (728x90)</option>
                                    <option value="Branded Content / Publieditorial">Branded Content / Publieditorial com SEO</option>
                                    <option value="Patrocínio de Dossiê Temático">Patrocínio de Dossiê Temático</option>
                                    <option value="Pacote Completo Personalizado">Pacote Completo Personalizado</option>
                                </select>
                            </div>

                            <div class="me-mk-field">
                                <label for="mk-notes">Objetivos da Campanha ou Mensagem</label>
                                <textarea id="mk-notes" rows="3" placeholder="Conte-nos sobre o lançamento, período desejado ou dúvidas específicas..."></textarea>
                            </div>

                            <button type="submit" class="me-mk-submit-btn" id="mk-submit-btn">
                                <i class="fab fa-whatsapp"></i> Enviar Solicitação via WhatsApp Direto
                            </button>
                            <p class="me-mk-form-disclaimer">Retorno ágil em horário comercial. Garantia de privacidade e proteção de dados.</p>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- SCRIPT DE ENVIO DO FORMULÁRIO VIA WHATSAPP -->
    <script>
    function submitMediaKitForm() {
        const name = document.getElementById('mk-name').value;
        const company = document.getElementById('mk-company').value;
        const segment = document.getElementById('mk-segment').value;
        const email = document.getElementById('mk-email').value;
        const phone = document.getElementById('mk-phone').value;
        const interest = document.getElementById('mk-interest').value;
        const notes = document.getElementById('mk-notes').value;

        const msg = encodeURIComponent(
            `*SOLICITAÇÃO DE MÍDIA KIT & PUBLICIDADE*\n` +
            `*Nome:* ${name}\n` +
            `*Empresa:* ${company}\n` +
            `*Segmento:* ${segment}\n` +
            `*E-mail:* ${email}\n` +
            `*Telefone/WhatsApp:* ${phone}\n` +
            `*Interesse Principal:* ${interest}\n` +
            (notes ? `*Observações:* ${notes}\n` : '') +
            `\n_Enviado através do Mídia Kit Oficial em MercadoErótico.org_`
        );

        window.open(`https://api.whatsapp.com/send?phone=5562982763039&text=${msg}`, '_blank');
    }
    </script>

    <!-- ESTILOS EXCLUSIVOS DO MÍDIA KIT -->
    <style>
    .me-mk-wrapper {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        color: #1e293b;
        background: #f8fafc;
        margin: -40px -20px 0 -20px;
        padding-bottom: 60px;
        overflow-x: hidden;
    }

    /* HERO */
    .me-mk-hero {
        background: radial-gradient(circle at 85% 15%, rgba(227, 28, 97, 0.35) 0%, transparent 60%),
                    radial-gradient(circle at 15% 85%, rgba(6, 182, 212, 0.25) 0%, transparent 60%),
                    linear-gradient(135deg, #0b020d 0%, #17041c 50%, #0f0213 100%);
        color: #fff;
        padding: 80px 24px 70px 24px;
        text-align: center;
        position: relative;
    }
    .me-mk-hero-inner {
        max-width: 1040px;
        margin: 0 auto;
    }
    .me-mk-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(227, 28, 97, 0.2);
        color: #ff3b7e;
        border: 1px solid rgba(227, 28, 97, 0.4);
        padding: 6px 16px;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 24px;
    }
    .me-mk-title {
        font-size: 2.75rem;
        font-weight: 900;
        line-height: 1.18;
        color: #ffffff;
        margin-bottom: 20px;
        letter-spacing: -0.02em;
    }
    .me-mk-subtitle {
        font-size: 1.15rem;
        color: #e2e8f0;
        line-height: 1.65;
        max-width: 860px;
        margin: 0 auto 36px auto;
        font-weight: 400;
    }
    .me-mk-hero-actions {
        display: flex;
        justify-content: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 40px;
    }
    .me-mk-btn-primary {
        background: linear-gradient(135deg, #e31c61 0%, #c4124e 100%);
        color: #ffffff !important;
        padding: 14px 28px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 1rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 10px 24px rgba(227, 28, 97, 0.4);
        transition: all 0.25s ease;
    }
    .me-mk-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 28px rgba(227, 28, 97, 0.55);
        background: linear-gradient(135deg, #f0246c 0%, #d81557 100%);
    }
    .me-mk-btn-secondary {
        background: rgba(255, 255, 255, 0.08);
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 14px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.25s ease;
    }
    .me-mk-btn-secondary:hover {
        background: rgba(255, 255, 255, 0.16);
        border-color: rgba(255, 255, 255, 0.4);
    }
    .me-mk-hero-trust {
        display: flex;
        justify-content: center;
        gap: 24px;
        flex-wrap: wrap;
        color: #cbd5e1;
        font-size: 0.85rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding-top: 24px;
    }
    .me-mk-hero-trust span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .me-mk-hero-trust i {
        color: #06b6d4;
    }

    /* STATS STRIP */
    .me-mk-stats-strip {
        max-width: 1140px;
        margin: -40px auto 40px auto;
        padding: 0 20px;
        position: relative;
        z-index: 2;
    }
    .me-mk-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }
    .me-mk-stat-card {
        background: #ffffff;
        padding: 24px 20px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
        border: 1px solid #e2e8f0;
        text-align: center;
        transition: transform 0.2s ease;
    }
    .me-mk-stat-card:hover {
        transform: translateY(-4px);
    }
    .me-mk-stat-icon {
        font-size: 1.5rem;
        color: #e31c61;
        margin-bottom: 8px;
    }
    .me-mk-stat-val {
        font-size: 2.1rem;
        font-weight: 900;
        color: #0f172a;
        line-height: 1.1;
    }
    .me-mk-stat-lbl {
        font-size: 0.85rem;
        font-weight: 700;
        color: #e31c61;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 8px;
    }
    .me-mk-stat-desc {
        font-size: 0.8rem;
        color: #64748b;
        line-height: 1.4;
        margin: 0;
    }

    /* SECTIONS */
    .me-mk-section {
        max-width: 1140px;
        margin: 0 auto 60px auto;
        padding: 0 20px;
    }
    .me-mk-section-header {
        text-align: center;
        max-width: 760px;
        margin: 0 auto 40px auto;
    }
    .me-mk-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fce7f0;
        color: #e31c61;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        margin-bottom: 10px;
    }
    .me-mk-section-title {
        font-size: 2.1rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 12px;
        line-height: 1.25;
    }
    .me-mk-section-sub {
        font-size: 1rem;
        color: #64748b;
        line-height: 1.6;
        margin: 0;
    }

    /* AUDIENCE GRID */
    .me-mk-audience-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }
    .me-mk-audience-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 30px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.04);
    }
    .me-mk-card-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .me-mk-card-title i {
        color: #e31c61;
    }
    .me-mk-bar-item {
        margin-bottom: 18px;
    }
    .me-mk-bar-header {
        display: flex;
        justify-content: space-between;
        font-size: 0.88rem;
        color: #334155;
        font-weight: 600;
        margin-bottom: 6px;
    }
    .me-mk-bar-header strong {
        color: #0f172a;
    }
    .me-mk-bar-bg {
        background: #f1f5f9;
        height: 10px;
        border-radius: 999px;
        overflow: hidden;
    }
    .me-mk-bar-fill {
        background: #e31c61;
        height: 100%;
        border-radius: 999px;
    }
    .me-mk-geo-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 24px;
    }
    .me-mk-geo-pill {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 10px 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
    }
    .me-mk-geo-pill strong {
        color: #1e293b;
    }
    .me-mk-geo-pill span {
        background: #e31c61;
        color: #fff;
        padding: 2px 8px;
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 700;
    }
    .me-mk-geo-pill.international {
        width: 100%;
        background: #eff6ff;
        border-color: #bfdbfe;
    }
    .me-mk-geo-pill.international span {
        background: #2563eb;
    }
    .me-mk-callout-box {
        background: #fdf2f8;
        border-left: 4px solid #e31c61;
        padding: 14px 18px;
        border-radius: 0 8px 8px 0;
        display: flex;
        gap: 12px;
        align-items: flex-start;
        font-size: 0.86rem;
        color: #831843;
        line-height: 1.5;
    }
    .me-mk-callout-box i {
        font-size: 1.1rem;
        color: #e31c61;
        margin-top: 2px;
    }

    /* DIFFERENTIAL SECTION */
    .me-mk-diff-bg {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 40px 30px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.03);
    }
    .me-mk-diff-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }
    .me-mk-diff-card {
        padding: 20px;
    }
    .me-mk-diff-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        margin-bottom: 16px;
    }
    .me-mk-diff-card h3 {
        font-size: 1.15rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 10px;
    }
    .me-mk-diff-card p {
        font-size: 0.88rem;
        color: #64748b;
        line-height: 1.6;
        margin: 0;
    }

    /* FORMATS GRID */
    .me-mk-formats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }
    .me-mk-format-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        padding: 24px;
        position: relative;
        display: flex;
        flex-direction: column;
        transition: all 0.25s ease;
    }
    .me-mk-format-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.08);
    }
    .me-mk-format-card.featured-border {
        border: 2px solid #ff3b7e;
        box-shadow: 0 8px 24px rgba(255, 59, 126, 0.12);
    }
    .me-mk-format-badge {
        position: absolute;
        top: 16px;
        right: 16px;
        background: #e31c61;
        color: #fff;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 0.65rem;
        font-weight: 800;
        letter-spacing: 0.05em;
    }
    .me-mk-format-media {
        background: #f8fafc;
        border-radius: 8px;
        padding: 16px;
        text-align: center;
        margin-bottom: 18px;
        border: 1px dashed #cbd5e1;
    }
    .me-mk-format-media i {
        font-size: 2rem;
        color: #64748b;
        margin-bottom: 6px;
        display: block;
    }
    .me-mk-format-dim {
        font-size: 0.75rem;
        font-weight: 700;
        color: #0f172a;
    }
    .me-mk-format-body h3 {
        font-size: 1.15rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 8px;
        line-height: 1.3;
    }
    .me-mk-format-body p {
        font-size: 0.85rem;
        color: #64748b;
        line-height: 1.5;
        margin-bottom: 16px;
    }
    .me-mk-format-feats {
        list-style: none;
        padding: 0;
        margin: 0;
        border-top: 1px solid #f1f5f9;
        padding-top: 12px;
        font-size: 0.8rem;
        color: #334155;
    }
    .me-mk-format-feats li {
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .me-mk-format-feats i {
        color: #10b981;
        font-size: 0.75rem;
    }

    /* PRICING / PACKAGES */
    .me-mk-pricing-bg {
        background: #0f172a;
        border-radius: 18px;
        padding: 50px 30px;
        color: #fff;
    }
    .me-mk-pricing-bg .me-mk-section-title {
        color: #fff;
    }
    .me-mk-pricing-bg .me-mk-section-sub {
        color: #94a3b8;
    }
    .me-mk-pricing-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        align-items: stretch;
    }
    .me-mk-price-card {
        background: #1e293b;
        border-radius: 14px;
        border: 1px solid #334155;
        padding: 30px 24px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
    }
    .me-mk-price-card.me-mk-card-highlight {
        background: linear-gradient(180deg, #2a112f 0%, #1a0820 100%);
        border: 2px solid #e31c61;
        box-shadow: 0 16px 36px rgba(227, 28, 97, 0.35);
        transform: scale(1.03);
    }
    .me-mk-card-ribbon {
        position: absolute;
        top: -12px;
        left: 50%;
        transform: translateX(-50%);
        background: #e31c61;
        color: #fff;
        padding: 4px 16px;
        border-radius: 999px;
        font-size: 0.7rem;
        font-weight: 800;
        letter-spacing: 0.08em;
    }
    .me-mk-price-header h3 {
        font-size: 1.35rem;
        font-weight: 800;
        color: #fff;
        margin-bottom: 8px;
    }
    .me-mk-price-header p {
        font-size: 0.82rem;
        color: #94a3b8;
        line-height: 1.4;
        margin-bottom: 24px;
    }
    .me-mk-price-features ul {
        list-style: none;
        padding: 0;
        margin: 0 0 28px 0;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding-top: 18px;
        font-size: 0.85rem;
        color: #cbd5e1;
    }
    .me-mk-price-features li {
        margin-bottom: 12px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        line-height: 1.4;
    }
    .me-mk-price-features i {
        color: #e31c61;
        margin-top: 3px;
    }
    .me-mk-btn-outline {
        display: block;
        text-align: center;
        background: transparent;
        color: #fff !important;
        border: 1px solid #64748b;
        padding: 12px;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .me-mk-btn-outline:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: #fff;
    }

    /* SPECS GRID */
    .me-mk-specs-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
    .me-mk-spec-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 22px;
    }
    .me-mk-spec-card h4 {
        font-size: 1rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .me-mk-spec-card h4 i {
        color: #06b6d4;
    }
    .me-mk-spec-card p {
        font-size: 0.82rem;
        color: #64748b;
        line-height: 1.5;
        margin: 0;
    }

    /* CONTACT / FORM */
    .me-mk-contact-section {
        max-width: 1140px;
        margin: 0 auto;
        padding: 0 20px;
    }
    .me-mk-contact-box {
        background: linear-gradient(135deg, #0b020d 0%, #1d0524 60%, #0f0213 100%);
        border-radius: 20px;
        padding: 50px 40px;
        display: grid;
        grid-template-columns: 1fr 1.15fr;
        gap: 40px;
        color: #fff;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
    }
    .me-mk-contact-info h2 {
        font-size: 2.1rem;
        font-weight: 800;
        color: #fff;
        margin: 16px 0 14px 0;
        line-height: 1.25;
    }
    .me-mk-contact-info p {
        color: #cbd5e1;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 30px;
    }
    .me-mk-direct-channels {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }
    .me-mk-channel-item {
        display: flex;
        align-items: center;
        gap: 14px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 12px 18px;
        border-radius: 10px;
    }
    .me-mk-channel-item i {
        font-size: 1.6rem;
        color: #e31c61;
    }
    .me-mk-channel-item strong {
        display: block;
        font-size: 0.75rem;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .me-mk-channel-item a, .me-mk-channel-item span {
        font-size: 0.95rem;
        color: #fff;
        font-weight: 700;
        text-decoration: none;
    }
    .me-mk-form-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 30px;
        color: #1e293b;
    }
    .me-mk-form-card h3 {
        font-size: 1.35rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 6px;
    }
    .me-mk-form-card p {
        font-size: 0.82rem;
        color: #64748b;
        margin-bottom: 20px;
    }
    .me-mk-field {
        margin-bottom: 14px;
    }
    .me-mk-field-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }
    .me-mk-field label {
        display: block;
        font-size: 0.75rem;
        font-weight: 700;
        color: #334155;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 4px;
    }
    .me-mk-field input, .me-mk-field select, .me-mk-field textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 0.85rem;
        color: #0f172a;
        background: #f8fafc;
        box-sizing: border-box;
    }
    .me-mk-field input:focus, .me-mk-field select:focus, .me-mk-field textarea:focus {
        border-color: #e31c61;
        background: #fff;
        outline: none;
        box-shadow: 0 0 0 3px rgba(227, 28, 97, 0.15);
    }
    .me-mk-submit-btn {
        width: 100%;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff;
        border: none;
        padding: 14px;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 800;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 8px 18px rgba(16, 185, 129, 0.35);
        transition: all 0.2s ease;
    }
    .me-mk-submit-btn:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        transform: translateY(-2px);
    }
    .me-mk-form-disclaimer {
        font-size: 0.72rem !important;
        color: #94a3b8 !important;
        text-align: center;
        margin: 10px 0 0 0 !important;
    }

    /* RESPONSIVE */
    @media (max-width: 991px) {
        .me-mk-title { font-size: 2.1rem; }
        .me-mk-stats-grid { grid-template-columns: repeat(2, 1fr); }
        .me-mk-audience-grid { grid-template-columns: 1fr; }
        .me-mk-diff-grid { grid-template-columns: 1fr; }
        .me-mk-formats-grid { grid-template-columns: 1fr; }
        .me-mk-pricing-grid { grid-template-columns: 1fr; }
        .me-mk-price-card.me-mk-card-highlight { transform: none; }
        .me-mk-specs-grid { grid-template-columns: 1fr; }
        .me-mk-contact-box { grid-template-columns: 1fr; padding: 30px 20px; }
    }
    @media (max-width: 576px) {
        .me-mk-title { font-size: 1.7rem; }
        .me-mk-stats-grid { grid-template-columns: 1fr; }
        .me-mk-field-row { grid-template-columns: 1fr; }
        .me-mk-hero-actions { flex-direction: column; }
        .me-mk-btn-primary, .me-mk-btn-secondary { width: 100%; justify-content: center; }
    }
    </style>
    <?php
    return ob_get_clean();
}
