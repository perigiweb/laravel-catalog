@extends('layouts.admin')

@section('content')
<div class="col col-md-8 col-lg-7 col-xl-6 mx-auto">
  @if (session()->has('product_message'))
  <div class="alert alert-{{ session('product_message.type') }}">{{ session('product_message.text') }}</div>
  @endif
  <form action="{{ $product->exists ? route('admin.products.update', ['product' => $product]):route('admin.products.store') }}" method="POST" novalidate class="card need-validation" enctype="multipart/form-data">
    @if ($product->exists)
        <input type="hidden" name="_method" value="patch">
    @endif
    @csrf
    <div class="card-header">
      <div class="card-title">{{ $pageTitle }}</div>
    </div>
    <div class="card-body">
      <div class="mb-3">
        <label class="form-label required">Name</label>
        <input required type="text" id="name" name="name" placeholder="Product Name"
            class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}">
        <div class="invalid-feedback">@error('name'){{ $message }} @else Product Name is required. @enderror</div>
      </div>
      <div class="mb-3">
        <label class="form-label required">Code</label>
        <input required type="text" id="code" name="code" placeholder="Product Code"
            class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $product->code) }}">
        <div class="invalid-feedback">@error('code'){{ $message }} @else Product Code is required. @enderror</div>
      </div>
      <div class="mb-3">
        <label class="form-label required">Brand</label>
        <select class="form-select w-auto @error('brand_id') is-invalid @enderror" name="brand_id" required>
          <option value="">Brand</option>
          @foreach($brands as $brand)
          <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? ' selected':'' }}>{{ $brand->name }}</option>
          @endforeach
        </select>
        <div class="invalid-feedback">@error('brand_id'){{ $message }} @else Product Brand is required. @enderror</div>
      </div>
      <div class="mb-3">
        <label class="form-label">Category</label>
        <select class="form-select w-auto @error('category_id') is-invalid @enderror" name="category_id">
          <option value="">Category</option>
          @foreach($cats as $cat)
          <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? ' selected':'' }}>{{ $cat->name }}</option>
          @endforeach
        </select>
        <div class="invalid-feedback">@error('category_id'){{ $message }} @enderror</div>
      </div>
      <div class="mb-3">
        <label class="form-label">Price</label>
        <input type="text" id="price" name="price" placeholder="" size="20"
            class="form-control w-auto @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}"
            pattern="[0-9\.]+"
        >
        <div class="invalid-feedback">@error('price'){{ $message }} @else Price must be a number. @enderror</div>
      </div>
      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" placeholder="Product description" rows="5"
            class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Image</label>
        @if ($product->image)
        <div class="position-relative w-50 pe-6 mb-2">
          <div class="position-absolute top-0 end-0 z-3">
            <button type="button" class="btn btn-sm btn-danger" title="Remove Image"
              data-bs-action="delete-item" data-url="{{ route('admin.products.remove-image', ['product' => $product]) }}"
              data-heading="Are you sure to remove?"
              data-message="Product image will be permanently removed and cannot be recovered."
            ><i class="fa fa-trash"></i></button>
          </div>
          <img src="{{ $product->image_url }}" class="img-fluid" />
        </div>
        @endif
        <input type="file" id="image" name="image" placeholder="Product Image"
            class="form-control @error('image') is-invalid @enderror" value="">
        <div class="invalid-feedback">@error('image'){{ $message }} @enderror</div>
      </div>
      <button type="submit" class="btn btn-primary">Save</button>
    </div>
  </form>
</div>
@endsection