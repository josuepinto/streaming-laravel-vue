<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class MovieListController extends Controller
{
    public function showList() {
        // reterive the list from db
        $moviesList = Movie::all();
        return view('moviesList', ['moviesList'=>$moviesList]);
    }
}
