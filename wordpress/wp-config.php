<?php
/**
 * The base configurations of the WordPress.
  *
   * This file has the following configurations: MySQL settings, Table Prefix,
    * Secret Keys, and ABSPATH. You can find more information by visiting
     * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
      * Codex page. You can get the MySQL settings from your web host.
       *
        * This file is used by the wp-config.php creation script during the
         * installation. You don't have to use the web site, you can just copy this file
          * to "wp-config.php" and fill in the values.
           *
            * @package WordPress
             */
             
             // ** MySQL settings - You can get this info from your web host ** //
             /** The name of the database for WordPress */
             define('DB_NAME', 'axa9070');
             
             /** MySQL database username */
             define('DB_USER', 'axa9070');
             
             /** MySQL database password */
             define('DB_PASSWORD', 'tomahawk');
             
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
                     define('AUTH_KEY',         'GbmuiskDsoXy(ax`1%i0qaZrQHvd%Kw^snl=kv4 AWpy`?Ac7a[Tij#35Fd--wEC');
                     define('SECURE_AUTH_KEY',  'TZN[+~|@+eK3q#FKL@uNI@:CsPv,a=6PKw+RGn%Vrq`>zn|rF/:k-#m_MkEl4#i&');
                     define('LOGGED_IN_KEY',    'X;A>q8$ET7?z,.Lk Ht+,HA@MW 52Bf7KZ8}X&pqc(!&0F5^X*-<-GZ+v0SH/9x ');
                     define('NONCE_KEY',        'r  ^|~@mOJfxbH`suta3Y@U#`JPu:V^l$D~aF7YT8+1YVr-^(=T6e2}k&m<yXDE^');
                     define('AUTH_SALT',        'W{5uW1;}l_?]MufUF5m-cu_{[rtQGAtD&W3~7ScbIcJYG})?|A,|J=#XV+J(&|8k');
                     define('SECURE_AUTH_SALT', 'PQ.pZrWd]CnI$e uD+]}h^u+EG^9Hso. h!B}Iim~17f_)UZz/zb0a?8Rzp=?a^9');
                     define('LOGGED_IN_SALT',   '?2H:-+H9h q-:F7G ^%|ipPJEN5f3fPif^]T!F|,j@yjRGGS[jJoy so[=^M$G|b');
                     define('NONCE_SALT',       'vh6~~}L(bpVglbs6?b%J1CAu$^}-!1]3mN]oFsPYt(j461$sfr!zNJcDpCgnH+=M');
                     
                     /**#@-*/
                     
                     /**
                      * WordPress Database Table prefix.
                       *
                        * You can have multiple installations in one database if you give each a unique
                         * prefix. Only numbers, letters, and underscores please!
                          */
                          $table_prefix  = 'wp_';
                          
                          /**
                           * For developers: WordPress debugging mode.
                            *
                             * Change this to true to enable the display of notices during development.
                              * It is strongly recommended that plugin and theme developers use WP_DEBUG
                               * in their development environments.
                                */
                                define('WP_DEBUG', false);
                                
                                /* That's all, stop editing! Happy blogging. */
                                
                                /** Absolute path to the WordPress directory. */
                                if ( !defined('ABSPATH') )
                                	define('ABSPATH', dirname(__FILE__) . '/');
                                	
                                	/** Sets up WordPress vars and included files. */
                                	require_once(ABSPATH . 'wp-settings.php');
                                	
