<x-layout>
<div>
  <header class="py-8 md:py-12">
    <h1 class="text-3xl font-bold">Ideas</h1>
    <p class="text-sm text-muted-foreground"> Capture your thoughts. Make a plan. </p>
  </header>
  <div class="mt-8 text-muted-foreground">

    <div class="mt-10">
      <div class="grid md:grid-cols-2 gap-6">

      @forelse ($ideas as $idea)
      <x-card  href="{{ route('idea.show', $idea) }}" >
        <h3 class="text-foreground text-lg mb-3">{{ $idea->title }}</h3>
<x-idea.status-label status="{{ $idea->status->value }}"> {{ $idea->status->label() }}</x-idea.status-label>        <div class="mt-5 line-clamp-3 text-sm">{{ $idea->description }}</div>
        <div class="mt-4 text-sm"> {{ $idea ->created_at->diffForHumans() }}</div>
        
      </x-card>
      @empty

      <x-card>
        <p>No ideas found</p>
      </x-card> 
      @endforelse
</div>

</div>

</x-layout>