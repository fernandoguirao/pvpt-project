<?php
/** 
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define('DB_NAME', 'pivotpoint');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'root');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', 'root');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'localhost');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8');

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '?f:W-pE`_glcHenx$$w48][b1_BkUbjKOm[7,S ?StVs7|+bC2=.5aqNQK4/Z!ce'); // Cambia esto por tu frase aleatoria.
define('SECURE_AUTH_KEY', '3of:^d?Cdar>bfF`d{w7[&+EYj!m:4FG(L5mnNm-(+1_A0-;5]E|t50SnnVHjQQ}'); // Cambia esto por tu frase aleatoria.
define('LOGGED_IN_KEY', 'D3?G.s6$bM}RuK=U+7P>Oney:Z(BJ;@b6O|[#}UdP*$*0K|zv::xEeqx=6$?u-Mv'); // Cambia esto por tu frase aleatoria.
define('NONCE_KEY', 'Z|H+FGd9#O|nbB]K<_?2K-O^?,Jm|,}(5@:h:bWF!_Q*fo=[Tn1=9YcKI,~4I[tb'); // Cambia esto por tu frase aleatoria.
define('AUTH_SALT', 'pL/|ZOc:&w~k1cc`?pL5p_D#VKXTqqTfg&1`#<Lh-c? N*(5a&p0#uK$3X|H#y:['); // Cambia esto por tu frase aleatoria.
define('SECURE_AUTH_SALT', 'JPEpiySk|weN6XvBxLU`VRv]MVlb2DQ|{{pg]8Y8p2 ;Y^dq~n-5Uh*cp_FY0vD,'); // Cambia esto por tu frase aleatoria.
define('LOGGED_IN_SALT', ',O7-nZH)Fkq0Pgm=8kEpm^P|}4||YXi}Di:P3<g4-NMp~d2j|TBPR4#rdL66tt?A'); // Cambia esto por tu frase aleatoria.
define('NONCE_SALT', '6LznE_s$h/,[sl$-A-hzkv>&hm5Q#5)SbNjn|/y>,F,#N;]#`|;RCjx-CMK+iN;>'); // Cambia esto por tu frase aleatoria.

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'wp_';

/**
 * Idioma de WordPress.
 *
 * Cambia lo siguiente para tener WordPress en tu idioma. El correspondiente archivo MO
 * del lenguaje elegido debe encontrarse en wp-content/languages.
 * Por ejemplo, instala ca_ES.mo copiándolo a wp-content/languages y define WPLANG como 'ca_ES'
 * para traducir WordPress al catalán.
 */
define('WPLANG', 'es_ES');

/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

