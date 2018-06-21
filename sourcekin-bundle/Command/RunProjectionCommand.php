<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 20.06.18
 *
 */

namespace SourcekinBundle\Command;

use Prooph\Bundle\EventStore\Projection\Projection;
use Prooph\Bundle\EventStore\Projection\ReadModelProjection;
use Prooph\EventStore\Projection\ProjectionManager;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RunProjectionCommand extends Command
{

    /**
     * @var  ProjectionManager
     */
    protected $manager;

    /**
     * @var ContainerInterface
     */
    protected $projections;

    /**
     * @var ContainerInterface
     */
    protected $readModels;

    /**
     * RunProjectionCommand constructor.
     *
     * @param ProjectionManager  $manager
     * @param ContainerInterface $projections
     * @param ContainerInterface $readModels
     */
    public function __construct(
        ProjectionManager $manager,
        ContainerInterface $projections,
        ContainerInterface $readModels
    ) {
        $this->manager     = $manager;
        $this->projections = $projections;
        $this->readModels  = $readModels;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('sourcekin:projection:run')
            ->addArgument('projection', InputArgument::REQUIRED)
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $projector      = null;
        $projectionName = $input->getArgument('projection');
        if( ! $this->projections->has($projectionName)){
            throw new \InvalidArgumentException('Projection '. $projectionName. ' does not exist');
        }

        $projection = $this->projections->get($projectionName);

        if( $projection instanceof ReadModelProjection) {
            $readModel = $this->readModels->get($projectionName);
            $projector = $this->manager->createReadModelProjection($projectionName, $readModel);
        }

        if( $projection instanceof Projection) {
            $projector = $this->manager->createProjection($projectionName);
        }

        if(! $projector ) throw new \RuntimeException('unable to create projection');

        $projector = $projection->project($projector);
        $projector->run(false);

    }


}