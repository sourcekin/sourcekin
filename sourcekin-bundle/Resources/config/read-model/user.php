<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 16.06.18
 *
 */

use SourcekinBundle\ReadModel\Doctrine\ORM\ProjectionRepository;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;

return function (ContainerConfigurator $configurator) {
    $configurator
        ->services()
        ->defaults()->autowire()->autoconfigure()
        ->set('sourcekin.login_user.projection_repository', ProjectionRepository::class)
        ->arg('$className', \SourcekinBundle\ReadModel\User\SecurityUser::class)
        ->set(\SourcekinBundle\ReadModel\User\SecurityUserProjector::class)
        ->arg('$repository', new Reference('sourcekin.login_user.projection_repository'))
        ->tag('broadway.domain.event_listener')
    ;

};