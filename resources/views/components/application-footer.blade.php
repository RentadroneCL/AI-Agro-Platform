<footer class="inset-x-0 bottom-0 flex-1 w-full p-4 mt-auto border-t">
  <div class="flex flex-col items-center justify-center md:justify-between md:flex-row">
    <!-- Logo -->
    <div class="flex items-center flex-shrink-0">
      <a href="{{ route('dashboard') }}">
        <img class="block w-auto h-7" src="{{ asset('svg/droneraising-isologotipo.svg') }}" alt="application-logo">
      </a>
    </div>

    <p class="mb-1 text-xs text-gray-700 md:mb-0">
      Made with <i class="text-red-400 fas fa-heart fa-fw" title="Love"></i> by the <a class="hover:text-blue-400 focus:outline-none hover:underline" href="https://solar.droneraising.com" target="_blank">droneraising</a> team.
    </p>

    <span class="text-xs text-gray-600">
      <i class="text-gray-400 far fa-copyright fa-fw"></i> {{ Carbon::now()->year }} <a class="hover:text-blue-400 focus:outline-none hover:underline" href="https://solar.droneraising.com" target="_blank">droneraising</a>
    </span>
  </div>
</footer>
