<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'rockinDBy3sep');

/** MySQL database username */
define('DB_USER', 'rockinDBy3sep');

/** MySQL database password */
define('DB_PASSWORD', 'fRF1ocOWI4');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Q^7Qm^3Ibq^6Mfu*{6MXq+{6ITeu*{HTeq+]6HTi+#2DTep+]6]5HWht~;9Ldt~[9');
define('SECURE_AUTH_KEY',  '[Oh-[Ddw[8Odw0GZo~:Gcw[8Rgw0FVo!0FVr,7Rgv|FYn^0FUv>BUjz>Ebr${7$7f');
define('LOGGED_IN_KEY',    '6Qbmy{6ITeq+<2EXiq+<2EPbmx]6HTepx.;ALep+#2Dep+#DOalx#1DOaw_:DOal-');
define('NONCE_KEY',        '8Vs}FZo!0Jkz}FYo!7Ncr!4Njz>7Qgz>Ibr^FYy<3Mfu>Mbq^3Ib+{6Piy{Lbq*2');
define('AUTH_SALT',        'bq*{6Ibmx*{6ITeq+;ALXeq+<2EPit*]6DPamx.5HSelx_;9LWp-#1DKl-#9KZlw_');
define('SECURE_AUTH_SALT', '#Da-:GVp_5Rhw|GZo@0G8Rgv>8Nn^0JYn@3Mcv>BQr^BUn$}Mfy<BUj.6Mfy{Lbu');
define('LOGGED_IN_SALT',   'Tm.7Tm+ETfu]EXiu*;ALx#2DPeq+;9Lamx_;DPht~;9LWit_5GSdp~]5HSl-|1C');
define('NONCE_SALT',       '8Vs|4Vk@0GZo>8R!0Jgz>BRgzv,7Mfz>Ibr,3Mf$EUn$Mfu<AQj*2Lbu.6Xm*2H');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);define('WP_ALLOW_MULTISITE', true);define('FS_METHOD', 'direct');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
