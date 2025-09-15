<a href="{{ route($route) }}" class="btn btn-outline-primary">
  {!! (isset($icon) ? $icon:'<i class="fa fa-plus me-1"></i>') !!}
  @if ($slot->isEmpty())
  Add
  @else
  {{ $slot }}
  @endif
</a>