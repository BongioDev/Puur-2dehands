@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row text-center">
    <div class="col-md-12">
      @if (Auth::user()->id == $user->id)
      <h1>Jouw zoekertjes</h1>
        @if (count($advers) == 0)
            <h5>Je hebt nog geen zoekertjes! Maak <a href="/adver">hier</a> een zoekertje aan.</h5>
        @endif
      @else
      <h1>Zoekertjes van dit profiel</h1>
      @endif
      <br>
    </div>
  </div>
    <div class="row">
        <div class="col-lg-12">
          @foreach ($advers->chunk(4) as $chunk)
          @if (count($advers) < 1)
              
          <h3>Geen zoekertjes gevonden</h3>

          @else
          <div class="card-deck">
            @foreach ($chunk as $adver)
            {{-- decode de image paths uit de adver --}}
            @php
                $decoded_images = json_decode($adver->images);
            @endphp
                <div style="max-width: 250px; min-width: 200px; margin:0 auto; margin-bottom:30px" class="card">
                  <a href="/showAdverUser/{{$adver->id}}">
                    <img style="height: 220px; object-fit: cover;" src="/storage/images/{{$decoded_images[0]->image}}" class="card-img-top" alt="...">
                      <div class="card-body ">
                      <h5 class="card-title"><b>{{$adver->title}}</b></h5>
                  </a>
                    <p class="card-text">
                        {!!$adver->discription!!}
                        <hr>
                        <b>Category: </b> {{$adver->category->name}}
                        <br>
                        <b>Conditie: </b> {{$adver->condition}}
                        <br>
                        <b>Locatie: </b> {{$adver->location}}
                        <br>
                        <b>Prijsklasse: </b> {{$adver->priceclass}}
                        <br>
                        <b>Prijs: </b>€ {{$adver->price}}
                        <br>
                    </p>
                    @if (Auth::user()->id == $user->id)
                      <a style="width:100%; margin-bottom: 10px;" href="/currentUser/{{$adver->id}}/edit" class="btn btn-outline-primary">Aanpassen</a>
                      {{-- deleteknop hieronder  --}}
                      {!!Form::open(['action'=>['currentUserController@destroy', $adver->id], 'method'=>'POST'])!!}
                          {{Form::hidden('_method', 'DELETE')}}
                          <a onclick="return confirm('Ben je zeker dat je zoekertje: {{$adver->title}} wilt verwijderen?')">
                          {{Form::submit('Verwijderen', ['class'=>'btn btn-outline-danger', 'style' => 'width:100%; margin-bottom: 10px',])}}</a>
                      {!!Form::close()!!}
                    @endif
                </div>
          </div>
          @endforeach
          </div> 
          @endif
          @endforeach    
        </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        {{ $advers->links() }}
      </div>
    </div>
</div>

@endsection