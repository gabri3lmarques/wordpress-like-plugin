<?php

/*
Plugin Name: Like Plugin
Description: Esse plugin permite aos visitantes classificarem publicações com Like e Dislike.
Version: 1.0
Author: Gabriel Marques
Text Domain: like-plugin
*/

if (!defined('ABSPATH')) {
    exit;
}

function like_plugin_autoload($class) {
    if (strpos($class, 'LikePlugin\\') === 0) {
        $class_name = str_replace('LikePlugin\\', '', $class);
        $file = plugin_dir_path(__FILE__) . 'includes/class-' . strtolower($class_name) . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
}

spl_autoload_register('like_plugin_autoload');

function like_plugin_init() {
    $plugin = new LikePlugin\LikePlugin();
    $plugin->run();

    $shortcodes = new LikePlugin\LikePlugin_Shortcodes();
    add_shortcode('top-liked', array($shortcodes, 'top_liked_posts'));
}




add_action('plugins_loaded', 'like_plugin_init');
