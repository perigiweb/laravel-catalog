@auth
<aside class="navbar navbar-vertical flex-column justify-content-start sidebar" id="sidebar" data-bs-theme="dark">
  <section class="sidebar-content" id="sidebar-content">
    <h1 class="navbar-brand px-3 w-100 gap-0"><span>Admin</span><span class="text-muted">Panel</span></h1>
    <nav class="sidebar-nav scrollable" id="sidebar-nav">
      <ul class="nav nav-pills flex-column mt-2" id="sidebar-menu">
        <li class="nav-item">
          <a href="{{ route('admin.dashboard') }}" class="nav-link @if (request()->routeIs('admin.dashboard')) active @endif"><i class="fa fa-home fa-fw me-1"></i> Dashboard</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.brands.index') }}" class="nav-link @if (request()->routeIs('admin.brands.*')) active @endif"><i class="fa fa-copyright fa-fw me-1"></i> Brands</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.cats.index') }}" class="nav-link @if (request()->routeIs('admin.cats.*')) active @endif"><i class="fa fa-table-cells-large fa-fw me-1"></i> Categories</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.products.index') }}" class="nav-link @if (request()->routeIs('admin.products.*')) active @endif"><i class="fa fa-boxes-stacked fa-fw me-1"></i> Products</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.accounts.index') }}" class="nav-link @if (request()->routeIs('admin.accounts.*')) active @endif"><i class="fa fa-users fa-fw me-1"></i> Accounts</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.logout') }}" class="nav-link"><i class="fa fa-sign-out-alt me-1 fa-fw text-danger"></i> Logout</a>
        </li>
      </ul>
    </nav>
  </section>
</aside>
@endauth