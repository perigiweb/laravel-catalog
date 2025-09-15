@extends('layouts.admin')

@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
  @if (count($accounts))
  <x-buttons.delete></x-buttons.delete>
  @endif
  <x-buttons.create route="admin.accounts.create">Add Account</x-buttons.create>
</div>
@if (session()->has('account_message'))
<div class="alert alert-{{ session('account_message.type') }}">{{ session('account_message.text') }}</div>
@endif
<form action="{{ route('admin.accounts.destroy') }}" method="POST" class="card overflow-hidden mb-3" id="admin-form">
  @method('DELETE')
  @csrf
  <div class="table-responsive">
    <table class="table table-selectable card-table table-vcenter card-table">
      <thead>
        <tr>
          <th class="w-1"><input type="checkbox" class="form-check-input" data-bs-toggle="check-all"></th>
          <th>Name</th>
          <th>Email</th>
          <th class="w-1">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
      @if (count($accounts))
        @foreach ($accounts as $account)
        <tr>
          <td>
            @if (auth()->user()->id != $account->id)
            <input type="checkbox" name="id[]" value="{{ $account->id }}" class="form-check-input" data-bs-toggle="check-item">
            @endif
          </td>
          <td><a href="{{ route('admin.accounts.edit', ['account' => $account]) }}">{{ $account->name }}</a></td>
          <td>{{ $account->email }}</td>
          <td>
            <div class="btn-group btn-group-sm justify-content-end">
              <a href="{{ route('admin.accounts.edit', ['account' => $account]) }}" class="btn btn-sm btn-outline-primary"><i class="fa fa-pencil"></i></a>
              @if (auth()->user()->id != $account->id)
              <button type="button" class="btn btn-outline-danger btn-sm"
                data-url="{{ route('admin.accounts.destroy', ['account' => $account]) }}"
                data-bs-action="delete-item"
              >
                <i class="fa fa-trash"></i>
              </button>
              @endif
            </div>
          </td>
        </tr>
        @endforeach
      @endif
      </tbody>
    </table>
  </div>
  @if ($accounts->hasPages())
  <div class="card-footer">{{ $accounts->links() }}</div>
  @endif
</form>
@endsection