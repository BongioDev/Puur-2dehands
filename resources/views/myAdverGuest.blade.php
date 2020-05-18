@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row text-center">
    <div class="col-md-12">
      <h1>Jouw zoekertjes</h1>
      <br>
    </div>
  </div>
    <div class="row">
        <div class="col-md-12">
          @if (count($advers) < 1)
              
          <h3>Geen zoekertjes gevonden</h3>

          @else
          
          <div class="card-deck justify-content-center">
            @foreach ($advers as $adver)
                <div style="max-width: 250px" class="card">
                <img style="height: 220px; object-fit: cover;" src="/storage/images/{{$adver->images}}" class="card-img-top" alt="...">
                    <div class="card-body">
                      <h5 class="card-title"><b>{{$adver->title}}</b></h5>
                    <p class="card-text">
                        {!!$adver->discription!!}
                        <hr>
                    </p>
                      <a style="width:100%; margin-bottom: 10px;" href="/currentUser/{{$adver->id}}/edit" class="btn btn-outline-primary">Aanpassen</a>
                      {{-- deleteknop hieronder  --}}
                      {!!Form::open(['action'=>['currentUserController@destroy', $adver->id], 'method'=>'POST'])!!}
                          {{Form::hidden('_method', 'DELETE')}}
                          <a onclick="return confirm('Ben je zeker dat je zoekertje: {{$adver->title}} wilt verwijderen?')">
                          {{Form::submit('Verwijderen', ['class'=>'btn btn-outline-danger', 'style' => 'width:100%; margin-bottom: 10px',])}}</a>
                      {!!Form::close()!!}
                    </div>
                  </div>
            @endforeach     
            @endif
          </div>     
        </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        {{ $advers->links() }}
      </div>
    </div>
</div>

@endsection