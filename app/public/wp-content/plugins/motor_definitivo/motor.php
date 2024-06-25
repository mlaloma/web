<?php
/**
 * Plugin Name: Motor de recomendación de productos
 * Description: Plugin para recopilar preferencias de usuario y construir perfiles para recomendaciones personalizadas de smartwatches.
 * Version: 1.0
 * Author: Miguel Laloma
 * License: GPL-2.0+
 */

// Función para obtener valores únicos para un atributo específico
function get_unique_attribute_values($taxonomy) {
    global $wpdb;

    $query = "SELECT DISTINCT name 
              FROM {$wpdb->terms} t 
              INNER JOIN {$wpdb->term_taxonomy} tt ON t.term_id = tt.term_id 
              WHERE tt.taxonomy = %s";

    $results = $wpdb->get_results($wpdb->prepare($query, $taxonomy));

    $values = array();
    foreach ($results as $result) {
        $values[] = $result->name;
    }

    return $values;
}

// Función para obtener valores únicos para todos los atributos
function get_all_unique_attribute_values() {
    global $wpdb;

    // Obtener marcas (categorías de productos)
    $query_marcas = "SELECT t.term_id, t.name
                     FROM {$wpdb->terms} t
                     INNER JOIN {$wpdb->term_taxonomy} tt ON t.term_id = tt.term_id
                     WHERE tt.taxonomy = 'product_cat'";
    $results_marcas = $wpdb->get_results($query_marcas);

    $marcas = array();
    foreach ($results_marcas as $marca) {
        $marcas[] = $marca->name;
    }

    $values = array(
        'marca' => $marcas,
        'forma_esfera' => get_unique_attribute_values('pa_forma-de-la-esfera'),
        'color_correa' => get_unique_attribute_values('pa_color-de-la-correa'),
        'material_correa' => get_unique_attribute_values('pa_material-de-la-correa'),
        'pantalla_tactil' => array('Si', 'No'),
        'vida_bateria' => array(),
        'bluetooth' => array('Si', 'No'),
        'tamano_pantalla' => array(),
        'peso' => array(),
        'precio' => array()
    );

    return $values;
}

// Función para renderizar el formulario de preferencias
function swp_render_preferences_form() {
    // Obtener el ID del usuario actual
    $user_id = get_current_user_id();

    // Obtener las preferencias actuales del usuario
    $preferencia_marca = get_user_meta($user_id, 'preferencia_marca', true);
    $preferencia_forma_esfera = get_user_meta($user_id, 'preferencia_forma_esfera', true);
    $preferencia_color_correa = get_user_meta($user_id, 'preferencia_color_correa', true);
    $preferencia_material_correa = get_user_meta($user_id, 'preferencia_material_correa', true);
    $preferencia_pantalla_tactil = get_user_meta($user_id, 'preferencia_pantalla_tactil', true);
    $preferencia_vida_bateria = get_user_meta($user_id, 'preferencia_vida_bateria', true);
    $preferencia_bluetooth = get_user_meta($user_id, 'preferencia_bluetooth', true);
    $preferencia_tamano_pantalla = get_user_meta($user_id, 'preferencia_tamano_pantalla', true);
    $preferencia_peso = get_user_meta($user_id, 'preferencia_peso', true);
    $preferencia_precio = get_user_meta($user_id, 'preferencia_precio', true);

    // Obtener todos los valores únicos para los atributos
    $attribute_values = get_all_unique_attribute_values();

    // HTML del formulario
    ob_start();
    ?>
    <form method="post" action="" class="swp-preferences-form">
        <table class="form-table">
            <tr>
                <th><label for="preferencia_marca">Marca</label></th>
                <td>
                    <select name="preferencia_marca" id="preferencia_marca">
                        <option value="">Selecciona una opción</option>
                        <?php foreach ($attribute_values['marca'] as $value) : ?>
                            <option value="<?php echo esc_attr($value); ?>" <?php selected($preferencia_marca, $value); ?>><?php echo esc_html($value); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="preferencia_forma_esfera">Forma de la Esfera</label></th>
                <td>
                    <select name="preferencia_forma_esfera" id="preferencia_forma_esfera">
                        <option value="">Selecciona una opción</option>
                        <?php foreach ($attribute_values['forma_esfera'] as $value) : ?>
                            <option value="<?php echo esc_attr($value); ?>" <?php selected($preferencia_forma_esfera, $value); ?>><?php echo esc_html($value); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="preferencia_color_correa">Color de la Correa</label></th>
                <td>
                    <select name="preferencia_color_correa" id="preferencia_color_correa">
                        <option value="">Selecciona una opción</option>
                        <?php foreach ($attribute_values['color_correa'] as $value) : ?>
                            <option value="<?php echo esc_attr($value); ?>" <?php selected($preferencia_color_correa, $value); ?>><?php echo esc_html($value); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="preferencia_material_correa">Material de la Correa</label></th>
                <td>
                    <select name="preferencia_material_correa" id="preferencia_material_correa">
                        <option value="">Selecciona una opción</option>
                        <?php foreach ($attribute_values['material_correa'] as $value) : ?>
                            <option value="<?php echo esc_attr($value); ?>" <?php selected($preferencia_material_correa, $value); ?>><?php echo esc_html($value); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="preferencia_pantalla_tactil">Pantalla Táctil</label></th>
                <td>
                    <select name="preferencia_pantalla_tactil" id="preferencia_pantalla_tactil">
                        <option value="">Selecciona una opción</option>
                        <?php foreach ($attribute_values['pantalla_tactil'] as $value) : ?>
                            <option value="<?php echo esc_attr($value); ?>" <?php selected($preferencia_pantalla_tactil, $value); ?>><?php echo esc_html($value); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="preferencia_vida_bateria">Vida de la Batería (días)</label></th>
                <td><input type="text" name="preferencia_vida_bateria" id="preferencia_vida_bateria" value="<?php echo esc_attr($preferencia_vida_bateria); ?>" class="regular-text"></td>
            </tr>
            <tr>
                <th><label for="preferencia_bluetooth">Bluetooth</label></th>
                <td>
                    <select name="preferencia_bluetooth" id="preferencia_bluetooth">
                        <option value="">Selecciona una opción</option>
                        <?php foreach ($attribute_values['bluetooth'] as $value) : ?>
                            <option value="<?php echo esc_attr($value); ?>" <?php selected($preferencia_bluetooth, $value); ?>><?php echo esc_html($value); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="preferencia_tamano_pantalla">Tamaño de Pantalla (pulgadas)</label></th>
                <td><input type="text" name="preferencia_tamano_pantalla" id="preferencia_tamano_pantalla" value="<?php echo esc_attr($preferencia_tamano_pantalla); ?>" class="regular-text"></td>
            </tr>
            <tr>
                <th><label for="preferencia_peso">Peso</label></th>
                <td><input type="text" name="preferencia_peso" id="preferencia_peso" value="<?php echo esc_attr($preferencia_peso); ?>" class="regular-text"></td>
            </tr>
            <tr>
                <th><label for="preferencia_precio">Precio</label></th>
                <td><input type="text" name="preferencia_precio" id="preferencia_precio" value="<?php echo esc_attr($preferencia_precio); ?>" class="regular-text"></td>
            </tr>
        </table>
        <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Guardar Preferencias"></p>
    </form>
    <?php
    return ob_get_clean();
}

// Mostrar el formulario
function swp_display_preferences_page() {
    // Verificar si el usuario está logueado
    if (is_user_logged_in()) {
        // Mostrar el formulario de preferencias
        echo '<div class="swp-preferences-form">';
        echo swp_render_preferences_form();
        echo '</div>';

    // Procesar el formulario cuando se envía
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        $user_id = get_current_user_id();
        update_user_meta($user_id, 'preferencia_marca', sanitize_text_field($_POST['preferencia_marca']));
        update_user_meta($user_id, 'preferencia_forma_esfera', sanitize_text_field($_POST['preferencia_forma_esfera']));
        update_user_meta($user_id, 'preferencia_color_correa', sanitize_text_field($_POST['preferencia_color_correa']));
        update_user_meta($user_id, 'preferencia_material_correa', sanitize_text_field($_POST['preferencia_material_correa']));
        update_user_meta($user_id, 'preferencia_pantalla_tactil', sanitize_text_field($_POST['preferencia_pantalla_tactil']));
        update_user_meta($user_id, 'preferencia_vida_bateria', sanitize_text_field($_POST['preferencia_vida_bateria']));
        update_user_meta($user_id, 'preferencia_bluetooth', sanitize_text_field($_POST['preferencia_bluetooth']));
        update_user_meta($user_id, 'preferencia_tamano_pantalla', sanitize_text_field($_POST['preferencia_tamano_pantalla']));
        update_user_meta($user_id, 'preferencia_peso', sanitize_text_field($_POST['preferencia_peso']));
        update_user_meta($user_id, 'preferencia_precio', sanitize_text_field($_POST['preferencia_precio']));

        //echo '<div class="updated"><p>Preferencias actualizadas correctamente.</p></div>';
    }

    } else {
        echo '<p>Debes iniciar sesión para acceder a tus preferencias de smartwatches.</p>';
    }
}

// Shortcode para mostrar el formulario en una página
function swp_preferences_shortcode() {
    ob_start();
    swp_display_preferences_page();
    return ob_get_clean();
}
add_shortcode('swp_preferences', 'swp_preferences_shortcode');

// Función para convertir valores decimales a formato WooCommerce (1.2 -> 1-2)
function convert_decimal_to_woocommerce_format($value) {
    return str_replace(array('.', ','), '-', $value);
}

function calculate_product_score($product, $user_preferences){
    $product_score = 0;
    if (!is_user_logged_in()){
        return $product_score;
    }
    $product_attributes = explode(', ', $product->attributes);

    // Compara cada atributo del producto con las preferencias del usuario y calcula la puntuación
    // Quitar los puntajes individuales.
    foreach ($product_attributes as $attribute) {
        list($value, $taxonomy) = explode(':', $attribute);
        $value = strtolower(trim($value)); // Normalizar el valor del atributo para la comparación
        $taxonomy = strtolower(trim($taxonomy)); // Normalizar la taxonomía para la comparación

        // Mostrar valores para depuración
        error_log("Comparando atributo $taxonomy con valor $value contra la preferencia del usuario");

        // Modificar peso de cada categoría??
        switch ($taxonomy) {
            case 'pa_forma-de-la-esfera':
                if (!empty($user_preferences['forma_esfera']) && $value == strtolower($user_preferences['forma_esfera'])) {
                    $product_score++;
                }
                break;
            case 'pa_color-de-la-correa':
                if (!empty($user_preferences['color_correa']) && $value == strtolower($user_preferences['color_correa'])) {
                    $product_score++;
                }
                break;
            case 'pa_material-de-la-correa':
                if (!empty($user_preferences['material_correa']) && $value == strtolower($user_preferences['material_correa'])) {
                    $product_score++;
                }
                break;
            case 'pa_pantalla-tactil':
                if (!empty($user_preferences['pantalla_tactil']) && $value == strtolower($user_preferences['pantalla_tactil'])) {
                    $product_score++;
                }
                break;
            case 'pa_vida-de-la-bateria-dias':
                if (!empty($user_preferences['vida_bateria']) && $value == convert_decimal_to_woocommerce_format(strtolower($user_preferences['vida_bateria']))) {
                    $product_score++;
                }
                break;
            case 'pa_bluetooth':
                if (!empty($user_preferences['bluetooth']) && $value == strtolower($user_preferences['bluetooth'])) {
                    $product_score++;
                }
                break;
            case 'pa_tamano-de-pantalla':
                if (!empty($user_preferences['tamano_pantalla']) && $value == convert_decimal_to_woocommerce_format(strtolower($user_preferences['tamano_pantalla']))) {
                    $product_score++;
                }
                break;
            case 'product_cat':
                if (!empty($user_preferences['marca']) && $value == strtolower($user_preferences['marca'])) {
                    $product_score++;
                }
                break;
        }
    }

    // Comparar el peso (considerando un margen de tolerancia)
    if (!empty($user_preferences['peso']) && (abs(floatval($product->weight) - floatval($user_preferences['peso']))) < 0.1) {
        $product_score++;
    }

    // Comparar el precio (considerando un margen de tolerancia)
    if (!empty($user_preferences['precio']) && (abs(floatval($product->price) <= (floatval($user_preferences['precio']))) + 10)) {
        $product_score++;
    }

    return $product_score;
}

function obtener_valoraciones_por_id_producto($product_id) {
    global $wpdb;

    $query = $wpdb->prepare("
    SELECT 
        cm.meta_value AS rating
    FROM 
        {$wpdb->prefix}posts p
    JOIN 
        {$wpdb->prefix}comments c ON p.ID = c.comment_post_ID
    JOIN 
        {$wpdb->prefix}commentmeta cm ON c.comment_ID = cm.comment_id AND cm.meta_key = 'rating'
    WHERE 
        p.ID = %d
        AND p.post_type = 'product'
        AND c.comment_type = 'review'
        AND c.comment_approved = 1
    ", $product_id);

    $results = $wpdb->get_results($query, ARRAY_A);

    // Inicializar el array de ratings con valores iniciales de 0 para cada rating del 1 al 5
    $ratings = array_fill(0, 5, 1);

    // Contar la cantidad de veces que se ha dado cada rating
    foreach ($results as $row) {
        $rating = intval($row['rating']);
        $ratings[$rating-1]++;
    }

    return $ratings;
}

// Función para calcular la puntuación bayesiana
function calculate_bayesian_score($ratings) {
    $K = 5; // Número de posibles valoraciones
    $z = 1.96; // Cuantil para α=0.05
    $N = array_sum($ratings); // Número total de valoraciones

    if ($N == 0) {
        return 0; // Evitar división por cero si no hay valoraciones
    }

    $sum_sk_nk = 0;
    $sum_sk2_nk = 0;

    for ($k = 1; $k <= $K; $k++) {
        //$sum_sk_nk += $k * $ratings[$k - 1];
        //$sum_sk2_nk += $k * $k * $ratings[$k - 1];
        $sum_sk_nk += $k * ($ratings[$k - 1] + 1);
        $sum_sk2_nk += $k * $k * ($ratings[$k - 1] + 1);
    }

    //$mean = ($sum_sk_nk + 1) / ($N + $K);
    //$variance = (($sum_sk2_nk + 1) / ($N + $K)) - (($sum_sk_nk + 1) / ($N + $K)) ** 2;
    $mean = ($sum_sk_nk) / ($N + $K);
    $variance = (($sum_sk2_nk) / ($N + $K)) - $mean ** 2;
    $standard_deviation = sqrt($variance);

    $bayes_score = $mean - ($z * $standard_deviation) / sqrt($N + $K + 1);

    return $bayes_score;
}

function swp_get_recommended_products($user_preferences) {
    global $wpdb;

    $query = "
    SELECT 
        p.ID as product_id, 
        p.post_title as product_name,
        MAX(CASE WHEN pm.meta_key = '_weight' THEN pm.meta_value ELSE NULL END) as weight,
        MAX(CASE WHEN pm.meta_key = '_price' THEN pm.meta_value ELSE NULL END) as price,
        MAX(CASE WHEN pm.meta_key = '_wc_average_rating' THEN pm.meta_value ELSE NULL END) as average_rating,
        MAX(CASE WHEN pm.meta_key = '_wc_review_count' THEN pm.meta_value ELSE NULL END) as review_count,
        GROUP_CONCAT(DISTINCT CONCAT(t.slug, ':', tt.taxonomy) SEPARATOR ', ') as attributes
    FROM 
        wp_posts p
    JOIN 
        wp_postmeta pm ON p.ID = pm.post_id
    LEFT JOIN 
        wp_term_relationships tr ON p.ID = tr.object_id
    LEFT JOIN 
        wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
    LEFT JOIN 
        wp_terms t ON tt.term_id = t.term_id
    WHERE 
        p.post_type = 'product'
        AND (tt.taxonomy LIKE 'pa_%' OR tt.taxonomy = 'product_cat')
    GROUP BY 
        p.ID, p.post_title";

    $products = $wpdb->get_results($query);

    $recommended_products = array();
    // Peso asignado a cada parte de la puntación [POR DEFINIR]
    $P = 0.5;
    // Hay que poner ambos scores en base 10 para que sean comparables
    foreach ($products as $product) {
        $ratings = obtener_valoraciones_por_id_producto($product->product_id);
        $product_score = calculate_product_score($product, $user_preferences);
        $bayes_score = calculate_bayesian_score($ratings);
        $score = $product_score * $P + $bayes_score * (1 - $P);
        $recommended_products[] = array(
            'product_id' => $product->product_id,
            'product_name' => $product->product_name,
            'product_score' => $product_score,
            'bayes_score' => $bayes_score,
            'score' => $score
        );
    }

    return $recommended_products;
}

function swp_display_recommended_products() {
    // Obtener el ID del usuario actual
    $user_id = get_current_user_id();

    // Obtener las preferencias actuales del usuario
    $user_preferences = array(
        'marca' => get_user_meta($user_id, 'preferencia_marca', true),
        'forma_esfera' => get_user_meta($user_id, 'preferencia_forma_esfera', true),
        'color_correa' => get_user_meta($user_id, 'preferencia_color_correa', true),
        'material_correa' => get_user_meta($user_id, 'preferencia_material_correa', true),
        'pantalla_tactil' => get_user_meta($user_id, 'preferencia_pantalla_tactil', true),
        'vida_bateria' => get_user_meta($user_id, 'preferencia_vida_bateria', true),
        'bluetooth' => get_user_meta($user_id, 'preferencia_bluetooth', true),
        'tamano_pantalla' => get_user_meta($user_id, 'preferencia_tamano_pantalla', true),
        'peso' => get_user_meta($user_id, 'preferencia_peso', true),
        'precio' => get_user_meta($user_id, 'preferencia_precio', true)
    );

    // Obtener productos recomendados
    $recommended_products = swp_get_recommended_products($user_preferences);

    // Ordenar productos por puntuación de coincidencia
    usort($recommended_products, function($a, $b) {
        return bccomp($b['score'], $a['score'], 14); // 14 es la precisión deseada
    });
    
    // Mostrar productos recomendados
    if (!empty($recommended_products)) {
        // Mostrar los 8 productos mejor valorados
        echo '<div class="productos-mejor-valorados">';
        for ($i = 0; $i < min(8, count($recommended_products)); $i++) {
            $product = $recommended_products[$i];
            $post = get_post($product['product_id']);
            $permalink = get_permalink($product['product_id']);
            $precio = get_post_meta($product['product_id'], '_price', true);
            $imagen_id = get_post_thumbnail_id($product['product_id']);
            $imagen_url = wp_get_attachment_url($imagen_id);
            $average_rating = get_post_meta($product['product_id'], '_wc_average_rating', true);
            $review_count = get_post_meta($product['product_id'], '_wc_review_count', true);
        
            echo '<div class="producto">';
            echo '<a href="' . esc_url($permalink) . '">';
            if ($imagen_url) {
                echo '<img src="' . esc_url($imagen_url) . '" alt="' . esc_attr($post->post_title) . '">';
            }
            echo '<h3>' . esc_html($post->post_title) . '</h3>';
            echo '</a>';
            echo '<p>Precio: ' . esc_html($precio) . ' €</p>';
            echo '<p>Valoración: ' . esc_html($average_rating) . ' (' . esc_html($review_count) . ' reseñas)</p>';
            echo '<p>Puntuación Producto: ' . esc_html($product['product_score']) . '</p>';
            echo '<p>Puntuación Bayes: ' . esc_html($product['bayes_score']) . '</p>';
            echo '<p>Puntuación: ' . esc_html($product['score']) . '</p>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<p>No se encontraron productos que coincidan con tus preferencias.</p>';
    }
}

// Shortcode para mostrar productos recomendados en una página
function swp_recommendations_shortcode() {
    ob_start();
    swp_display_recommended_products();
    return ob_get_clean();
}
add_shortcode('swp_recommendations', 'swp_recommendations_shortcode');

// Enqueue styles and scripts
function swp_enqueue_styles() {
    wp_enqueue_style('swp-styles', plugins_url('css/styles.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'swp_enqueue_styles');
?>