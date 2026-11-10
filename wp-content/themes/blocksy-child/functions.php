<?php
add_action("wp_enqueue_scripts", function() {
    wp_enqueue_style("font-awesome-cdn", "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css", array(), "6.4.0");
});

add_action("wp_head", function() {
    // 1. Injetar style.css do child theme diretamente para eliminar cache e latência
    $child_css = get_stylesheet_directory() . "/style.css";
    if (file_exists($child_css)) {
        echo "<style id=\"mercado-child-style\">\n" . file_get_contents($child_css) . "\n</style>\n";
    }
}, 99);
