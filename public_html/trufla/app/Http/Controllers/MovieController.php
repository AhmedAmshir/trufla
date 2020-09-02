<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;
use App\Managers\MovieManager;
use App\Genre;

class MovieController extends Controller
{

    public function index(Request $request) {

        return view('Movies.index', ['data' => app('MovieManager')->getMoviesList($request->query())]);
    }
}
