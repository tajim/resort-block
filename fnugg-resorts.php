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
 * @package           fnugg-resorts
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */


// If this file is called directly, abort
if ( ! defined ( 'WPINC' )) {
	die;
}

define( 'FNUGG_RESORTS_VERSION', '1.0.0' );
define( 'FNUGG_RESORTS_URL', untrailingslashit( plugins_url(  '', __FILE__ ) ) );
define( 'FNUGG_RESORTS_PATH', dirname( __FILE__ ) );

/* The core plugin file that is used to run the entire plugin*/
require_once FNUGG_RESORTS_PATH . '/inc/fnugg-init.php';
require_once FNUGG_RESORTS_PATH . '/inc/fnugg-api-class.php';