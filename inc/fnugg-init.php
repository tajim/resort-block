<?php
/*
* Main file to run the plugin
* 
* @since 1.0.0
*
 * @package           fnugg-resorts
*/
function fnugg_resorts_block_init() {
	register_block_type( 
		FNUGG_RESORTS_PATH . '/build',
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
	
	if (!isset($attr['selected_ski']) && current_user_can( 'edit_posts' )) {
		return '<p class="fnugg-alert">' .esc_html('Please select a resort.', 'fnugg-resorts'). '</p>';
	}	
		
	if (isset($attr['selected_ski'])) {
		$selected_ski_ed =  $attr['selected_ski'];
		$fnugg = new Fnugg_API_Wrapper();	
		return $fnugg->fnugg_render($selected_ski_ed);		
	}		

}