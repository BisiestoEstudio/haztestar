<?php

namespace BIS_Core;

/**
 * Class Loader
 * Clase que se ocupa de cargar todos los archivos necesarios para el funcionamiento del plugin.
 *
 * @package BIS_Core
 */

class Loader
{

    private static $instance = null;


    /**
     * Crea una estancia única de la clase
     * @return $instance of the class
     */
    public static function init()
    {
        if(null === self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }



    private function __construct()
    {
        require_once 'config.php';
        $this->load_text_domain();
        if($this->check_dependencies()){
            $this->load_files();
        }
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }


    /**
     * Comprueba que las dependencias del plugin sean correctas.
     */
    private function check_dependencies()
    {
        $has_dependencies = true;

        //Include here the dependencies checks.

        return $has_dependencies;

    }


    /**
     * Carga el text domain
     */
    private function load_text_domain()
    {
        load_plugin_textdomain('haztestar-core', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }



    /**
     * Carga todos los archivos requeridos por el plugin
     */
    private function load_files(){
        //Write here the require_once statements.
		require_once 'class-api_hercesa.php';
		require_once 'class-service_controller.php';
		require_once 'class-order.php';

    }

    /**
     * Encola los scripts necesarios.
     */
    public function enqueue_scripts(){
        //Write here the wp_enqueue_scripts statements.

    }

}