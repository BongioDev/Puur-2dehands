@extends('layouts.app')
@extends('layouts.googleAdver')

@section('content')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div style="margin-bottom: 50px">
            {!! Form::open(['action' => 'HomeController@searchInput', 'method' => 'GET', 'id' => 'test']) !!}
                @csrf
                {{-- zoeken text --}}
                {{Form::text('zoekopdracht', '', ['class' => 'form-control', 'placeholder' => 'Zoekopdracht', 'style' => 'max-width: 40%; display:inline;'])}}
                {{-- regio --}}
                {{Form::text('regio', '', ['id' => 'autocomplete', 'class' => 'form-control', 'placeholder' => 'Regio', 'style' => 'max-width: 20%; display:inline;'])}}
                {{-- zoeken afstand van regio --}}
                {{Form::select('afstand',['id' => 'afstand', '' => 'Max. afstand', '5000' => '< 5 km', '10000' => '< 10 km', '25000' => '< 25 km', '50000' => '< 50 km', '70000' => '< 70 km', '100000' => '< 100 km'])}}
                {{-- zoeken categorie --}}
                <select name="category">
                    <option value="">Alle categorieën</option>
                    @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
                {{-- submit button --}}
                {{Form::submit('Zoek', ['id' => 'test', 'class' => 'btn btn-outline-primary'])}}
                                
            {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
    <div class="container-fluid">
        <div class="row">
            {{-- verdwijnt na smaller dan lg --}}
            <div class="col-lg-2 d-none d-lg-block">
                <h3>Categorieën</h3>
                <div class="list-group">
                    @foreach ($categories as $category)
                    <a href="/cat/{{$category->id}}" class="category list-group-item list-group-item-action">{{$category->name}}</a>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-10 text-center">
                        <h1>Zoekertjes</h1>
                @foreach ($advers->chunk(4) as $chunk)
                <div class="card-deck">
                    @foreach ($chunk as $adver)
                    {{-- decode de image paths uit de adver --}}
            @php
            $decoded_images = json_decode($adver->images);
            @endphp
                     {{-- style in css bestand geeft problemen...??? --}}
                    <div style="max-width: 250px; min-width: 200px; margin: 0 auto; margin-bottom: 30px" class="card">
                        <a href="/showAdverUser/{{$adver->id}}">
                            <img style="height: 220px; object-fit: cover;" src="/storage/images/{{$decoded_images[0]->image}}" class="card-img-top">
                            <div class="card-body">
                            <h5 class="card-title"><b>{{$adver->title}}</b></h5>
                        </a>
                            <p class="card-text">
                                <b>€ : {{$adver->price}}</b>
                                <hr>
                            </p>
                            <a style="width:100%; margin-bottom: 10px;" href="/showAdverUser/{{$adver->id}}" class="btn btn-outline-primary">Bekijk</a>
                    </div>
                </div>
                @endforeach
            </div> 
            @endforeach 
           <div class="d-flex justify-content-center">{{ $advers->links() }}</div>   
        </div>
    </div>

@endsection

