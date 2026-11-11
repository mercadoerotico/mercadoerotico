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
