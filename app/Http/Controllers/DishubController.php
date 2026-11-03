<?php

namespace App\Http\Controllers;

use App\Models\DishubAkdpRoute;
use App\Models\DishubFlightSchedule;
use App\Models\DishubSectionNote;
use App\Models\DishubTerminal;
use App\Models\DishubTollRate;

class DishubController extends Controller
{
    public function index()
    {
        $arrivals = DishubFlightSchedule::where('category', 'arrival')->orderBy('sort_order')->get();
        $departures = DishubFlightSchedule::where('category', 'departure')->orderBy('sort_order')->get();
        $terminals = DishubTerminal::orderBy('sort_order')->get();
        $routes = DishubAkdpRoute::orderBy('sort_order')->get();
        $tollRates = DishubTollRate::orderBy('sort_order')->get();
        $notes = DishubSectionNote::orderBy('section')->orderBy('sort_order')->get()->groupBy('section');
        $arrivalGroups = $this->groupByUpdateDate($arrivals);
        $departureGroups = $this->groupByUpdateDate($departures);
        $terminalGroups = $this->groupByUpdateDate($terminals);
        $routeGroups = $this->groupByUpdateDate($routes);
        $tollRateGroups = $this->groupByUpdateDate($tollRates);

        return view('theme-govmodern.dishub.index', compact(
            'arrivals',
            'departures',
            'terminals',
            'routes',
            'tollRates',
            'notes',
            'arrivalGroups',
            'departureGroups',
            'terminalGroups',
            'routeGroups',
            'tollRateGroups'
        ));
    }

    protected function groupByUpdateDate($items)
    {
        return $items
            ->sortBy([
                ['data_updated_at', 'desc'],
                ['sort_order', 'asc'],
                ['id', 'asc'],
            ])
            ->groupBy(function ($item) {
                return optional($item->data_updated_at)->format('Y-m-d') ?: 'tanpa-tanggal';
            });
    }
}
