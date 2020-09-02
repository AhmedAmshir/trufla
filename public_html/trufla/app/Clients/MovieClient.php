<?php

namespace App\Clients;

use GuzzleHttp\Client;

class MovieClient {

    private $client;

    public function __construct() {
        $this->client = new Client([
            'base_uri' => config('app.api_movie_uri')
        ]);
    }

    public function latest()
    {
        $latestResponse = $this->client->get("movie/latest?api_key=".config('app.api_movie_key'));
        return json_decode($latestResponse->getBody(), true);
    }
    public function topReted() {
        $topRatedResponse = $this->client->get("movie/top_rated?api_key=".config('app.api_movie_key'));
        return json_decode($topRatedResponse->getBody(), true)['results'];
    }

    public function details($id) {
        $movieDetailsResponse = $this->client->get("movie/".$id."?api_key=".config('app.api_movie_key'));
        return json_decode($movieDetailsResponse->getBody(), true);
    }
}