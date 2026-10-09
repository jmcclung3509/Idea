<x-layout>
  <div>
    <header class="py-8 md:py-12">
      <h1 class="text-3xl font-bold">{{ $idea->title }}</h1>
    </header>
    <div class="mt-8 text-muted-foreground">

  
          <div class="mt-5 line-clamp-3 text-sm">{{ $idea->description }}</div>
          <div class="mt-4 text-sm"> {{ $idea ->created_at->diffForHumans() }}</div>
  

  
    
  </div>
  

  
  </x-layout>