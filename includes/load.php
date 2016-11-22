<?php

define('CORE_PATH', get_stylesheet_directory() . '/includes');
define('CORE_URL', get_stylesheet_directory_uri()  . '/includes');
define( 'CORE_PLUGINS_PATH', CORE_PATH . '/plugins/' );
define( 'CORE_PLUGINS_URL', CORE_URL . '/plugins/' );

/* load plugins */

// acf- font-awesome icon
require_once CORE_PLUGINS_PATH.'/advanced-custom-fields-font-awesome/acf-font-awesome.php';
// add plugins bfi tumb
require_once CORE_PLUGINS_PATH.'/BFI_Thumb.php';

// add new redzy api function + angular
require_once CORE_PATH.'/rezdy_api/init.php';

/* autoload functions */

$dirs = array(
    CORE_PATH . '/post_types/',
    CORE_PATH . '/functions/',
    CORE_PATH . '/acf/',
);
foreach ($dirs as $dir) {
    $other_inits = array();
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (false !== ($file = readdir($dh))) {
                if ($file != '.' && $file != '..' && stristr($file, '.php') !== false) {
                    list($nam, $ext) = explode('.', $file);
                    if ($ext == 'php')
                        $other_inits[] = $file;
                }
            }
            closedir($dh);
        }
    }
    asort($other_inits);
    foreach ($other_inits as $other_init) {
        if (file_exists($dir . $other_init))
            include_once $dir . $other_init;
    }
} 