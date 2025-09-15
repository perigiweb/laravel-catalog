@extends('layouts.admin')

@section('content')
  <div class="d-flex gap-3 align-items-center mb-3">
    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add New</a>
  </div>
  <div class="card">
    <table class="table card-table">
      <thead>
        <tr>
          <th>Title</th>
          <th class="w-1">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
      @if (count($pages))
        @foreach ($pages as $page)
        <tr>
          <td><a href="{{ route('admin.pages.edit', ['page' => $page]) }}">{{ $page->title }}</a></td>
          <td>
            <form action="{{ route('admin.pages.destroy', ['page' => $page])}}" method="post">
              <input type="hidden" name="_METHOD" value="DELETE">
              @csrf
              <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="delete-item">
                  <i class="fa fa-trash"></i> Delete
              </button>
          </form>
          </td>
        </tr>
        @endforeach
      @endif
      </tbody>
    </table>
  </div>
@endsection