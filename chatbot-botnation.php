<?php
    /*
    Plugin Name: Chatbot Botnation
    Description: Create easily your own AI chatbot for Word Press powered by Botnation AI. Free chatbot building platform.
    Author: <a href='https://botnation.ai'>Botnation AI</a>
    Version: 1.3.3
    Text Domain: chatbot-botnation
    Domain Path: /languages
    */
    defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

    require_once plugin_dir_path(__FILE__) . 'includes/bnai-cb-constants.php';
    require_once plugin_dir_path(__FILE__) . 'includes/bnai-cb-administration.php';
    require_once plugin_dir_path(__FILE__) . 'includes/bnai-cb-page-options.php';
    require_once plugin_dir_path(__FILE__) . 'includes/bnai-cb-injector.php';



    function bnai_cb_load_plugin_textdomain() {
        $plugin_rel_path = basename( dirname( __FILE__ ) ) . '/languages'; /* Relative to WP_PLUGIN_DIR */
        load_plugin_textdomain( 'chatbot-botnation', FALSE, $plugin_rel_path );
    }
    add_action( 'plugins_loaded', 'bnai_cb_load_plugin_textdomain' );

?>