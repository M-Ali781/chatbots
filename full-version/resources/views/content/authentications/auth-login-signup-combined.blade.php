@php
  $configData = Helper::appClasses();
  $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', ' Login & Sign Up')

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

        @if ($errors->has('login_error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $errors->first('login_error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        @if ($errors->any() && !$errors->has('login_error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        <!-- Login & Sign Up Card -->
        <div class="card p-md-7 p-1">
          <!-- Logo -->
          <div class="app-brand justify-content-center mt-5">
            <a href="{{ url('/') }}" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">
                  <img src="{{ asset('assets/img/favicon/favicon.ico') }}" alt="CHATbots Logo" width="50">
              </span>

              <span class="app-brand-text demo text-heading fw-semibold">CHATbots</span>
            </a>
          </div>
          <!-- /Logo -->

          <div class="card-body mt-1">
            <ul class="nav nav-pills nav-justified mb-4" id="authTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">
                  Login
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="signup-tab" data-bs-toggle="tab" data-bs-target="#signup" type="button" role="tab">
                  Sign Up
                </button>
              </li>
            </ul>

            <div class="tab-content" id="authTabContent">
              <!-- Login Form -->
              <div class="tab-pane fade show active" id="login" role="tabpanel">
                <h4 class="mb-1">Welcome to CHATbots 👋</h4>
                <p class="mb-4">Please sign in to continue</p>
                <form method="POST" action="{{ route('login-signup.post') }}">
                  @csrf
                  <input type="hidden" name="form_type" value="login">
                  <div class="form-floating form-floating-outline mb-3">
                    <input type="email" id="loginEmail" class="form-control" name="email" placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
                    <label for="loginEmail">Email</label>
                  </div>
                  <div class="mb-3">
                    <div class="form-password-toggle">
                      <div class="input-group input-group-merge">
                        <div class="form-floating form-floating-outline">
                          <input type="password" id="loginPassword" class="form-control" name="password" placeholder="Password" required>
                          <label for="loginPassword">Password</label>
                        </div>
                        <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                      </div>
                    </div>
                  </div>
                  <div class="mb-3 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
                      <label class="form-check-label" for="rememberMe">Remember Me</label>
                    </div>
                    <a href="{{ url('auth/forgot-password-basic') }}">Forgot Password?</a>
                  </div>
                  <button type="submit" class="btn btn-primary d-grid w-100">Login</button>
                </form>
              </div>

              <!-- Sign Up Form -->
              <div class="tab-pane fade" id="signup" role="tabpanel">
                <h4 class="mb-1">Create your CHATbots account 🚀</h4>
                <p class="mb-4">Fill the details below to sign up</p>
                <form method="POST" action="{{ route('login-signup.post') }}">
                  @csrf
                  <input type="hidden" name="form_type" value="signup">
                  <div class="form-floating form-floating-outline mb-3">
                    <input type="text" id="signupName" class="form-control" name="name" placeholder="Enter your name" value="{{ old('name') }}" required>
                    <label for="signupName">Name</label>
                  </div>
                  <div class="form-floating form-floating-outline mb-3">
                    <input type="email" id="signupEmail" class="form-control" name="email" placeholder="Enter your email" value="{{ old('email') }}" required>
                    <label for="signupEmail">Email</label>
                  </div>
                  <div class="mb-3">
                    <div class="form-password-toggle">
                      <div class="input-group input-group-merge">
                        <div class="form-floating form-floating-outline">
                          <input type="password" id="signupPassword" class="form-control" name="password" placeholder="Password" required>
                          <label for="signupPassword">Password</label>
                        </div>
                        <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                      </div>
                    </div>
                  </div>
                  <div class="mb-3">
                    <div class="form-floating form-floating-outline">
                      <input type="password" id="signupPasswordConfirm" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                      <label for="signupPasswordConfirm">Confirm Password</label>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-success d-grid w-100">Sign Up</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- /Login & Sign Up Card -->

        <img alt="mask" src="{{ asset('assets/img/illustrations/auth-basic-login-mask-'.$configData['style'].'.png') }}" class="authentication-image d-none d-lg-block" />
      </div>
    </div>
  </div>
@endsection
