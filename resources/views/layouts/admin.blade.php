@extends('layouts.app')

@section('body')
<div class="layout-fixed layout-navbar-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-dark">
            @auth()
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <form class="form-inline" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </li>
            </ul>
            @endauth
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ route('home') }}" class="brand-link text-decoration-none text-reset justify-content-center d-flex">
                <span class="brand-text text-light">{{ __('Test task') }}</span>
            </a>
            <div class="sidebar">
                <nav class="mt-3">
                    <ul class="nav nav-pills nav-sidebar flex-column">
                        <li class="nav-item">
                            <a href="{{ route('events.index') }}" class="nav-link">
                                <i class="fas fa-users"></i>
                                <p>{{ __('Events') }}</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    @yield('content-header')
                </div>
            </div>
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


