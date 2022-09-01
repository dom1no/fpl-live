<?php

namespace App\Console\Commands\Traits;

trait HasImportedCount
{
    private int $importedCount = 0;

    private function importedInc(): void
    {
        $this->importedCount++;
    }

    private function clearImportedCount(): void
    {
        $this->importedCount = 0;
    }

    private function importedCount(): int
    {
        return $this->importedCount;
    }

    private function importedCountText(string $entity): string
    {
        return "Imported {$this->importedCount()} $entity. ";
    }
}
