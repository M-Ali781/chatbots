@php
  $configData = Helper::appClasses();
  $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', 'Admin Login')

@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/@form-validation/form-validation.scss'
  ])
@endsection

@section('page-style')
  @vite([
    'resources/assets/vendor/scss/pages/page-auth.scss'
  ])
@endsection

@section('vendor-script')
  @vite([
    'resources/assets/vendor/libs/@form-validation/popular.js',
    'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
    'resources/assets/vendor/libs/@form-validation/auto-focus.js'
  ])
@endsection

@section('page-script')
  @vite([
    'resources/assets/js/pages-auth.js'
  ])
@endsection

@section('content')
  <div class="position-relative">
    <div class="authentication-wrapper authentication-basic container-p-y p-4 p-sm-0">
      <div class="authentication-inner py-6">

        {{-- Gestion des messages --}}
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        @if ($errors->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        <!-- Login Card -->
        <div class="card p-md-7 p-1">
          <!-- Logo -->
          <div class="app-brand justify-content-center mt-5">
            <a href="{{ url('/') }}" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">
                <img src="{{ asset('assets/img/favicon/favicon.ico') }}" alt="Admin Logo" width="50">
              </span>
              <span class="app-brand-text demo text-heading fw-semibold">Admin Panel</span>
            </a>
          </div>
          <!-- /Logo -->

          <div class="card-body mt-1">
            <h4 class="mb-1 text-center">Bienvenue 👋</h4>
            <p class="mb-4 text-center">Connectez-vous en tant qu'administrateur pour continuer</p>

            <form method="POST" action="{{ route('admin.login') }}">
              @csrf
              <div class="form-floating form-floating-outline mb-3">
                <input type="email" id="adminLoginEmail" class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" placeholder="Entrez votre email" required autofocus>
                <label for="adminLoginEmail">Email</label>
                @error('email')
                <span class="invalid-feedback d-block">{{ $message }}</span>
                @enderror
              </div>

              <div class="mb-3">
                <div class="form-password-toggle">
                  <div class="input-group input-group-merge">
                    <div class="form-floating form-floating-outline">
                      <input type="password" id="adminLoginPassword"
                             class="form-control @error('password') is-invalid @enderror"
                             name="password" placeholder="Mot de passe" required>
                      <label for="adminLoginPassword">Mot de passe</label>
                    </div>
                    <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                  </div>
                  @error('password')
                  <span class="invalid-feedback d-block">{{ $message }}</span>
                  @enderror
                </div>
              </div>

              <div class="mb-3 d-flex justify-content-between align-items-center">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="adminRememberMe" name="remember"
                    {{ old('remember') ? 'checked' : '' }}>
                  <label class="form-check-label" for="adminRememberMe">Se souvenir de moi</label>
                </div>
              </div>

              <button type="submit" class="btn btn-primary d-grid w-100">Se connecter</button>
            </form>
          </div>
        </div>
        <!-- /Login Card -->

        <img alt="mask" src="{{ asset('assets/img/illustrations/auth-basic-login-mask-'.$configData['style'].'.png') }}" class="authentication-image d-none d-lg-block" />
      </div>
    </div>
  </div>
@endsection
