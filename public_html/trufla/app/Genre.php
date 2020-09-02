<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Genre extends Model
{
    protected $fillable = ['api_genre_id', 'name', 'created_at'];

    public $timestamps = false;

    protected $primaryKey = 'api_genre_id';

    public function movies() {
        return $this->belongsToMany('App\Movie', 'genre_movie', 'genre_id', 'movie_id');
    }

    public static function insertMovieGenres($genres) {
        DB::table('genres')->insertOrIgnore($genres);
    }
}
