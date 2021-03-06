<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 12.06.18
 *
 */

namespace App\Command;

use Sourcekin\EventHandling\CommandBus;
use Sourcekin\EventHandling\MessageReceivingInterface;
use Symfony\Component\Console\Command\Command;

abstract  class MessageReceivingCommand extends Command implements MessageReceivingInterface
{
    /**
     * @var CommandBus
     */
    protected $commandBus;

    /**
     * MessageReceivingCommand constructor.
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus) {
        $this->commandBus = $commandBus;
        parent::__construct();
    }


}