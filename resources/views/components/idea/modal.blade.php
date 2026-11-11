@props(['idea'=> new App\Models\Idea()])

<x-modal 
:name="$idea->exists ? 'edit-idea' : 'create-idea'" 
:title="$idea->exists ? 'Edit Idea' : 'Create Idea'">
  <form 
  x-data="{
   status: @js(old('status', $idea->status->value)),
    links: [], 
    newLink: '' , 
    steps: @js(old('steps', $idea->steps->map->only(['description', 'completed', 'id']))),
     newStep: '',
     hasImage: false,
     links: @js(old('links', $idea->links ?? [])),
     newLink: ''
     }" 
  method="POST" 
  action="{{ $idea->exists ? route('idea.update', $idea) : route('idea.store') }}"
   x-bind:enctype="hasImage ? 'multipart/form-data' : false ">
      @csrf
      @if($idea->exists)
      @method('PATCH')
      @endif
      <div class="space-y-4">
          <x-form.field
              label="Title"
              name="title"
              placeholder="Enter a title for your idea"
              autofocus
              required
              data-test="title-input"
              :value="$idea->title"
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
              :value="$idea->description"
          />

          <div class="space-y-2">
              <label for="image" class="label">Image</label>
              @if($idea->image_path)
        
              <img src="{{ asset('storage/' . $idea->image_path) }}" alt="" class=" mb-4 rounded-lg shadow-md w-full h-auto object-cover">
              <button class="mb-4 btn btn-outlined h-10 w-full" form='delete-image-form'>Remove Image</button>
              @endif
              <input type="file" name="image" id="image" class="file-input" @change="hasImage = $event.target.files.length > 0" />
          </div>

          {{-- //steps --}}
          <div>
              <fieldset class="space-y-2">
                  <legend class="label">Steps</legend>
                  <template x-for="(step, index) in steps" :key="step.id ?? index">
                      <div class="flex gap-2">
                      <input type="text" :name="`steps[${index}][description]`" x-model="step.description" class="input" />
                      <input type="hidden" :name="`steps[${index}][id]`" :value="step.id ?? ''"/>
                      <input type="hidden" :name="`steps[${index}][completed]`" :value="step.completed ? '1' : '0'"/>
                          <button 
                          @click="steps.splice(index, 1); newStep = '';"
                          type="button"  
                          aria-label="Remove step" 
                          data-test="remove-step-button">
                              <x-icons.close class="form-muted-icon" />
                          </button>
                      </div>
                  </template>

                  <div class="flex gap-2 mt-2">
                      <input
                          x-model="newStep"
                          data-test="new-step-input"
                          type="text"
                          id="new-step"
                          class="input flex-1"
                          placeholder="Enter a step for your idea"
            
                      />

                      <button @click="steps.push({ description: newStep.trim(), completed: false }); newStep = ''" type="button" :disabled="!newStep.trim()" aria-label="Add step" data-test="add-step-button">
                          <x-icons.close class="transform -rotate-45 form-muted-icon" />
                      </button>
                  </div>
              </fieldset>
          </div>

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
          <button type="submit" class="btn btn-primary" data-test="submit-button">
            {{ $idea->exists ? 'Update Idea' : 'Create Idea' }}</button>
          <button type="button" class="btn btn-outlined" data-test="cancel-button" @click="$dispatch('close-modal')">Cancel</button>
      </div>
  </form>
  @if($idea->image_path)
  <form action ="{{  route('idea.image.destroy', $idea) }}" id="delete-image-form" method="POST" >
    @method('DELETE')
    @csrf
  </form>
  @endif
</x-modal>