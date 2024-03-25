@props(['placeholder', 'elementOptions', 'disabled' => false])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}>
    <option value="">{{ $placeholder }}</option>
    @if($elementOptions)
        @foreach($elementOptions as $key => $value)
            <option value="{{ $key }}">{{ $value }}</option>
        @endforeach
    @endif
</select>
