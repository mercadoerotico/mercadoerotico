<?php
add_action("wp_enqueue_scripts", function() {
    wp_enqueue_style("font-awesome-cdn", "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css", array(), "6.4.0");
});

// Desativar colapso automático do menu no dropdown "More" / "Mais"
add_filter('blocksy:header:menu:has-responsive-desktop-menu', '__return_false');

// Tradução de strings em inglês (Compartilhamento social)
add_filter('gettext', function($translated_text, $text, $domain) {
    if ($text === 'Share this content:' || $text === 'Share this content') {
        return 'Compartilhe este conteúdo:';
    }
    return $translated_text;
}, 20, 3);

// Redirecionamentos amigáveis (SEO e prevenção de 404)
add_action('init', function() {
    $request_uri = trim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
    if ($request_uri === 'midia') {
        wp_redirect(home_url('/na-midia/'), 301);
        exit;
    }
    // Redirecionar /categoria/* para /category/*
    if (preg_match('#^categoria/(.*)$#i', $request_uri, $matches)) {
        wp_redirect(home_url('/category/' . $matches[1] . '/'), 301);
        exit;
    }
});

add_action("wp_head", function() {
    // 1. Injetar style.css do child theme diretamente para eliminar cache e latência
    $child_css = get_stylesheet_directory() . "/style.css";
    if (file_exists($child_css)) {
        echo "<style id=\"mercado-child-style\">\n" . file_get_contents($child_css) . "\n</style>\n";
    }
    ?>
    <style id="mercado-menu-nowrap-override">
    /* Menu sem 'More': quebra de linha fluida se não couber */
    header [data-id*="menu"] ul.menu,
    header nav.menu-container ul.menu {
        flex-wrap: wrap !important;
        white-space: normal !important;
        overflow: visible !important;
        row-gap: 6px !important;
    }
    header [data-id*="menu"] ul.menu > li,
    header nav.menu-container ul.menu > li {
        display: inline-flex !important;
        flex-shrink: 0 !important;
        white-space: nowrap !important;
    }
    header .more-items-container {
        display: none !important;
    }
    </style>
    <?php
}, 99);

// Abrir links de redes sociais e canais externos em nova aba/janela no conteúdo de artigos e páginas
add_filter('the_content', function($content) {
    if (empty($content)) return $content;
    $pattern = '~<a\s+[^>]*href=["\'][^"\']*(?:facebook\.com|instagram\.com|youtube\.com|linkedin\.com|twitter\.com|x\.com|tiktok\.com|spotify\.com|threads\.net|t\.me|telegram\.me|whatsapp\.com|wa\.me)[^"\']*["\'][^>]*>~i';
    return preg_replace_callback($pattern, function($matches) {
        $tag = $matches[0];
        if (strpos($tag, 'target=') === false) {
            $tag = rtrim($tag, '>') . ' target="_blank" rel="noopener noreferrer">';
        } else {
            $tag = preg_replace('/target=["\'][^"\']*["\']/i', 'target="_blank"', $tag);
            if (strpos($tag, 'rel=') === false) {
                $tag = rtrim($tag, '>') . ' rel="noopener noreferrer">';
            }
        }
        return $tag;
    }, $content);
}, 20);

add_action('wp_footer', function() {
    ?>
    <script id="mercado-menu-unwrap-script">
    (function() {
        function unwrapMenuMore() {
            const menus = document.querySelectorAll('header [data-id*="menu"], header nav.menu-container');
            menus.forEach(function(m) {
                m.removeAttribute('data-responsive');
                const more = m.querySelector('.more-items-container');
                if (more) {
                    const sub = more.querySelector('.sub-menu');
                    if (sub) {
                        while (sub.firstElementChild) {
                            more.parentNode.insertBefore(sub.firstElementChild, more);
                        }
                    }
                    more.remove();
                }
            });
        }
        unwrapMenuMore();
        window.addEventListener('resize', unwrapMenuMore);
        document.addEventListener('DOMContentLoaded', unwrapMenuMore);
        setTimeout(unwrapMenuMore, 500);
        setTimeout(unwrapMenuMore, 1500);

        // Garantir abertura de redes sociais em nova janela/aba em qualquer elemento do portal
        function ensureSocialLinksNewWindow() {
            const socialRegex = /(?:facebook\.com|instagram\.com|youtube\.com|linkedin\.com|twitter\.com|x\.com|tiktok\.com|spotify\.com|threads\.net|t\.me|telegram\.me|whatsapp\.com|wa\.me)/i;
            document.querySelectorAll('a[href]').forEach(function(a) {
                if (socialRegex.test(a.href)) {
                    a.setAttribute('target', '_blank');
                    const rel = a.getAttribute('rel') || '';
                    if (!rel.includes('noopener')) {
                        a.setAttribute('rel', (rel ? rel + ' ' : '') + 'noopener noreferrer');
                    }
                }
            });
        }
        ensureSocialLinksNewWindow();
        document.addEventListener('DOMContentLoaded', ensureSocialLinksNewWindow);
        document.addEventListener('click', function(e) {
            const a = e.target.closest && e.target.closest('a[href]');
            if (a && /(?:facebook\.com|instagram\.com|youtube\.com|linkedin\.com|twitter\.com|x\.com|tiktok\.com|spotify\.com|threads\.net|t\.me|telegram\.me|whatsapp\.com|wa\.me)/i.test(a.href)) {
                a.setAttribute('target', '_blank');
                const rel = a.getAttribute('rel') || '';
                if (!rel.includes('noopener')) {
                    a.setAttribute('rel', (rel ? rel + ' ' : '') + 'noopener noreferrer');
                }
            }
        }, true);
    })();
    </script>
    <?php
}, 99);

/**
 * Redirecionamentos 301 Automáticos para Campanhas e URLs Antigas
 * Elimina erros 404 provenientes de links internos em matérias históricas
 */
add_action('template_redirect', function() {
    $request_uri = untrailingslashit(strtok($_SERVER['REQUEST_URI'] ?? '', '?'));

    $redirects = array(
        '/guia-de-compras-sex-shop-quarentena-sexy' => home_url('/acervo/'),
        '/vibrador-o-livro-download-gratis' => home_url('/livraria/'),
        '/category/sexyfair2018' => home_url('/category/eventos/'),
        '/catalogo-de-lancamentos-para-o-dia-dos-namorados-e-pesquisa-mercado-erotico-na-quarentena' => home_url('/acervo/'),
        '/novembro-azul-pesquisa-sobre-consumo-masculino-em-sex-shop-e-ebook-de-masturbacao' => home_url('/livraria/'),
        '/category/premio-2020' => home_url('/category/noticias/'),
        '/category/testadora-de-produtos' => home_url('/category/produtos/'),
        '/author/mariana-kiss' => home_url('/author/marianna-kiss/'),
    );

    if (isset($redirects[$request_uri])) {
        wp_redirect($redirects[$request_uri], 301);
        exit;
    }

    // Prevenção inteligente de 404: links antigos de materiais, downloads e pesquisas redirecionam para o Acervo
    if (is_404()) {
        $raw_uri = strtolower($_SERVER['REQUEST_URI'] ?? '');
        $acervo_keywords = array('download', 'ebook', 'e-book', 'pesquisa', 'anuario', 'guia', 'manual', 'relatorio', 'livro', 'acervo');
        foreach ($acervo_keywords as $kw) {
            if (strpos($raw_uri, $kw) !== false) {
                wp_redirect(home_url('/acervo/'), 301);
                exit;
            }
        }
    }
});

/**
 * Filtro de Segurança em the_content:
 * Substitui links externos quebrados conhecidos diretamente pela página de Acervo/Livraria
 */
add_filter('the_content', function($content) {
    static $broken_map = null;
    if ($broken_map === null) {
        $acervo_url = home_url('/acervo/');
        $livraria_url = home_url('/livraria/');

        $broken_map = array(
            'http://bit.ly/vibrador-ebook' => $livraria_url,
            'https://bit.ly/vibrador-ebook' => $livraria_url,
            'https://issuu.com/realestudio/docs/cat_logo_spiceup' => $acervo_url,
            'http://bit.ly/melhoresdomercadofinal' => $acervo_url,
            'https://drive.google.com/open?id=1cdHgTJwt9bBvIwe6GILOG8IAHLq9Bxr9' => $acervo_url,
            'http://aula.kpages.online/ebookdeumatch#section-4273723' => $acervo_url,
            'http://mercado-erotico.coursify.me/courses/como-publicar-um-livro' => $acervo_url,
            'https://mercado-erotico.coursify.me/courses/como-publicar-um-livro' => $acervo_url,
            'http://www.facebook/vibracaopositiva17' => $acervo_url,
            'https://bit.ly/2VSUxAh' => $acervo_url,
            'https://drive.google.com/drive/folders/1EJr7S7eD2E4JmcbNdHZXYgn0QlUw8Lta?usp=sharing' => $acervo_url,
            'https://go.hotmart.com/D59035149W' => $acervo_url,
            'https://go.hotmart.com/D59035149W?dp=1' => $acervo_url,
            'https://bit.ly/3tIFgAg' => $acervo_url,
            'https://drive.google.com/file/d/1DqvYzf43S48Pzc4yPt3MnQm7Koi_tQtw/view?usp=sharing' => $acervo_url,
            'https://drive.google.com/file/d/1T50PPX6QX9_4BJ_PQBCeIbuONmPlevQ1/view?usp=sharing' => $acervo_url,
            'https://www.loja.luzdaserraeditora.com.br/livros/manifesto-da-autoestima--p' => $acervo_url,
            'https://bit.ly/ebook-mrx-black-friday' => $acervo_url,
            'https://bit.ly/ebook-mrx-black-friday.' => $acervo_url,
            'https://go.hotmart.com/V63979941W' => $acervo_url,
            'https://hotmart.com/pt-br/marketplace/produtos/sexpompoar/F73063847K' => $acervo_url,
            'https://drive.google.com/drive/folders/1zJNHiCwsls_8rOov3sHTQ2v9JZMhNdmX?usp=sharing' => $acervo_url,
            'https://www.al.rs.gov.br/procuradoriadamulher/Portals/Procuradoriadamulher/Relatorio_lesbocenso%202022.pdf' => $acervo_url,
            'https://go.hotmart.com/P92659595B?dp=1' => $acervo_url,
        );
    }

    return str_replace(array_keys($broken_map), array_values($broken_map), $content);
}, 20);


