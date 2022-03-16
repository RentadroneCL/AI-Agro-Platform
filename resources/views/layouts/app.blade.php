<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'droneraising') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    @livewireStyles

    <!-- Scripts -->
    <script defer src="{{ mix('js/app.js') }}"></script>
  </head>
  <body class="font-sans antialiased">
    <x-jet-banner />

    <div class="min-h-screen bg-gray-100">
      @livewire('navigation-menu')

      <!-- Page Heading -->
      @if (isset($header))
        <header class="pt-16 bg-white shadow">
          <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
            {{ $header }}
          </div>
        </header>
      @endif

      <!-- Page Content -->
      <main class="h-full">
        @if (session('status'))
          <div class="p-4 mb-4 text-sm font-medium text-blue-600 bg-blue-100 border-2 border-blue-300 shadow-sm">
            {{ session('status') }}
          </div>
        @endif

        {{ $slot }}
      </main>
    </div>

    @livewireScripts

    @stack('modals')

    @stack('scripts')
  </body>
</html>
