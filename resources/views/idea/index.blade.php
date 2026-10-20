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
                            <h3 class="mb-3 text-lg text-foreground">{{ $idea->title }}</h3>
                            <x-idea.status-label status="{{ $idea->status->value }}">
                                {{ $idea->status->label() }}
                            </x-idea.status-label>
                            <div class="mt-5 line-clamp-3 text-sm">{{ $idea->description }}</div>
                            <div class="mt-4 text-sm">{{ $idea->created_at->diffForHumans() }}</div>
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
    <x-modal name="create-idea" title="New Idea">
        <form x-data="{ status: 'pending', links: [], newLink: '' }" method="POST" action="{{ route('idea.store') }}">
            @csrf

            <div class="space-y-4">
                <x-form.field
                    label="Title"
                    name="title"
                    placeholder="Enter a title for your idea"
                    autofocus
                    required
                    data-test="title-input"
                />

                <div>
                    <label for="status" class="label">Status</label>

                    <div class="flex gap-2 mt-2">
                        @foreach (App\IdeaStatus::cases() as $status)
                            <button
                                type="button"
                                class="btn flex-1 h-10"
                                data-test="button-status-{{ $status->value }}"
                                :class="status === @js($status->value) ? '' : 'btn-outlined'"
                                @click="status = @js($status->value)"
                            >
                                {{ $status->label() }}
                            </button>
                        @endforeach

                        <input type="text" name="status" :value="status" hidden />
                    </div>

                    <x-form.error name="status" />
                </div>

                <x-form.field
                    label="Description"
                    name="description"
                    type="textarea"
                    data-test="description-input"
                    placeholder="Describe your idea... "
                />

                <div>
                    <fieldset class="space-y-2">
                        <legend class="label">Links</legend>
                        <template x-for="(link, index) in links" :key="index">
                            <div class="flex gap-2">
                            <input type="text" name="links[]" x-model="link" class="input"/>
                                <button @click="links.splice(index, 1);" type="button"  aria-label="Remove link" data-test="remove-link-button">
                                    <x-icons.close class="form-muted-icon" />
                                </button>
                            </div>
                        </template>

                        <div class="flex gap-2 mt-2">
                            <input
                                x-model="newLink"
                                data-test="new-link-input"
                                type="url"
                                id="new-link"
                                autoclomplete="url"
                                spellcheck="false"
                                class="input flex-1"
                                placeholder="https://example.com"
                            />

                            <button @click="links.push(newLink.trim()); newLink= ''" type="button" :disabled="!newLink.trim()" aria-label="Add link" data-test="add-link-button">
                                <x-icons.close class="transform -rotate-45 form-muted-icon" />
                            </button>
                        </div>
                    </fieldset>
                </div>
            </div>

            <div class="flex justify-end gap-x-5 mt-4">
                <button type="submit" class="btn btn-primary" data-test="submit-button">Create Idea</button>
                <button type="button" class="btn btn-outlined" data-test="cancel-button" @click="$dispatch('close-modal')">Cancel</button>
            </div>
        </form>
    </x-modal>
</x-layout>
