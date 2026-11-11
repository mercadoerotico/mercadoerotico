<?php
/**
 * Plugin Name: Mercado Erótico - Segurança & Performance Hardening
 * Description: Otimizações essenciais de segurança (bloqueio de enumeração de usuários, ocultação de versão do WP, proteção contra bots) e performance (remoção de emoji scripts inúteis, ajuste de heartbeat).
 * Version: 1.0.0
 * Author: Equipe Portal Mercado Erótico
 */

if (!defined('ABSPATH')) exit;

/**
 * 1. SEGURANÇA: Bloqueio de Enumeração de Usuários via REST API
 * Apenas administradores logados podem consultar /wp-json/wp/v2/users
 */
add_filter('rest_endpoints', function($endpoints) {
    if (isset($endpoints['/wp/v2/users'])) {
        $endpoints['/wp/v2/users'][0]['permission_callback'] = function() {
            return current_user_can('list_users');
        };
    }
    if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
        $endpoints['/wp/v2/users/(?P<id>[\d]+)'][0]['permission_callback'] = function() {
            return current_user_can('list_users');
        };
    }
    return $endpoints;
});

/**
 * 2. SEGURANÇA: Bloquear Enumeração via URL ?author=N
 */
add_action('template_redirect', function() {
    if (!is_admin() && isset($_GET['author']) && is_numeric($_GET['author'])) {
        wp_safe_redirect(home_url(), 301);
        exit;
    }
});

/**
 * 3. SEGURANÇA: Ocultar Versão do WordPress
 */
remove_action('wp_head', 'wp_generator');
add_filter('the_generator', '__return_empty_string');

/**
 * 4. PERFORMANCE: Desativar Emojis do WordPress (Dispositivos modernos já renderizam nativamente)
 */
add_action('init', function() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', function($plugins) {
        if (is_array($plugins)) {
            return array_diff($plugins, array('wpemoji'));
        }
        return array();
    });
    add_filter('wp_resource_hints', function($urls, $relation_type) {
        if ('dns-prefetch' === $relation_type) {
            $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/');
            $urls = array_diff($urls, array($emoji_svg_url));
        }
        return $urls;
    }, 10, 2);
});

/**
 * 5. PERFORMANCE: Otimizar Frequência do Heartbeat API (Alivia consumo de CPU na hospedagem)
 */
add_filter('heartbeat_settings', function($settings) {
    $settings['interval'] = 60; // 60 segundos em vez de 15 segundos
    return $settings;
});

/**
 * 6. ANTI-SPAM DEFINITIVO: Desativar Completamente Todos os Comentários no Portal
 */
// Fecha comentários e trackbacks em todas as consultas
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);
add_filter('comments_array', '__return_empty_array', 10, 2);

// Bloqueia qualquer envio direto de bot via POST para wp-comments-post.php
add_action('init', function() {
    if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], 'wp-comments-post.php') !== false) {
        wp_die('Os comentários neste portal estão permanentemente desativados.', 'Comentários Encerrados', array('response' => 403));
    }
});

// Remove item "Comentários" do menu administrativo e da barra superior
add_action('admin_menu', function() {
    remove_menu_page('edit-comments.php');
});
add_action('wp_before_admin_bar_render', function() {
    global $wp_admin_bar;
    if ($wp_admin_bar) {
        $wp_admin_bar->remove_menu('comments');
    }
});

