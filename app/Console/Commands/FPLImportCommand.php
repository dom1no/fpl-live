<?php

namespace App\Console\Commands;

use App\Console\Commands\Traits\HasImportedCount;
use App\Console\Commands\Traits\HasMeasure;
use App\Services\FPL\FPLService;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

abstract class FPLImportCommand extends Command
{
    use HasImportedCount;
    use HasMeasure;

    public function __construct()
    {
        $this->signature = $this->signatureName();
        $this->description = "Import {$this->entityName()} from FPL API";

        parent::__construct();
    }

    abstract public function entityName(): string;

    private function signatureName(): string
    {
        $entityName = Str::slug($this->entityName());

        return "import:{$entityName} {$this->signatureArgs()}";
    }

    public function signatureArgs(): ?string
    {
        return null;
    }

    public function handle(FPLService $FPLService): void
    {
        $this->startMeasure();
        $this->info("Starting import {$this->entityName()}...");

        $this->import($FPLService);

        $this->finishMeasure();
        $this->info("Finished import {$this->entityName()}. {$this->importedCountText($this->entityName())} {$this->durationText()}");
    }

    abstract public function import(FPLService $FPLService): void;
}
