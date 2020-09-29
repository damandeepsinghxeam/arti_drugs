<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

if(isset($_SERVER['REDIRECT_REDIRECT_HTTP_AUTHORIZATION'])){
    $allServerData = json_encode($_SERVER);
    $allRequestData = json_encode($_REQUEST);
    
    $fp = fopen('loggin-requests.txt', 'a');//opens file in append mode  
    
    fwrite($fp, "\n ----- Server Data ----- \n");
    fwrite($fp, $allServerData); 
    
    fwrite($fp, "\n ----- Request Data ----- \n");
    fwrite($fp, $allRequestData);
    
    
    fwrite($fp, "\n **************************************** \n");  
    fclose($fp);  
}


$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

require_once __DIR__.'/public/index.php';
