@props(['name', 'label' => false, 'type' => 'text', 'value' => ''])

<div class="space-y-2">
  @if($label)
    <label class="label" for="{{ $name }}">{{ $label }}</label>
    @endif
@if($type === 'textarea')
    <textarea
        class="textarea"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name) }}"
        {{ $attributes }}
    >{{ old($name, $value) }}</textarea>
@else
    <input
        type="{{ $type }}"
        class="input"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{ $attributes }}
    >
@endif
<x-form.error name="{{ $name }}" />
</div>
