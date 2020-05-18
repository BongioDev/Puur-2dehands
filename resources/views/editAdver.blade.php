@extends('layouts.googleAdver')
@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
           {{-- form zoeketje aanmaken --}}
            {!! Form::open(['action' => ['currentUserController@update', $advers->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

                    <h2>Algemene informatie</h2>
                    {{-- titel --}}
                    <div class="form-group">
                        {{Form::label('title', 'Titel')}}
                        {{Form::text('title', $advers->title, ['class' => 'form-control', 'placeholder' => 'Titel'])}}
                    </div>
                    {{-- beschrijving --}}
                    <div class="form-group">
                        {{Form::label('discription', 'Beschrijving')}}
                        {{Form::textarea('discription', $advers->discription, ['class' => 'form-control description', 'rows' => 5, 'cols' => 50, 'placeholder' => 'Beschrijving'])}}
                    </div>
                     {{-- categorie --}}
                     {{-- prefilled niet... oplossing is handmatig alle categorieën typen met de values..... --}}
                     Categorie
                     <select name="category">
                         <option value="">Alle categorieën</option>
                         @foreach ($categories as $category)
                         <option @if ($advers->category_id == $category->id) selected="selected" @endif value="{{$category->id}}">{{$category->name}}</option>
                         @endforeach
                     </select>
                    {{-- conditie --}}
                    <div class="form-group">
                        <label for="condition">Conditie</label>
                        <select name="condition">
                            <option value="">Kies prijsklasse</option>
                            <option @if ($advers->condition == 'Nieuw') selected="selected" @endif value="Nieuw">Nieuw</option>
                            <option @if ($advers->condition == 'Gebruikt') selected="selected" @endif value="Gebruikt">Gebruikt</option>
                        </select>
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
                            <option id="vraagprijs" @if ($advers->priceclass == 'Vraagprijs') selected="selected" @endif value="Vraagprijs">Vraagprijs</option>
                            <option id="bieden" @if ($advers->priceclass == 'Bieden') selected="selected" @endif value="Bieden">Bieden</option>
                            <option id="otk" @if ($advers->priceclass == 'Prijs overeen te komen') selected="selected" @endif        value="Prijs overeen te komen">Prijs overeen te komen</option>
                            <option id="ruilen" @if ($advers->priceclass == 'Ruilen') selected="selected" @endif value="Ruilen">Ruilen</option>
                            <option id="gratis" @if ($advers->priceclass == 'Gratis') selected="selected" @endif value="Gratis">Gratis</option>
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
                        {{Form::text('price', $advers->price, ['id' => 'prijs', 'class' => 'form-control', 'placeholder' => 'Prijs'])}}
                    </div>
                    <h2>Contactgegevens</h2>
                    {{-- tel --}}
                    <div class="form-group">
                        {{Form::label('tel', 'Tel.')}}
                        {{Form::text('tel', $advers->tel, ['class' => 'form-control', 'placeholder' => 'Tel.'])}}
                    </div>
                    {{-- locatie --}}
                    <div class="form-group">
                        {{Form::label('location', 'Stad of gemeente')}}
                        {{Form::text('location', $advers->location, ['id' => 'autocomplete', 'class' => 'form-control', 'placeholder' => 'Stad of gemeente'])}}
                    </div>
                    {{-- submit knop --}}
                    <br>
                        {{Form::hidden('_method', 'PUT')}}
                        {{Form::submit('Aanpassen', ['class' => 'btn btn-outline-primary'])}}
            
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection