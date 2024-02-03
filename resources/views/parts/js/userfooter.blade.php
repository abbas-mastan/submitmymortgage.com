<script>
    var uploadUrl = '{{ url(getUserRoutePrefix() . '/file-upload') }}';
        var userId = {{ Auth::id() }};
    window.returnBack = "{{ url(getRoutePrefix() . '/redirect/back/file-uploaded-successfully') }}";
</script>
<script src="{{ asset('js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/upload.js') }}" type="text/javascript"></script>
