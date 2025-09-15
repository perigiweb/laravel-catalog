<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ (isset($pageTitle) && $pageTitle) ? $pageTitle . ' - ':'' }}{{ config('app.name') }}</title>
        <meta name="x-csrf-token" content="{{ csrf_token() }}">
        <link rel="preconnect" href="https://cdnjs.cloudflare.com">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700" rel="stylesheet" />
        @vite('resources/admin/js/app.js')
        @stack('styles')
    </head>
    <body>
        <div class="d-flex flex-column min-vh-100">
          @auth
            <div class="page flex-fill">
              <header class="navbar navbar-light fixed-top navbar-fixed-top">
                <div class="container-fluid">
                  <button type="button" class="navbar-toggler d-lg-none me-2" data-bs-toggle="sidebar">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="navbar-brand d-flex justify-content-start flex-grow-1 gap-2" id="page-title">
                    @if (isset($back) && $back)
                      <a href="{{ $back }}" class="btn btn-sm btn-ghost-secondary"><i class="fa fa-arrow-left"></i></a>
                    @endif
                    @if (isset($pageTitle) && $pageTitle)
                    <span class="me-auto">{{ $pageTitle }}</span>
                    @endif
                  </div>
                  <div class="navbar-nav flex-row ms-auto gap-1">
                    <div class="nav-item">
                      <a class="nav-link" href="/" target="_blank" title="View Site"><i class="fa fa-globe"></i></a>
                    </div>
                    <div class="nav-item">
                      <a href="{{ route('admin.accounts.edit', ['account' => auth()->user()]) }}" class="nav-link">
                        <i class="fa fa-user-circle me-1"></i> <span>{{ auth()->user()->short_name }}</span>
                      </a>
                    </div>
                    <div class="nav-item">
                      <a href="{{ route('admin.logout') }}" class="nav-link text-danger"><i class="fa fa-sign-out-alt"></i></a>
                    </div>
                  </div>
                </div>
              </header>

              <div class="main-wrapper" id="main-content">
                <section class="container-fluid">
                  @yield('content')
                </section>
              </div>
            </div>
          @else
            @yield('content')
          @endauth
          <footer class="footer border-top py-2">
            <div class="container-fluid d-flex flex-column flex-sm-row justify-content-between align-items-center gap-sm-2">
              <div>&copy; 2025. <a href="https://perigi.my.id">PerigiWeb</a></div>
              <div class="small">Built With Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</div>
            </div>
          </footer>
        </div>
        @include('layouts.admin-menu')
        <div class="sidebar-overlay" data-bs-toggle="sidebar"></div>
        <div class="modal modal-blur fade" id="modal-alert" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content translate-middle-y">
                    <div class="modal-body lh-sm d-flex align-items-center"></div>
                    <div class="modal-footer justify-content-center p-1"></div>
                </div>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>