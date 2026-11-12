<x-layout>
    <div>
        <header class="py-8 md:py-12">
            <h1 class="text-3xl font-bold">Ideas</h1>
            <p class="text-sm text-muted-foreground">Capture your thoughts. Make a plan.</p>

            <x-card
                x-data
                @click="$dispatch('open-modal', 'create-idea')"
                is="button"
                type="button"
                class="mt-10 cursor-pointer h-32 w-full"
                data-test="create-idea-button"
            >
                <p>Whats the idea?</p>
            </x-card>
        </header>

        <div class="flex gap-2">
            <a href="/ideas"
                @class([
                    'btn',
                    'border bg-purple-500/10 text-purple-500 border-purple-500' => ! request()->has('status'),
                    'btn-outlined' => request()->has('status'),
                ])>All</a>

            @foreach (App\IdeaStatus::cases() as $status)
                <a href="/ideas?status={{ $status->value }}"
                    @class([
                        'btn',
                        'border ' . $status->classes() => request('status') === $status->value,
                        'btn-outlined' => request('status') !== $status->value,
                    ])>
                    {{ $status->label() }}
                    <span class="text-xs ml-2">({{ $statusCounts->get($status->value) }})</span>
                </a>
            @endforeach
        </div>

        <div class="mt-8 text-muted-foreground">
            <div class="mt-10">
                <div class="grid gap-6 md:grid-cols-2">
                    @forelse ($ideas as $idea)
                        <x-card href="{{ route('idea.show', $idea) }}">
                            @if ($idea->image_path)
                            <img src="{{ asset('storage/' . $idea->image_path) }}" alt="" class=" mb-4 rounded-lg shadow-md w-full h-auto object-cover">
                            @endif
                            <h3 class="mb-3 text-lg text-foreground">{{ $idea->title }}</h3>
                            <x-idea.status-label status="{{ $idea->status->value }}">
                                {{ $idea->status->label() }}
                            </x-idea.status-label>
                            <div class="text-sm text-foreground cursor-pointer mt-4 line-clamp-3">{{ $idea->description }}</div>                            <div class="mt-4 text-sm">{{ $idea->created_at->diffForHumans() }}</div>
                        </x-card>
                    @empty
                        <x-card>
                            <p>No ideas found</p>
                        </x-card>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- open-modal:create-idea -->
    <x-idea.modal name="create-idea" title="Create Idea">
    </x-idea.modal>
</x-layout>
