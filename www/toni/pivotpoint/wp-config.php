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
define('AUTH_KEY', 'L{eJ+hc/}U)lT&aam+i/_4rH0|gY1-_5z*hQlj$9`l)Z+:h8,ex[ww fd&y[LUxH'); // Cambia esto por tu frase aleatoria.
define('SECURE_AUTH_KEY', 'NG|c7+(T&+4f?t-<yu$>Qhd</O*$`-E<66Jy9P}!vl{J2[g$j1+=!n~ |+e`8oRw'); // Cambia esto por tu frase aleatoria.
define('LOGGED_IN_KEY', 'AnyIC|+hy6`p0(sQ IvS_Q;w}fPd~J4P 3j1l<VyV*xU P6e~u[(aG`z1kx=?m}s'); // Cambia esto por tu frase aleatoria.
define('NONCE_KEY', '~x-$)}@yT%FOB|aF$/{;IWdK]Mwkg%Rhq>n2}R&`86P P<4Hm2AX|h3J{+G52U-l'); // Cambia esto por tu frase aleatoria.
define('AUTH_SALT', '#0f~E=uneT?<7OGy[mDk=wE@)p*0[s~ W >+G;H%ijyet4NE!Vm^Htjrh+B BOa,'); // Cambia esto por tu frase aleatoria.
define('SECURE_AUTH_SALT', 'g# F|]v@+]-t+ c++SgV7eE-]FzI-45ofGe{;!dW:S1Q<DIWS3Q6#{;m2~<|h6p/'); // Cambia esto por tu frase aleatoria.
define('LOGGED_IN_SALT', 'UHqg:UZqCS- f[t|,2ZC.h; =eSZTLi53N;^ED@yXh=HpFU9c6S8oqSvP)g|o=z!'); // Cambia esto por tu frase aleatoria.
define('NONCE_SALT', '-CJ8}MqC,1Se~Bl-R<Wj-+LUJpZ._/A%0g=9j3Gf9U8#:drxS d:[$+6g:?}u(<K'); // Cambia esto por tu frase aleatoria.

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
define ('TP_PUBLICATION_SYSTEM','disable');



/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

