<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Serie;

class SeriesListController extends Controller
{
    // method that contain the list of series

    //public function list() {
        //$seriesList = array();

        // convert array into object for better access using method $p1->name
        
        //$s1 = (object)array("name" => "Berlin", "image" => "image/berlin.jpg", "desc"=> "The Energy of Love. During his glory days, Berlin assembles a gang in Paris for an almost impossible heist for 44M €.", "actor" => "Pedro Alonso, Joel Sanchez, Maria Isabel", "director" => "Alex Pina");
        //$s2 = (object)array("name" => "Squid Game", "image" => "image/squadgame.jpeg", "desc" => "It revolves around a secret contest where 456 players, all of whom are in deep financial hardship, risk their lives to play a series of deadly children's games.", "actor"=>"Lee Jung, Park", "director" => "Hwang Dong-hyuk");
        //$s3 = (object)array("name"=>"Toxic Town", "image"=>"image/toxicTown.jpeg", "desc" => "Families fighting for justice after children in the Northamptonshire town were born with birth defects, believed to be caused by industrial pollution.", "actor" => "Jodie, Joe, Aimee Lou", "director" => "Minkie &  Spiro");


        //array_push($seriesList, $s1);
        //array_push($seriesList, $s2);
        //array_push($seriesList, $s3);

       // return $seriesList;
    //}

    // now above method will create the list now we need the method that will display these list
     // Método para mostrar el formulario de agregar serie
     public function create()
     {
         return view('admin.addSerie');
     }
 
     // Método para almacenar una nueva serie
     public function store(Request $request)
     {
         // Validación de los datos
         $request->validate([
             'name' => 'required|string|max:255',
             'desc' => 'required|string',
             'actor' => 'required|string',
             'director' => 'required|string',
             'image' => 'required|image',
             'video_url' => 'required|url',
             'num_episode' => 'required|integer'
         ]);
 
         // Guardar la serie en la base de datos
         $serie = new Serie();
         $serie->name = $request->name;
         $serie->desc = $request->desc;
         $serie->actor = $request->actor;
         $serie->director = $request->director;
         $serie->video_url = $request->video_url;
         $serie->num_episode = $request->num_episode;
 
         // Subir la imagen de la serie
         if ($request->hasFile('image')) {
             $serie->image = $request->file('image')->store('series_images', 'public');
         }
 
         $serie->save();
 
         return redirect()->route('series.create')->with('success', 'Serie añadida con éxito');

     }
     public function show($id, Request $request)
     {
         $serie = Serie::with('episodes')->findOrFail($id);
         $seasonFilter = $request->query('season');
     
         $episodes = $serie->episodes;
     
         // Si hay temporada seleccionada, filtrar
         if ($seasonFilter) {
             $episodes = $episodes->where('season', $seasonFilter);
         }
     
         // Obtener todas las temporadas únicas para el desplegable
         $seasons = $serie->episodes->pluck('season')->unique()->sort();
     
         return view('showSerie', compact('serie', 'episodes', 'seasons', 'seasonFilter'));
     }
     

    public function showList() {

        // call the above list method to get the list of series
        //$listaSerie = $this->list();
        // Retrieve all series from the database
        $seriesList = Serie::all();
        
        return view('seriesList', ['seriesList'=>$seriesList]);
    }
}
