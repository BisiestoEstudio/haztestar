<?php

/**
 * @link              https://https://bisiesto.es/
 * @since             1.0.0
 *
 * @wordpress-plugin
 * Plugin Name: 	  Haztestar Core
 * Plugin URI:        https://bisiesto.es/
 * Description:       Plugin que conecta la instalación de Haztestar con la plataforma de Hercesa.
 * Version:           1.0.0
 * Author:            Bisiesto
 * Author URI:        https://bisiesto.es/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       haztestar-core
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}



/********************************************************
    ACTIVATION AND DEACTIVATION
********************************************************/

/**
 * Función ejecutada en la activación del plugin.
 */
function BIS_Core_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-activator.php';
	BIS_Core\Activator::activate();
}

/**
 * Función ejecutada en la desactivación del plugin.
 */
function BIS_Core_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-deactivator.php';
	BIS_Core\Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'BIS_Core_activate' );
register_deactivation_hook( __FILE__, 'BIS_Core_deactivate' );



/********************************************************
    INIT PLUGIN
 ********************************************************/

/**
 * Inicialización del plugin.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-loader.php';

BIS_Core\Loader::init();


