<?php
require '../vendor/autoload.php';
class WhoopsHook {
    public function bootWhoops() {
        if(ENVIRONMENT !== 'production'){
            $whoops = new \Whoops\Run;
            $whoops->pushHandler(new Whoops\Handler\PrettyPageHandler());
            $whoops->register();
        }
    }
}