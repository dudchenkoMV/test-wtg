@extends('layouts.app')

@section('body')
        <div class="login-page dark-mode">
            <div class="login-box">
                <div class="login-logo">
                    <h3>{{ __('Login') }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-group row m-0">
                            <label for="email">Email:</label>
                        </div>
                        <div class="form-group mb-3 row">
                            <input type="email" class="form-control" id="email" name="email" placeholder="email@example.com" value="{{ old('email') }}">
                            @error('email')
                            <div class="alert alert-warning">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group m-0 row">
                            <label for="password">Password:</label>
                        </div>
                        <div class="form-group mb-3 row">
                            <input type="password" class="form-control" id="password" name="password">
                            @error('password')
                            <div class="alert alert-warning">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3 row d-flex justify-content-end">
                            <button class="btn btn-light" type="submit"> {{ __('Login') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
