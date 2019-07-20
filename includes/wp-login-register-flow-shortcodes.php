<?php
/*
# function : wplrf_account_shortcode_callback
# define shortcode function 
*/
function wplrf_account_shortcode_callback($params = array()) {
	# extract
	extract(shortcode_atts(array(
		'link_text' => 'My Account',
	), $params));
	# output buffer start
	ob_start(); ?>
    <a class="wplrf-account-btn"><?php echo strip_tags(apply_filters( 'wplrf_account_btn_text', $link_text )); ?></a>
    <?php
    # output buffer end
    return ob_get_clean();
}
# add shortcode
add_shortcode('wplrf-account-link', 'wplrf_account_shortcode_callback');
?>