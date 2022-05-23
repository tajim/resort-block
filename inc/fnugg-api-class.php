<?php
/*
* PHP class to fetch data from the FNUGG API
* 
* @since 1.0.0
*
*/

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Invalid request.' );
}

if ( ! class_exists( 'Fnugg_API_Wrapper' ) ) :

	class Fnugg_API_Wrapper {
		
		/**
		* Fnugg API URL
		*
		*/
		public $api_url;
	    
		
		public $resort_name;		
		public $sourceFields;
		
		public $response;		

		/**
		 * Constructor
		 */
		public function __construct() {	
													
			$this->sourceFields = array (
				'name',
				'images.image_full',
				'site_path',
				'conditions.combined.top.last_updated', 				
				'conditions.combined.top.symbol.fnugg_id',
				'conditions.combined.top.symbol.name',
				'conditions.combined.top.temperature.value', 
				'conditions.combined.top.wind.mps',
				'conditions.combined.top.wind.name',
				'conditions.combined.top.wind.degree',
				'conditions.combined.top.wind.speed',
				'conditions.combined.top.condition_description',
			);			
			
			$this->api_url = 'https://api.fnugg.no/search';
			
		}						
			   	
		// fetch response from API and save it to transient cache
		private function fnugg_fetch_api ( $resort_name ) {	
			
			$resort_name_slug = sanitize_title($resort_name);
			$ski_transient = get_transient( 'fnugg-transient-' . $resort_name_slug );						
			
				//check if cache exists and create if it does not exists
				if ( $ski_transient === false ) {			
						
					$args_for_get = array (			  
					  'method'  => 'GET',
					);			

					$query_args = array('q' => $resort_name, 'sourceFields' => implode(',', $this->sourceFields)  );
					$query_url = $this->api_url.'?'.http_build_query($query_args);

					$response = wp_remote_get( $query_url, $args_for_get );	

					if ( is_wp_error( $response ) ) {				
						$response_body = $request_api->get_error_message();
					} 
					elseif ( is_array( $response ) && ! is_wp_error( $response ) ) {
						$response_headers = $response['headers']; 
						$response_body    = $response['body']; 
						$response_body_arr = json_decode($response_body, true);
						set_transient( 'fnugg-transient-' . $resort_name_slug, $response_body_arr, DAY_IN_SECONDS / 2 );
						return $response_body_arr;
					}
					else {						
					}
				}
				
				// return from cache
				else {
					
					return $ski_transient;
					
				}
			
		}
		
		public function fnugg_render ( $resort_name ) {								
			
			//prepare markup for the block render
			$response_body = $this->fnugg_fetch_api($resort_name);
			$response_arr = $response_body['hits']['hits']['0']['_source'];
			
			$fnugg_condition_id 	= intval($response_arr['conditions']['combined']['top']['symbol']['fnugg_id']) ?? "";
			$fnugg_thumbnail 		= sanitize_url($response_arr['images']['image_full']) ?? "";
			$fnugg_last_updated_raw = sanitize_text_field($response_arr['conditions']['combined']['top']['last_updated']) ?? "";			
			$fnugg_condition 		= sanitize_text_field($response_arr['conditions']['combined']['top']['symbol']['name']) ?? "";
			$fnugg_weather 			= sanitize_text_field($response_arr['conditions']['combined']['top']['temperature']['value']) ?? "";		
			$fnugg_wind_mps 		= sanitize_text_field($response_arr['conditions']['combined']['top']['wind']['mps']) ?? "";
			$fnugg_wind_name 		= sanitize_text_field($response_arr['conditions']['combined']['top']['wind']['name']) ?? "";
			$fnugg_wind_degree 		= sanitize_text_field($response_arr['conditions']['combined']['top']['wind']['degree']) ?? "";
			$fnugg_wind_speed 		= sanitize_text_field($response_arr['conditions']['combined']['top']['wind']['speed']) ?? "";	
			$fnugg_snow_on_path 	= sanitize_text_field($response_arr['conditions']['combined']['top']['condition_description']) ?? "";
			
			$date = new DateTime($fnugg_last_updated_raw);
			$fnugg_last_updated = $date->format('d.m.Y - H:i');
			
			ob_start();
			
				include('resort-render-markup.php');									
			
			return ob_get_clean();
			
			
		}
		
	}

endif;
