@props(['name', 'title'])
<div 
x-data="{ show: false, name: @js($name) }"
x-show="show"
@open-modal.window="if ($event.detail === name) { show = true }"
@keydown.escape.window="show = false"
@close-modal.window="show = false"
x-transition:enter="duration-300"
x-transition:enter-start="opacity-0"
x-transition:enter-end="opacity-100"
x-transition:leave="ease-in duration-150"
x-transition:leave-start="opacity-100"
x-transition:leave-end="opacity-0 -translate-y-4 -translate-x-4"
style="display: none;"
class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 backdrop-blur-xs"
role="dialog"
aria-modal="true"
aria-labelledby="modal-{{ $name }}-title"
:aria-hidden="!show"
tabindex="-1">

    <x-card @click.away="show = false" class="shadow-xl max-w-2xl w-full max-h-[80vh] overflow-auto">
      <div>
      <div class="flex justify-between items-center">
        <h2 id="modal-{{ $name }}-title" class="text-lg font-bold">{{ $title }}</h2>
        <button aria-label="Close Modal" @click="show = false" class="hover:bg-gray-100 rounded-full">
          <x-icons.close />
          </button>
          </div>
        <div class="mt-4">
            {{ $slot }}
        </div>
      </div>
    </x-card>
</div>