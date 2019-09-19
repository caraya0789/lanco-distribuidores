<?php
/**
 * Plugin Name:     Lanco Distribuidores
 * Plugin URI:      http://lancopaints.com
 * Description:     Administrador para los distribuidores de lanco paints
 * Author:          Cristian Araya J.
 * Author URI:      http://teahdigital.com
 * Text Domain:     lanco-distribuidores
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Lanco_Distribuidores
 */
require_once __DIR__ . '/vendor/autoload.php';

define('LANDIST_PATH', __DIR__);
define('LANDIST_VERSION', '0.1.0');

function landist_get_plugin_object() {
	return \Lanco\Distribuidores::get_instance();
}

add_action( 'plugins_loaded', [ landist_get_plugin_object(), 'hooks' ] );