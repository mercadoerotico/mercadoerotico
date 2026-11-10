<?php
add_action("wp_enqueue_scripts", function() {
    wp_enqueue_style("blocksy-parent-style", get_template_directory_uri() . "/style.css");
    wp_enqueue_style("blocksy-child-style", get_stylesheet_directory_uri() . "/style.css", array("blocksy-parent-style"), time());
});

add_action("wp_head", function() {
    ?>
    <style id="mercado-header-fixes">
    /* LOGO EM DESTAQUE E OCULTAÇÃO TOTAL DO TEXTO */
    .site-branding .site-logo-container img {
        max-height: 65px !important;
        width: auto !important;
        height: auto !important;
        display: block !important;
        transition: transform 0.25s ease !important;
    }
    .site-branding .site-logo-container:hover img {
        transform: scale(1.03) !important;
    }
    .site-title-container,
    .site-title,
    .site-description {
        display: none !important;
        visibility: hidden !important;
        height: 0 !important;
        width: 0 !important;
        overflow: hidden !important;
    }

    /* MENU NAVBAR REFINADO */
    .header-menu-1 .menu > li > a {
        font-size: 13.5px !important;
        font-weight: 600 !important;
        color: #1a1a1a !important;
        padding: 10px 12px !important;
        transition: color 0.2s ease !important;
    }
    .header-menu-1 .menu > li > a:hover {
        color: #e31c61 !important;
    }

    /* BOTÕES ESPECIAIS (Acervo e Livraria) */
    .header-menu-1 .menu > li.menu-item-acervo > a,
    .header-menu-1 .menu > li a[href*="/acervo"] {
        background: #111 !important;
        color: #fff !important;
        border-radius: 20px !important;
        padding: 6px 14px !important;
        margin: 0 4px !important;
        font-size: 12px !important;
        font-weight: 700 !important;
        border: 1px solid rgba(255,255,255,0.2) !important;
    }
    .header-menu-1 .menu > li.menu-item-acervo > a:hover,
    .header-menu-1 .menu > li a[href*="/acervo"]:hover {
        background: #e31c61 !important;
        color: #fff !important;
        border-color: #e31c61 !important;
    }

    .header-menu-1 .menu > li.menu-item-livraria > a,
    .header-menu-1 .menu > li a[href*="/livraria"] {
        background: linear-gradient(135deg, #e31c61, #9c1543) !important;
        color: #fff !important;
        border-radius: 20px !important;
        padding: 6px 14px !important;
        margin: 0 4px !important;
        font-size: 12px !important;
        font-weight: 700 !important;
        box-shadow: 0 4px 12px rgba(227, 28, 97, 0.3) !important;
    }
    .header-menu-1 .menu > li.menu-item-livraria > a:hover,
    .header-menu-1 .menu > li a[href*="/livraria"]:hover {
        opacity: 0.9 !important;
        color: #fff !important;
        transform: translateY(-1px) !important;
    }

    @media (max-width: 991px) {
        .site-branding .site-logo-container img {
            max-height: 48px !important;
        }
    }
    </style>
    <?php
}, 99);
