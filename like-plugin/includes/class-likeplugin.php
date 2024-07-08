<?php

namespace LikePlugin;

class LikePlugin {
    public function run() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_filter('the_content', array($this, 'add_buttons'));
        add_action('wp_ajax_like_plugin_handle_vote', array($this, 'handle_vote'));
        add_action('wp_ajax_nopriv_like_plugin_handle_vote', array($this, 'handle_vote'));
    }

    public function enqueue_scripts() {
        wp_enqueue_script('like-plugin-script', plugin_dir_url(__FILE__) . '../assets/js/like-plugin.js', array('jquery'), '1.0', true);
        wp_localize_script('like-plugin-script', 'likePlugin', array(
            'ajax_url' => admin_url('admin-ajax.php'),
        ));
        wp_enqueue_style('like-plugin-style', plugin_dir_url(__FILE__) . '../assets/css/like-plugin.css');
    }

    public function add_buttons($content) {
        if (is_single()) {
            $post_id = get_the_ID();
            $content .= '<div class="like-plugin-buttons" data-post-id="' . $post_id . '">
                <button class="like-button"></button>
            </div>';
        }
        return $content;
    }

    public function handle_vote() {
        if (isset($_POST['post_id']) && isset($_POST['action_type'])) {
            $post_id = intval($_POST['post_id']);
            $action_type = sanitize_text_field($_POST['action_type']);

            $current_popularity = get_post_meta($post_id, '_like_plugin_popularity', true);
            $current_popularity = $current_popularity ? intval($current_popularity) : 0;

            if ($action_type == 'like') {
                $current_popularity++;
            } elseif ($action_type == 'remove_like') {
                $current_popularity--;
            }

            update_post_meta($post_id, '_like_plugin_popularity', $current_popularity);

            echo $current_popularity;
        }
        wp_die();
    }
}
