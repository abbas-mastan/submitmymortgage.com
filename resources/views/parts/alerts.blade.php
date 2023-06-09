@isset($msg_error)
<div class="p-4 my-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
    <span class="font-medium">Error!</span>{{$msg_error}}
  </div>
{{-- <div class="row" id="proBanner">
    <div class="col-12">
      <div class="ml-2 mr-2 mt-2 alert alert-danger alert-dismissible">
                  <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Error!</strong> {{$msg_error}}
              </div>
    </div>
</div> --}}
@endisset
@isset($msg_danger)
<div class="p-4 my-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
    <span class="font-medium">Error!</span> {{$msg_error}}
  </div>
{{-- <div class="row" id="proBanner">
    <div class="col-12">
      <div class="ml-2 mr-2 mt-2 alert alert-danger alert-dismissible">
                  <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Error!</strong> {{$msg_danger}}
              </div>
    </div>
</div> --}}
@endisset
@isset($msg_info)
<div class="p-4 my-4 text-sm text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-200 dark:text-blue-800" role="alert">
    <span class="font-medium">Info!</span> {{$msg_info}}
  </div>
{{-- <div class="row" id="proBanner">
    <div class="col-12">
      <div class="ml-2 mr-2 mt-2 alert alert-info alert-dismissible">
                  <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Info!</strong> {{$msg_info}}
              </div>
    </div>
</div> --}}
@endisset

@isset($msg_warning)
<div class="p-4 my-4 text-sm text-yellow-700 bg-yellow-100 rounded-lg dark:bg-yellow-200 dark:text-yellow-800" role="alert">
    <span class="font-medium">Warning!</span>  {{$msg_warning}}
  </div>
{{-- <div class="row" id="proBanner">
    <div class="col-12">
      <div class="ml-2 mr-2 mt-2 alert alert-warning alert-dismissible">
            <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Warning!</strong> {{$msg_warning}}
        </div>
    </div>
</div> --}}
@endisset

@isset($msg_success)
<div class="p-4 my-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
    <span class="font-medium">Success!</span> {{$msg_success}}
  </div>
{{-- <div class="row" id="proBanner">
    <div class="col-12">
      <div class="ml-2 mr-2 mt-2 alert alert-success alert-dismissible">
            <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> {{$msg_success}}
        </div>
    </div>
</div> --}}
@endisset
@if(session('msg_success'))
<div class="p-4 my-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
    <span class="font-medium">Success!</span> {{session('msg_success')}}
  </div>
{{-- <div class="row" id="proBanner">
    <div class="col-12">
      <div class="ml-2 mr-2 mt-2 alert alert-success alert-dismissible">
            <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> {{session('msg_success')}}
        </div>
    </div>
</div> --}}
@endif
@if(session('msg_error'))
<div class="p-4 my-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
    <span class="font-medium">Error!</span> {{session('msg_error')}}
  </div>
{{-- <div class="row" id="proBanner">
    <div class="col-12">
      <div class="ml-2 mr-2 mt-2 alert alert-danger alert-dismissible">
                  <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Error!</strong> {{session('msg_error')}}
              </div>
    </div>
</div> --}}
@endif
@if(session('msg_danger'))
<div class="p-4 my-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
    <span class="font-medium">Error!</span> {{session('msg_danger')}}
  </div>
{{-- <div class="row" id="proBanner">
    <div class="col-12">
      <div class="ml-2 mr-2 mt-2 alert alert-danger alert-dismissible">
                  <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Error!</strong> {{session('msg_danger')}}
              </div>
    </div>
</div> --}}
@endif
@if(session('msg_info'))
<div class="p-4 my-4 text-sm text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-200 dark:text-blue-800" role="alert">
    <span class="font-medium">Info!</span>  {{session('msg_info')}}
  </div>
{{-- <div class="row" id="proBanner">
    <div class="col-12">
      <div class="ml-2 mr-2 mt-2 alert alert-info alert-dismissible">
                  <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Info!</strong> {{session('msg_info')}}
              </div>
    </div>
</div> --}}
@endif

@if(session('msg_warning'))
<div class="p-4 my-4 text-sm text-yellow-700 bg-yellow-100 rounded-lg dark:bg-yellow-200 dark:text-yellow-800" role="alert">
    <span class="font-medium">Warning!</span> {{session('msg_warning')}}
  </div>
{{-- <div class="row" id="proBanner">
    <div class="col-12">
      <div class="ml-2 mr-2 mt-2 alert alert-warning alert-dismissible">
            <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Warning!</strong> {{session('msg_warning')}}
        </div>
    </div>
</div> --}}
@endif
@isset($errors)
    @foreach($errors->all() as $message)
    <div class="p-4 my-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
        <span class="font-medium">Error!</span> {{$message}}
      </div>
        {{-- <div class="row" id="proBanner">
            <div class="col-12">
              <div class="ml-2 mr-2 mt-2 alert alert-danger alert-dismissible">
                    <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Error!</strong> {{$message}}
                </div>
            </div>
        </div> --}}
    @endforeach
@endisset
