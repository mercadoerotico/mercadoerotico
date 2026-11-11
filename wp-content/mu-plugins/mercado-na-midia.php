<?php
/**
 * Plugin Name: Mercado Erótico - Na Mídia & Assessoria de Imprensa
 * Description: Sistema administrativo completo para gerenciar matérias e repercussões do portal na imprensa, alimentando a página /na-midia/.
 * Version: 2.0.0
 * Author: Equipe Portal Mercado Erótico
 */

if (!defined('ABSPATH')) exit;

/**
 * 1. DADOS PADRÃO (TODAS AS 175 MATÉRIAS ORIGINAIS DO PORTAL COM LINKS DIRETOS)
 */
function mercado_get_default_na_midia_items() {
    $json = <<<'JSON'
[{"id": "youtube-canal-oficial", "outlet": "YouTube Oficial", "outlet_tag": "YOUTUBE • VÍDEO", "tag_color": "#dc2626", "category": "tv", "category_lbl": "Vídeo & Cobertura Especial", "title": "Canal Mercado Erótico: Reportagens, Entrevistas e Bastidores da Imprensa", "date": "Oficial", "excerpt": "Acompanhe as matérias audiovisuais, podcasts em vídeo, coberturas de feiras e debates setoriais no canal oficial do portal no YouTube.", "url": "https://www.youtube.com/@canalmercadoerotico4514", "logo": "", "featured": true}, {"id": "cbn-vibradores", "outlet": "Rádio CBN", "outlet_tag": "CBN RÁDIO", "tag_color": "#dc2626", "category": "radio", "category_lbl": "Rádio & Notícias", "title": "Venda de vibradores aumenta 50% desde o início da quarentena", "date": "2020", "excerpt": "Reportagem em áudio da Rádio CBN detalha a alta nas vendas e a procura por bem-estar íntimo durante o isolamento.", "url": "https://cbn.globoradio.globo.com/default.htm?url=%2Fmedia%2Faudio%2F302062%2Fvenda-de-vibradores-aumenta-50-desde-o-inicio-da-q.htm&ref=http://busca3.globo.com/", "logo": "/wp-content/uploads/2022/09/cbn-logo-300x97.png", "featured": true}, {"id": "oglobo-acessorios", "outlet": "O Globo", "outlet_tag": "O GLOBO", "tag_color": "#0284c7", "category": "jornal", "category_lbl": "Saúde & Bem-Estar", "title": "Uso de acessórios eróticos deixa de ser tabu entre as mulheres e saúde agradece", "date": "2021", "excerpt": "O Globo analisa a revolução do mercado íntimo feminino, benefícios para o assoalho pélvico e autoconhecimento.", "url": "https://oglobo.globo.com/saude/bem-estar/uso-de-acessorios-eroticos-deixa-de-ser-tabu-entre-as-mulheres-e-saude-agradece-25230754", "logo": "/wp-content/uploads/2022/09/o-globo-logo-1-1024x197.png", "featured": true}, {"id": "folha-triplica", "outlet": "Folha de S.Paulo", "outlet_tag": "FOLHA DE S.PAULO", "tag_color": "#1f2937", "category": "jornal", "category_lbl": "Mercado & Negócios", "title": "Mercado erótico triplica na pandemia e investe em diversidade", "date": "2021", "excerpt": "Folha aborda a forte expansão do comércio de artigos sensuais no país, dados de faturamento e novas linhas inclusivas.", "url": "https://www1.folha.uol.com.br/mercado/2021/06/mercado-erotico-triplica-na-pandemia-e-investe-em-diversidade.shtml", "logo": "/wp-content/uploads/2022/09/5c0a6b612c6641059597e3c5.png", "featured": true}, {"id": "estadao-mercado", "outlet": "O Estado de S. Paulo", "outlet_tag": "ESTADÃO", "tag_color": "#0369a1", "category": "jornal", "category_lbl": "Economia & Negócios", "title": "Mulheres empreendem no bilionário mercado erótico e lideram expansão das vendas", "date": "2021", "excerpt": "Estadão destaca como o empreendedorismo feminino e a profissionalização impulsionaram o mercado íntimo brasileiro.", "url": "https://www.pressreader.com/brazil/o-estado-de-s-paulo/20210411/282342567657929", "logo": "/wp-content/uploads/2022/09/estadao-logo-1-1-1024x219.png", "featured": true}, {"id": "exame-dispara", "outlet": "Revista Exame", "outlet_tag": "EXAME", "tag_color": "#b91c1c", "category": "revista", "category_lbl": "Revista de Negócios", "title": "Com quarentena, mercado de brinquedos eróticos dispara", "date": "2020", "excerpt": "Exame traz dados do salto histórico na comercialização de produtos eróticos durante o isolamento social.", "url": "https://exame.com/casual/com-quarentena-mercado-de-brinquedos-eroticos-dispara/", "logo": "/wp-content/uploads/2022/09/exame-logo-1-1-1536x250-1-1024x167.png", "featured": true}, {"id": "yahoo-namorados", "outlet": "Yahoo! Finanças", "outlet_tag": "YAHOO! FINANÇAS", "tag_color": "#7c3aed", "category": "portal", "category_lbl": "Economia & Finanças", "title": "Casados são os que mais comprarão vibradores para o Dia dos Namorados", "date": "2021", "excerpt": "Pesquisa revela que o público casado responde por grande parte das compras de acessórios para renovar a relação.", "url": "https://br.financas.yahoo.com/noticias/casados-sao-os-que-mais-comprarao-vibradores-para-o-dia-dos-namorados-195914095.html", "logo": "/wp-content/uploads/2022/09/yahoo-logo-1024x284.png", "featured": true}, {"id": "jovempan-consumo", "outlet": "Jovem Pan", "outlet_tag": "JOVEM PAN", "tag_color": "#e11d48", "category": "radio", "category_lbl": "Rádio & Notícias", "title": "Sabia que as mulheres são as maiores consumidoras de produtos eróticos no Brasil?", "date": "2021", "excerpt": "Programa \"Tá Explicado\" analisa os dados de comportamento de compra feminino e a liderança das mulheres no setor.", "url": "https://jovempan.com.br/programas/ta-explicado/sabia-que-as-mulheres-sao-as-maiores-consumidoras-de-produtos-eroticos-no-brasil.html", "logo": "/wp-content/uploads/2022/09/1200px-Jovem_Pan_logo_2018.svg_-1024x550.png", "featured": true}, {"id": "istoedinheiro-sextech", "outlet": "IstoÉ Dinheiro", "outlet_tag": "ISTOÉ DINHEIRO", "tag_color": "#334155", "category": "revista", "category_lbl": "Negócios & Inovação", "title": "Pandemia ajuda sextech de áudios eróticos a alcançar 5 mil assinantes", "date": "2021", "excerpt": "A transformação das startups de entretenimento íntimo e a busca por experiências auditivas personalizadas.", "url": "https://www.istoedinheiro.com.br/pandemia-ajuda-sextech-de-audios-eroticos-a-alcancar-5-mil-assinantes/", "logo": "/wp-content/uploads/2022/09/logo-1-576x324-1.jpg", "featured": true}, {"id": "cnn-vendas", "outlet": "CNN Brasil", "outlet_tag": "CNN BRASIL", "tag_color": "#dc2626", "category": "tv", "category_lbl": "Business & Notícias", "title": "Busca por sex toys dispara na quarentena: loja online aumenta vendas em 475%", "date": "2020", "excerpt": "CNN Brasil repercute o crescimento expressivo das plataformas virtuais e a procura por novidades eróticas.", "url": "https://www.cnnbrasil.com.br/business/busca-por-sex-toys-dispara-na-quarentena-loja-online-aumenta-vendas-em-475/", "logo": "/wp-content/uploads/2022/09/cnn-brasil-logo-1024x722.png", "featured": true}, {"id": "tpm-revolucionario", "outlet": "Revista TPM / Trip", "outlet_tag": "TPM / TRIP", "tag_color": "#db2777", "category": "revista", "category_lbl": "Comportamento & Cultura", "title": "Milly Lacombe: O orgasmo é revolucionário", "date": "2019", "excerpt": "Reflexão sobre sexualidade, empoderamento e autonomia feminina através do prazer e do autocuidado íntimo.", "url": "https://revistatrip.uol.com.br/tpm/milly-lacombe-o-orgasmo-e-revolucionario", "logo": "/wp-content/uploads/2022/09/13174076_10154277248434260_5335189027355714884_n.png", "featured": true}, {"id": "uol-economia-namorados", "outlet": "UOL Economia", "outlet_tag": "UOL ECONOMIA", "tag_color": "#ea580c", "category": "portal", "category_lbl": "Economia & Comércio", "title": "Presentes para o Dia dos Namorados na quarentena: comércio íntimo lidera intenções", "date": "2020", "excerpt": "UOL mostra a reinvenção das datas comemorativas e a alta demanda por presentes sensuais e kits para casais.", "url": "https://economia.uol.com.br/noticias/redacao/2020/06/11/presentes-dia-dos-namorados-quarentena-pandemia-coronavirus.htm", "logo": "/wp-content/uploads/2022/09/logo-uol-512.png", "featured": true}, {"id": "marieclaire-autoerotismo", "outlet": "Revista Marie Claire", "outlet_tag": "MARIE CLAIRE", "tag_color": "#e11d48", "category": "revista", "category_lbl": "Amor & Sexo", "title": "O potencial da masturbação e do autoerotismo em tempos de pandemia", "date": "2020", "excerpt": "Especialistas analisam os benefícios físicos e mentais da sexualidade positiva e da quebra de vergonhas.", "url": "https://revistamarieclaire.globo.com/Amor-e-Sexo/noticia/2020/09/o-potencial-da-masturbacao-e-do-autoerotismo-em-tempos-de-pandemia.html", "logo": "/wp-content/uploads/2022/09/unnamed.jpg", "featured": true}, {"id": "extra-sabrina-sato", "outlet": "Jornal Extra (Globo)", "outlet_tag": "JORNAL EXTRA", "tag_color": "#2563eb", "category": "jornal", "category_lbl": "Saúde & Ciência", "title": "Sabrina Sato revela ter 40 vibradores: conheça os benefícios do acessório para a saúde da mulher", "date": "2022", "excerpt": "Reportagem médica sobre a importância do bem-estar sexual feminino, fisioterapia pélvica e saúde preventiva.", "url": "https://extra.globo.com/noticias/saude-e-ciencia/sabrina-sato-revela-ter-40-vibradores-conheca-os-beneficios-do-acessorio-para-saude-da-mulher-25545551.html", "logo": "/wp-content/uploads/2022/09/Extra_RJ.svg_-1024x184.png", "featured": true}, {"id": "forbes-sextechs", "outlet": "Forbes Brasil", "outlet_tag": "FORBES BRASIL", "tag_color": "#0f172a", "category": "revista", "category_lbl": "Tecnologia & Inovação", "title": "6 sextechs brasileiras que estão transformando a experiência da intimidade e do autocuidado", "date": "2021", "excerpt": "Forbes mapeia as startups que unem tecnologia, design ergonômico e saúde íntima no mercado nacional.", "url": "https://forbes.com.br/forbes-tech/2021/09/6-sextechs-brasileiras-que-estao-transformando-a-experiencia-da-intimidade-e-do-autocuidado/", "logo": "/wp-content/uploads/2022/09/forbes-logo-7-1.png", "featured": true}, {"id": "veja-explode", "outlet": "Revista Veja", "outlet_tag": "VEJA", "tag_color": "#b91c1c", "category": "revista", "category_lbl": "Gente & Sociedade", "title": "Explode a venda de vibradores no Brasil durante a pandemia", "date": "2020", "excerpt": "Coluna Veja Gente documenta como o isolamento consolidou os produtos de bem-estar como itens essenciais de consumo.", "url": "https://veja.abril.com.br/coluna/veja-gente/explode-venda-vibradores-no-brasil-durante-a-pandemia/", "logo": "/wp-content/uploads/2022/09/Veja.svg_-1024x484.png", "featured": true}, {"id": "claudia-clube", "outlet": "Revista Cláudia", "outlet_tag": "REVISTA CLÁUDIA", "tag_color": "#db2777", "category": "revista", "category_lbl": "Amor & Sexo", "title": "Clube de assinatura de bem-estar sexual traz curadoria de produtos para mulheres", "date": "2021", "excerpt": "A personalização e a discrição no envio de caixas com itens eróticos e educativos voltados para o público feminino.", "url": "https://claudia.abril.com.br/amor-e-sexo/clube-de-assinatura-de-bem-estar-sexual/", "logo": "/wp-content/uploads/2022/09/LOGO-CLAUDIA-01_670-1.png", "featured": true}, {"id": "vocesa-lilit", "outlet": "Você S/A", "outlet_tag": "VOCÊ S/A", "tag_color": "#0891b2", "category": "revista", "category_lbl": "Empreendedorismo", "title": "Conheça a startup que cresce no ramo de produtos eróticos e sexual wellness", "date": "2021", "excerpt": "Análise sobre a profissionalização dos planos de negócio no segmento de bem-estar íntimo.", "url": "https://vocesa.abril.com.br/empreendedorismo/conheca-a-lilit-sextech-que-cresce-no-ramo-de-produtos-eroticos/", "logo": "/wp-content/uploads/2022/09/Voce_SA.svg_-1024x226.png", "featured": true}, {"id": "istoe-signos", "outlet": "Revista IstoÉ", "outlet_tag": "ISTOÉ", "tag_color": "#475569", "category": "revista", "category_lbl": "Comportamento & Estilo", "title": "Saiba quais os sex toys ideais para você e como explorar o autocuidado íntimo", "date": "2021", "excerpt": "Matéria da IstoÉ desmistifica os diferentes tipos de estimuladores, materiais certificados e cuidados com a higiene.", "url": "https://istoe.com.br/saiba-quais-os-sex-toys-ideais-para-voce-de-acordo-com-seu-signo/", "logo": "/wp-content/uploads/2022/09/logo-istoe.png", "featured": true}, {"id": "pegn-triplica", "outlet": "Pequenas Empresas & Grandes Negócios", "outlet_tag": "PEGN", "tag_color": "#16a34a", "category": "revista", "category_lbl": "Negócios & PME", "title": "Mercado erótico triplica em número de empreendedores na pandemia", "date": "2021", "excerpt": "PEGN destaca o aquecimento de sex shops virtuais e consultorias que encontraram oportunidade de expansão.", "url": "https://revistapegn.globo.com/Negocios/noticia/2021/03/mercado-erotico-triplica-em-numero-de-empreendedores-na-pandemia.html", "logo": "/wp-content/uploads/2022/09/618b4cbb80fb34312851985c_pequena-empresas-grandes-negocios-logo.png", "featured": true}, {"id": "universa-uol-empreender", "outlet": "Universa UOL", "outlet_tag": "UNIVERSA UOL", "tag_color": "#ea580c", "category": "portal", "category_lbl": "Universa Talks", "title": "Mercado erótico cresce 12% e é opção para quem quer empreender", "date": "2021", "excerpt": "Canal Universa do UOL debate a autonomia financeira de consultoras de produtos sensuais e a liderança das mulheres.", "url": "https://www.uol.com.br/universa/noticias/redacao/2021/10/03/mercado-erotico-cresce-12-e-e-opcao-para-quem-quer-empreender.htm", "logo": "/wp-content/uploads/2022/09/logo-uol-512.png", "featured": true}, {"id": "midia-monitor-mercantil", "outlet": "Monitor Mercantil", "outlet_tag": "MONITOR MERCANTIL", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Monitor Mercantil", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://monitormercantil.com.br/mercado-erotico-deve-encerrar-ano-com-faturamento-de-us-33-bi/", "logo": "", "featured": false}, {"id": "midia-blog-mei-f-cil", "outlet": "Blog Mei Fácil", "outlet_tag": "BLOG MEI FÁCIL", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Blog Mei Fácil", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://blog.meifacil.com/empreendedorismo/mercado-erotico/", "logo": "", "featured": false}, {"id": "midia-estado-de-minas", "outlet": "Estado de Minas", "outlet_tag": "ESTADO DE MINAS", "tag_color": "#1f2937", "category": "jornal", "category_lbl": "Jornal Regional / Nacional", "title": "Repercussão e dados do setor íntimo citados em Estado de Minas", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.em.com.br/app/noticia/nacional/2020/12/23/interna_nacional,1223333/setor-erotico-tem-crescimento-em-2020-casados-compram-mais-que-solteiros.shtml", "logo": "", "featured": false}, {"id": "midia-rede-conex-o-mulher", "outlet": "Rede Conexão Mulher", "outlet_tag": "REDE CONEXÃO MULHER", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Rede Conexão Mulher", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://redeconexaomulher.com/blog/2021/11/29/segundo-mercado-erotico-pandemia-foi-responsavel-por-aumento-das-vendas-no-setor/", "logo": "", "featured": false}, {"id": "midia-tribuna-do-norte", "outlet": "Tribuna do Norte", "outlet_tag": "TRIBUNA DO NORTE", "tag_color": "#1f2937", "category": "jornal", "category_lbl": "Jornal Regional / Nacional", "title": "Repercussão e dados do setor íntimo citados em Tribuna do Norte", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "http://www.tribunadonorte.com.br/noticia/mercado-era-tico-cresce-na-pandemia/524251", "logo": "", "featured": false}, {"id": "midia-jornal-dia-a-dia", "outlet": "Jornal Dia a Dia", "outlet_tag": "JORNAL DIA A DIA", "tag_color": "#1f2937", "category": "jornal", "category_lbl": "Jornal Regional / Nacional", "title": "Repercussão e dados do setor íntimo citados em Jornal Dia a Dia", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://jornaldiadia.com.br/mercado-erotico-deve-encerrar-o-ano-com-faturamento-de-us-33-bilhoes/", "logo": "", "featured": false}, {"id": "midia-portal-federal", "outlet": "Portal Federal", "outlet_tag": "PORTAL FEDERAL", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Portal Federal", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://portalfederal.com.br/campanha-mes-do-orgasmo-portal-mercado-erotico-org-dedica-junho-ao-orgasmo/", "logo": "", "featured": false}, {"id": "midia-paran-shop", "outlet": "Paraná Shop", "outlet_tag": "PARANÁ SHOP", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Paraná Shop", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://paranashop.com.br/2021/12/mercado-erotico-deve-fechar-ano-faturando-us-33-bi/", "logo": "", "featured": false}, {"id": "midia-o-liberal", "outlet": "O Liberal", "outlet_tag": "O LIBERAL", "tag_color": "#1f2937", "category": "jornal", "category_lbl": "Jornal Regional / Nacional", "title": "Repercussão e dados do setor íntimo citados em O Liberal", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.oliberal.com/amazonia/consumo-de-mercado-erotico-triplica-durante-a-pandemia-1.430735", "logo": "", "featured": false}, {"id": "midia-delas-ig", "outlet": "Delas IG", "outlet_tag": "DELAS IG", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Delas IG", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://delas.ig.com.br/2021-07-14/mulheres-sexshop-mercado-erotico.html", "logo": "", "featured": false}, {"id": "midia-bahia-ba", "outlet": "Bahia.ba", "outlet_tag": "BAHIA.BA", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Bahia.ba", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://bahia.ba/economia/mercado-erotico-deve-faturar-us-33-bilhoes-r-188-bilhoes-este-ano/", "logo": "", "featured": false}, {"id": "midia-bem-paran", "outlet": "Bem Paraná", "outlet_tag": "BEM PARANÁ", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Bem Paraná", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.bemparana.com.br/noticia/pandemia-faz-crescer-vendas-no-setor-erotico-em-2020-com-destaque-para-os-vibradores#.Yvb5Mexv9-E", "logo": "", "featured": false}, {"id": "midia-times-bras-lia", "outlet": "Times Brasília", "outlet_tag": "TIMES BRASÍLIA", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Times Brasília", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://timesbrasilia.com.br/satelites-e-regiao/mercado-erotico-deve-faturar-us-33-bilhoes-este-ano/", "logo": "", "featured": false}, {"id": "midia-top-view", "outlet": "Top View", "outlet_tag": "TOP VIEW", "tag_color": "#db2777", "category": "revista", "category_lbl": "Revista Especializada", "title": "Repercussão e dados do setor íntimo citados em Top View", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://topview.com.br/fashion/a-liberdade-para-cuidar-de-si/", "logo": "", "featured": false}, {"id": "midia-elas-que-lucrem", "outlet": "Elas que Lucrem", "outlet_tag": "ELAS QUE LUCREM", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Elas que Lucrem", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.eql.com.br/usufruir/2021/08/mercado-erotico-cresce-e-impulsiona-a-independencia-sexual-e-financeira-de-mulheres-brasileiras/", "logo": "", "featured": false}, {"id": "midia-erre-jota-not-cias", "outlet": "Erre Jota Notícias", "outlet_tag": "ERRE JOTA NOTÍCIAS", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Erre Jota Notícias", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://errejotanoticias.com.br/mercado-erotico-cresceu-12-durante-a-pandemia/", "logo": "", "featured": false}, {"id": "midia-gazeta-de-alagoas", "outlet": "Gazeta de Alagoas", "outlet_tag": "GAZETA DE ALAGOAS", "tag_color": "#1f2937", "category": "jornal", "category_lbl": "Jornal Regional / Nacional", "title": "Repercussão e dados do setor íntimo citados em Gazeta de Alagoas", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.gazetadealagoas.com.br/cidades/344031/venda-de-produtos-eroticos-em-alagoas-cresce-na-pandemia", "logo": "", "featured": false}, {"id": "midia-glamurama", "outlet": "Glamurama", "outlet_tag": "GLAMURAMA", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Glamurama", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://glamurama.uol.com.br/modo-de-vida/sextechs-brasileiras-crescem-enquanto-desmistificam-tabus-que-envolvem-o-prazer-feminino/", "logo": "", "featured": false}, {"id": "midia-universo-de-neg-cios", "outlet": "Universo de Negócios", "outlet_tag": "UNIVERSO DE NEGÓCIOS", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Universo de Negócios", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://universodenegocios.com.br/pesquisa%E2%80%8C-%E2%80%8Caponta%E2%80%8C-%E2%80%8Cque%E2%80%8C-%E2%80%8Cmercado%E2%80%8C-%E2%80%8Cerotico%E2%80%8C-%E2%80%8Ccresceu%E2%80%8C-%E2%80%8C12%E2%80%8C-%E2%80%8Cdurante%E2%80%8C-%E2%80%8Ca/", "logo": "", "featured": false}, {"id": "midia-sinapro-8211-mg", "outlet": "Sinapro &#8211; MG", "outlet_tag": "SINAPRO &#8211; MG", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Sinapro &#8211; MG", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.sinapromg.com.br/bem-estar-sexual-mercado-bilionario-em-franca-ascensao/", "logo": "", "featured": false}, {"id": "midia-o-sul", "outlet": "O Sul", "outlet_tag": "O SUL", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em O Sul", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.osul.com.br/uso-de-acessorios-eroticos-deixa-de-ser-tabu-entre-as-mulheres/", "logo": "", "featured": false}, {"id": "midia-observat-rio-g-bol", "outlet": "Observatório G/BOL", "outlet_tag": "OBSERVATÓRIO G/BOL", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Observatório G/BOL", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://observatoriog.bol.uol.com.br/noticias/com-pandemia-setor-erotico-cresceu-em-2020-entenda", "logo": "", "featured": false}, {"id": "midia-o-livre", "outlet": "O Livre", "outlet_tag": "O LIVRE", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em O Livre", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://olivre.com.br/mercado-de-produtos-eroticos-cresceu-50-durante-a-pandemia", "logo": "", "featured": false}, {"id": "midia-esta-o-litoral-sp", "outlet": "Estação Litoral SP", "outlet_tag": "ESTAÇÃO LITORAL SP", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Estação Litoral SP", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.estacaolitoralsp.com.br/03/01/2022/empresas-e-negocios/mercado-erotico-encerra-o-ano-com-faturamento-de-us-33-bilhoes/", "logo": "", "featured": false}, {"id": "midia-clic-portal", "outlet": "Clic Portal", "outlet_tag": "CLIC PORTAL", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Clic Portal", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://clicportal.com.br/negocios/crescimento-do-mercado-de-sex-shop-durante-a-pandemia/", "logo": "", "featured": false}, {"id": "midia-aracaju-magazine", "outlet": "Aracaju Magazine", "outlet_tag": "ARACAJU MAGAZINE", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Aracaju Magazine", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.aracajumagazine.com.br/conteudo/tema-livre/dia-do-sexo-conheca-os-6-vibradores-mais-caros-do-mundo", "logo": "", "featured": false}, {"id": "midia-blog-hope-lingerie", "outlet": "Blog Hope Lingerie", "outlet_tag": "BLOG HOPE LINGERIE", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Blog Hope Lingerie", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://blog.hopelingerie.com.br/universo-hope/sexual-wellness-e-autocuidado-proporcionado-pelo-prazer-feminino/", "logo": "", "featured": false}, {"id": "midia-cresex", "outlet": "Cresex", "outlet_tag": "CRESEX", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Cresex", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.cresex.com.br/post/a-import%C3%A2ncia-da-qualifica%C3%A7%C3%A3o-profissional-de-quem-trabalha-no-mercado-er%C3%B3tico", "logo": "", "featured": false}, {"id": "midia-motel-tarot", "outlet": "Motel Tarot", "outlet_tag": "MOTEL TAROT", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Motel Tarot", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://moteltarot.com.br/sexo/sex-toys/", "logo": "", "featured": false}, {"id": "midia-iset", "outlet": "ISET", "outlet_tag": "ISET", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em ISET", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.iset.com.br/blog/ecommerce-sex-shop-como-criar-loja-virtual-nicho/", "logo": "", "featured": false}, {"id": "midia-donna", "outlet": "Donna", "outlet_tag": "DONNA", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Donna", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://gauchazh.clicrbs.com.br/donna/sexo-e-relacionamento/noticia/2020/06/cinco-sex-shops-virtuais-que-vale-a-pena-conhecer-ckbqu56qc00fz0162c5qtzci9.html", "logo": "", "featured": false}, {"id": "midia-guia-ol-sp", "outlet": "Guia Olá SP", "outlet_tag": "GUIA OLÁ SP", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Guia Olá SP", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "http://www.guiaolasp.com.br/mercado-erotico/", "logo": "", "featured": false}, {"id": "midia-movimento-empreender", "outlet": "Movimento Empreender", "outlet_tag": "MOVIMENTO EMPREENDER", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Movimento Empreender", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://movimentoempreender.com/podcasts/empreendedorismo-sem-tabu-o-prazer-feminino", "logo": "", "featured": false}, {"id": "midia-metro", "outlet": "Metro", "outlet_tag": "METRO", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Metro", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.metroworldnews.com.br/estilo-vida/2021/06/11/mercado-erotico-dia-dos-namorados.html", "logo": "", "featured": false}, {"id": "midia-metr-poles", "outlet": "Metrópoles", "outlet_tag": "METRÓPOLES", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Metrópoles", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.metropoles.com/colunas/pouca-vergonha/vibrou-gozou-veja-os-principais-erros-ao-usar-vibradores", "logo": "", "featured": false}, {"id": "midia-o-fluminense", "outlet": "O Fluminense", "outlet_tag": "O FLUMINENSE", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em O Fluminense", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.ofluminense.com.br/cidades/2020/12/1159932-ja-para-o-mercado-erotico.html", "logo": "", "featured": false}, {"id": "midia-meio-norte", "outlet": "Meio Norte", "outlet_tag": "MEIO NORTE", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Meio Norte", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.meionorte.com/noticias/saiba-o-que-e-o-sexo-hibrido-e-conheca-os-novos-brinquedos-427508", "logo": "", "featured": false}, {"id": "midia-inventas", "outlet": "Inventas", "outlet_tag": "INVENTAS", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Inventas", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://inventas.com.br/mercado-erotico-em-sao-luis/", "logo": "", "featured": false}, {"id": "midia-1320hub", "outlet": "1320Hub", "outlet_tag": "1320HUB", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em 1320Hub", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://1320hub.com.br/informa/tendencias-e-movimentos/2022/05/bem-estar-sexual-prazer-feminino-e-saude-juntos/", "logo": "", "featured": false}, {"id": "midia-panorama-farmac-utico", "outlet": "Panorama Farmacêutico", "outlet_tag": "PANORAMA FARMACÊUTICO", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Panorama Farmacêutico", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://panoramafarmaceutico.com.br/com-cosmeticos-veganos-e-a-base-de-cannabis-numero-de-empreendedores-no-setor-erotico-triplicou-em-2020/", "logo": "", "featured": false}, {"id": "midia-whow", "outlet": "WHOW!", "outlet_tag": "WHOW!", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em WHOW!", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.whow.com.br/bem-estar-sexual-mercado-bilionario-em-franca-ascensao/", "logo": "", "featured": false}, {"id": "midia-revista-cenarium", "outlet": "Revista Cenarium", "outlet_tag": "REVISTA CENARIUM", "tag_color": "#db2777", "category": "revista", "category_lbl": "Revista Especializada", "title": "Repercussão e dados do setor íntimo citados em Revista Cenarium", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://revistacenarium.com.br/para-maiores-mercado-dos-briquedinhos-sexuais-tem-aumento-no-brasil-com-o-isolamento-provocado-pela-pandemia/", "logo": "", "featured": false}, {"id": "midia-m-dia-bahia", "outlet": "Mídia Bahia", "outlet_tag": "MÍDIA BAHIA", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Mídia Bahia", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://midiabahia.com.br/mercado-erotico-deve-faturar-us-33-bilhoes-r-188-bilhoes-este-ano/", "logo": "", "featured": false}, {"id": "midia-luci-azevedo", "outlet": "Luci Azevedo", "outlet_tag": "LUCI AZEVEDO", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Luci Azevedo", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://luciazevedo.com.br/mercado-erotico-setor-de-sex-shop-de-natal-cresce-durante-a-pandemia/", "logo": "", "featured": false}, {"id": "midia-folha-do-amap", "outlet": "Folha do Amapá", "outlet_tag": "FOLHA DO AMAPÁ", "tag_color": "#1f2937", "category": "jornal", "category_lbl": "Jornal Regional / Nacional", "title": "Repercussão e dados do setor íntimo citados em Folha do Amapá", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.folhadoamapa.com/noticia/159/por-conta-da-pandemia-empresas-do-setor-erotico-registraram-crescimento-no-ano-de-2020", "logo": "", "featured": false}, {"id": "midia-somos-lilith", "outlet": "Somos Lilith", "outlet_tag": "SOMOS LILITH", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Somos Lilith", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.somoslilit.com/blogs/imprensa/bem-estar-sexual-vira-categoria-e-leva-negocios-eroticos-a-novo-patamar", "logo": "", "featured": false}, {"id": "midia-blog-olho-no-rn", "outlet": "Blog Olho no RN", "outlet_tag": "BLOG OLHO NO RN", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Blog Olho no RN", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.blogdeolhonorn.com.br/mercado-erotico-setor-de-sex-shop-de-natal-cresce-durante-a-pandemia/", "logo": "", "featured": false}, {"id": "midia-dois-a-mais-cosm-tica", "outlet": "Dois a Mais Cosmética", "outlet_tag": "DOIS A MAIS COSMÉTICA", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Dois a Mais Cosmética", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.doisamaiscosmetica.com.br/noticias/com-cosmeticos-veganos-e-a-base-de-cannabis-numero-de-empreendedores-no-setor-erotico-triplicou-em-2020/", "logo": "", "featured": false}, {"id": "midia-o-pinga-fogo", "outlet": "O Pinga Fogo", "outlet_tag": "O PINGA FOGO", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em O Pinga Fogo", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://opingafogo.com.br/conteudo/venda-de-vibradores-dobra-na-quarentena.html", "logo": "", "featured": false}, {"id": "midia-lexos", "outlet": "Lexos", "outlet_tag": "LEXOS", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Lexos", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.lexos.com.br/blog/da-loja-fisica-para-online-como-fazer-essa-transicao-com-sucesso/", "logo": "", "featured": false}, {"id": "midia-cultura-e-neg-cios", "outlet": "Cultura e Negócios", "outlet_tag": "CULTURA E NEGÓCIOS", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Cultura e Negócios", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://culturaenegocios.com.br/dia-do-empreendedorismo-feminino-oito-em-cada-dez-pessoas-que-empreendem-no-setor-erotico-sao-mulheres/", "logo": "", "featured": false}, {"id": "midia-xvcuritiba", "outlet": "XVCuritiba", "outlet_tag": "XVCURITIBA", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em XVCuritiba", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://xvcuritiba.com.br/sexshop-atacado-uma-oportunidade-de-empreendimento/", "logo": "", "featured": false}, {"id": "midia-minuto-ligado", "outlet": "Minuto Ligado", "outlet_tag": "MINUTO LIGADO", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Minuto Ligado", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "http://minutoligado.com.br/noticias/busca-por-produtos-sex-shop-cresce-na-quarentena-entenda-o-por-que/", "logo": "", "featured": false}, {"id": "midia-cinebuzz-uol", "outlet": "Cinebuzz Uol", "outlet_tag": "CINEBUZZ UOL", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Cinebuzz Uol", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://cinebuzz.uol.com.br/noticias/streaming/durante-quarentena-brasil-ja-vendeu-1-milhao-de-vibradores.phtml", "logo": "", "featured": false}, {"id": "midia-bazar-do-prazer", "outlet": "Bazar do Prazer", "outlet_tag": "BAZAR DO PRAZER", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Bazar do Prazer", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.bazardoprazer.com.br/pagina/produtos-para-revenda-l-descubra-quais-sao-os-20-mais-procurados.html", "logo": "", "featured": false}, {"id": "midia-o-povo", "outlet": "O Povo", "outlet_tag": "O POVO", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em O Povo", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.opovo.com.br/noticias/especialpublicitario/empreender/2022/03/08/empreendedorismo-sem-tabu-apostando-no-prazer-feminino.html", "logo": "", "featured": false}, {"id": "midia-di-rio-do-centro-do-mundo", "outlet": "Diário do Centro do Mundo", "outlet_tag": "DIÁRIO DO CENTRO DO MUNDO", "tag_color": "#1f2937", "category": "jornal", "category_lbl": "Jornal Regional / Nacional", "title": "Repercussão e dados do setor íntimo citados em Diário do Centro do Mundo", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.diariodocentrodomundo.com.br/essencial/venda-de-vibradores-cresce-50-na-pandemia/", "logo": "", "featured": false}, {"id": "midia-max-not-cias", "outlet": "Max Notícias", "outlet_tag": "MAX NOTÍCIAS", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Max Notícias", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.maxnoticias.com.br/entretenimento/id-920774/cresce_procura_por_produtos_er_ticos_em_cuiab__e_empres_ria_v__setor_como_fil_o", "logo": "", "featured": false}, {"id": "midia-pelo-mundo-df", "outlet": "Pelo Mundo DF", "outlet_tag": "PELO MUNDO DF", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Pelo Mundo DF", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.pelomundodf.com.br/noticia/49853/vibradores-sao-os-campeoes-de-venda-na-pandemia", "logo": "", "featured": false}, {"id": "midia-rdnews", "outlet": "RDNews", "outlet_tag": "RDNEWS", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em RDNews", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.rdnews.com.br/economia/conteudos/132197", "logo": "", "featured": false}, {"id": "midia-agenda-do-poder", "outlet": "Agenda do Poder", "outlet_tag": "AGENDA DO PODER", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Agenda do Poder", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.agendadopoder.com.br/manchete/sabrina-sato-revela-com-naturalidade-no-saia-justa-ter-mais-de-40-vibradores-mercado-teve-crescimento-de-50-na-pandemia/", "logo": "", "featured": false}, {"id": "midia-achei-sudoeste", "outlet": "Achei Sudoeste", "outlet_tag": "ACHEI SUDOESTE", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Achei Sudoeste", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.acheisudoeste.com.br/noticias/42483-2020/07/07/na-pandemia-brasil-registra-recorde-na-venda-de-produtos-eroticos", "logo": "", "featured": false}, {"id": "midia-rep-rter-mt", "outlet": "Repórter MT", "outlet_tag": "REPÓRTER MT", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Repórter MT", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.reportermt.com/variedades/vibrador-vicia-especialista-esclarece-duvidas/149660", "logo": "", "featured": false}, {"id": "midia-resumo-cast", "outlet": "Resumo Cast", "outlet_tag": "RESUMO CAST", "tag_color": "#0284c7", "category": "radio", "category_lbl": "Rádio & Podcast", "title": "Repercussão e dados do setor íntimo citados em Resumo Cast", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.resumocast.com.br/6-sextechs-brasileiras-que-estao-transformando-a-experiencia-da-intimidade-e-do-autocuidado/", "logo": "", "featured": false}, {"id": "midia-m-dia-hoje", "outlet": "Mídia Hoje", "outlet_tag": "MÍDIA HOJE", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Mídia Hoje", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.midiahoje.com.br/imprime.php?cid=15803", "logo": "", "featured": false}, {"id": "midia-dia-de-beaut", "outlet": "Dia de Beauté", "outlet_tag": "DIA DE BEAUTÉ", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Dia de Beauté", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://diadebeaute.com/2021/09/08/sexual-wellness-se-transforma-no-autocuidado-mais-libertador-do-momento/", "logo": "", "featured": false}, {"id": "midia-n-s-mulheres-da-periferia", "outlet": "Nós Mulheres da Periferia", "outlet_tag": "NÓS MULHERES DA PERIFERIA", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Nós Mulheres da Periferia", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://nosmulheresdaperiferia.com.br/sex-shop-online/", "logo": "", "featured": false}, {"id": "midia-blog-insaci-vel-desejo", "outlet": "Blog Insaciável Desejo", "outlet_tag": "BLOG INSACIÁVEL DESEJO", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Blog Insaciável Desejo", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://blog.insaciaveldesejo.com.br/produtos-eroticos/", "logo": "", "featured": false}, {"id": "midia-di-rio-do-sudoeste", "outlet": "Diário do Sudoeste", "outlet_tag": "DIÁRIO DO SUDOESTE", "tag_color": "#1f2937", "category": "jornal", "category_lbl": "Jornal Regional / Nacional", "title": "Repercussão e dados do setor íntimo citados em Diário do Sudoeste", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://diariodosudoeste.com.br/almanaque/sextech-inova-com-plataforma-de-contos-eroticos-em-audio-na-pandemia/", "logo": "", "featured": false}, {"id": "midia-jacyon-web-r-dio", "outlet": "Jacyon Web Rádio", "outlet_tag": "JACYON WEB RÁDIO", "tag_color": "#0284c7", "category": "radio", "category_lbl": "Rádio & Podcast", "title": "Repercussão e dados do setor íntimo citados em Jacyon Web Rádio", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://jacyonwebradiosite.com/noticia/720229/maisa-pacheco-empreendedora-master-sexshop", "logo": "", "featured": false}, {"id": "midia-jornal-da-franca", "outlet": "Jornal da Franca", "outlet_tag": "JORNAL DA FRANCA", "tag_color": "#1f2937", "category": "jornal", "category_lbl": "Jornal Regional / Nacional", "title": "Repercussão e dados do setor íntimo citados em Jornal da Franca", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.jornaldafranca.com.br/na-pandemia-tem-negocio-fechando-mas-tambem-tem-negocio-abrindo/", "logo": "", "featured": false}, {"id": "midia-portugu-s-press", "outlet": "Português Press", "outlet_tag": "PORTUGUÊS PRESS", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Português Press", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://portugues.press/veja-quais-sao-os-produtos-eroticos-mais-vendidos-no-pais/", "logo": "", "featured": false}, {"id": "midia-dolce-morumbi", "outlet": "Dolce Morumbi", "outlet_tag": "DOLCE MORUMBI", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Dolce Morumbi", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://dolcemorumbi.com/2021/11/19/dia-do-empreendedorismo-feminino-oito-em-cada-dez-pessoas-que-empreendem-no-setor-erotico-sao-mulheres/", "logo": "", "featured": false}, {"id": "midia-vibre-mulher", "outlet": "Vibre Mulher", "outlet_tag": "VIBRE MULHER", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Vibre Mulher", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://vibremulher.com.br/sugador-de-clitoris-por-que-voce-precisa-de-um-o-mais-rapido-possivel/", "logo": "", "featured": false}, {"id": "midia-blog-jovem-pan", "outlet": "Blog Jovem Pan", "outlet_tag": "BLOG JOVEM PAN", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Blog Jovem Pan", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://blog.jovempan.com.br/mulheresdapan/o-quanto-a-pandemia-de-coronavirus-afetou-o-sexo/", "logo": "", "featured": false}, {"id": "midia-medium-com", "outlet": "Medium.com", "outlet_tag": "MEDIUM.COM", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Medium.com", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://medium.com/adrifernandes/sexual-wellness-voc%C3%AA-sabe-o-que-%C3%A9-a11cdeb6071d", "logo": "", "featured": false}, {"id": "midia-gmc-on-line", "outlet": "GMC On Line", "outlet_tag": "GMC ON LINE", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em GMC On Line", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://gmconline.com.br/noticias/cidade/venda-de-brinquedos-eroticos-cresce-50-em-maringa-durante-isolamento/", "logo": "", "featured": false}, {"id": "midia-l-bios-livres", "outlet": "Lábios Livres", "outlet_tag": "LÁBIOS LIVRES", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Lábios Livres", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://labioslivres.com/tipos-de-vibradores-e-prazer-saiba-mais-sobre-esses-sextoys/", "logo": "", "featured": false}, {"id": "midia-cristina-monte", "outlet": "Cristina Monte", "outlet_tag": "CRISTINA MONTE", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Cristina Monte", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://cristinamonte.com.br/coluna-mais-negocios-edicao-86/", "logo": "", "featured": false}, {"id": "midia-di-rio-ga-cho", "outlet": "Diário Gaúcho", "outlet_tag": "DIÁRIO GAÚCHO", "tag_color": "#1f2937", "category": "jornal", "category_lbl": "Jornal Regional / Nacional", "title": "Repercussão e dados do setor íntimo citados em Diário Gaúcho", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "http://diariogaucho.clicrbs.com.br/rs/entretenimento/noticia/2021/01/que-tal-inovar-e-apostar-em-suas-fantasias-14348736.html", "logo": "", "featured": false}, {"id": "midia-gg-not-cias", "outlet": "GG Notícias", "outlet_tag": "GG NOTÍCIAS", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em GG Notícias", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://ggnoticias.com.br/noticia/1925/casal-aposta-em-franquia-de-sexy-shop-para-alavancar-negocios.html", "logo": "", "featured": false}, {"id": "midia-al", "outlet": "Alô", "outlet_tag": "ALÔ", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Alô", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.alonews.com.br/sex-appeal/2020/06/32747/dia-dos-namorados-essas-dicas-da-labareda-boutique-vao-turb.html", "logo": "", "featured": false}, {"id": "midia-revista-painel-pol-tico", "outlet": "Revista Painel Político", "outlet_tag": "REVISTA PAINEL POLÍTICO", "tag_color": "#db2777", "category": "revista", "category_lbl": "Revista Especializada", "title": "Repercussão e dados do setor íntimo citados em Revista Painel Político", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://revista.painelpolitico.com/venda-de-vibradores-aumenta-50-desde-o-inicio-da-quarentena-no-brasil/", "logo": "", "featured": false}, {"id": "midia-folha-metropolitana", "outlet": "Folha Metropolitana", "outlet_tag": "FOLHA METROPOLITANA", "tag_color": "#1f2937", "category": "jornal", "category_lbl": "Jornal Regional / Nacional", "title": "Repercussão e dados do setor íntimo citados em Folha Metropolitana", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.fmetropolitana.com.br/menopausa-e-bem-estar-acima-dos-40-anos-motivam-negocios/", "logo": "", "featured": false}, {"id": "midia-estad-o", "outlet": "Estadão", "outlet_tag": "ESTADÃO", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Estadão", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.pressreader.com/brazil/o-estado-de-s-paulo/20210805/282140704428780", "logo": "", "featured": false}, {"id": "midia-revista-poder", "outlet": "Revista Poder", "outlet_tag": "REVISTA PODER", "tag_color": "#db2777", "category": "revista", "category_lbl": "Revista Especializada", "title": "Repercussão e dados do setor íntimo citados em Revista Poder", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://revistapoder.uol.com.br/edicoes/edicao-147/o-ponto-g-das-sextechs/", "logo": "", "featured": false}, {"id": "midia-d24am", "outlet": "D24am", "outlet_tag": "D24AM", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em D24am", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://d24am.com/plus/bem-estar-sexual-vira-nova-categoria-de-negocios/", "logo": "", "featured": false}, {"id": "midia-o-tempo", "outlet": "O Tempo", "outlet_tag": "O TEMPO", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em O Tempo", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.otempo.com.br/super-noticia/interessa/tecnologia-e-games/masturbacao-feminina-vendas-de-vibradores-tem-alta-de-50-com-isolamento-social-1.2357119", "logo": "", "featured": false}, {"id": "midia-blog-da-miess", "outlet": "Blog da Miess", "outlet_tag": "BLOG DA MIESS", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Blog da Miess", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://blog.miess.com.br/vibrador-conheca-os-modelos-mais-vendidos-em-2020/", "logo": "", "featured": false}, {"id": "midia-di-rio-do-nordeste", "outlet": "Diário do Nordeste", "outlet_tag": "DIÁRIO DO NORDESTE", "tag_color": "#1f2937", "category": "jornal", "category_lbl": "Jornal Regional / Nacional", "title": "Repercussão e dados do setor íntimo citados em Diário do Nordeste", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://diariodonordeste.verdesmares.com.br/estilo-de-vida/sisi/donas-do-proprio-prazer-1.3073939", "logo": "", "featured": false}, {"id": "midia-latino-news", "outlet": "Latino News", "outlet_tag": "LATINO NEWS", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Latino News", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://latinonews.com.br/negocios/sex-shops-registram-aumento-de-vendas-na-quarentena/", "logo": "", "featured": false}, {"id": "midia-blog-da-eduk", "outlet": "Blog da Eduk", "outlet_tag": "BLOG DA EDUK", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Blog da Eduk", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://blog.eduk.com.br/post/doces-eroticos-como-fazer-e-vender/", "logo": "", "featured": false}, {"id": "midia-o-4-poder", "outlet": "O 4 Poder", "outlet_tag": "O 4 PODER", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em O 4 Poder", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.o4poder.com.br/2021/10/uso-de-acessorios-eroticos-deixa-de-ser-tabu-entre-as-mulheres/", "logo": "", "featured": false}, {"id": "midia-wiy-com", "outlet": "Wiy.com", "outlet_tag": "WIY.COM", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Wiy.com", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://wiy.com.br/noticias/brasil-registra-recorde-na-venda-de-brinquedos-eroticos-na-pandemia/", "logo": "", "featured": false}, {"id": "midia-nsctotal", "outlet": "NSCTotal", "outlet_tag": "NSCTOTAL", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em NSCTotal", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.nsctotal.com.br/noticias/10-apps-para-apimentar-conversas-virtuais", "logo": "", "featured": false}, {"id": "midia-pol-mica-para-ba", "outlet": "Polêmica Paraíba", "outlet_tag": "POLÊMICA PARAÍBA", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Polêmica Paraíba", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.polemicaparaiba.com.br/entretenimento/brinquedos-sexuais-poderoso-aliado-das-mulheres-pode-viciar-e-causar-maleficios-a-saude-especialista-faz-alerta/", "logo": "", "featured": false}, {"id": "midia-sextima", "outlet": "Sextima", "outlet_tag": "SEXTIMA", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Sextima", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://sexestima.com.br/masturbacao-feminina-e-quarentena/", "logo": "", "featured": false}, {"id": "midia-meio-digital-news", "outlet": "Meio Digital News", "outlet_tag": "MEIO DIGITAL NEWS", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Meio Digital News", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://meiodigitalnews.com.br/aplicativos/", "logo": "", "featured": false}, {"id": "midia-portal-do-zacarias", "outlet": "Portal do Zacarias", "outlet_tag": "PORTAL DO ZACARIAS", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Portal do Zacarias", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://portaldozacarias.com.br/site/noticia/uso-de-vibradores-deixa-de-ser-tabu-entre-as-mulheres--e-famosas-revelam-uso-do-acessario/", "logo": "", "featured": false}, {"id": "midia-platina-line", "outlet": "Platina Line", "outlet_tag": "PLATINA LINE", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Platina Line", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://platinaline.com/dia-do-sexo-conheca-os-vibradores-mais-caros-do-mundo/", "logo": "", "featured": false}, {"id": "midia-por-dentro-de-minas", "outlet": "Por dentro de Minas", "outlet_tag": "POR DENTRO DE MINAS", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Por dentro de Minas", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://pordentrodeminas.com.br/noticias/gerais/2020/07/venda-de-vibradores-eroticos-dispara-durante-quarentena-diz-pesquisa/", "logo": "", "featured": false}, {"id": "midia-hoje-em-dia", "outlet": "Hoje em Dia", "outlet_tag": "HOJE EM DIA", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Hoje em Dia", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.hojeemdia.com.br/um-mercado-assanhado-na-contram-o-de-outros-setores-sex-shops-vivem-aumento-de-vendas-na-pandemia-1.787907", "logo": "", "featured": false}, {"id": "midia-elo-jornal", "outlet": "Elo Jornal", "outlet_tag": "ELO JORNAL", "tag_color": "#1f2937", "category": "jornal", "category_lbl": "Jornal Regional / Nacional", "title": "Repercussão e dados do setor íntimo citados em Elo Jornal", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "http://elojornal.com.br/2021/11/18/dia-do-empreendedorismo-feminino-oito-em-cada-dez-pessoas-que-empreendem-no-setor-erotico-sao-mulheres/", "logo": "", "featured": false}, {"id": "midia-di-rio-de-minas", "outlet": "Diário de Minas", "outlet_tag": "DIÁRIO DE MINAS", "tag_color": "#1f2937", "category": "jornal", "category_lbl": "Jornal Regional / Nacional", "title": "Repercussão e dados do setor íntimo citados em Diário de Minas", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://jornaldiariodeminas.com.br/noticias/2020/09/prazer-feminino-high-tech-brinquedos-tecnologicos-viram-febre/", "logo": "", "featured": false}, {"id": "midia-assuntos-mulher", "outlet": "Assuntos Mulher", "outlet_tag": "ASSUNTOS MULHER", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Assuntos Mulher", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.assuntosmulher.com.br/v1/donas-do-proprio-prazer-sisi/amp/", "logo": "", "featured": false}, {"id": "midia-folha-max", "outlet": "Folha Max", "outlet_tag": "FOLHA MAX", "tag_color": "#1f2937", "category": "jornal", "category_lbl": "Jornal Regional / Nacional", "title": "Repercussão e dados do setor íntimo citados em Folha Max", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.folhamax.com/curiosidades/apresentadora-revela-que-tem-mais-de-40-vibradores-conheca-os-beneficios/361333", "logo": "", "featured": false}, {"id": "midia-colider-news", "outlet": "Colider News", "outlet_tag": "COLIDER NEWS", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Colider News", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://colidernews.com.br/artigos/leitura/1302/sexo-hibrido-unifica-sexo-presencial-e-a-distancia?cod=1302", "logo": "", "featured": false}, {"id": "midia-frenezi-revista", "outlet": "Frenezi Revista", "outlet_tag": "FRENEZI REVISTA", "tag_color": "#db2777", "category": "revista", "category_lbl": "Revista Especializada", "title": "Repercussão e dados do setor íntimo citados em Frenezi Revista", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://frenezirevista.com/2022/03/03/masturbacao-feminina-do-tabu-ao-conhecimento/", "logo": "", "featured": false}, {"id": "midia-revista-n-s", "outlet": "Revista Nós", "outlet_tag": "REVISTA NÓS", "tag_color": "#db2777", "category": "revista", "category_lbl": "Revista Especializada", "title": "Repercussão e dados do setor íntimo citados em Revista Nós", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://revistanosufu.wordpress.com/2021/06/19/vibrando-prazer/", "logo": "", "featured": false}, {"id": "midia-bagy-blog", "outlet": "Bagy Blog", "outlet_tag": "BAGY BLOG", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Bagy Blog", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://bagy.com.br/blog/melhores-produtos-para-revender/", "logo": "", "featured": false}, {"id": "midia-pira-info", "outlet": "Pira Info", "outlet_tag": "PIRA INFO", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Pira Info", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://pirainfo.com.br/?p=10562", "logo": "", "featured": false}, {"id": "midia-jornal-info-cruzeiro", "outlet": "Jornal Info Cruzeiro", "outlet_tag": "JORNAL INFO CRUZEIRO", "tag_color": "#1f2937", "category": "jornal", "category_lbl": "Jornal Regional / Nacional", "title": "Repercussão e dados do setor íntimo citados em Jornal Info Cruzeiro", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://jornalinfocruzeiro.com.br/2022/05/03/vibrou-gozou-veja-os-principais-erros-ao-usar-vibradores/", "logo": "", "featured": false}, {"id": "midia-revista-29horas", "outlet": "Revista 29Horas", "outlet_tag": "REVISTA 29HORAS", "tag_color": "#db2777", "category": "revista", "category_lbl": "Revista Especializada", "title": "Repercussão e dados do setor íntimo citados em Revista 29Horas", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://29horas.com.br/coluna/mercado-erotico-cresce-durante-a-pandemia/", "logo": "", "featured": false}, {"id": "midia-ecommerce-brasil", "outlet": "Ecommerce Brasil", "outlet_tag": "ECOMMERCE BRASIL", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Ecommerce Brasil", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.ecommercebrasil.com.br/artigos/sex-shop-online-tabu-lucrativo-e-commerce", "logo": "", "featured": false}, {"id": "midia-yahoo-not-cias", "outlet": "Yahoo! Notícias", "outlet_tag": "YAHOO! NOTÍCIAS", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Yahoo! Notícias", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://br.noticias.yahoo.com/brasileiros-compram-1-milh%C3%A3o-vibradores-080028246.html", "logo": "", "featured": false}, {"id": "midia-o-estado-do-maranh-o", "outlet": "O Estado do Maranhão", "outlet_tag": "O ESTADO DO MARANHÃO", "tag_color": "#1f2937", "category": "jornal", "category_lbl": "Jornal Regional / Nacional", "title": "Repercussão e dados do setor íntimo citados em O Estado do Maranhão", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://oestadoma.com/noticias/2020/05/31/cresce-a-venda-de-produtos-eroticos-com-o-isolamento-social/", "logo": "", "featured": false}, {"id": "midia-territ-rio-livre-8211-blog-tribuna-do-norte", "outlet": "Território Livre &#8211; Blog Tribuna do Norte", "outlet_tag": "TERRITÓRIO LIVRE &#8211; BLOG TRIBUNA DO NORTE", "tag_color": "#1f2937", "category": "jornal", "category_lbl": "Jornal Regional / Nacional", "title": "Repercussão e dados do setor íntimo citados em Território Livre &#8211; Blog Tribuna do Norte", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "http://blog.tribunadonorte.com.br/territoriolivre/mercado-de-brinquedos-eroticos-movimenta-bilhoes-pelo-brasil-mundo-afora/", "logo": "", "featured": false}, {"id": "midia-revista-cl-udia", "outlet": "Revista Cláudia", "outlet_tag": "REVISTA CLÁUDIA", "tag_color": "#db2777", "category": "revista", "category_lbl": "Revista Especializada", "title": "Repercussão e dados do setor íntimo citados em Revista Cláudia", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://claudia.abril.com.br/amor-e-sexo/dildos-sex-toys-penetraveis-prazer/", "logo": "", "featured": false}, {"id": "midia-monitor-mercantil", "outlet": "Monitor Mercantil", "outlet_tag": "MONITOR MERCANTIL", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Monitor Mercantil", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://monitormercantil.com.br/procura-por-brinquedos-eroticos-registra-crescimento-na-pandemia/", "logo": "", "featured": false}, {"id": "midia-revista-marie-claire", "outlet": "Revista Marie Claire", "outlet_tag": "REVISTA MARIE CLAIRE", "tag_color": "#db2777", "category": "revista", "category_lbl": "Revista Especializada", "title": "Repercussão e dados do setor íntimo citados em Revista Marie Claire", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://revistamarieclaire.globo.com/Sexo/noticia/2022/03/sex-toys-dicas-simples-de-como-higienizar-e-guardar-seus-brinquedos.html", "logo": "", "featured": false}, {"id": "midia-blog-cia-sex", "outlet": "Blog Cia Sex", "outlet_tag": "BLOG CIA SEX", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Blog Cia Sex", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://blog.ciasex.com.br/amp/2022/02/atacado-de-sex-shop-e-lingerie-vantagens-e-dicas-de-como-revender/", "logo": "", "featured": false}, {"id": "midia-ibahia", "outlet": "IBahia", "outlet_tag": "IBAHIA", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em IBahia", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.ibahia.com/entretenimento/brasil-bate-marca-de-1-milhao-de-vibradores-vendidos-na-quarenta", "logo": "", "featured": false}, {"id": "midia-cadernow", "outlet": "Cadernow", "outlet_tag": "CADERNOW", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Cadernow", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.cadernow.com.br/vitrine/massageador-discreto/", "logo": "", "featured": false}, {"id": "midia-rolnews", "outlet": "ROLNews", "outlet_tag": "ROLNEWS", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em ROLNews", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.rolnews.com.br/noticia/brasil-bate-marca-de-1-milhao-de-vibradores-vendidos-na-quarentena", "logo": "", "featured": false}, {"id": "midia-farol-da-bahia", "outlet": "Farol da Bahia", "outlet_tag": "FAROL DA BAHIA", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Farol da Bahia", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.faroldabahia.com.br/index.php/noticia/semvvergonha-brasil-atinge-1-milhao-de-vibradores-vendidos-na-quarentena", "logo": "", "featured": false}, {"id": "midia-di-rio-da-regi-o", "outlet": "Diário da Região", "outlet_tag": "DIÁRIO DA REGIÃO", "tag_color": "#1f2937", "category": "jornal", "category_lbl": "Jornal Regional / Nacional", "title": "Repercussão e dados do setor íntimo citados em Diário da Região", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.diariodaregiao.com.br/economia/lojas-do-segmento-erotico-registram-aumento-nas-vendas-em-rio-preto-1.15172", "logo": "", "featured": false}, {"id": "midia-correio-24horas", "outlet": "Correio 24Horas", "outlet_tag": "CORREIO 24HORAS", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Correio 24Horas", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://blogs.correio24horas.com.br/mesalte/tag/sexualidade/", "logo": "", "featured": false}, {"id": "midia-ndice-bovespa", "outlet": "Índice BOVESPA", "outlet_tag": "ÍNDICE BOVESPA", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Índice BOVESPA", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://indicesbovespa.com.br/liveseo-dona-coelha-fazendo-seo-de-qualidade-com-prazer/", "logo": "", "featured": false}, {"id": "midia-o-popular", "outlet": "O Popular", "outlet_tag": "O POPULAR", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em O Popular", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.opopularjm.com.br/segmento-erotico-ganha-novo-publico-durante-pandemia/", "logo": "", "featured": false}, {"id": "midia-al-news", "outlet": "Alô News", "outlet_tag": "ALÔ NEWS", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Alô News", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.alonews.com.br/sex-appeal/2021/01/37779/com-quarentena-mercado-de-brinquedos-eroticos-dispara.html", "logo": "", "featured": false}, {"id": "midia-blog-isso-a-rn", "outlet": "Blog É Isso Aí RN", "outlet_tag": "BLOG É ISSO AÍ RN", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Blog É Isso Aí RN", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://eissoairn.blogspot.com/2020/07/venda-de-sex-shops-aumentam-50-durante.html", "logo": "", "featured": false}, {"id": "midia-ibevar", "outlet": "IBEVAR", "outlet_tag": "IBEVAR", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em IBEVAR", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.ibevar.org.br/blog/quarentena-faz-namorados-darem-panela-travesseiro-e-pijama-como-presentes/", "logo": "", "featured": false}, {"id": "midia-portal-viu", "outlet": "Portal VIU", "outlet_tag": "PORTAL VIU", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Portal VIU", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.portalviu.com.br/negocios/servidora-fatura-com-conserto-de-vibradores-eletricos-em-sao-carlos", "logo": "", "featured": false}, {"id": "midia-carla-pepe", "outlet": "Carla Pepe", "outlet_tag": "CARLA PEPE", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Carla Pepe", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://carlapepe.medium.com/se-toca-ec0facd5c8c1", "logo": "", "featured": false}, {"id": "midia-portal-de-not-cias", "outlet": "Portal de Notícias", "outlet_tag": "PORTAL DE NOTÍCIAS", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Portal de Notícias", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.portaldenoticias.net/como-os-vibradores-surgiram/", "logo": "", "featured": false}, {"id": "midia-pop-mundo", "outlet": "Pop Mundo", "outlet_tag": "POP MUNDO", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Pop Mundo", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://popmundo.com.br/conheca-o-batom-que-esta-deixando-a-industria-farmaceutica-enfurecida/", "logo": "", "featured": false}, {"id": "midia-os-cabe-as-da-not-cia", "outlet": "Os Cabeças da Notícia", "outlet_tag": "OS CABEÇAS DA NOTÍCIA", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Os Cabeças da Notícia", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://oscabecasdanoticia.com.br/2020/10/sexo-tambem-e-estudo-7-plataformas-de-cursos-on-line-sobre-sexualidade/", "logo": "", "featured": false}, {"id": "midia-conselho-regional-de-psicologia-do-paran", "outlet": "Conselho Regional de Psicologia do Paraná", "outlet_tag": "CONSELHO REGIONAL DE PSICOLOGIA DO PARANÁ", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Conselho Regional de Psicologia do Paraná", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://crppr.org.br/wp-content/uploads/2020/10/Contato_131.pdf", "logo": "", "featured": false}, {"id": "midia-terra-mt-digital", "outlet": "Terra MT Digital", "outlet_tag": "TERRA MT DIGITAL", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Terra MT Digital", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://terramtdigital.com.br/geral/cachorro-encontra-brinquedo-sex-toy-em-passeio-na-praia/", "logo": "", "featured": false}, {"id": "midia-blog-do-bg", "outlet": "Blog do BG", "outlet_tag": "BLOG DO BG", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Blog do BG", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.blogdobg.com.br/tag/dia-dos-namorados/", "logo": "", "featured": false}, {"id": "midia-primeira-hora", "outlet": "Primeira Hora", "outlet_tag": "PRIMEIRA HORA", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Primeira Hora", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://primeirahora.net.br/noticia/6278/servidora-fatura-com-conserto-de-vibradores-eletricos-mulheres-ficam-mais-confortaveis.html", "logo": "", "featured": false}, {"id": "midia-sabor-vida", "outlet": "Sabor à Vida", "outlet_tag": "SABOR À VIDA", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Sabor à Vida", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.saboravida.com.br/gastronomia/2021/05/14/os-produtos-eroticos-mais-vendidos-durante-a-pandemia/", "logo": "", "featured": false}, {"id": "midia-essencial-prazer", "outlet": "Essencial Prazer", "outlet_tag": "ESSENCIAL PRAZER", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Essencial Prazer", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.essencialprazer.com.br/artigo/47", "logo": "", "featured": false}, {"id": "midia-rcn-67", "outlet": "RCN 67", "outlet_tag": "RCN 67", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em RCN 67", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.rcn67.com.br/cbn/campo-grande/especialidiz-que-a-sexualidade-esta-ligada-ao-empoderamento/138372/", "logo": "", "featured": false}, {"id": "midia-tribuna-on-line", "outlet": "Tribuna On Line", "outlet_tag": "TRIBUNA ON LINE", "tag_color": "#1f2937", "category": "jornal", "category_lbl": "Jornal Regional / Nacional", "title": "Repercussão e dados do setor íntimo citados em Tribuna On Line", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://tribunaonline.com.br/cidades/venda-de-produto-sensual-dispara-durante-pandemia-72159", "logo": "", "featured": false}, {"id": "midia-em-neon", "outlet": "Em Neon", "outlet_tag": "EM NEON", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Em Neon", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "http://www.emneon.com.br/2019/06/", "logo": "", "featured": false}, {"id": "midia-programa-point-mix", "outlet": "Programa Point Mix", "outlet_tag": "PROGRAMA POINT MIX", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Programa Point Mix", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "http://programapointmix.com/?p=10528", "logo": "", "featured": false}, {"id": "midia-tab-uol", "outlet": "TAB Uol", "outlet_tag": "TAB UOL", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em TAB Uol", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://tab.uol.com.br/noticias/redacao/2020/07/10/sexo-meditacao-psicodelia-refugios-para-lidar-com-impactos-do-isolamento.htm", "logo": "", "featured": false}, {"id": "midia-rol-cultural", "outlet": "Rolê Cultural", "outlet_tag": "ROLÊ CULTURAL", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Rolê Cultural", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://rolecultural.com.br/2019/06/26/lancamento-do-primeiro-camarote-voltado-para-negocios-business-friendly-marca-presenca-na-parada-lgbt-em-sao-paulo/", "logo": "", "featured": false}, {"id": "midia-revista-para-elas", "outlet": "Revista Para Elas", "outlet_tag": "REVISTA PARA ELAS", "tag_color": "#db2777", "category": "revista", "category_lbl": "Revista Especializada", "title": "Repercussão e dados do setor íntimo citados em Revista Para Elas", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://issuu.com/thalitardias/docs/praelas___1_", "logo": "", "featured": false}, {"id": "midia-ohlal", "outlet": "OhLalá", "outlet_tag": "OHLALÁ", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em OhLalá", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.ohlala.sex/pt-ohlala/clistories-blog/vibrador-o-livro-entre-a-historia-e-o-futuro-dicas-e-curiosidades/", "logo": "", "featured": false}, {"id": "midia-o-globo", "outlet": "O Globo", "outlet_tag": "O GLOBO", "tag_color": "#dc2626", "category": "tv", "category_lbl": "Televisão & Canal", "title": "Repercussão e dados do setor íntimo citados em O Globo", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://oglobo.globo.com/busca/click?q=%22mercado+er%C3%B3tico%22&p=0&r=1663300267975&u=https%3A%2F%2Foglobo.globo.com%2Fsaude%2Fmedicina%2Fnoticia%2F2022%2F07%2Fsabrina-sato-revela-ter-40-vibradores-conheca-os-beneficios-do-acessorio-para-a-saude-da-mulher.ghtml&t=informacional&d=false&f=false&ss=&o=&cat=&key=5c7f905299b47c1891f5cbcb518e3085", "logo": "", "featured": false}, {"id": "midia-extra", "outlet": "Extra", "outlet_tag": "EXTRA", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Extra", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://extra.globo.com/mulher/uso-de-vibradores-deixa-de-ser-tabu-entre-as-mulheres-famosas-revelam-uso-do-acessorio-25231466.html", "logo": "", "featured": false}, {"id": "midia-edi-o-do-brasil", "outlet": "Edição do Brasil", "outlet_tag": "EDIÇÃO DO BRASIL", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Edição do Brasil", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://edicaodobrasil.com.br/2020/05/08/venda-de-artigos-eroticos-dispara-durante-quarentena/?fbclid=IwAR2AksGw2au3Yc1tk8cAbM_ElS_8_zoQdJHgiA6ze_eiTkwI2PcMpIEKkts", "logo": "", "featured": false}, {"id": "midia-portal-r10", "outlet": "Portal R10", "outlet_tag": "PORTAL R10", "tag_color": "#475569", "category": "portal", "category_lbl": "Portal de Notícias", "title": "Repercussão e dados do setor íntimo citados em Portal R10", "date": "2020-2022", "excerpt": "Citação do Portal Mercado Erótico como fonte especializada em dados, comportamento de consumo e inteligência do mercado sensual.", "url": "https://www.portalr10.com/noticia/48456/universidade-do-prazer-plataforma-reune-cursos-online-sobre-sexo?fbclid=IwAR0jgCXzYaJ1GFEg_RYzWYA3NPqjmtpK_Aj_assb6mlZPyEJoO63LdiXbNA", "logo": "", "featured": false}]
JSON;
    return json_decode($json, true) ?: [];
}

/**
 * 2. STORAGE / RETRIEVAL
 */
function mercado_get_na_midia_items() {
    $items = get_option('mercado_na_midia_items', null);
    if (!is_array($items) || empty($items)) {
        $items = mercado_get_default_na_midia_items();
        update_option('mercado_na_midia_items', $items);
    }
    return $items;
}

/**
 * 3. ADMIN SCRIPTS (Media Uploader)
 */
add_action('admin_enqueue_scripts', function($hook) {
    if (strpos($hook, 'mercado-na-midia') !== false) {
        wp_enqueue_media();
    }
});

/**
 * 4. ADMIN MENU
 */
add_action('admin_menu', function() {
    add_menu_page(
        'Na Mídia & Imprensa',
        'Na Mídia',
        'manage_options',
        'mercado-na-midia',
        'mercado_na_midia_admin_page',
        'dashicons-megaphone',
        29
    );
});

/**
 * 5. ADMIN DASHBOARD PAGE
 */
function mercado_na_midia_admin_page() {
    if (!current_user_can('manage_options')) return;

    $items = mercado_get_na_midia_items();
    $message = '';
    $message_type = 'success';
    $editing_item = null;

    // POST Actions
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Reset defaults
        if (isset($_POST['mercado_midia_action']) && $_POST['mercado_midia_action'] === 'reset_defaults') {
            check_admin_referer('mercado_midia_reset_verify', 'mercado_midia_nonce');
            $items = mercado_get_default_na_midia_items();
            update_option('mercado_na_midia_items', $items);
            if (function_exists('wp_cache_flush')) wp_cache_flush();
            do_action('litespeed_purge_all');
            $message = 'Acervo de ' . count($items) . ' matérias originais restaurado com sucesso!';
        }
        // Save (Add or Edit)
        elseif (isset($_POST['mercado_midia_action']) && $_POST['mercado_midia_action'] === 'save_item') {
            check_admin_referer('mercado_midia_save_verify', 'mercado_midia_nonce');

            $outlet      = sanitize_text_field($_POST['outlet'] ?? '');
            $category    = sanitize_key($_POST['category'] ?? 'portal');
            $category_lbl= sanitize_text_field($_POST['category_lbl'] ?? '');
            $outlet_tag  = sanitize_text_field($_POST['outlet_tag'] ?? strtoupper($outlet));
            $tag_color   = sanitize_hex_color($_POST['tag_color'] ?? '#e31c61') ?: '#e31c61';
            $title       = sanitize_text_field($_POST['title'] ?? '');
            $date        = sanitize_text_field($_POST['date'] ?? date('Y'));
            $excerpt     = sanitize_textarea_field($_POST['excerpt'] ?? '');
            $url         = esc_url_raw($_POST['url'] ?? '');
            $logo        = esc_url_raw($_POST['logo'] ?? '');
            $featured    = !empty($_POST['featured']);

            if (!empty($outlet) && !empty($url)) {
                $item_id = sanitize_key($_POST['item_id'] ?? '');
                if (empty($item_id)) {
                    $item_id = 'midia-' . sanitize_title($outlet) . '-' . substr(md5(uniqid()), 0, 5);
                }

                $new_item = [
                    'id'          => $item_id,
                    'outlet'      => $outlet,
                    'category'    => $category,
                    'category_lbl'=> $category_lbl,
                    'outlet_tag'  => $outlet_tag,
                    'tag_color'   => $tag_color,
                    'title'       => $title ?: ('Matéria em ' . $outlet),
                    'date'        => $date,
                    'excerpt'     => $excerpt,
                    'url'         => $url,
                    'logo'        => $logo,
                    'featured'    => $featured
                ];

                $found = false;
                foreach ($items as $k => $existing) {
                    if (($existing['id'] ?? '') === $item_id) {
                        $items[$k] = $new_item;
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    array_unshift($items, $new_item);
                    $message = 'Matéria "' . esc_html($title) . '" adicionada com sucesso!';
                } else {
                    $message = 'Matéria atualizada com sucesso!';
                }

                update_option('mercado_na_midia_items', $items);
                if (function_exists('wp_cache_flush')) wp_cache_flush();
                do_action('litespeed_purge_all');
            } else {
                $message = 'Preencha o Nome do Veículo e o Link Direto da matéria.';
                $message_type = 'error';
            }
        }
        // Delete
        elseif (isset($_POST['mercado_midia_action']) && $_POST['mercado_midia_action'] === 'delete_item') {
            check_admin_referer('mercado_midia_del_verify', 'mercado_midia_nonce');
            $del_id = sanitize_key($_POST['delete_id'] ?? '');

            $deleted_title = '';
            foreach ($items as $k => $it) {
                if (($it['id'] ?? '') === $del_id) {
                    $deleted_title = $it['outlet'] ?? 'Item';
                    unset($items[$k]);
                    break;
                }
            }

            $items = array_values($items);
            update_option('mercado_na_midia_items', $items);
            if (function_exists('wp_cache_flush')) wp_cache_flush();
            do_action('litespeed_purge_all');
            $message = 'Matéria "' . esc_html($deleted_title) . '" excluída com sucesso!';
        }
    }

    // Check Edit GET
    if (isset($_GET['action']) && $_GET['action'] === 'edit' && !empty($_GET['id'])) {
        $edit_id = sanitize_key($_GET['id']);
        foreach ($items as $it) {
            if (($it['id'] ?? '') === $edit_id) {
                $editing_item = $it;
                break;
            }
        }
    }

    $total_items = count($items);
    $featured_count = count(array_filter($items, fn($it) => !empty($it['featured'])));
    ?>
    <div class="wrap me-midia-admin">
        <h1 class="wp-heading-inline">
            <span class="dashicons dashicons-megaphone" style="font-size:28px; width:28px; height:28px; vertical-align:middle; margin-right:8px; color:#e31c61;"></span>
            Na Mídia &bull; Acervo Completo de Imprensa
        </h1>
        <hr class="wp-header-end">

        <?php if (!empty($message)): ?>
            <div class="notice notice-<?php echo esc_attr($message_type); ?> is-dismissible" style="margin-top:15px;">
                <p><strong><?php echo $message; ?></strong></p>
            </div>
        <?php endif; ?>

        <!-- Stats Bar -->
        <div class="me-midia-stats-bar">
            <div class="stat-card">
                <span class="stat-num"><?php echo $total_items; ?></span>
                <span class="stat-lbl">Total de Aparições</span>
            </div>
            <div class="stat-card">
                <span class="stat-num" style="color:#e31c61;"><?php echo $featured_count; ?></span>
                <span class="stat-lbl">Destaques Nacionais</span>
            </div>
            <div class="stat-card stat-integration">
                <span class="stat-lbl">Página Pública:</span>
                <a href="<?php echo esc_url(home_url('/na-midia/')); ?>" target="_blank" class="button button-secondary">
                    Ver Página /na-midia/ <span class="dashicons dashicons-external" style="vertical-align:middle; font-size:16px;"></span>
                </a>
            </div>
        </div>

        <div class="me-midia-layout">
            <!-- Formulário (Esquerda) -->
            <div class="me-midia-form-col">
                <div class="me-admin-box">
                    <h2 class="box-title">
                        <?php echo $editing_item ? '✏️ Editar Matéria' : '➕ Adicionar Nova Matéria'; ?>
                    </h2>

                    <form method="post" action="<?php echo esc_url(admin_url('admin.php?page=mercado-na-midia')); ?>">
                        <?php wp_nonce_field('mercado_midia_save_verify', 'mercado_midia_nonce'); ?>
                        <input type="hidden" name="mercado_midia_action" value="save_item">
                        <input type="hidden" name="item_id" value="<?php echo esc_attr($editing_item['id'] ?? ''); ?>">

                        <p>
                            <label for="f_outlet"><strong>Nome do Veículo *</strong></label>
                            <input type="text" name="outlet" id="f_outlet" class="widefat" required 
                                   value="<?php echo esc_attr($editing_item['outlet'] ?? ''); ?>" 
                                   placeholder="Ex: Folha de S.Paulo, O Globo, CNN Brasil...">
                        </p>

                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
                            <p>
                                <label for="f_cat"><strong>Tipo de Canal *</strong></label>
                                <select name="category" id="f_cat" class="widefat">
                                    <?php 
                                    $cats = [
                                        'jornal'  => 'Jornal Impresso / Digital',
                                        'portal'  => 'Portal de Notícias',
                                        'tv'      => 'Televisão & Canal',
                                        'radio'   => 'Rádio & Podcasts',
                                        'revista' => 'Revista de Negócios / Estilo'
                                    ];
                                    $cur_cat = $editing_item['category'] ?? 'portal';
                                    foreach ($cats as $k => $v) {
                                        echo '<option value="' . esc_attr($k) . '" ' . selected($cur_cat, $k, false) . '>' . esc_html($v) . '</option>';
                                    }
                                    ?>
                                </select>
                            </p>
                            <p>
                                <label for="f_cat_lbl"><strong>Subtítulo / Editoria</strong></label>
                                <input type="text" name="category_lbl" id="f_cat_lbl" class="widefat" 
                                       value="<?php echo esc_attr($editing_item['category_lbl'] ?? 'Economia & Negócios'); ?>" 
                                       placeholder="Ex: Economia & Negócios">
                            </p>
                        </div>

                        <div style="display:grid; grid-template-columns: 2fr 1fr; gap:10px;">
                            <p>
                                <label for="f_tag"><strong>Selo / Tag Visual</strong></label>
                                <input type="text" name="outlet_tag" id="f_tag" class="widefat" 
                                       value="<?php echo esc_attr($editing_item['outlet_tag'] ?? ''); ?>" 
                                       placeholder="Ex: FOLHA DE S.PAULO">
                            </p>
                            <p>
                                <label for="f_color"><strong>Cor do Selo</strong></label>
                                <input type="color" name="tag_color" id="f_color" class="widefat" style="height:36px; padding:2px;" 
                                       value="<?php echo esc_attr($editing_item['tag_color'] ?? '#e31c61'); ?>">
                            </p>
                        </div>

                        <p>
                            <label for="f_title"><strong>Título da Reportagem / Pauta</strong></label>
                            <input type="text" name="title" id="f_title" class="widefat" 
                                   value="<?php echo esc_attr($editing_item['title'] ?? ''); ?>" 
                                   placeholder="Título completo da matéria...">
                        </p>

                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
                            <p>
                                <label for="f_date"><strong>Ano / Data</strong></label>
                                <input type="text" name="date" id="f_date" class="widefat" 
                                       value="<?php echo esc_attr($editing_item['date'] ?? date('Y')); ?>" 
                                       placeholder="Ex: 2023 ou 10/05/2022">
                            </p>
                            <p>
                                <label for="f_logo"><strong>Logo do Veículo (Opcional)</strong></label>
                                <input type="text" name="logo" id="f_logo" class="widefat" 
                                       value="<?php echo esc_attr($editing_item['logo'] ?? ''); ?>" 
                                       placeholder="/wp-content/uploads/...">
                            </p>
                        </div>

                        <p>
                            <label for="f_url"><strong>Link Direto da Matéria (URL Completa) *</strong></label>
                            <input type="url" name="url" id="f_url" class="widefat" required 
                                   value="<?php echo esc_url($editing_item['url'] ?? ''); ?>" 
                                   placeholder="https://exemplo.com/noticia/materia-direta.html">
                        </p>

                        <p>
                            <label for="f_excerpt"><strong>Resumo / Citação</strong></label>
                            <textarea name="excerpt" id="f_excerpt" class="widefat" rows="3" 
                                      placeholder="Como o Mercado Erótico ou especialistas foram citados..."><?php echo esc_textarea($editing_item['excerpt'] ?? ''); ?></textarea>
                        </p>

                        <p>
                            <label>
                                <input type="checkbox" name="featured" value="1" <?php checked(!empty($editing_item['featured'])); ?>>
                                <strong>Destacar na linha principal (Destaques Nacionais)</strong>
                            </label>
                        </p>

                        <div style="margin-top:20px; display:flex; gap:10px;">
                            <button type="submit" class="button button-primary button-large" style="background:#e31c61; border-color:#c41652;">
                                <?php echo $editing_item ? '💾 Salvar Alterações' : '➕ Adicionar à Mídia'; ?>
                            </button>
                            <?php if ($editing_item): ?>
                                <a href="<?php echo esc_url(admin_url('admin.php?page=mercado-na-midia')); ?>" class="button button-secondary button-large">
                                    Cancelar
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>

                <div class="me-admin-box" style="margin-top:20px; border-left: 4px solid #f59e0b;">
                    <h3 style="margin-top:0;">⚠️ Restaurar Acervo Original Completo</h3>
                    <p style="color:#64748b; font-size:13px;">Restaura as 175 matérias originais do portal com todos os links diretos corrigidos e limpos de spam:</p>
                    <form method="post" action="<?php echo esc_url(admin_url('admin.php?page=mercado-na-midia')); ?>" onsubmit="return confirm('ATENÇÃO: Isso restaurará o acervo original completo de 175 matérias. Deseja continuar?');">
                        <?php wp_nonce_field('mercado_midia_reset_verify', 'mercado_midia_nonce'); ?>
                        <input type="hidden" name="mercado_midia_action" value="reset_defaults">
                        <button type="submit" class="button button-link-delete">
                            Restaurar 175 Matérias Originais
                        </button>
                    </form>
                </div>
            </div>

            <!-- Tabela de Matérias (Direita) -->
            <div class="me-midia-table-col">
                <div class="me-admin-box">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                        <h2 class="box-title" style="margin:0; padding:0; border:none;">
                            📋 Acervo de Aparições (<?php echo $total_items; ?>)
                        </h2>
                        <input type="text" id="adminMidiaSearch" placeholder="🔍 Filtrar veículo..." 
                               style="padding:6px 12px; border:1px solid #cbd5e1; border-radius:6px; width:220px;">
                    </div>

                    <div style="max-height: 750px; overflow-y: auto; border: 1px solid #e2e8f0; border-radius: 8px;">
                        <table class="wp-list-table widefat fixed striped" id="adminMidiaTable">
                            <thead>
                                <tr>
                                    <th style="width:140px;">Veículo</th>
                                    <th>Título & Resumo</th>
                                    <th style="width:75px;">Ano</th>
                                    <th style="width:100px;">Canal</th>
                                    <th style="width:75px; text-align:center;">Destaque</th>
                                    <th style="width:140px; text-align:right;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $it): 
                                    $is_feat = !empty($it['featured']);
                                    $outlet_name = $it['outlet'] ?? 'Veículo';
                                ?>
                                    <tr data-search="<?php echo esc_attr(strtolower($outlet_name . ' ' . ($it['title'] ?? ''))); ?>">
                                        <td>
                                            <strong style="color:#0f172a; font-size:13px;"><?php echo esc_html($outlet_name); ?></strong>
                                            <?php if (!empty($it['logo'])): ?>
                                                <div style="margin-top:4px;">
                                                    <img src="<?php echo esc_url($it['logo']); ?>" style="max-height:20px; max-width:80px; object-fit:contain;">
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div style="font-weight:600; color:#1e293b; line-height:1.3; font-size:13px;">
                                                <a href="<?php echo esc_url($it['url']); ?>" target="_blank" rel="noopener" style="text-decoration:none; color:inherit;">
                                                    <?php echo esc_html($it['title'] ?? 'Sem título'); ?>
                                                    <span class="dashicons dashicons-external" style="font-size:13px; vertical-align:middle; color:#94a3b8;"></span>
                                                </a>
                                            </div>
                                            <div style="font-size:11px; color:#64748b; margin-top:3px; max-height:32px; overflow:hidden;">
                                                <?php echo esc_html(wp_trim_words($it['excerpt'] ?? '', 12)); ?>
                                            </div>
                                        </td>
                                        <td><span class="badge-year"><?php echo esc_html($it['date'] ?? '—'); ?></span></td>
                                        <td><span class="badge-cat"><?php echo esc_html($it['category'] ?? 'portal'); ?></span></td>
                                        <td style="text-align:center;">
                                            <?php echo $is_feat ? '⭐ Sim' : '<span style="color:#94a3b8;">—</span>'; ?>
                                        </td>
                                        <td style="text-align:right;">
                                            <div style="display:flex; justify-content:flex-end; gap:6px;">
                                                <a href="<?php echo esc_url(admin_url('admin.php?page=mercado-na-midia&action=edit&id=' . urlencode($it['id']))); ?>" 
                                                   class="button button-small">Editar</a>
                                                <form method="post" action="<?php echo esc_url(admin_url('admin.php?page=mercado-na-midia')); ?>" style="display:inline;"
                                                      onsubmit="return confirm('Excluir esta matéria?');">
                                                    <?php wp_nonce_field('mercado_midia_del_verify', 'mercado_midia_nonce'); ?>
                                                    <input type="hidden" name="mercado_midia_action" value="delete_item">
                                                    <input type="hidden" name="delete_id" value="<?php echo esc_attr($it['id']); ?>">
                                                    <button type="submit" class="button button-small button-link-delete" style="color:#ef4444;">Excluir</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    jQuery(document).ready(function($) {
        $('#adminMidiaSearch').on('keyup input', function() {
            var term = $(this).val().toLowerCase();
            $('#adminMidiaTable tbody tr').each(function() {
                var text = $(this).data('search') || '';
                if (text.indexOf(term) > -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
    </script>

    <style>
    .me-midia-admin { margin-top:20px; font-family:-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
    .me-midia-stats-bar { display:flex; gap:16px; margin:20px 0; flex-wrap:wrap; }
    .stat-card { background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:14px 22px; box-shadow:0 1px 3px rgba(0,0,0,0.05); display:flex; flex-direction:column; min-width:130px; }
    .stat-num { font-size:24px; font-weight:800; color:#1e293b; }
    .stat-lbl { font-size:12px; color:#64748b; font-weight:600; text-transform:uppercase; margin-top:2px; }
    .stat-card.stat-integration { margin-left:auto; justify-content:center; align-items:flex-end; }
    .me-midia-layout { display:flex; gap:24px; align-items:flex-start; }
    .me-midia-form-col { flex:0 0 400px; max-width:400px; }
    .me-midia-table-col { flex:1; min-width:0; }
    .me-admin-box { background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:22px; box-shadow:0 1px 3px rgba(0,0,0,0.05); }
    .box-title { margin:0 0 18px; font-size:17px; font-weight:700; color:#0f172a; padding-bottom:12px; border-bottom:1px solid #f1f5f9; }
    .badge-year { background:#f1f5f9; padding:2px 6px; border-radius:4px; font-size:11px; font-weight:600; }
    .badge-cat { background:#eff6ff; color:#2563eb; padding:2px 6px; border-radius:4px; font-size:11px; font-weight:700; text-transform:uppercase; }
    @media (max-width: 1080px) {
        .me-midia-layout { flex-direction:column; }
        .me-midia-form-col { flex:1 1 100%; max-width:100%; }
        .stat-card.stat-integration { margin-left:0; }
    }
    </style>
    <?php
}

/**
 * 6. SHORTCODE PÚBLICO [mercado_na_midia]
 */
add_shortcode('mercado_na_midia', 'mercado_na_midia_render');
function mercado_na_midia_render() {
    $items = mercado_get_na_midia_items();
    $total_items = count($items);

    ob_start();
    ?>
    <div class="me-internal-wrapper me-na-midia-app" id="na-midia-app">
        <!-- Hero Banner Oficial -->
        <div class="me-internal-hero">
            <span class="me-internal-badge"><i class="fas fa-bullhorn"></i> IMPRENSA &bull; RECONHECIMENTO &amp; CREDIBILIDADE</span>
            <h1 class="me-internal-title">Mercado Erótico na Mídia</h1>
            <p class="me-internal-subtitle">
                O portal e suas especialistas são referências consolidadas como fontes primárias de dados, investigações comportamentais e inteligência de mercado nos principais veículos de imprensa do Brasil e do mundo.
            </p>
            <div class="me-midia-stats-bar">
                <span class="stat-highlight"><strong><?php echo $total_items; ?></strong> Aparições Documentadas</span>
                <span class="stat-sep">&bull;</span>
                <span>Cobertura Nacional e Internacional</span>
                <span class="stat-sep">&bull;</span>
                <span>Jornais, TV, Rádio e Revistas de Negócios</span>
            </div>
        </div>



        <!-- Filtros e Busca Rápida -->
        <div class="me-midia-filter-bar">
            <div class="filter-top-row">
                <span class="filter-bar-lbl"><i class="fas fa-filter"></i> Filtrar por Formato:</span>
                <div class="midia-search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" id="midiaSearchInput" placeholder="Buscar por veículo ou tema..." oninput="searchMidia(this.value)">
                </div>
            </div>
            <div class="midia-filter-pills" id="midiaFilterPills">
                <button type="button" class="midia-pill active" data-cat="all" onclick="filterMidia('all', this)">
                    🌐 Todas as Aparições (<?php echo $total_items; ?>)
                </button>
                <button type="button" class="midia-pill" data-cat="featured" onclick="filterMidia('featured', this)">
                    ⭐ Destaques Nacionais (21)
                </button>
                <button type="button" class="midia-pill" data-cat="jornal" onclick="filterMidia('jornal', this)">
                    📰 Jornais
                </button>
                <button type="button" class="midia-pill" data-cat="portal" onclick="filterMidia('portal', this)">
                    💻 Portais de Notícias
                </button>
                <button type="button" class="midia-pill" data-cat="tv" onclick="filterMidia('tv', this)">
                    📺 Televisão &amp; Vídeos
                </button>
                <button type="button" class="midia-pill" data-cat="radio" onclick="filterMidia('radio', this)">
                    🎙️ Rádio &amp; Podcasts
                </button>
                <button type="button" class="midia-pill" data-cat="revista" onclick="filterMidia('revista', this)">
                    📖 Revistas Especializadas
                </button>
            </div>
        </div>

        <!-- Grid Dinâmico de Matérias -->
        <div class="me-media-grid" id="midiaCardsGrid">
            <?php foreach ($items as $it): 
                $cat = esc_attr($it['category'] ?? 'portal');
                $tag_color = esc_attr($it['tag_color'] ?? '#e31c61');
                $is_feat = !empty($it['featured']) ? '1' : '0';
                $outlet_name = $it['outlet'] ?? 'Imprensa';
                $title = $it['title'] ?? 'Reportagem';
                $logo = $it['logo'] ?? '';
            ?>
                <article class="media-card" data-category="<?php echo $cat; ?>" data-featured="<?php echo $is_feat; ?>" data-search="<?php echo esc_attr(strtolower($outlet_name . ' ' . $title)); ?>">
                    <div class="media-outlet-header">
                        <?php if (!empty($logo)): ?>
                            <div class="outlet-logo-wrap">
                                <img src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr($outlet_name); ?>" class="outlet-logo-img" loading="lazy">
                            </div>
                        <?php else: ?>
                            <span class="outlet-tag" style="background:<?php echo $tag_color; ?>; color:#ffffff;">
                                <?php echo esc_html($it['outlet_tag'] ?? $outlet_name); ?>
                            </span>
                        <?php endif; ?>
                        <span class="media-year"><i class="far fa-calendar-alt"></i> <?php echo esc_html($it['date']); ?></span>
                    </div>

                    <div class="media-category-sub"><?php echo esc_html($it['category_lbl'] ?? ''); ?></div>
                    <h3 class="media-headline"><?php echo esc_html($title); ?></h3>
                    <p class="media-excerpt"><?php echo esc_html($it['excerpt']); ?></p>

                    <div class="media-card-footer">
                        <a href="<?php echo esc_url($it['url']); ?>" target="_blank" rel="noopener noreferrer" class="media-link">
                            <span>Acessar Reportagem Original</span>
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <div id="noMidiaResults" style="display:none; text-align:center; padding:50px 20px; background:#fff; border-radius:16px; border:1px solid #eaeaea; margin-top:20px;">
            <p style="color:#64748b; font-size:1.1rem; margin:0;"><i class="fas fa-search"></i> Nenhuma reportagem encontrada para a busca.</p>
        </div>

        <!-- Box Assessoria de Imprensa para Jornalistas -->
        <section class="me-press-kit-box" aria-label="Espaço para Imprensa">
            <div class="press-kit-inner">
                <div class="press-kit-icon">
                    <i class="fas fa-microphone-alt"></i>
                </div>
                <div class="press-kit-text">
                    <span class="press-kit-tag">ASSESSORIA DE IMPRENSA &amp; COMUNICAÇÃO</span>
                    <h2 class="press-kit-title">Espaço para Jornalistas, Produtores e Redações</h2>
                    <p class="press-kit-desc">
                        Precisa de dados estatísticos confiáveis, análises econômicas do setor sensual, fontes técnicas ou entrevistas exclusivas com especialistas renomados para sua matéria?
                    </p>
                    <div class="press-kit-actions">
                        <a href="<?php echo esc_url(home_url('/contato/')); ?>" class="press-btn-primary">
                            <i class="fas fa-envelope-open-text"></i> Solicitar Pauta ou Fonte
                        </a>
                        <a href="https://api.whatsapp.com/send?phone=5562982763039&text=Ol%C3%A1%2C+sou+jornalista+e+gostaria+de+uma+pauta%2Fentrevista+com+o+Portal+Mercado+Er%C3%B3tico" target="_blank" rel="noopener" class="press-btn-whatsapp">
                            <i class="fab fa-whatsapp"></i> WhatsApp da Redação
                        </a>
                        <a href="<?php echo esc_url(home_url('/pesquisas/')); ?>" class="press-btn-secondary">
                            <i class="fas fa-chart-line"></i> Consultar Indicadores &amp; Pesquisas
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Script de Filtro e Busca Rápida -->
    <script>
    var currentCat = 'all';
    var currentQuery = '';

    function filterMidia(category, btn) {
        currentCat = category;
        if (btn) {
            document.querySelectorAll('#midiaFilterPills .midia-pill').forEach(function(p) {
                p.classList.remove('active');
            });
            btn.classList.add('active');
        }
        applyFilters();
    }

    function searchMidia(query) {
        currentQuery = (query || '').toLowerCase().trim();
        applyFilters();
    }

    function applyFilters() {
        var cards = document.querySelectorAll('#midiaCardsGrid .media-card');
        var visibleCount = 0;

        cards.forEach(function(card) {
            var catMatch = false;
            if (currentCat === 'all') {
                catMatch = true;
            } else if (currentCat === 'featured') {
                catMatch = (card.getAttribute('data-featured') === '1');
            } else {
                catMatch = (card.getAttribute('data-category') === currentCat);
            }

            var searchMatch = true;
            if (currentQuery.length > 0) {
                var searchData = card.getAttribute('data-search') || '';
                searchMatch = (searchData.indexOf(currentQuery) > -1);
            }

            if (catMatch && searchMatch) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        var noRes = document.getElementById('noMidiaResults');
        if (noRes) {
            noRes.style.display = (visibleCount === 0) ? 'block' : 'none';
        }
    }
    </script>

    <style>
    .me-na-midia-app {
        max-width: 1240px;
        margin: 0 auto;
        padding: 10px 20px 80px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }
    .me-internal-hero {
        background: radial-gradient(circle at 50% 30%, #1f1122 0%, #0d0612 100%);
        border-radius: 20px;
        padding: 50px 30px;
        text-align: center;
        color: #fff;
        margin-bottom: 35px;
        border: 1px solid rgba(227, 28, 97, 0.25);
        box-shadow: 0 15px 35px rgba(0,0,0,0.25);
    }
    .me-internal-badge {
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
    .me-internal-title {
        font-size: 2.4rem;
        font-weight: 900;
        color: #fff;
        margin: 0 0 12px;
        line-height: 1.25;
    }
    .me-internal-subtitle {
        font-size: 1.1rem;
        color: #d1c7d4;
        max-width: 780px;
        margin: 0 auto 25px;
        line-height: 1.6;
    }
    .me-midia-stats-bar {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 15px;
        font-size: 0.9rem;
        color: #d1c7d4;
        flex-wrap: wrap;
    }
    .me-midia-stats-bar .stat-highlight {
        color: #e31c61;
        font-weight: 700;
    }
    .me-midia-stats-bar .stat-sep {
        color: rgba(227, 28, 97, 0.5);
    }



    /* Filtros e Busca */
    .me-midia-filter-bar {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px 24px;
        margin-bottom: 35px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }
    .filter-top-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .filter-bar-lbl {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1e293b;
    }
    .midia-search-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }
    .midia-search-wrap i {
        position: absolute;
        left: 12px;
        color: #94a3b8;
        font-size: 0.9rem;
    }
    .midia-search-wrap input {
        padding: 8px 12px 8px 34px;
        border: 1px solid #cbd5e1;
        border-radius: 20px;
        font-size: 0.88rem;
        width: 250px;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .midia-search-wrap input:focus {
        border-color: #e31c61;
        box-shadow: 0 0 0 3px rgba(227, 28, 97, 0.1);
    }
    .midia-filter-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .midia-pill {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #475569;
        font-size: 0.85rem;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .midia-pill:hover {
        background: #f1f5f9;
        color: #0f172a;
        border-color: #cbd5e1;
    }
    .midia-pill.active {
        background: #e31c61;
        color: #fff;
        border-color: #e31c61;
        box-shadow: 0 3px 10px rgba(227, 28, 97, 0.25);
    }

    /* Grid de Matérias */
    .me-media-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 26px;
        margin-bottom: 50px;
    }
    .media-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #eaeaea;
        box-shadow: 0 6px 20px rgba(0,0,0,0.03);
        padding: 24px;
        display: flex;
        flex-direction: column;
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    }
    .media-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 28px rgba(0,0,0,0.08);
        border-color: #cbd5e1;
    }
    .media-outlet-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        min-height: 40px;
    }
    .outlet-logo-wrap {
        max-width: 150px;
        height: 38px;
        display: flex;
        align-items: center;
    }
    .outlet-logo-img {
        max-width: 100%;
        max-height: 36px;
        object-fit: contain;
    }
    .outlet-tag {
        display: inline-block;
        font-size: 0.72rem;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 6px;
        letter-spacing: 0.6px;
        text-transform: uppercase;
    }
    .media-year {
        font-size: 0.8rem;
        color: #64748b;
        font-weight: 600;
    }
    .media-category-sub {
        font-size: 0.75rem;
        color: #e31c61;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }
    .media-headline {
        font-size: 1.15rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.35;
        margin: 0 0 10px;
    }
    .media-excerpt {
        font-size: 0.88rem;
        color: #475569;
        line-height: 1.55;
        margin: 0 0 20px;
        flex-grow: 1;
    }
    .media-card-footer {
        border-top: 1px solid #f1f5f9;
        padding-top: 14px;
        margin-top: auto;
    }
    .media-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #e31c61;
        font-size: 0.85rem;
        font-weight: 700;
        text-decoration: none;
        transition: color 0.2s, transform 0.2s;
    }
    .media-link:hover {
        color: #9c1543;
        transform: translateX(4px);
    }

    /* Box Imprensa */
    .me-press-kit-box {
        background: linear-gradient(135deg, #1f1122 0%, #0d0612 100%);
        border: 1px solid rgba(227, 28, 97, 0.3);
        border-radius: 20px;
        padding: 40px 30px;
        color: #fff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    .press-kit-inner {
        display: flex;
        align-items: center;
        gap: 30px;
    }
    .press-kit-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: rgba(227, 28, 97, 0.15);
        color: #e31c61;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 2rem;
        flex-shrink: 0;
        border: 2px solid rgba(227, 28, 97, 0.3);
    }
    .press-kit-text {
        flex-grow: 1;
    }
    .press-kit-tag {
        display: inline-block;
        color: #e31c61;
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 1px;
        margin-bottom: 6px;
    }
    .press-kit-title {
        font-size: 1.5rem;
        font-weight: 800;
        margin: 0 0 10px;
        color: #fff;
    }
    .press-kit-desc {
        font-size: 0.95rem;
        color: #d1c7d4;
        line-height: 1.55;
        max-width: 800px;
        margin: 0 0 20px;
    }
    .press-kit-actions {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
    }
    .press-btn-primary {
        background: #e31c61;
        color: #fff !important;
        font-weight: 700;
        font-size: 0.9rem;
        padding: 10px 20px;
        border-radius: 25px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background 0.2s;
    }
    .press-btn-primary:hover {
        background: #c41652;
    }
    .press-btn-whatsapp {
        background: #10b981;
        color: #fff !important;
        font-weight: 700;
        font-size: 0.9rem;
        padding: 10px 20px;
        border-radius: 25px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background 0.2s;
    }
    .press-btn-whatsapp:hover {
        background: #059669;
    }
    .press-btn-secondary {
        background: rgba(255,255,255,0.08);
        color: #fff !important;
        border: 1px solid rgba(255,255,255,0.2);
        font-weight: 700;
        font-size: 0.9rem;
        padding: 10px 20px;
        border-radius: 25px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background 0.2s;
    }
    .press-btn-secondary:hover {
        background: rgba(255,255,255,0.15);
    }
    @media (max-width: 768px) {
        .me-internal-title { font-size: 1.8rem; }
        .press-kit-inner { flex-direction: column; text-align: center; }
        .press-kit-actions { justify-content: center; }
        .filter-top-row { flex-direction: column; align-items: stretch; }
        .midia-search-wrap input { width: 100%; }
        .me-media-grid { grid-template-columns: 1fr; }
    }
    </style>
    <?php
    return ob_get_clean();
}
