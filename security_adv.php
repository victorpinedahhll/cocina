<?php
// =============================
// FUNCIONES EXTRAS DE SEGURIDAD
// =============================

// PDO o MYSQLI BIND_PARAM no protege de otros riesgos, como:
// Cross-Site Scripting (XSS) si imprimes datos sin filtrar en HTML
// Lógica rota si el dato es inesperado (ejemplo, alguien manda un array donde esperas un string)
// Manejo de tipos incorrectos, como pasar letras donde esperas un número


/**
 * Sanitiza cualquier input (string)
 */
function limpiarEntrada($input) {
    if (!is_string($input)) return $input;

    // Opcional: eliminar etiquetas HTML
    $input = strip_tags($input);
    
    // Elimina espacios en blanco extremos
    $input = trim($input);

    return $input;
}

/**
 * Obtiene un valor de $_POST de forma segura
 */
function get_post($key, $default = null) {
    return isset($_POST[$key]) ? limpiarEntrada($_POST[$key]) : $default;
}

/**
 * Obtiene un valor de $_GET de forma segura
 */
function get_get($key, $default = null) {
    return isset($_GET[$key]) ? limpiarEntrada($_GET[$key]) : $default;
}

/**
 * Valida un número entero desde $_POST
 */
function post_int($key, $default = null) {
    return filter_input(INPUT_POST, $key, FILTER_VALIDATE_INT) ?? $default;
}

/**
 * Valida un número entero desde $_GET
 */
function get_int($key, $default = null) {
    return filter_input(INPUT_GET, $key, FILTER_VALIDATE_INT) ?? $default;
}

/**
 * Valida un email desde $_POST
 */
function post_email($key, $default = null) {
    return filter_input(INPUT_POST, $key, FILTER_VALIDATE_EMAIL) ?? $default;
}

/**
 * Valida un email desde $_GET
 */
function get_email($key, $default = null) {
    return filter_input(INPUT_GET, $key, FILTER_VALIDATE_EMAIL) ?? $default;
}

/**
 * Obtiene un valor de $_REQUEST de forma segura
 */
function get_request($key, $default = null) {
    if (isset($_POST[$key])) {
        return limpiarEntrada($_POST[$key]);
    } elseif (isset($_GET[$key])) {
        return limpiarEntrada($_GET[$key]);
    } else {
        return $default;
    }
}

?>