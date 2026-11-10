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
        max-height: 60px !important;
        width: auto !important;
        height: auto !important;
        display: block !important;
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

    /* MENU NAVBAR LIMPO E ELEGANTE (ORIGINAL DO TEMA) */
    .header-menu-1 .menu > li > a {
        font-size: 13.5px !important;
        font-weight: 600 !important;
        color: #1a1a1a !important;
        padding: 10px 14px !important;
        transition: color 0.2s ease !important;
    }
    .header-menu-1 .menu > li > a:hover {
        color: #e31c61 !important;
    }

    @media (max-width: 991px) {
        .site-branding .site-logo-container img {
            max-height: 48px !important;
        }
    }
    </style>
    <?php
}, 99);
