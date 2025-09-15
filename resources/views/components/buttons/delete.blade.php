<button type="button" class="btn btn-danger" data-bs-action="delete" form="{{ $form ?? 'admin-form' }}">
  @if ($slot->isEmpty())
  <i class="fa fa-trash me-1"></i> Delete
  @else
  {{ $slot }}
  @endif
</button>