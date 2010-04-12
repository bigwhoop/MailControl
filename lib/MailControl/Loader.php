<?php
namespace MailControl;

class Loader
{
    /**
     * Register autoloading and add our root directory
     * to the include path (if not already set)
     */
    public static function register()
    {
        $paths = explode(PATH_SEPARATOR, get_include_path());
        $paths = array_map('realpath', $paths);
        
        $path = realpath(__DIR__ . '/..');
        if (!in_array($path, $paths)) {
            set_include_path($path . PATH_SEPARATOR . get_include_path());
        }
        
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }
    
    
    /**
     * Autoload callback
     * 
     * @param string $class
     * @return bool
     */
    public static function autoload($class)
    {
        if (0 !== strpos($class, 'MailControl')) {
            return false;
        }
        
        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
        require_once $class;
        
        return true;
    }
}