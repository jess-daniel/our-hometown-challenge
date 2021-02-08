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
define( 'DB_NAME', 'podcast_hometown' );

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
define( 'AUTH_KEY',         '?hi1PYExU4.Z2+,lmLiq |:uJvg8A_TrM_-+e}/z:2A{/TJ!$nGVyyJj8JP^a|=b' );
define( 'SECURE_AUTH_KEY',  'p,FNoA&./%O]NUnW*d&Ds39alj*$bkAQ%fP<cTygGuzH!?:iSD]?BAywtzaHYd4B' );
define( 'LOGGED_IN_KEY',    'a)WI~NGij}+bsq/8ASdcG#RnCyVuYyc^2XGwxk9sI%t|=s{0jaBf(L?|.oF^JF,w' );
define( 'NONCE_KEY',        '{-}R06id#9o2G ;}yBRGeZU$Ddj8wk*iAHaq;,6]<7G}HFhkT[%P|kfa>`$Hz!|l' );
define( 'AUTH_SALT',        'E,Hj%F@w4ob>/>ZQGcF2)>eJ)6oP0@E3qZrMvLH#/4+Kvm]ptVKN1rTqrzEa*tYE' );
define( 'SECURE_AUTH_SALT', '!&z4czo)YRP,8Mq>_Q7tf2QPA])yoFlc$BVFR004:v0a3[>vuitu,rujw>#iLuu4' );
define( 'LOGGED_IN_SALT',   'hS^EXZ~<SUiEH$*H(#-88W;d(R@yw*cauE4E2 KEzP_v%hhtv;[EM cBU^`yW7ob' );
define( 'NONCE_SALT',       'JgW%^@rko,*=R~~[P4v@Mvn_09f{T4)q_c*^Gq) }[O~>av}` d}}M8;)He@m}B/' );

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


