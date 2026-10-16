<x-layout>
    <div class="mx-auto max-w-4xl py-4">
        <div class="mb-4 flex items-center justify-between">
            <a href="{{ route('idea.index') }}" class="flex items-center text-sm text-muted-foreground">
                <x-icons.arrow-back />
                <span class="ml-2">Back to Ideas</span>
            </a>

            <div class="flex items-center gap-2">
                <button class="btn btn-outlined bg-primary/10 text-primary hover:bg-primary/20">
                    <x-icons.external />
                    Edit
                </button>

                <form method="POST" action="{{ route('idea.destroy', $idea) }}">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-outlined bg-red-500/10 text-red-500 hover:bg-red-500/20">Delete</button>
                </form>
            </div>
        </div>

        <div class="my-4">
            <h1 class="text-3xl font-bold">{{ $idea->title }}</h1>

            <div class="mt-4 flex items-center gap-x-3">
                <x-idea.status-label :status="$idea->status->value">
                    {{ $idea->status->label() }}
                </x-idea.status-label>

                <div class="text-muted-foreground text-sm">{{ $idea->created_at->diffForHumans() }}</div>
            </div>

            <x-card class="mt-6 block">
                <div class="text-sm text-foreground">{{ $idea->description }}</div>
            </x-card>

            @if ($idea->links->count())
                <div class="mt-6 space-y-2">
                    <h3 class=" font-bold text-lg">Links</h3>

                    @foreach ($idea->links as $link)
                        <x-card href="{{ $link }}" class="text-primary font-medium flex gap-x-3 itmes-center">{{ $link }}</x-card>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-layout>
