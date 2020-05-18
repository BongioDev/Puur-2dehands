@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('verifieer uw e-mail adres') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Een verificatie link is naar uw e-mail adres verstuurd') }}
                        </div>
                    @endif

                    {{ __('Controleer voordat u doorgaat uw inbox voor een verificatielink.') }}
                    {{ __('Als u geen e-mail hebt ontvangen') }}, <a href="{{ route('verification.resend') }}">{{ __('klik dan hier voor een nieuwe verificatie link') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
