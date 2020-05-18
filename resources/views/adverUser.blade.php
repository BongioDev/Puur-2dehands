@extends('layouts.app')

{{-- hier ook meerdere fotos fiksen --}}

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="jumbotron">
                <h1>{{$adver->title}}</h1>
                <small>Toegevoegd op: {{$adver->created_at}}</small>
                <br>
                {{-- carousel --}}
                <div id="carouselExampleIndicators" class="carousel slide" data-interval="false">
                  <div style="" class="carousel-inner">
                    @foreach ($images as $image)
                    <div class="carousel-item @if($loop->first) active @endif">
                      <img style="margin: 0 auto; max-width: 100%; max-height: 700px;" class="d-block" src="/storage/images/{{$image->image}}" alt="First slide">
                    </div>
                    @endforeach
                  </div>
                  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
                
                <p class="lead">{!!$adver->discription!!}</p>
                <hr class="my-4">
                <p><b>Category: </b>{{$adver->category->name}}</p>
                <p><b>Conditie: </b>{{$adver->condition}}</p>
                <p><b>Locatie: </b>{{$adver->location}}</p>
                <p><b>Prijsklasse: </b>{{$adver->priceclass}}</p>
                <p><b>Prijs: </b>€ {{$adver->price}}</p>
              </div>
        </div>
        <div class="col-md-4">
            <div class="card" style="width: 100%;">
                <div class="card-body">
                  <h3 class="card-title"><b>Eigenaar zoekertje: </b></h3>
                  <p class="card-text"><b>Naam: </b>{{$adver->user->name}}</p>
                  <p class="card-text"><b>E-mail: </b>{{$adver->user->email}}</p>
                  <p class="card-text"><b>Tel. nr. : </b>{{$adver->user->tel}}</p>
                  <p class="card-text"><b>Locatie: </b>{{$adver->user->location}}</p>
                <a style="width: 100%;margin-bottom:10px" href="/currentUser/guest/{{$adver->user_id}}" class="btn btn-outline-primary">Bekijk profiel</a>
                  <a  style="width: 100%" href="/sendmail/{{$adver->id}}" class="btn btn-outline-primary">Stuur een bericht</a>     
              </div>
            </div>
        </div>
    </div>
</div>

@endsection
