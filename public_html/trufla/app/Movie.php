<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Movie extends Model
{
    protected $fillable = ['api_movie_id', 'title', 'popularity', 'votes', 'created_at'];

    public $timestamps = false;

    public function genres() {
        return $this->belongsToMany('App\Genre', 'genre_movie', 'movie_id', 'genre_id');
    }

    public static function saveMovie($movie, $genres)
    {
        $created = Movie::create($movie);
        if($created->id) {
            $created = $created->fresh();
            if(!empty($genres)) $created->genres()->attach($genres);
        }  
    }

    public static function getMovies($filters)
    {
        $movies = Movie::with('genres');
        if(array_key_exists('category_id', $filters)) {
            $movies = Movie::whereHas('genres', function($q) use ($filters) {
                $q->where('api_genre_id', '=', $filters['category_id']);
            });
        }

        if(array_key_exists('title', $filters)) {
            $movies->orderBy('movies.title', $filters['title']);
        }
        if(array_key_exists('popular', $filters)) {
            $movies->orderBy('movies.popularity', $filters['popular']);
        }
        if(array_key_exists('rated', $filters)) {
            $movies->orderBy('movies.votes', $filters['rated']);
        }
        
        return $movies->get();
    }

    public static function findMovie($id)
    {
        return DB::table("movies")->where('api_movie_id', $id)->get()->toArray();
    }
}
