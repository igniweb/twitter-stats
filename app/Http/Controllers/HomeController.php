<?php namespace App\Http\Controllers;

use App\Search;

class HomeController extends Controller {

    public function index()
    {
        $search = Search::find(1);

        return view('welcome', compact('search'));
    }

}
