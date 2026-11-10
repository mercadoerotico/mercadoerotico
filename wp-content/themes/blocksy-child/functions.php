<?php
add_action("wp_enqueue_scripts", function() {
    wp_enqueue_style("font-awesome-cdn", "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css", array(), "6.4.0");
});

// Desativar colapso automático do menu no dropdown "More" / "Mais"
add_filter('blocksy:header:menu:has-responsive-desktop-menu', '__return_false');

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
    })();
    </script>
    <?php
}, 99);
