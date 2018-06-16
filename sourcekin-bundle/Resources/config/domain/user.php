<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 15.06.18.
 */

use Sourcekin\User\UserCommandHandler;
use Sourcekin\User\UserRepository;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function(ContainerConfigurator $container){
    $container
        ->services()->defaults()->private()->autowire()->autoconfigure()
        ->set(UserRepository::class)
        ->set(UserCommandHandler::class)
        ;
};