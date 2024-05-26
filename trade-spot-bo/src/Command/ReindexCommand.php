<?php

namespace App\Command;

use App\Component\ElasticSearch\Indexer\Indexer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DateTime;

#[AsCommand(name: 'app:reindex', description: '')]
class ReindexCommand extends Command
{
    public function __construct(
        protected readonly Indexer $indexer,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Start Reindex!!');
        try {
            $now = new DateTime();
            $indexes = $this->indexer->indexCreate($now);
            $this->indexer->indexAll($indexes['accounts'], $indexes['products']);
            $this->indexer->indexSwitch($now);
        } catch (\Throwable $exception) {
            $output->writeln('Reindex fail!');
            $output->writeln($exception->getMessage());
            return Command::FAILURE;
        }
        $output->writeln('reindex completed!');

        return Command::SUCCESS;
    }

}
