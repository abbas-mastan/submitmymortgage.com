@php
    $attachments = \App\Models\Attachment::where('user_id', Auth::id())->get();
@endphp
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="text-gradientStart">Files from Gmail</div>
        </div>
        <div class="list-group grid grid-cols-1 gap-2">
            {{-- @if (count($attachments) > 1)
                @php
                    $splitIndex = ceil(count($attachments) / 2);
                    $firstHalf = $attachments->take($splitIndex);
                    $secondHalf = $attachments->splice($splitIndex);
                @endphp
                @foreach ($firstHalf as $key => $file)
                    <div class="list-group-item">
                        <div id="attachments" class="inline ">
                            <input id="check{{ $file->id }}" type="checkbox" value="{{$file->id}}" name="attachment[]"
                                class="form-control">
                            <label for="check{{ $file->id }}">
                                {{ $file->file_name }}
                            </label>
                        </div><br>
                    </div>
                @endforeach
                @foreach ($secondHalf as $key => $file)
                    <div class="list-group-item">
                        <div id="attachments" class="inline ">
                            <input id="check{{ $file->id }}" type="checkbox" value="{{$file->id}}" name="attachment[]" class="form-control">
                            <label for="check{{ $file->id }}">
                                {{ $file->file_name }}
                            </label>
                        </div>
                    </div>
                @endforeach
            @else --}}
            
                <div class="list-group">
                    @foreach ($attachments as $key => $file)
                        <div class="list-group-item">
                            <div id="attachments" class="inline ">
                                <input id="check{{ $file->id }}" type="checkbox" value="{{$file->id}}" name="attachment[]"
                                    class="form-control">
                                <label for="check{{ $file->id }}">
                                    {{ $file->file_name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            {{-- @endif --}}
        </div>
    </div>
</div>