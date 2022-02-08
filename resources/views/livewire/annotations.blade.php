<div class="flex flex-col justify-start h-full">
  <div class="inline-flex items-center w-full mb-4">
    <img class="object-cover w-8 h-8 mr-4 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }} avatar's">
    <h3 class="text-base font-medium text-gray-900 md:text-lg">{{ Auth::user()->name }}</h3>
  </div>

  <form>
    <textarea wire:model='content' class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" rows="2" class="" placeholder="{{ __("What's happening on?") }}"></textarea>
    <div class="flex justify-end w-full mt-4">
      <x-jet-button wire:click='create'>{{ __('Annotate') }}</x-jet-button>
    </div>
  </form>

  {{-- Annotations list. --}}
  <div class="flex flex-col justify-start py-3 border-b">
    <div class="inline-flex justify-start">
      <img class="object-cover w-8 h-8 mb-auto mr-4 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }} avatar's">
      <div class="max-w-xl text-sm text-gray-600">Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse doloribus laudantium fugit aliquid eius velit quam, maiores nobis molestias incidunt repellat non dolor! Assumenda tenetur, possimus deserunt quam perferendis nesciunt!</div>
    </div>
    <div class="flex justify-end">
      <div class="inline-flex items-center justify-between">
        <i class="mr-4 text-gray-400 fas fa-edit"></i>
        <i class="text-red-400 fas fa-trash"></i>
      </div>
    </div>
  </div>
</div>
