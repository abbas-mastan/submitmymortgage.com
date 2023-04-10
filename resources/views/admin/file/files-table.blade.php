<table class="w-full" id="files-table">
    @if (!empty($cat))
        <caption class="text-center font-bold mb-3">{{ $cat }}</caption>
    @endif
    <thead class="bg-gray-300">
        <tr>
            <th class=" pl-2 tracking-wide">
                S No.
            </th>
            <th class="">
               File Title
            </th>
            
            <th class="">
                Upload Date
            </th>
            <th class="">
                Uploaded by
            </th>
            <th class="">
                User ID
            </th>
            <th class="">
                Actions
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($files as  $file)
            <tr>
                <td class=" pl-2 tracking-wide border border-l-0">{{ $loop->iteration }}</td>
                <td class=" pl-2 tracking-wide border border-l-0">
                    <a href="{{ asset($file->file_path) }}" class="hover:text-blue-500 inline">
                        {{ $file->file_name }}
                    </a>
                    <a href="{{ asset($file->file_path) }}" class="hover:text-blue-500 inline" download>  
                        <img src="{{ asset('icons/download.svg') }}" alt="" class="w-6 h-8 ml-5 inline">
                    </a>   
                    
                </td>
                
                <td class=" pl-2 tracking-wide border border-l-0 capitalize">
                    {{ convertDBDateUSFormat($file->created_at) }}                  
                    
                </td>
                <td class=" pl-2 tracking-wide border border-l-0 capitalize">
                    {{ $file->user->name }}
                    
                    
                </td>
                <td class=" pl-2 tracking-wide border border-l-0">
                    {{ $file->user->email }}
                    
                </td>
                
                
                
                <td  class=" pl-2 tracking-wide border border-r-0">
                    <div class="flex justify-center">
                        <a onclick="return confirm('Are you sure you want to delete this file?')" title="Delete this file" href="{{url(getAdminRoutePrefix().'/delete-file/'.$file->id)}}">
                            <button class="bg-themered  tracking-wide font-semibold capitalize text-xl">
                                <img src="{{ asset('icons/trash.svg') }}" alt="" class="p-1 w-7">
                            </button>
                        </a>
                    </div>
                    
                    {{-- <div class="flex justify-center">
                        <form id="status-form" action="{{ url(getAdminRoutePrefix().'/update-file-status/'.$file->id) }}" class="">
                            <select name="status" id="status" required class="p-0">
                                <option value="">Change the status</option>
                                <option {{ $file->status === 'Complete' ? 'selected' : '' }} value="Complete">Complete</option>
                                <option {{ $file->status === 'Incomplete' ? 'selected' : '' }} value="Incomplete">Incomplete</option>
                            </select>
                        </form>
                    </div> --}}
                </td>
            </tr>
            
            
        @endforeach
        
    </tbody>
</table>