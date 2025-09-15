@extends('layouts.admin')

@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
  @if (count($cats))
  <x-buttons.delete></x-buttons.delete>
  @endif
  <x-buttons.create route="admin.cats.create">Add Category</x-buttons.create>
</div>
@if (session()->has('category_message'))
<div class="alert alert-{{ session('cat_message.type') }}">{{ session('category_message.text') }}</div>
@endif
<form action="{{ route('admin.cats.destroy') }}" method="POST" class="card overflow-hidden" id="admin-form">
  @method('DELETE')
  @csrf
  <div class="table-responsive">
    <table class="table table-selectable card-table table-vcenter card-table">
      <thead>
        <tr>
          <th class="w-1"><input type="checkbox" class="form-check-input" data-bs-toggle="check-all"></th>
          <th>Name</th>
          <th class="w-1">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
      @if (count($cats))
        @foreach ($cats as $cat)
        <tr>
          <td>
            <input type="checkbox" name="id[]" value="{{ $cat->id }}" class="form-check-input" data-bs-toggle="check-item">
          </td>
          <td><a href="{{ route('admin.cats.edit', ['cat' => $cat]) }}">{{ $cat->name }}</a></td>
          <td>
            <div class="btn-group btn-group-sm justify-content-end">
              <a href="{{ route('admin.cats.edit', ['cat' => $cat]) }}" class="btn btn-sm btn-outline-primary"><i class="fa fa-pencil"></i></a>
              <button type="button" class="btn btn-outline-danger btn-sm"
                data-url="{{ route('admin.cats.destroy', ['cat' => $cat]) }}"
                data-bs-action="delete-item"
              ><i class="fa fa-trash"></i></button>
            </div>
          </td>
        </tr>
        @endforeach
      @else
        <tr>
          <td colspan="4" class="text-center">No categories to display. Please <a href="{{ route('admin.cats.create') }}">Add Category</a></td>
        </tr>
      @endif
      </tbody>
    </table>
  </div>
  @if ($cats->hasPages())
  <div class="card-footer">{{ $cats->links() }}</div>
  @endif
</form>
@endsection