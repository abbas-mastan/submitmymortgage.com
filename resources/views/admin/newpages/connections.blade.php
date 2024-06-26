@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
@endsection
@section('content')
    @include('parts.connection-modal-form')
    <div class="flex-wrap flex-shrink-0 w-full">
        <x-flex-card title="Connections" titlecounts="{{ count($connections) }}"
            iconurl="{{ asset('icons/Marketing.svg') }}" />
        <table class="w-full pt-7" id="{{ count($connections) > 10 ? 'deleted-table' : 'table' }}">
            <x-users-table-head />
            <tbody>
                @foreach ($connections as $connection)
                    <tr class="text-center">
                        <td class=" pl-2 tracking-wide border border-l-0">
                            {{ $loop->iteration }}
                        </td>

                        <td class=" pl-2 tracking-wide border border-l-0">
                            <a title="Click to edit connection" class="text-blue-500 inline" {{-- href="{{ url(getRoutePrefix() . '/contact/' . $connection->id) }}" --}}>
                                {{ $connection->name }}
                                <button class="editConnection" data-connection-id="{{ $connection->id }}"
                                    data-connection-name="{{ $connection->name }}"
                                    data-connection-email="{{ $connection->email }}"
                                    data-connection-role="{{ $connection->role }}"
                                    data-connection-company="{{ $connection->company_id ?? null }}">
                                    <img src="{{ asset('icons/pencil.svg') }}" alt="edit-icon">
                                </button>
                            </a>
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            {{ $connection->email }}
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            {{ $connection->role }}
                        </td>
                        <td class=" pl-2 tracking-wide border border-l-0">
                            @if ($connection->createdBy())
                                {{ $connection->createdBy->name ?? null }} {{ $connection->createdBy->role ?? null }}
                            @endif
                        </td>
                        <td class=" pl-2 tracking-wide border border-r-0">
                            <a data="Delete" class="delete"
                                href="{{ url(getRoutePrefix() . '/delete-connection/' . $connection->id) }}">
                                <button class="bg-themered  tracking-wide font-semibold capitalize text-xl">
                                    <img src="{{ asset('icons/trash.svg') }}" alt="" class="p-1 w-7">
                                </button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('foot')
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
        $('.closeModal').click(function(e) {
            e.preventDefault();
            $('#newProjectModal').addClass('hidden');
            $('.contactForm').attr('action', "{{ url(getRoutePrefix() . '/do-user') }}");
        });

        $('.editConnection').click(function(e) {
            $('#newProjectModal').removeClass('hidden');
            e.preventDefault();

            $('.contactForm').attr('action', $('.contactForm').attr('action') + "/" + $(this).attr(
                'data-connection-id'));
            $('#name').val($(this).attr('data-connection-name'));
            $('#email').val($(this).attr('data-connection-email'));
            const companyValue = $(this).attr('data-connection-company');
            if (companyValue) {
                $('.contactForm').append(
                    `<input type="hidden" value="${companyValue}" name="company">`
                );
            }
            var role = $('#role').val($(this).attr('data-connection-role'));
            $('.contactForm button[type="submit"]').text('Update');
            // Find the option with the matching value and set it as selected
            $('#role option').filter(function() {
                return $(this).val() == role;
            }).prop('selected', true);
        });
    </script>
@endsection
