<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:reindex', description: 'Re-index casting calls and roles')]
class ReindexCommand extends Command
{
    public const DATE_FORMAT = 'Y_m_d_H_i_s';
    private const INDEX_NAME_PATTERN = '%s_%s';

    public function __construct(
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        return Command::SUCCESS;
    }

}
