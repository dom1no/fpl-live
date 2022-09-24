<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use App\View\Models\Fixture\IndexViewModel;
use App\View\Models\Fixture\ShowViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class FixtureController extends Controller
{
    public function index(Request $request): View
    {
        $gameweek = $request->gameweek();

        $viewModel = new IndexViewModel($gameweek);

        return view('fixtures.index', $viewModel);
    }

    public function show(Fixture $fixture): View
    {
        $viewModel = new ShowViewModel($fixture);

        return view('fixtures.show', $viewModel);
    }
}
