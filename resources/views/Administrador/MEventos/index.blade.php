@extends('adminlte::page')

@section('title')

@section('content_header')
    <h1>Mantenimiento de Eventos</h1>
@stop

@section('content')
    <div class="container-fluid">
        @if (session('mensaje'))
            <div class="alert alert-success">
                {{ session('mensaje') }}
            </div>
        @endif
        <div class="table-responsive">
            <table id="datatable" class="table table-hover nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Organizer') }}</th>
                        <th>{{ __('Coliseum') }}</th>
                        <th>{{ __('Control desk') }}</th>
                        <th>{{ __('Judge') }} A</th>
                        <th>{{ __('Judge') }} B</th>
                        <th>{{ __('Award') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($eventos as $evento)
                        <tr>
                            <td>{{ Carbon\Carbon::parse($evento->fechas[0])->format('Y/m/d') }}</td>
                            <td>{{ $evento->organizador->nombre . ' ' . $evento->organizador->apellido }}</td>
                            <td>{{ $evento->coliseum->nombre }}</td>
                            <td>{{ $evento->mcontrol->nombre . ' ' . $evento->mcontrol->apellido }}</td>
                            <td>{{ $evento->judge->nombre . ' ' . $evento->judge->apellido }}</td>
                            <td>
                                @if (!empty($evento->assistent))
                                    {{ $evento->assistent->nombre . ' ' . $evento->assistent->apellido }}
                                @else
                                    {{ __('No one') }}
                                @endif
                            </td>
                            <td>{{ $evento->awards }}</td>
                            <td>
                                @if ($evento->status == 0)
                                    <span class="btn btn-primary">{{ __('Inactived') }}</span>
                                @elseif($evento->status == 1)
                                    <span class="btn btn-success">{{ __('Actived') }}</span>
                                @elseif ($evento->status == 2)
                                    <span class="btn btn-warning">{{ __('Suspended') }}</span>
                                @endif
                            </td>
                            <td><a href="{{ route('meventos.show', $evento->id) }}">{{ __('View') }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>{{ __('Organizer') }}</th>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Coliseum') }}</th>
                        <th>{{ __('Control desk') }}</th>
                        <th>{{ __('Judge') }} A</th>
                        <th>{{ __('Judge') }} B</th>
                        <th>{{ __('Award') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/datatable/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
    {{-- JS --}}
    <script src="{{ asset('js/jquery-3.6.0.js') }}"></script>
    <script src="{{ asset('js/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/datatable/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/datatable/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/ajax/jszip.min.js') }}"></script>
    <script src="{{ asset('js/ajax/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/ajax/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/datatable/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/datatable/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/datatable/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/datatable/sorting/date-eu.js') }}"></script>

    {{-- SCRIPTS --}}
    <script type="text/javascript">
        $(document).ready(function() {
            function getLanguage() {
                var lang = $('html').attr('lang');
                if (lang == 'es') {
                    lng = "es-ES";
                } else if (lang == 'en') {
                    lng = "en-GB";
                }
                var result = null;
                var path = 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/';
                result = path + lng + ".json";
                return result;
            }

            // Build Datatable
            $('#datatable').DataTable({
                "order": [0, 'desc'],
                columnDefs: [{
                    type: 'date-eu',
                    targets: 0
                }],
                language: {
                    "url": getLanguage()
                },
                bInfo: false,
                lengthChange: false,
                pageLength: 10,
                lengthMenu: [
                    [10],
                    [10]
                ]
            });
        });
    </script>
@endsection
