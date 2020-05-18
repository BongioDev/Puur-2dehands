@extends('layouts.googleAdver')
@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row text-center">
        <div class="col-md-12">
            <h1>Zoekertje aanmaken</h1>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
           {{-- form zoeketje aanmaken --}}
            {!! Form::open(['action' => 'AdverController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

                    <h2>Algemene informatie</h2>
                    {{-- titel --}}
                    <div class="form-group">
                        {{Form::label('title', 'Titel')}}
                        {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Titel'])}}
                    </div>
                    {{-- beschrijving --}}
                    <div class="form-group">
                        {{Form::label('discription', 'Beschrijving')}}
                        {{Form::textarea('discription', '', ['class' => 'form-control description', 'rows' => 5, 'cols' => 50, 'placeholder' => 'Beschrijving'])}}
                    </div>
                    {{-- categorie --}}
                    Categorie
                    <select name="category">
                        <option value="">Kies categorieën</option>
                        @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                    {{-- conditie --}}
                    <div class="form-group">
                        {{Form::label('condition', 'Conditie')}}
                        {{Form::select('condition',['' => 'Kies conditie', 'Nieuw' => 'Nieuw', 'Gebruikt' => 'Gebruikt'])}}
                    </div>
                    {{-- fotos --}}
                    <h2>Foto's</h2>
                    <div class="form-group">
                        <input type="file" id="file-input" name="image[]" multiple />                        
                        <br>
                        <small>Max. 5 foto's</small>
                    </div>
                    <h2>Prijs</h2>
                    {{-- prijs categorie --}}
                    <div class="form-group">
                        <select id="select" name="priceclass" onchange="prijsklasse()">
                            <option value="">Kies prijsklasse</option>
                            <option id="vraagprijs" value="Vraagprijs">Vraagprijs</option>
                            <option id="bieden" value="Bieden">Bieden</option>
                            <option id="otk"    value="Prijs overeen te komen">Prijs overeen te komen</option>
                            <option id="ruilen" value="Ruilen">Ruilen</option>
                            <option id="gratis" value="Gratis">Gratis</option>
                        </select>
                    </div>

                    <script>
                        function prijsklasse(){
                    
                            var prijs = document.getElementById("prijs");
                    
                           if(document.getElementById('vraagprijs').selected == true){
                               prijs.readOnly = false;
                               prijs.value = "";
                           }
                           if(document.getElementById('bieden').selected == true){
                               prijs.readOnly = false;
                               prijs.value = "Bieden vanaf: € ";
                           }
                           if(document.getElementById('otk').selected == true){
                               prijs.value = "Prijs overeen te komen";
                               prijs.readOnly = true;
                           }
                           if(document.getElementById('ruilen').selected == true){
                               prijs.value = "Ruilen";
                               prijs.readOnly = true;
                           }
                           if(document.getElementById('gratis').selected == true){
                               prijs.value = "Gratis";
                               prijs.readOnly = true;
                           }
                       }
                    </script>

                    {{-- Prijs --}}
                    <div class="form-group">
                        {{Form::label('price', 'Prijs')}}
                        {{Form::text('price', '', ['id' => 'prijs', 'class' => 'form-control', 'placeholder' => 'Prijs'])}}
                    </div>
                    <h2>Contactgegevens</h2>
                    {{-- tel --}}
                    <div class="form-group">
                        {{Form::label('tel', 'Tel.')}}
                        {{Form::text('tel', '', ['class' => 'form-control', 'placeholder' => 'Tel.'])}}
                    </div>
                    {{-- locatie --}}
                    <div class="form-group">
                        {{Form::label('location', 'Stad of gemeente')}}
                        {{Form::text('location', '', ['id' => 'autocomplete', 'class' => 'form-control', 'placeholder' => 'Stad of gemeente'])}}
                    </div>
                    {{-- submit knop --}}
                    <br>
                        {{Form::submit('Plaats zoekertje', ['id' => 'submit', 'class' => 'btn btn-outline-primary'])}}
            
            {!! Form::close() !!}

        </div>
    </div>
</div>

@endsection