@if ($errors->has($name))
    <span id="{{ $name }}-error" class="error text-danger" for="input-{{ $name }}">
        {{ $errors->first($name) }}
    </span>
@endif
