<?php

namespace App\Http\Livewire;

use App\Models\Fixture;
use App\Models\Gameweek;
use App\Models\Player;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class PlayerModal extends Component
{
    protected $listeners = [
        'setCurrentFixture' => 'setCurrentFixture',
        'show' => 'show',
    ];

    public Gameweek $gameweek;

    public ?Player $player = null;
    public Fixture $currentFixture;
    public ?Collection $pastFixtures = null;
    public ?Collection $futureFixtures = null;

    public function mount(): void
    {
        $this->gameweek = request()->gameweek();
    }

    public function setCurrentFixture(Fixture $fixture): void
    {
        $this->currentFixture = $fixture;
    }

    public function show(Player $player): void
    {
        $this->player = $player->load([
            'stats',
            'points',
            'team.fixtures.gameweek',
            'team.fixtures.teams',
        ]);

        $this->currentFixture ??= $this->getCurrentFixture();
        $this->initFixtures();

        $this->emit('showModal', 'player-modal');
    }

    private function getCurrentFixture(): Fixture
    {
        return $this->player
            ->team
            ->fixtures
            ->firstWhere('gameweek_id', $this->gameweek->id) ?: new Fixture();
    }

    private function initFixtures(): void
    {
        [$this->futureFixtures, $this->pastFixtures] = $this->player
            ->team
            ->fixtures
            ->partition(fn(Fixture $fixture) => $fixture->isFeature());
    }

    public function render(): View
    {
        return view('components.player-modal.index');
    }
}
