<?php
add_action("wp_enqueue_scripts", function() {
    wp_enqueue_style("blocksy-parent-style", get_template_directory_uri() . "/style.css");
    wp_enqueue_style("blocksy-child-style", get_stylesheet_directory_uri() . "/style.css", array("blocksy-parent-style"), time());
});

add_action("wp_head", function() {
    ?>
    <style id="mercado-header-fixes">
    /* 1. LOGO EM DESTAQUE REAL (AMPLIADO E VISÍVEL) */
    .site-branding .site-logo-container {
        display: flex !important;
        align-items: center !important;
    }
    .site-branding .site-logo-container img {
        max-height: 85px !important;
        width: auto !important;
        height: auto !important;
        max-width: 260px !important;
        display: block !important;
        transition: transform 0.25s ease !important;
    }
    .site-branding .site-logo-container:hover img {
        transform: scale(1.02) !important;
    }

    /* OCULTAR TOTALMENTE TEXTO DO SITE */
    .site-title-container,
    .site-title,
    .site-description {
        display: none !important;
        visibility: hidden !important;
        height: 0 !important;
        width: 0 !important;
        overflow: hidden !important;
    }

    /* 2. ESPAÇAMENTO DA NAVBAR */
    [data-row="middle"] {
        padding: 10px 0 !important;
    }
    [data-column="start"] {
        flex: 0 0 auto !important;
    }

    /* 3. MENU NAVEGAÇÃO LIMPO E SOFISTICADO (SEM PÍLULAS ARTIFICIAIS) */
    .header-menu-1 .menu > li > a {
        font-size: 13.5px !important;
        font-weight: 600 !important;
        color: #222 !important;
        padding: 10px 14px !important;
        letter-spacing: 0.2px !important;
        transition: color 0.2s ease !important;
    }
    .header-menu-1 .menu > li > a:hover {
        color: #e31c61 !important;
    }
    .header-menu-1 .menu > li.current-menu-item > a {
        color: #e31c61 !important;
    }

    /* 4. LOGO NO MOBILE */
    @media (max-width: 991px) {
        .site-branding .site-logo-container img {
            max-height: 58px !important;
            max-width: 210px !important;
        }
        [data-row="middle"] {
            padding: 8px 0 !important;
        }
    }
    </style>
    <?php
}, 99);
