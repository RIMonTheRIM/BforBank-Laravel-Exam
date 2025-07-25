@extends('layouts.app')

@section('content')
<div class="pageContent">
    <div class="loginWrapper registerWrapper">
        <div class="registerFormWrapper">
            <div class="registerTitle">{{ __('Register') }}</div>
            <form class="registerForm" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="">
                    <label for="nom" class="">{{ __('Nom') }}</label>

                    <div class="">
                        <input id="nom" type="text" class="form-control @error('name') is-invalid @enderror" name="nom" value="{{ old('nom') }}" required autocomplete="nom" autofocus>

                        @error('nom')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <label for="prenom" class="">{{ __('Prénom') }}</label>

                    <div class="">
                        <input id="prenom" type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" value="{{ old('prenom') }}" required autocomplete="prenom" autofocus>

                        @error('nom')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <label for="email" class="">{{ __('Addresse Email') }}</label>

                    <div class="">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <label for="telephone" class="">{{ __('Telephone') }}</label>

                    <div class="">
                        <input id="telephone" type="text" class="form-control @error('telephone') is-invalid @enderror" name="telephone" value="{{ old('telephone') }}" required autocomplete="telephone" autofocus>

                        @error('telephone')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <label for="password" class="">{{ __('Mot de passe') }}</label>

                    <div class="">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <label for="password-confirm" class="">{{ __('Confirmer le mot de passe') }}</label>

                    <div class="">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>
                <div class="submitButton">
                    <button type="submit" class="btn btn-primary">
                        S'inscrire
                    </button>
                </div>
            </form>
            <div class="submitButton switchButton">
                <a class="btn btn-link" href="{{ route('login') }}">Vous avez déjà un compte? Se connecter</a>
            </div>

        </div>

    </div>
    <div class="registerBackground">
    </div>
</div>

@endsection
