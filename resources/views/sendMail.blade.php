@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            @csrf @method('POST')
            {!! Form::open(['action' => ['HomeController@sendMailToAdverUser', $adverId], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        
            <div class="form-group">                       
                {{Form::label('message', 'Jouw bericht')}}                      
                {{Form::textarea('message', '<p>Beste ' . $adver->user->name . ',</p><p>Is uw zoekertje: "' . $adver->title . '" nog beschikbaar?</p><br><p>Groeten ' . $user->name . '!</p>
                <p>E-mail: ' . $user->email . ' </p><p>Tel. Nr. : ' . $user->tel . '</p>', ['class' => 'form-control description', 'rows' => 15, 'cols' => 50, 'placeholder' => 'Bericht'])}}                   
            </div>                   
            <br>                       
            {{Form::submit('Verstuur bericht', ['class' => 'btn btn-outline-primary'])}}
                       
            {!! Form::close() !!}
        </div>
    </div>
</div>
 
@endsection
