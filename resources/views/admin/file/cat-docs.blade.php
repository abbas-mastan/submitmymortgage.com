@extends('layouts.app')

@section('head')
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

  <style>
        #file
        {
            display: none;
        }
    </style>
@endsection

@section('content')


        @include('admin.file.cards')
        <div class="">
                @if(!empty($id))
                        @include('elems.upload-btn')
                        @include('admin.file.info-table')
                @endif
        </div>
        
        <div class="">
                @include('admin.file.files-table')
        </div>
        
        

   
    
@endsection
@section('foot')
<script>
        @if( !empty($id) )
                var userId = {{ $id }};
                var cat = '{{ $cat }}';
                var uploadUrl = '{{url(getAdminRoutePrefix()."/file-upload")}}';
        @endif
</script>
<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('js/upload.js')}}"></script>
 

<script>
$(document).ready(function(){
    $('#status').on('change',function(){
        if($('#status').val() !== "")
            $('#status-form').submit();
    });
});
</script>
@endsection