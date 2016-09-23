<?php
/**
 * @package Fusion_Extension_Comments
 */

/**
 * Comments Template Extension.
 *
 * Function for adding the WordPress Comments section.
 *
 * @since 1.0.0
 */

/**
 * Map Shortcode
 */

add_action('init', 'fsn_init_comments', 12);
function fsn_init_comments() {	
			
	if (function_exists('fsn_map')) {
		fsn_map(array(
			'name' => __('Comments', 'fusion-extension-comments'),
			'shortcode_tag' => 'fsn_comments',
			'description' => __('Add comments section. Displays a field for users to input comments.', 'fusion-extension-comments'),
			'icon' => 'comment'
		));
	}
}

/**
 * Output Shortcode
 */

function fsn_comments_shortcode( $atts, $content = null ) {
	
	$output = '<div class="fsn-comments '. fsn_style_params_class($atts) .'">';
		ob_start();
		comments_template();
		$output .= ob_get_clean();
	$output .= '</div>';
	
	return $output;
}

add_shortcode( 'fsn_comments', 'fsn_comments_shortcode' );

?>