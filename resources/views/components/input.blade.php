
<div class="form-group mb-2">
    <label for="{{ $name }}">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" class="form-control @error($name) is-invalid @enderror" />
    
    @error($name)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror
</div>