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
define( 'AUTH_KEY',          '~hVKLZa?9LbV$]N$lBd9HOLk$(xssV(b%^TT8z *jL>+$u}k*{g7Z&&D BXiy$e#' );
define( 'SECURE_AUTH_KEY',   'QoJ:-VjRD8Xu<9MQMdn}|WANlq.}&|0::,.i/^MCn<s[]D5-=}4-T8Ql!ZAeb-(G' );
define( 'LOGGED_IN_KEY',     '*JjIG|3zh}ocu+~iHP`A$+}afp@Luim#E>pqr)YuA;A|Myi,x,<yJ=`P,n5k<Q1b' );
define( 'NONCE_KEY',         'yw^}6y%hDxNskkSX?,(V@qj}ZXyj`1lQHbX@loq67K^49&K3=bzz#. u%j!Qt~hw' );
define( 'AUTH_SALT',         'Ziu(Tn5NpuG*e=#zHeR&8&$/hJ%(f-lm@ftv!MuefkCq5+=>-V@K$LRupCRja%gz' );
define( 'SECURE_AUTH_SALT',  'G2A?#-U[{9?p=%>3~N*|@a;o$:)FNa3=VRsDWf%Q#E&phPr@8H;j4&ns--g4aT.m' );
define( 'LOGGED_IN_SALT',    'd_8JmoKx<n5O6xLCulE0lbmtC3Z>cZYEBM!ISppfMPrWvc2`aZWH7J?<45}RZ4U~' );
define( 'NONCE_SALT',        'm[@fi]-~p+<0l0a+Nt^l4eHsr<#AFe{(b^m-oumY`QDHL6m8Io%q#/M=jUAd;#M?' );
define( 'WP_CACHE_KEY_SALT', '_`Nl=;KQWbn~Ga Kw,P>;XUb,H?S;.e)36lnJ.xp),3B2F[PN;NmRt1|BkBu$K|$' );

define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true); // 日志写入 wp-content/debug.log
define('WP_DEBUG_DISPLAY', true);

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