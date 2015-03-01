<?php namespace App\Http\Controllers;

use App\Search;

class HomeController extends Controller {

    public function index()
    {
        return view('home.index');
    }

    public function amcharts($searchId = false)
    {
        $search = $this->search($searchId);

        $stats = json_decode($search->stats, true);

        return view('home.amcharts', compact('search', 'stats'));
    }

    public function google_charts($searchId = false)
    {
        $search = $this->search($searchId);

        $stats = json_decode($search->stats, true);

        return view('home.google_charts', compact('search', 'stats'));
    }

    private function search($searchId)
    {
        $search = ! empty($searchId) ? Search::find($searchId) : $this->lastSearch();
        
        if (empty($search))
        {
            abort(404);
        }

        return $search;
    }

    private function lastSearch()
    {
        return Search::orderBy('created_at', 'desc')->first();
    }

}
