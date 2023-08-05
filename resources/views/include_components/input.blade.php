@php
 $label ??=null;
 $type ??= 'text';
 $class ??= null;
 $name ??= ucfirst();
 $value ??= '';
@endphp

<div @class(['form-group mb-2', $class])>
    <label for="{{ $name }}">{{ $label }}</label>

    @if ($type === 'textarea')
        <textarea class="form-control @error($name) is-invalid @enderror" type="{{ $type }}" id="{{ $name }}" name="{{ $name }}">{{ old($name, $value) }}</textarea>    
    @elseif ($type === 'file')
        <input class="form-control @error($name) is-invalid @enderror" type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $value) }}">    
    @else
        <input class="form-control @error($name) is-invalid @enderror" type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $value) }}">    
    @endif
    
    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>