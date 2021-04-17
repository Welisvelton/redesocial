<?php
class Autoloading
{
    public static function register()
    {
        spl_autoload_register(function ($class) {

            $file = __DIR__."/".self::substituir($class).'.php';
          
            if (file_exists($file)) {
                require_once($file);
                return true;
            }
            echo "Erro ao carregar: " . $file;
            exit;
        });
    }
    
    private static function substituir($str){
       return str_replace("\\", '/', $str);
    }
}
Autoloading::register();