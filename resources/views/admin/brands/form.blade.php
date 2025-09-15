@extends('layouts.admin')

@section('content')
<div class="col col-md-8 col-lg-7 col-xl-6 mx-auto">
  @if (session()->has('brand_message'))
  <div class="alert alert-{{ session('brand_message.type') }}">{{ session('brand_message.text') }}</div>
  @endif
  <form action="{{ $brand->exists ? route('admin.brands.update', ['brand' => $brand]):route('admin.brands.store') }}" method="POST" novalidate class="card need-validation" enctype="multipart/form-data">
    @if ($brand->exists)
        <input type="hidden" name="_method" value="patch">
    @endif
    @csrf
    <div class="card-header">
      <div class="card-title">{{ $pageTitle }}</div>
    </div>
    <div class="card-body">
      <div class="mb-3">
        <label class="form-label required">Code</label>
        <input required type="text" id="code" name="code" placeholder="Brand Code"
            class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $brand->code) }}">
        <div class="invalid-feedback">@error('code'){{ $message }} @else Code is required. @enderror</div>
      </div>
      <div class="mb-3">
        <label class="form-label required">Name</label>
        <input required type="text" id="name" name="name" placeholder="Brand Name"
            class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $brand->name) }}">
        <div class="invalid-feedback">@error('name'){{ $message }} @else Name is required. @enderror</div>
      </div>
      <div class="mb-3">
        <label class="form-label">Logo</label>
        @if ($brand->logo)
        <div class="position-relative w-50 pe-6 mb-2">
          <div class="position-absolute top-0 end-0 z-3">
            <button type="button" class="btn btn-sm btn-danger" title="Remove Image"
              data-bs-action="delete-item" data-url="{{ route('admin.brands.remove-logo', ['brand' => $brand]) }}"
              data-heading="Are you sure to remove?"
              data-message="Brand Logo will be permanently removed and cannot be recovered."
            ><i class="fa fa-trash"></i></button>
          </div>
          <img src="{{ $brand->logo_url }}" class="img-fluid" />
        </div>
        @endif
        <input type="file" id="logo" name="logo" placeholder="Brand Logo"
            class="form-control @error('logo') is-invalid @enderror" value="">
        <div class="invalid-feedback">@error('logo'){{ $message }} @enderror</div>
      </div>
      <button type="submit" class="btn btn-primary">Save</button>
    </div>
  </form>
</div>
@endsection