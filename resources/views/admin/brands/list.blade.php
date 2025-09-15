@extends('layouts.admin')

@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
  @if (count($brands))
  <x-buttons.delete></x-buttons.delete>
  @endif
  <x-buttons.create route="admin.brands.create">Add Brand</x-buttons.create>
</div>
@if (session()->has('brand_message'))
<div class="alert alert-{{ session('brand_message.type') }}">{{ session('brand_message.text') }}</div>
@endif
<form action="{{ route('admin.brands.destroy') }}" method="POST" class="card overflow-hidden" id="admin-form">
  @method('DELETE')
  @csrf
  <div class="table-responsive">
    <table class="table table-selectable card-table table-vcenter card-table">
      <thead>
        <tr>
          <th class="w-1"><input type="checkbox" class="form-check-input" data-bs-toggle="check-all"></th>
          <th style="width: 100px;">Logo</th>
          <th>Code</th>
          <th>Name</th>
          <th class="w-1">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
      @if (count($brands))
        @foreach ($brands as $brand)
        <tr>
          <td>
            <input type="checkbox" name="id[]" value="{{ $brand->id }}" class="form-check-input" data-bs-toggle="check-item">
          </td>
          <td>
            @if ($brand->logo)
            <img src="{{ $brand->logo_url }}" class="img-fluid" width="100" />
            @endif
          </td>
          <td><a href="{{ route('admin.brands.edit', ['brand' => $brand]) }}">{{ $brand->code }}</a></td>
          <td>{{ $brand->name }}</td>
          <td>
            <div class="btn-group btn-group-sm justify-content-end">
              <a href="{{ route('admin.brands.edit', ['brand' => $brand]) }}" class="btn btn-sm btn-outline-primary"><i class="fa fa-pencil"></i></a>
              <button type="button" class="btn btn-outline-danger btn-sm"
                data-url="{{ route('admin.brands.destroy', ['brand' => $brand]) }}"
                data-bs-action="delete-item"
              ><i class="fa fa-trash"></i></button>
            </div>
          </td>
        </tr>
        @endforeach
      @else
        <tr>
          <td colspan="4" class="text-center">No brands to display. Please <a href="{{ route('admin.brands.create') }}">Add Brand</a></td>
        </tr>
      @endif
      </tbody>
    </table>
  </div>
  @if ($brands->hasPages())
  <div class="card-footer">{{ $brands->links() }}</div>
  @endif
</form>
@endsection