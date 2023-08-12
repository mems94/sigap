@php
 $label ??=null;
 $class ??= null;
 $name ??= ucfirst();
 $value ??= '';
@endphp

<div @class(['form-group', $class])>
    <label for="{{ $name }}">{{ $label }}</label>
    <select class="form-control" name="{{ $name }}" id="{{ $name }}">
        @foreach ($options as $k => $v)
            <option @selected($value->contains($k)) value="{{ $k }}">{{ $v }}</option>
        @endforeach
    </select>    
    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>