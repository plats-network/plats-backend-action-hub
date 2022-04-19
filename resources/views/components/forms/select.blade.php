<select name="{{ $name }}" class="form-select" {{ $select2 }}>
    @foreach($options as $value => $text)
    <option value="{{ $value }}">{{ $text }}</option>
    @endforeach
</select>
