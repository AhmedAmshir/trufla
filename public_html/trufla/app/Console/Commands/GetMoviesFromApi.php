<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Clients\MovieClient;
use App\Genre;
use App\Movie;


class GetMoviesFromApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'movie:api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get latest and top rated movies from third party API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(MovieClient $movieClient)
    {
        $this->info('**Get top rated movies**');
        
        $topRatedMovies = $movieClient->topReted();

        $topRatedMoviesBar = $this->output->createProgressBar(count($topRatedMovies));
        $topRatedMoviesBar->start();

        foreach (array_reverse($topRatedMovies) as $movie) {
            
            $m = app('MovieManager')->handleMovieData($movie);
            $movieDetails = $movieClient->details($movie['id']);
            $genres = [];
            foreach($movieDetails['genres'] as $g) {
                $genre = app('MovieManager')->handleMovieGenres($g);
                array_push($genres, $genre);
            }

            Genre::insertMovieGenres($genres);
            Movie::saveMovie($m, $movie['genre_ids']);

            $topRatedMoviesBar->advance();
        }
        $topRatedMoviesBar->finish();

        $this->info("\n**Get latest movie**");
        $latestMovie = $movieClient->latest();
        $lmovie = app('MovieManager')->handleMovieData($latestMovie);
        
        $lgenres = [];
        $lgenreIds = [];
        if(array_key_exists('genres', $latestMovie) && !empty($latestMovie['genres'])) {

            foreach($latestMovie['genres'] as $genre) {
                array_push($lgenreIds, $genre['id']);
            }
            foreach($latestMovie['genres'] as $g) {
                $genre = app('MovieManager')->handleMovieGenres($g);
                array_push($lgenres, $genre);
            }
            if(!empty($lgenres)) Genre::insertMovieGenres($lgenres);
        }

        $movieExist = app("MovieManager")->checkIfMovieExist($lmovie['api_movie_id']);
        if(empty($movieExist)) Movie::saveMovie($lmovie, $lgenreIds);
        
        $this->info('Great, Done');
    }
}
