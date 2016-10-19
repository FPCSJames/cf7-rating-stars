<?php
/*
* Plugin Name:       Star Rating for Contact Form 7
* Description:       Add a star rating field type to Contact Form 7.
* Version:           1.0
* Author:            James M. Joyce, Flashpoint Computer Services, LLC
* Author URI:        http://www.flashpointcs.net
* License:           MIT
* License URI:       https://fpcs.mit-license.org
*/

if(defined('WPCF7_VERSION') && WPCF7_VERSION) {
	add_action('wpcf7_init', 'ratingstars_add_cf7_shortcode');
	add_action('wp_enqueue_scripts', 'ratingstars_add_custom_css', 11);
}

function ratingstars_add_cf7_shortcode() {
	wpcf7_add_shortcode('ratingstars', 'ratingstars_cf7_shortcode_handler', true);
}

function ratingstars_cf7_shortcode_handler( $tag ) {
	$tag = new WPCF7_Shortcode($tag);
	$name = wpcf7_format_atts(array('name' => $tag->name));
	
	$html = '<div class="wpcf7-star-rating">'."\n";
	for($i = 5; $i >= 1; $i--) {
		$html .= sprintf(
			'<input type="radio" id="wpcf7-star-r%1$d" value="%1$d Stars" %2$s>',
			$i, $name
		);
		$html .= "\n".'<label for="wpcf7-star-r'.$i.'">'.$i.' Stars</label>'."\n";
	}
	$html .= '</div>';
	
	return $html;
}

function ratingstars_add_custom_css() {
	$stars = plugins_url('stars.png', __FILE__);
	$css = '.wpcf7-star-rating{float:left}.wpcf7-star-rating input{position:absolute;top:-9999px}.wpcf7-star-rating label{float:right;display:block;font-size:0;width:24px;height:24px;background:url('.$stars.') 0 -24px}.wpcf7-star-rating label:hover{cursor:pointer}.wpcf7-star-rating label:hover,.wpcf7-star-rating label:hover ~ label,.wpcf7-star-rating input:checked ~ label{background-position:0 0}';
	wp_add_inline_style('contact-form-7', $css);
}