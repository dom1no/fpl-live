<?php

namespace App\Observers;

use App\Models\Fixture;
use App\Models\Manager;
use App\Models\ManagerPick;
use App\Notifications\FixtureFinishedNotification;
use Illuminate\Support\Collection;

class FixtureObserver
{
    public function updated(Fixture $fixture): void
    {
        $this->fixtureFinishedNotify($fixture);
    }

    private function fixtureFinishedNotify(Fixture $fixture): void
    {
        if ($fixture->wasChanged('is_finished_provisional') && $fixture->is_finished_provisional) {
            $picks = $this->getFixtureManagersPicks($fixture);

            Manager::whereKey($picks->keys())
                ->get()
                ->each(
                    fn (Manager $manager) => $manager->setRelation('picks', $picks->get($manager->id))
                )->each(
                    fn (Manager $manager) => $manager->notify(new FixtureFinishedNotification($fixture, $manager))
                );
        }
    }

    private function getFixtureManagersPicks(Fixture $fixture): Collection
    {
        return ManagerPick::forGameweek($fixture->gameweek)
            ->whereHas('player', function ($q) use ($fixture) {
                $q->whereHas('team', function ($q) use ($fixture) {
                    $q->whereHas('fixtures', function ($q) use ($fixture) {
                        $q->whereKey($fixture->id);
                    });
                });
            })
            ->get()
            ->groupBy('manager_id');
    }
}
