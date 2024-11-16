<?php

namespace Iinasg\FortuneAdInserter\Commands;

use Illuminate\Console\Command;

class FortuneAdInserterCommand extends Command
{
    public $signature = 'fortune-ad-inserter';

    public $description = 'My command';

    public function handle(): void
    {
        $this->comment('All done');
    }
}
