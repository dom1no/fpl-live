<?php

namespace App\Console\Commands\Traits;

trait HasImportedCount
{
    private int $importedCount = 0;

    protected function importedInc(): void
    {
        $this->importedCount++;
    }

    protected function importedCount(): int
    {
        return $this->importedCount;
    }

    protected function importedCountText(string $entity): string
    {
        return "Imported {$this->importedCount()} {$entity}. ";
    }
}
