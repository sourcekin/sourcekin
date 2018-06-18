<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 17.06.18.
 */

use Doctrine\DBAL\Connection;
use Sourcekin\Application;
use Sourcekin\User\Model\UserRepository;
use Sourcekin\User\Projection\UserProjector;
use Sourcekin\User\Projection\UserReadModel;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;

return function(ContainerConfigurator $container){
    $container
        ->services()->defaults()->autowire()->autoconfigure()->bind(Connection::class, new Reference('database_connection'))
        ->set(UserRepository::class, \Sourcekin\User\Infrastructure\UserRepository::class)
        ->load(Application::ns('Sourcekin.User.Model.Command.'), Application::path('/User/Model/Command/*Handler.php'))
        ->tag('prooph_service_bus.sourcekin_command_bus.route_target', ['message_detection' => true])
        ->set(UserProjector::class)
        ->set(UserReadModel::class)
        ;
};