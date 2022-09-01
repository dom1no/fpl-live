<?php

namespace App\Console\Commands\Traits;

trait HasMeasure
{
    private array $measures = [];

    private function startMeasure(string $name = 'default'): void
    {
        $this->measures[$name] = [
            'startAt' => now(),
            'finishAt' => null,
            'duration' => null,
        ];
    }

    private function finishMeasure(string $name = 'default'): void
    {
        $finishAt = now();
        $this->measures[$name]['finishAt'] = $finishAt;
        $this->measures[$name]['duration'] = $finishAt->diffInMilliseconds($this->measures[$name]['startAt']);
    }

    private function duration(string $name = 'default'): int
    {
        $duration = $this->measures[$name]['duration'] ?? null;

        if (is_null($duration)) {
            $this->finishMeasure($name);

            return $this->duration();
        }

        return $duration;
    }

    private function durationText(string $name = 'default'): string
    {
        $duration = $this->duration($name);
        $stringDuration = $duration ? (string) $duration : '0';

        return "{$stringDuration}ms";
    }
}
