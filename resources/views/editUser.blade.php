@extends('layouts.app')
@extends('layouts.googleAdver')

@section('content')

{{--  wachtwoord laten opgeven bij veranderen profiel!!! --}}

<div class="container">
    <div class="row">
        <div class="col-md-12">
           {{-- form user gegevens aanpassen/bijvullen(foto en woonplaats) --}}
            {!! Form::open(['action' => ['editUserController@update', $user->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                   {{-- naam --}}
                    <div class="form-group">
                        {{Form::label('name', 'Naam')}}
                        {{Form::text('name', $user->name, ['class' => 'form-control', 'placeholder' => 'Naam'])}}
                    </div>  
                    {{-- locatie  --}}
                    <div class="form-group">
                        {{Form::label('location', 'Woonplaats')}}
                        <small>(Geef enkel jouw stad of gemeente weer)</small>
                        {{Form::text('location', $user->location, ['id' => 'autocomplete', 'class' => 'form-control', 'placeholder' => 'Woonplaats'])}}
                    </div>   
                    {{-- tel  --}}
                    <div class="form-group">
                        {{Form::label('tel', 'Tel. Nr.')}}
                        {{Form::text('tel', $user->tel, ['class' => 'form-control', 'placeholder' => 'Tel. Nr;'])}}
                    </div>  
                    {{-- image --}}
                    <div class="form-group">
                        {{Form::label('user_image', 'Profielfoto')}}
                        <br>
                        {{Form::file('user_image')}}
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