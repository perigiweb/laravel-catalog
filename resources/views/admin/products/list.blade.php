@extends('layouts.admin')

@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
  @if (count($products))
  <x-buttons.delete></x-buttons.delete>
  @endif
  <x-buttons.create route="admin.products.create">Add Product</x-buttons.create>
</div>
@if (session()->has('brand_message'))
<div class="alert alert-{{ session('brand_message.type') }}">{{ session('brand_message.text') }}</div>
@endif
<div class="card overflow-hidden">
  <div class="card-body d-flex justify-content-end align-items-center border-bottom py-2">
    <form action="{{ request()->url() }}" method="GET" class="input-group input-group-sm w-auto">
      <input type="text" name="q" class="form-control w-auto" size="20" value="{{ request()->query('q') }}" placeholder="Product name or code" />
      <select class="form-select w-auto" name="brand_id">
        <option value="">Brand</option>
        @foreach($brands as $brand)
        <option value="{{ $brand->id }}"{{ request()->query('brand_id') == $brand->id ? ' selected':'' }}>{{ $brand->name }}</option>
        @endforeach
      </select>
      <select class="form-select w-auto" name="category_id">
        <option value="">Category</option>
        @foreach($cats as $cat)
        <option value="{{ $cat->id }}" {{ request()->query('category_id') == $cat->id ? ' selected':'' }}>{{ $cat->name }}</option>
        @endforeach
      </select>
      <button type="submit" class="btn btn-secondary"><i class="fa fa-search"></i></button>
    </form>
  </div>
  <form action="{{ route('admin.products.destroy') }}" method="POST" class="table-responsive" id="admin-form">
    @method('DELETE')
    @csrf
    <table class="table table-selectable card-table table-vcenter card-table">
      <thead>
        <tr>
          <th class="w-1"><input type="checkbox" class="form-check-input" data-bs-toggle="check-all"></th>
          <th style="width: 100px;">&nbsp;</th>
          <th>Code</th>
          <th>Name</th>
          <th>Price</th>
          <th>Brand</th>
          <th>Category</th>
          <th class="w-1">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
      @if (count($products))
        @foreach ($products as $product)
        <tr>
          <td>
            <input type="checkbox" name="id[]" value="{{ $product->id }}" class="form-check-input" data-bs-toggle="check-item">
          </td>
          <td>
            @if ($product->image)
            <img src="{{ $product->image_url }}" class="img-fluid" width="100" />
            @endif
          </td>
          <td><a href="{{ route('admin.products.edit', ['product' => $product]) }}">{{ $product->code }}</a></td>
          <td>{{ $product->name }}</td>
          <td>{{ $product->price }}</td>
          <td>{{ $product->brand->name }}</td>
          <td>{{ $product->category?->name }}</td>
          <td>
            <div class="btn-group btn-group-sm justify-content-end">
              <a href="{{ route('admin.products.edit', ['product' => $product]) }}" class="btn btn-sm btn-outline-primary"><i class="fa fa-pencil"></i></a>
              <button type="button" class="btn btn-outline-danger btn-sm"
                data-url="{{ route('admin.products.destroy', ['product' => $product]) }}"
                data-bs-action="delete-item"
              >
                <i class="fa fa-trash"></i>
              </button>
            </div>
          </td>
        </tr>
        @endforeach
      @else
        <tr>
          <td colspan="4" class="text-center">No products to display. Please <a href="{{ route('admin.products.create') }}">Add Product</a></td>
        </tr>
      @endif
      </tbody>
    </table>
  </form>
  @if ($products->hasPages())
  <div class="card-footer">{{ $products->links() }}</div>
  @endif
</div>
@endsection