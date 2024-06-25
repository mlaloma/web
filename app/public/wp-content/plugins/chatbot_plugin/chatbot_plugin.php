<?php
/*
Plugin Name: Chatbot Plugin
Description: Plugin para integrar un chatbot en WordPress.
Version: 1.0
Author: Miguel Laloma
*/

// Función para registrar los scripts y estilos del chatbot
function my_chatbot_enqueue_assets() {
    wp_enqueue_style('my-chatbot-css', plugins_url('assets/css/chatbot.css', __FILE__));
    wp_enqueue_script('my-chatbot-js', plugins_url('assets/js/chatbot.js', __FILE__), array('jquery'), null, true);
    wp_localize_script('my-chatbot-js', 'chatbot_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'my_chatbot_enqueue_assets');

// Función para manejar las solicitudes del chatbot
function handle_chatbot_request() {
    $user_input = $_POST['message'];
    $api_url = 'http://localhost:5000/get_response'; // URL del servicio Flask

    //añadir un error tipo chat desactivado o en mantenimiento cuando falle el puerto
    $response = wp_remote_post($api_url, array(
        'method'    => 'POST',
        'body'      => json_encode(array('message' => $user_input)),
        'headers'   => array(
            'Content-Type' => 'application/json',
        ),
    ));

    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        echo json_encode(array('response' => "Something went wrong: $error_message"));
    } else {
        $body = wp_remote_retrieve_body($response);
        echo $body;
    }

    wp_die();
}
add_action('wp_ajax_nopriv_get_chatbot_response', 'handle_chatbot_request');
add_action('wp_ajax_get_chatbot_response', 'handle_chatbot_request');

// Función para mostrar el chatbot
function my_chatbot_display() {
    include(plugin_dir_path(__FILE__) . 'templates/chatbot.html');
}
//add_shortcode('my_chatbot', 'my_chatbot_display');
add_action('wp_footer', 'my_chatbot_display');

// Función para iniciar el servicio Flask utilizando PowerShell en Windows
function activate_my_chatbot_plugin() {
    // Ruta al script de inicio del servicio
    $script_path = plugin_dir_path(__FILE__) . 'includes/chatbot_start.ps1';

    // Comando para ejecutar el script de inicio del servicio
    $command = 'powershell.exe -ExecutionPolicy Bypass -File "' . $script_path . '"';
    
    // Ejecutar el comando
    exec($command, $output, $status);
    
    // Verificar el estado de ejecución
    if ($status !== 0) {
        error_log('Error al iniciar el servicio Flask: ' . implode("\n", $output));
    }
}

// Registrar la función de activación del plugin
register_activation_hook(__FILE__, 'activate_my_chatbot_plugin');
