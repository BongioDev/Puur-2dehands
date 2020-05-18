@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row text-center">
        <div class="col-md-12">
          @if (Auth::user()->id == $user->id)
            <h1>Jouw profiel</h1>
            <br>
          @else
        <h1>Profiel van {{$user->name}}</h1>
          @endif
        </div>
    </div>
    <div class="row no-gutters">
        <div class="col-lg-4">
          {{-- links --}}
            <div class="card mx-auto" style="width: 16rem; margin-bottom: 30px">
                <img src="/storage/user_images/{{$user->user_image}}" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Navigatie</h5>
                  <hr>
                  @if (Auth::user()->id == $user->id)
                    <a style="margin-bottom:10px; width:100%" href="/currentUser/myAdver" class="btn btn-outline-primary">Mijn zoekertjes</a> 
                  @else
                <a style="margin-bottom:10px; width:100%" href="/currentUser/guest/myAdver/guest/{{$user->id}}" class="btn btn-outline-primary">Zoekertjes van dit profiel</a> 
                  @endif
                  @if (Auth::user()->id == $user->id)
                    <a style="margin-bottom:10px; width:100%" href="/resetpassword" class="btn btn-outline-primary">Verander wachtwoord</a>
                  @endif
                  </div>
              </div>
        </div>
        <div class="col-lg-8">
          {{-- rechts --}}
            <div class="card" style="width: 100%;">
                <div class="card-body">
                  <h3 class="card-title">Gegevens</h3>
                  <p class="card-text"><span style="font-size:14pt;">Naam: </span>{{$user->name}}</p>
                  <p class="card-text"><span style="font-size:14pt;">E-mail adres: </span>{{$user->email}}</p>
                  @if (Auth::user()->id == $user->id)
                  <small>(Optioneel)</small>
                  @endif
                  <p class="card-text"><span style="font-size:14pt;">Woonplaats: </span>{{$user->location}}</p>
                  @if (Auth::user()->id == $user->id)
                  <small>(Optioneel)</small>
                  @endif
                  <p class="card-text"><span style="font-size:14pt;">Tel. nr. : </span>{{$user->tel}}</p>
                  <hr>
                  @if (Auth::user()->id == $user->id)
                    <a href="/editUser/{{$user->id}}/edit" class="btn btn-outline-primary">Aanpassen</a>
                  @endif
                </div>
              </div>
              
              {{-- reviews --}}
              <div class="card" style="width: 100%; margin-top: 25px">
                <div class="card-body">
                  <h3 class="card-title">Beoordelingen gebruiker</h3>

                  @foreach ($user->review as $review)
                  <p class="card-text">
                    @php 
                      $author = DB::table('users')->where('id', $review->author_id)->first();
                    @endphp 
                    <a href="/currentUser/guest/{{$author->id}}">{{$author->name}}</a> schreef: <b>{{$review->review}}</b>
                    <br>
                    <small>{{$review->created_at}}</small>
                    {{-- delete button --}}
                    @if (Auth::user()->id == $author->id)
                    {!!Form::open(['action' => ['HomeController@reviewDestroy', $review->id], 'method' => 'post'])!!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{ Form::button('
                        <svg class="bi bi-trash-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" d="M2.5 1a1 1 0 00-1 1v1a1 1 0 001 1H3v9a2 2 0 002 2h6a2 2 0 002-2V4h.5a1 1 0 001-1V2a1 1 0 00-1-1H10a1 1 0 00-1-1H7a1 1 0 00-1 1H2.5zm3 4a.5.5 0 01.5.5v7a.5.5 0 01-1 0v-7a.5.5 0 01.5-.5zM8 5a.5.5 0 01.5.5v7a.5.5 0 01-1 0v-7A.5.5 0 018 5zm3 .5a.5.5 0 00-1 0v7a.5.5 0 001 0v-7z" clip-rule="evenodd"/>
                        </svg>
                        ', ['style' => 'width: 15%', 'class' => 'btn btn-outline-danger', 'role' => 'button', 'type' => 'submit']) }}
                    {!!Form::close() !!}
                    @endif
                    <hr>
                  </p>
                    @endforeach

                  {{-- form review--}}
                  @if (Auth::user()->id != $user->id)
                  <form method="post" action="/currentUser/guest/{{$user->id}}/{{Auth::user()->id}}">
                    @csrf
                    <input name="review" type="text" class="form-control">
                    <br>
                    <button type="submit" class="btn btn-outline-primary">Plaats een beoordeling</button>
                  </form>
                  @endif
                </div>
              </div>
        </div>
    </div>

@endsection