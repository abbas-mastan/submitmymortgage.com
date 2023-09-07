<div class="my-3 capitalize {{$class ?? ''}}">
    <label for="{{$name}}" class="block text-sm text-dark-500 leading-6  font-bold">{{$label}}</label>
    <div class=" rounded-md shadow-sm">
        <input type="{{$type ?? 'text'}}" name="{{$name}}" id="{{$name}}"
            class="block w-full shadow-none py-0.5 pl-7 pr-20 bg-gray-100 border-1
             ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
              sm:text-sm sm:leading-6"
            placeholder="{{$label}}">
    </div>
    <span class="text-red-700" id="{{$name}}_error"></span>
</div>
