@extends('layouts.app')

@section('content')

<div class="container" xmlns:v-bind="http://www.w3.org/1999/xhtml">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body" v-bind:style="styles">

                    {!! Form::open(['route' => 'register', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'POST', 'id' => 'registerForm'] ) !!}

                        {{ csrf_field() }}

                    <div class="columns">
                        <div class="column is-one-third">
                            <label for="user_type" class="label">Account Type</label>
                        </div>
                        <div class="column">
                            <b-field>
                                <b-radio-button v-model="accountType"
                                                name="user_type"
                                                native-value="personal"
                                                type="is-info">
                                    <b-icon icon="account"></b-icon>
                                    <span>Personal</span>
                                </b-radio-button>

                                <b-radio-button v-model="accountType"
                                                name="user_type"
                                                native-value="business"
                                                type="is-success">
                                    <b-icon icon="store"></b-icon>
                                    <span>Business</span>
                                </b-radio-button>
                            </b-field>
                        </div>
                    </div>

                    <div class="field">
                        <div class="columns">
                            <div class="column is-one-third">
                                <label for="name" class="label" v-if="accountType == 'personal'">UserName</label>
                                <label for="name" class="label" v-else>AccountName</label>
                            </div>
                            <div class="column">
                                <p class="control">
                                    <input class="input {{ $errors->has('name') ? 'is-danger' : '' }}" type="text" name="name" id="name" value="{{ old('name') }}" placeholder="User Name" v-if="accountType == 'personal'" required>
                                    <input class="input {{ $errors->has('name') ? 'is-danger' : '' }}" type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Account Name" v-else required>
                                </p>
                                @if ($errors->has('name'))
                                    <p class="help is-danger">{{ $errors->first('name') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="columns">
                            <div class="column is-one-third">
                                <label for="full_name" class="label" v-if="accountType == 'personal'">Full Name</label>
                                <label for="full_name" class="label" v-else>Store Name</label>
                            </div>
                            <div class="column">
                                <p class="control">
                                    <input class="input {{ $errors->has('full_name') ? 'is-danger' : '' }}" type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" placeholder="Full Name" v-if="accountType == 'personal'" required>
                                    <input class="input {{ $errors->has('name') ? 'is-danger' : '' }}" type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" placeholder="Store Name" v-else required>
                                </p>
                                @if ($errors->has('full_name'))
                                    <p class="help is-danger">{{ $errors->first('full_name') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>


                    <div class="field">
                        <div class="columns">
                            <div class="column is-one-third">
                                <label for="email" class="label">Email</label>
                            </div>
                            <div class="column">
                                <b-field>
                                    <b-input value="{{ old('email') }}" placeholder="Email" type="email" class="{{ $errors->has('email') ? 'is-danger' : '' }}" name="email" id="email" required></b-input>
                                </b-field>
                                @if ($errors->has('email'))
                                    <p class="help is-danger">{{ $errors->first('email') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="columns">
                            <div class="column is-one-third">
                                <label for="phone_number" class="label">Phone Number</label>
                            </div>
                            <div class="column">
                                <b-field>
                                    <b-input value="{{ old('email') }}" placeholder="Phone Number" type="text" class="{{ $errors->has('phone_number') ? 'is-danger' : '' }}" name="phone_number" id="phone_number"></b-input>
                                </b-field>
                                @if ($errors->has('phone_number'))
                                    <p class="help is-danger">{{ $errors->first('phone_number') }}</p>
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

                    <div class="field">
                        <div class="columns">
                            <div class="column is-one-third">
                                <label for="password-confirm" class="label">Confirm Password</label>
                            </div>
                            <div class="column">
                                <b-field>
                                    <b-input type="password"
                                             placeholder="Confirm Password"
                                             name="password_confirmation"
                                             id="password-confirm"
                                             class="{{ $errors->has('password_confirmation') ? 'is-danger' : '' }}"
                                             password-reveal>
                                    </b-input>
                                </b-field>
                                @if ($errors->has('password_confirmation'))
                                    <p class="help is-danger">{{ $errors->first('password_confirmation') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                        @if(config('settings.reCaptchStatus'))
                            <div class="form-group">
                                <div class="col-sm-6 col-sm-offset-4">
                                    <div class="g-recaptcha" data-sitekey="{{ config('settings.reCaptchSite') }}"></div>
                                </div>
                            </div>
                        @endif
                        <div class="form-group margin-bottom-2">
                            <div class="col-sm-6 col-sm-offset-4">
                                <button type="submit" class="button is-info">
                                    Register
                                </button>
                            </div>
                        </div>

                        <p class="text-center margin-bottom-2">
                            Or Use Social Logins to Register
                        </p>

                        @include('partials.socials')

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer_scripts')

    <script src='https://www.google.com/recaptcha/api.js'></script>

    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\RegisterUserRequest', '#registerForm'); !!}

    <script>

        const app = new Vue({
            el: '#app',
            data:{
                accountType: '',

            },
            computed: {
                styles: function () {
                    if (this.accountType === 'personal'){
                        return {
                            'background-color' : 'rgba(0, 43, 255, 0.15)'
                        }
                    } else {
                        return {
                            'background-color' : 'rgba(4, 255, 0, 0.15)'
                        }
                    }
                }
            }
        });
        app.accountType = 'personal';
    </script>

@endsection