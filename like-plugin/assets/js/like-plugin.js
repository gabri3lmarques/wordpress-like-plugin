jQuery(document).ready(function($) {
    function updateLikeButton(post_id) {
        var $button = $('.like-plugin-buttons[data-post-id="' + post_id + '"] .like-button');
        var previous_action = localStorage.getItem('like_plugin_' + post_id);

        if (previous_action && previous_action === 'like') {
            $button.addClass('liked');
        } else {
            $button.removeClass('liked');
        }
    }

    $('.like-plugin-buttons').each(function() {
        var post_id = $(this).data('post-id');
        updateLikeButton(post_id);
    });

    $('.like-plugin-buttons .like-button').on('click', function() {
        var $this = $(this);
        var post_id = $this.closest('.like-plugin-buttons').data('post-id');
        var action_type = 'like';
        var previous_action = localStorage.getItem('like_plugin_' + post_id);

        if (previous_action && previous_action === 'like') {
            action_type = 'remove_like';
        }

        $.ajax({
            url: likePlugin.ajax_url,
            type: 'POST',
            data: {
                action: 'like_plugin_handle_vote',
                post_id: post_id,
                action_type: action_type,
            },
            success: function(response) {
                alert('Nova popularidade: ' + response);
                if (action_type === 'remove_like') {
                    localStorage.removeItem('like_plugin_' + post_id);
                } else {
                    localStorage.setItem('like_plugin_' + post_id, action_type);
                }
                updateLikeButton(post_id);
            }
        });
    });
});
