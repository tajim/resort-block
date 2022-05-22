<?php
/**
 * Plugin Name:       Fnugg Resorts
 * Description:       A custom plugin which shows available ski resorts details from fnugg.no API
 * Requires at least: 5.8
 * Requires PHP:      7.0
 * Version:           1.0.0
 * Author:            Mohammad Tajim
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       fnugg-resorts
 *
 * @package           awesome-blocks
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */


function fnugg_resorts_block_init() {
	register_block_type( 
		__DIR__ . '/build',
		array(
			'render_callback' => 'fnugg_block_render_callback',
			'attributes' => array(
				"content" => array(
					"type" => "object"
				),				
				'selected_ski' => array(
					'type' => 'string'
				),
				"blockId" => array(
				  "type" => "string"
				),
				"skicount" => array(
				  "type" => "number"
				)				
			)					
		)		
	);
}
add_action( 'init', 'fnugg_resorts_block_init' );

function fnugg_block_render_callback( $attr, $content ) {	
		
	if (isset($attr['selected_ski'])) {
		$selected_ski_ed =  $attr['selected_ski'];
		$fnugg = new Fnugg_API_Wrapper();	
		return $fnugg->fnugg_render($selected_ski_ed);		
	}		
	elseif ( current_user_can( 'edit_posts' ) ) {
		return '<p class="fnugg-alert">'.__('Please select a resort.', 'fnugg-resorts').'</p>';		 
	}	
	else {
	 	// show nothing
	}
}

require_once 'inc/fnugg-api-class.php'; // Fnugg API Middleware