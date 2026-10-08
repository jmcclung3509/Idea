@props(['title', 'description'])

<div class ="flex min-h-[calc(100dvh-4rem)] items-center justify-center px-4">
  <div class="w-full max-w-md">
    <div class="text-center my-4">
      <h1 class="text-2xl font-bold">{{  $title }}</h1>
      <p class="text-sm text-gray-500">{{ $description }}</p>
    </div>
  {{$slot}}
  </div>
</div>