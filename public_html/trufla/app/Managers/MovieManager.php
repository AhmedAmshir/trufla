<?php

namespace App\Managers;

use App\Movie;

class MovieManager {


    public function __construct(){}

    public function getMoviesList($filters = []) {
        $data =[];
        $movies = Movie::getMovies($filters);
        if(!empty($movies)) {
            foreach ($movies as $movie) {
                $m['title'] = $movie->title; 
                $m['popularity'] = $movie->popularity; 
                $m['votes'] = $movie->votes;
                $m['genres'] = [];
                foreach ($movie->genres as $genre) {
                    $m['genres'][]= $genre->name;
                }
                array_push($data, $m);
            }
            return $data;
        }
        return false;
    }

    public function handleMovieData($movie) {
        $m['api_movie_id'] = $movie['id'];
        $m['title'] = $movie['original_title'];
        $m['popularity'] = $movie['popularity'];
        $m['votes'] = $movie['vote_count'];
        $m['created_at'] = date('Y-m-d H:i:s');
        return $m;
    }

    public function handleMovieGenres($g) {
        $genre['api_genre_id'] = $g['id'];
        $genre['name'] = $g['name'];
        $genre['created_at'] = date('Y-m-d H:i:s');
        return $genre;
    }

    public function checkIfMovieExist($id)
    {
        return Movie::findMovie($id);
    }
}