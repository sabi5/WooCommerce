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
define( 'DB_NAME', 'woo_wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         '&ty >J4]^u~x?Y?^}~.vdc7Oq?R[B<{OoQFn-Qm*eMFey 4/BGf~9&Wn o$t}6|-' );
define( 'SECURE_AUTH_KEY',  'm~[B#t 8 )#D9mjdSPpc[3/QA8b*Q{rwd(H.z|/o,e&A?FG<]i|Z2j*%3R@VIl-&' );
define( 'LOGGED_IN_KEY',    'N[^]hI); Qbr_~^9vF^=^!1#=Ox1p,AZn/pE>iqN[uP&5!GisA)bTb)h,Jk,?P+y' );
define( 'NONCE_KEY',        'xxk1<R3`Q;KmqI=i>z6Uy_FZIO.zIBO3m6+Eo.ycNX&;oU)Y Y!tz&*b<h_U=TM6' );
define( 'AUTH_SALT',        '#np`f|:?t1<v+m/-2XA0PwV)F[hL5p}9 _R%oax> 8Z1.O>eaA g! Jpd}IybVA/' );
define( 'SECURE_AUTH_SALT', 'vmctSiXkVO^cApbtQ)=>v}bjO&Ph2+gjXUGF|AI<$}X&,4|cvM?<pV9F)wk7}*5c' );
define( 'LOGGED_IN_SALT',   '=gu-&J`.u{~mXe%xk?3Axi=:YiSGqaDli)~La$P^1n#f;rqd,>R/8rf)0V`5LcNC' );
define( 'NONCE_SALT',       'I<jtt:.S~Yw!D[]x%%69,3jp5rzDBKRGH9VQ3X7GE<vpNSbpXv7I4|Si~k1!9FK1' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';
define('FS_METHOD','direct');

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
define( 'WP_DEBUG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
