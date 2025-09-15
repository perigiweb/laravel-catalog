<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ ((isset($pageTitle) && $pageTitle) ? $pageTitle . ' - ':'') . config('app.name') }}</title>
        <meta name="description" content="{{ $meta_desc ?? '' }}" />
        @stack('head')
        @vite('resources/front/js/app.js')
    </head>
    <body>
        <div class="d-flex flex-column min-vh-100">
            <header class="navbar navbar-expand fixed-top border-bottom bg-body-tertiary">
                <div class="container-md">
                    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a href="/" class="navbar-brand d-flex align-items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"  stroke="currentColor" stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-home"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l-2 0l9 -9l9 9l-2 0" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                        <div class="d-none d-md-block fw-bold">{{ config('app.name') }}</div>
                    </a>
                </div>
            </header>
            <main class="main-wrapper flex-fill py-4">
                <div class="container-md">
                    @yield('content')
                </div>
            </main>
            <footer class="bg-secondary text-light py-3">
                <div class="container-md d-flex flex-column flex-sm-row justify-content-between align-items-center gap-sm-2">
                    <div>&copy; 2025. <a href="https://perigi.my.id" class="text-light">PerigiWeb</a></div>
                    <div class="small">Built With Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</div>
                </div>
            </footer>
        </div>
    </body>
    @stack('scripts')
</html>