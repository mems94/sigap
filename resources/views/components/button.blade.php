<div class="form-group">
    <button type="submit" {{ $attributes->merge(["class" => "btn btn-$type"]) }} >{{ $slot }}</button>
</div>