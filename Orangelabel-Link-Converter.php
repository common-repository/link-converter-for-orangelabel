<?php

/**
 *
 * @package   Orangelabel_link_converter
 * @author    Arjan Pronk <arjan.pronk@zeef.com>
 * @license   GPL-2.0+
 * @link      http://linkpizza.com
 *
 * @wordpress-plugin
 * Plugin Name:       Link Converter for Orangelabel
 * Plugin URI:        http://orangelabel.zanox.com/home/
 * Description:       Automatically change outgoing links to Orangelabel links to your content
 * Version:           1.0.1
 * Author:            Arjan Pronk
 * Author URI:        arjan.pronk@linkpizza.com
 * Text Domain:       orangelabel-link-converter
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /lang
 *
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-Orangelabel-Link-Converter-activator.php
 */
function activate_Orangelabel_Link_Converter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-Orangelabel-Link-Converter-activator.php';
	Orangelabel_Link_Converter_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-Orangelabel-Link-Converter-deactivator.php
 */
function deactivate_Orangelabel_Link_Converter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-Orangelabel-Link-Converter-deactivator.php';
	Orangelabel_Link_Converter_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_Orangelabel_Link_Converter' );
register_deactivation_hook( __FILE__, 'deactivate_Orangelabel_Link_Converter' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-Orangelabel-Link-Converter.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_Orangelabel_Link_Converter() {

	$plugin = new Orangelabel_Link_Converter();
	$plugin->run();

}
run_Orangelabel_Link_Converter();


define('ORANGELABEL_LINK_CONVERTER_BASE_FILE', plugin_basename( __FILE__ ));
