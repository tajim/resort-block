<?php
/**
 * Fnugg Resort Render Markup
 *
 */
?>
<div class="fnugg_resort_ed">
	<h3 class="resort_name"><?php esc_html_e($resort_name); ?></h3>
	<div class="img_holder">
			<img src="<?php echo esc_url($fnugg_thumbnail); ?>" class="resort_thumb" />
			<div class="updated_date">
				<p class="label"><?php echo __('DAGENS FORHOLD', 'fnugg-resorts') ?></p>
				<p>	<?php echo __('Oppdatert:', 'fnugg-resorts') ?> <?php esc_html_e($fnugg_last_updated); ?></p>
			</div>
	</div>
	<div class="text_holder">
		<div class="resort_detail condition">
			<img src="<?php echo plugin_dir_url( __DIR__ ) . 'assets/icons/resort-weather-blue-' .esc_attr($fnugg_condition_id). '.svg'; ?>" />
			<p><?php esc_html_e($fnugg_condition); ?></p>
		</div>
		<div class="resort_detail weather">
			<p><?php esc_html_e($fnugg_weather); ?>&#176;</p>
		</div>
		<div class="resort_detail wind">			
			<img src="<?php echo plugin_dir_url( __DIR__ ) . 'assets/icons/wind.svg'; ?>" style="transform: rotate(<?php esc_html_e($fnugg_wind_degree); ?>deg);" />
			<p class="mps"><?php esc_html_e($fnugg_wind_mps); ?><span>m/s</span></p>
			<p><?php esc_html_e($fnugg_wind_name); ?> and <?php esc_html_e($fnugg_wind_speed); ?></p>
		</div>
		<div class="resort_detail ski_path">
			<img src="<?php echo plugin_dir_url( __DIR__ ) . 'assets/icons/ski_path.svg'; ?>" />		
			<p><?php esc_html_e($fnugg_snow_on_path); ?></p>
		</div>		
	</div>
</div>