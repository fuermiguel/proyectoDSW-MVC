<?php

/****En este archivo definimos las inyecciones que queremos tener disponibles para el contenedor****/


//Hacemos las importaciones necesarias
use Application\Controllers\HomeController; 
use Application\Providers\Doctrine;
use Application\Providers\View;
use Application\Utils\TwigFunctions;


return [//Array asociativo
    'config.database' => function(){
        return parse_ini_file(base_path('app/Config/database.ini'));//https://secure.php.net/manual/es/function.parse-ini-file.php
    },


    //Esta es la manera de hacerlo de forma dinámica diciendo al container como resolver las dependencias
    HomeController::class => \DI\create()->constructor(\DI\get(Doctrine::class)),

    Doctrine::class => function(\Psr\Container\ContainerInterface $container){
        return new Doctrine($container);
    },
    View::class => \DI\create(View::class),
    'SharedContainerTwig' => function (\Psr\Container\ContainerInterface $container) {
        TwigFunctions::setContainer($container);
    }
];

?>

