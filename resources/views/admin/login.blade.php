@extends('layouts.admin')

@section('content')
<div class="page page-center flex-fill">
  <div class="container container-tight">
    <div class="card card-md">
      <form action="" method="POST" class="card-body need-validation" novalidate>
        <h2 class="h2 text-center mb-4">Login to <b>Admin</b>Panel</h2>
        <div id="message" class="alert py-2 lh-sm @error('message') alert-danger @else d-none @enderror">@error('message'){{ $message }}@enderror</div>
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input required type="email" id="email" name="email"
                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
            <div class="invalid-feedback">
                @error('email')
                    {{ $message }}
                @else
                    Email is required and must be valid.
                @enderror
            </div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input required type="password" id="password" name="password"
                class="form-control @error('password') is-invalid @enderror" value="">
            <div class="invalid-feedback">@error('password'){{ $message }} @else Password is required. @enderror</div>
        </div>
        <div class="mb-3">
          <label class="form-check">
            <input type="checkbox" class="form-check-input" name="remember" value="1" />
            <span class="form-check-label">Remember me</span>
          </label>
        </div>
        <button type="submit" class="btn btn-primary w-100 px-5">Login</button>
      </form>
    </div>
  </div>
</div>
@endsection