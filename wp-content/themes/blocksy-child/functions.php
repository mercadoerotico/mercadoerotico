<?php
add_action("wp_enqueue_scripts", function() {
    wp_enqueue_style("blocksy-parent-style", get_template_directory_uri() . "/style.css");
    wp_enqueue_style("blocksy-child-style", get_stylesheet_directory_uri() . "/style.css", array("blocksy-parent-style"));
});
