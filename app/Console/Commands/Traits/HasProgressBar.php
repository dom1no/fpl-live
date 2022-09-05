<?php

namespace App\Console\Commands\Traits;

use Symfony\Component\Console\Helper\ProgressBar;

trait HasProgressBar
{
    private ?ProgressBar $progressBar = null;

    protected function startProgressBar(int $total): void
    {
        $this->progressBar = $this->output->createProgressBar($total);

        $this->progressBar->start();
    }

    protected function advanceProgressBar(): void
    {
        $this->progressBar?->advance();
    }

    protected function finishProgressBar(): void
    {
        $this->progressBar?->finish();
        $this->newLine();
    }
}
