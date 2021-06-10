<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'traveho' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', '127.0.0.1:3308' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );


/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '/Pl7g?sCeilJ}&fDvUQcKuO;$}/=H)ZKYXT=UG6>zrLDOXCf!GA4@dO$$m~q5vB#' );
define( 'SECURE_AUTH_KEY',  '1rH#jzl^PR}e,t;P_O}m?En1Y*zWS4~zIaq925VUAG15kf3x^6j06-hKTJ%,W/FX' );
define( 'LOGGED_IN_KEY',    's>0<n36,it|Ut?k3k-JW8qgz!J+LOGVyKUy gH5<V/{rJAaiIqaj_4?r;*q:W4xd' );
define( 'NONCE_KEY',        'vvD`R$D;Dg7O5GU(0@ lW 4S7{obQ[>6?GNA?v~as`h67sr_^<;r}3Lu.*HR,VGM' );
define( 'AUTH_SALT',        'wDkQX~,PtHz|W(;|j6+cgmT=x^vV,4LU62?KB|g%V.vM7JsCIf:/$s{N54D%-F+S' );
define( 'SECURE_AUTH_SALT', 'GzC<`ghummI<2lli0Yt2F5 #c!jA}YuF*CG3v_(=fX1cV~C&c/0x0x)JIY5S(Ub>' );
define( 'LOGGED_IN_SALT',   '|b>l7>B(G.>)Cr!8AT;wi$]W }`rSsrGx(0084zoH[Y|:HYzR! g1tyhLom0Tu8T' );
define( 'NONCE_SALT',       'CntP-RzjSQE54+&5^`C8tl^I4=VkLWZnM~tpTjvNE34%Qqxs/?Mh~5#=&7O{fJf0' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
