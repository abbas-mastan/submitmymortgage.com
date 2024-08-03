@props(['value' => null, 'inputClass' => null, 'name', 'label', 'attribute', 'type', 'class'])
<div class="my-3 capitalize {{ $class ?? '' }}">
    <label for="{{ $name }}" class="block text-sm text-dark-500 leading-6  font-bold">{{ $label }}</label>
    <div class="relative rounded-md shadow-sm">
        @if (isset($sign))
            <span class="pointer-events-none w-8 h-8 absolute left-3 mt-0.5 sm:text-sm sm:leading-6">$</span>
        @endif
        <input type="{{ $type ?? 'text' }}" {{ $attribute ?? '' }} name="{{ $name }}" id="{{ $name }}"
            class="{{$inputClass}} block w-full shadow-none py-0.5 pl-7 bg-gray-100 border-1
             ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
              sm:text-sm sm:leading-6"
            placeholder="{{ $label }}" value="{{ $value }}">
    </div>
    <span class="text-red-700 {{ $name }}_error" style="text-transform: none !important;" id="{{ $name }}_error"></span>
</div>
