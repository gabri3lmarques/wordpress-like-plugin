<?php

namespace LikePlugin;

class LikePlugin_Shortcodes {

    public function top_liked_posts() {
        $args = array(
            'meta_key' => '_like_plugin_popularity',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'posts_per_page' => 10,
        );

        $query = new \WP_Query($args);
        $output = '<ul>';
        while ($query->have_posts()) {
            $query->the_post();
            $output .= '<li><a href="' . get_permalink() . '">' . get_the_title() . ' (' . get_post_meta(get_the_ID(), '_like_plugin_popularity', true) . ')</a></li>';
        }
        $output .= '</ul>';

        wp_reset_postdata();

        return $output;
    }



}
