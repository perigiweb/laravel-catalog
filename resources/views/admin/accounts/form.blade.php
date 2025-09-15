@extends('layouts.admin')

@section('content')
<div class="col col-md-8 col-lg-7 col-xl-6 mx-auto">
  @if (session()->has('account_message'))
  <div class="alert alert-{{ session('account_message.type') }}">{{ session('account_message.text') }}</div>
  @endif
  <form action="{{ $account->exists ? route('admin.accounts.update', ['account' => $account]):route('admin.accounts.store') }}" method="POST" novalidate class="card need-validation">
    @if ($account->exists)
        <input type="hidden" name="_method" value="patch">
    @endif
    @csrf
    <div class="card-body">
      <div class="mb-3">
        <label for="name" class="form-label required">Name</label>
        <input required type="text" id="name" name="name" placeholder="Name"
            class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $account->name) }}">
        <div class="invalid-feedback">@error('name'){{ $message }} @else Name is required. @enderror</div>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label required">Email</label>
        <input required type="email" id="email" name="email" placeholder="user@example.com"
            class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $account->email) }}">
        <div class="invalid-feedback">@error('email'){{ $message }} @else Email is required and must be valid. @enderror</div>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label{{ $account->exists ? '':' required' }}">Password</label>
        <input type="password" id="password" name="password" placeholder="" autocomplete="off"
          class="form-control @error('password') is-invalid @enderror" value=""
          {{ $account->exists ? '':' required' }}
        >
        <div class="invalid-feedback">@error('password'){{ $message }} @else Password is required. @enderror</div>
        @if ($account->exists)
        <div class="small form-text">Fill in this if you want to change password.</div>
        @endif
      </div>
      <button type="submit" class="btn btn-primary">Save</button>
    </div>
  </form>
</div>
@endsection