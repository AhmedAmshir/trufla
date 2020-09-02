@foreach ($data as $movie)
    <b>Movie Title:</b> {{ $movie['title'] }} <br/>
    <b>Movie Popularity:</b> {{ $movie['popularity'] }} <br/>
    <b>Movie Votes:</b> {{ $movie['votes'] }} <br/>
    
    @if(!empty($movie['genres']))
        <b>Movie Categories:</b>
        @foreach ($movie['genres'] as $genre)
            <li>{{ $genre }}</li>
        @endforeach
    @endif
    <br/><br/>
@endforeach