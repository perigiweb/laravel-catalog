@extends('layouts.admin')

@section('content')
<div class="col col-md-8 col-lg-7 col-xl-6 mx-auto">
  @if (session()->has('category_message'))
  <div class="alert alert-{{ session('category_message.type') }}">{{ session('category_message.text') }}</div>
  @endif
  <form action="{{ $category->exists ? route('admin.cats.update', ['cat' => $cat]):route('admin.cats.store') }}" method="POST" novalidate class="card need-validation" enctype="multipart/form-data">
    @if ($category->exists)
        <input type="hidden" name="_method" value="patch">
    @endif
    @csrf
    <div class="card-header">
      <div class="card-title">{{ $pageTitle }}</div>
    </div>
    <div class="card-body">
      <div class="mb-3">
        <label class="form-label required">Name</label>
        <input required type="text" id="name" name="name" placeholder="Category Name"
            class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}">
        <div class="invalid-feedback">@error('name'){{ $message }} @else Category Name is required. @enderror</div>
      </div>
      <button type="submit" class="btn btn-primary">Save</button>
    </div>
  </form>
</div>
@endsection