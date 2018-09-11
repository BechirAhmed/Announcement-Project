@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="field">
                            <div class="columns">
                                <div class="column is-one-third">
                                    <label for="login" class="label">{{ __('Username or Email') }}</label>
                                </div>
                                <div class="column">
                                    <b-field>
                                        <b-input value="{{ old('name') ?: old('email') }}" placeholder="Email" type="text" class="{{ $errors->has('name') || $errors->has('email') ? 'is-danger' : '' }}" name="login" id="login" required autofocus></b-input>
                                    </b-field>
                                    @if ($errors->has('name') || $errors->has('email'))
                                        <p class="help is-danger">{{ $errors->first('name') ?: $errors->first('email') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="columns">
                                <div class="column is-one-third">
                                    <label for="password" class="label">Password</label>
                                </div>
                                <div class="column">
                                    <b-field>
                                        <b-input type="password"
                                                 placeholder="Password reveal input"
                                                 name="password"
                                                 id="password"
                                                 class="{{ $errors->has('password') ? 'is-danger' : '' }}"
                                                 minlength="6"
                                                 password-reveal>
                                        </b-input>
                                    </b-field>
                                    @if ($errors->has('password'))
                                        <p class="help is-danger">{{ $errors->first('password') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="field">
                                    <b-checkbox name="remember" {{ old('remember') ? 'checked' : '' }}>Remember Me</b-checkbox>
                                </div>
                            </div>
                        </div>

                        <div class="form-group margin-bottom-3">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="button is-info">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>

                        <p class="text-center margin-bottom-3">
                            Or Login with
                        </p>

                        @include('partials.socials-icons')

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_scripts')

@endsection