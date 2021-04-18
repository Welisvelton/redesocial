<?php 

namespace Login;

interface Login
{
    public static function logar($email, $senha);

    public static function logout();
    
}

