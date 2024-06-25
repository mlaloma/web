<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'pFl/Nf9ie}9n)|<h`VIY.=R?sdT[.AiYW1=$%qJ0yX4;;-)ys1G>{!V#S424#)Lz' );
define( 'SECURE_AUTH_KEY',   's17jUKP-RPD1?c;O3/ C~yYG|WV?QVJsWSWJUtRKi-cb^mIBe1X#G]?*0VrQ5{!I' );
define( 'LOGGED_IN_KEY',     'w{%? gK7X&D?|a[H2:IJxLa0EOc.,C5QF}QiK.9Zh/NTBg->`o2O7 XbLUOP9+v}' );
define( 'NONCE_KEY',         '9BCS51tVD+j)V{6:;{o8_!c^{I[(!lpS4**_-cc1dOltwhsGqaO44j#^d<l c8`k' );
define( 'AUTH_SALT',         '#*wf>ZBAVoWD.tpt*]|NqTQ;fK`dUN_}u0-Xqm]M/MP7u$0`$4,U>VG=%=[wfp<c' );
define( 'SECURE_AUTH_SALT',  'y,o1Cia&Q]RLMk>MJm {6n@03gs|2iI:t$9J:YL%)-y|[*Mj.M$/GB)@77fy4)PB' );
define( 'LOGGED_IN_SALT',    '3D`m*9t3xj,yjU~BQMjDrBr,wl 4NZ=-!)]h2DV1LSV~TgLjs(U97yy1iM8EEMOP' );
define( 'NONCE_SALT',        '7?@u0[+B<Qc._`N.J8SS15Cm2<f+sj}*Lds^1Rm+~y,&cA$_&P}4)pywRjI*Lx$]' );
define( 'WP_CACHE_KEY_SALT', 'mv`6muU#@^`:>5_%@x#12d}7o4vyJ:&LxXCbRgxG1@,rIP_~xdQB[}pR[is8)V:C' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
