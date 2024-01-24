@props(['href','title'])
<li class="-mt-4 hidden sm:block">
    <span class="border-l-4 border-l-white  border-opacity-20 h-14  vertical-line-m">
        &nbsp;
    </span>
</li>
<li class="mt-10 py-3 sm:px-24 flex flex-row sm:-mt-3">
    <span class="hidden sm:block border-4 border-white  border-opacity-20 rounded-full text-xs  -ml-16">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </span>
    <a class="truncate ml-4" href="{{url(getRoutePrefix().'/'.$href)}}">
        <span class="tracking-wide sm:block  capitalize text-white">{{$title}}</span>
    </a>
</li>