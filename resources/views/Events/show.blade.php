@extends('layouts.app')

@section('content')
    @if (session('mensaje'))
        <div class="alert btn alert-warning">
            {{ session('mensaje') }}
        </div>
    @endif
    <div class="card bg-black text-white border border-danger">
        <div class="card-header border border-danger">
            @can('addanimal')
                @if (count($listps) <= 330)
                    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#AddExemplar">
                        {{ __('Join') }}
                    </button>
                @endif
            @endcan
            @if ($errors->has('mascota_id'))
                <span class="alert fs-6 text-danger" id="Message">
                    {{ __('Choose other exemplar') }}
                </span>
            @endif
            @if (count($evento->participants) >= 2)
                <a type="button" class="btn btn-dark" href="{{ route('duels.show', $evento->id) }}">
                    {{ __('Duels') }}
                </a>
            @endif

            <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#Event">
                {{ __('Event') }}
            </button>
            <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#Tickets">
                {{ __('Tickets') }}
            </button>
        </div>
        <div class="card-body border border-danger table-responsive">
            <table id="datatable" class="table table-dark table-hover nowrap">
                <thead>
                    <tr>
                        <th>REGGAL</th>
                        <th>{{ __('Weight') }}</th>
                        <th>{{ __('Shed') }}</th>
                        <th>{{ __('Disability') }}</th>
                        <th>{{ __('Seal') }}</th>
                        <th>{{ __('BOX') }} MIN.</th>
                        <th>{{ __('BOX') }} MAX.</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listps as $listp)
                        <tr>
                            <td>{{ $listp->mascota->REGGAL }}</td>
                            <td>{{ $listp->mascota->sss }}</td>
                            <td>{{ $listp->mascota->user->galpon }}</td>
                            <td>
                                <?php switch ($listp->mascota->des) {
                                    case '0':
                                        echo __('No');
                                        break;
                                    case '1':
                                        echo __('Visual');
                                        break;
                                    case '2':
                                        echo __('Physical');
                                        break;
                                    case '3':
                                        echo __('Other');
                                        break;
                                } ?></td>
                            <td>{{ $listp->mascota->plc }}</td>
                            <td>1</td>
                            <td>2</td>
                            <td>
                                @can('chngw')
                                    <button type="button" class="btn btn-dark" data-bs-toggle="modal"
                                        data-bs-target="#CHNGW{{ $listp->mascota->id }}">
                                        {{ __('Change weight') }}
                                    </button>
                                    <!-- MODAL CHANGE WEIGHT -->
                                    <div class="modal fade" id="CHNGW{{ $listp->mascota->id }}" aria-hidden="true"
                                        aria-labelledby="CHNGW{{ $listp->mascota->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div class="modal-title text-black fw-bold">{{ __('Choose exemplar') }}
                                                    </div>
                                                    <button type="button" class="btn btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form class="form-horizontal" method="POST"
                                                    action="{{ route('participants.update', $listp->id) }}"
                                                    enctype="multipart/form-data" autocomplete="off">
                                                    {{ method_field('PUT') }}
                                                    {!! csrf_field() !!}
                                                    <div class="modal-body bg-black">
                                                        {{-- MASCOTA --}}
                                                        <div class="row mb-2">
                                                            <label
                                                                class="col-sm-4 col-form-label">{{ __('Exemplar') }}:</label>
                                                            <div class="col-sm-8">
                                                                <input class="form-control text-danger" type="text"
                                                                    value="{{ $listp->mascota->nombre }}" readonly>
                                                            </div>
                                                        </div>
                                                        {{-- EVENTO_ID MASCOTA_ID --}}
                                                        <div>
                                                            <input type="text" id="mascota_id" name="mascota_id"
                                                                value="{{ $listp->mascota->id }}" hidden>
                                                            <input type="text" id="evento_id" name="evento_id"
                                                                value="{{ $evento->id }}" hidden>
                                                        </div>
                                                        {{-- REGGAL --}}
                                                        <div class="row mb-2">
                                                            <label
                                                                class="col-sm-4 col-form-label">{{ __('REGGAL') }}:</label>
                                                            <div class="col-sm-8">
                                                                <input class="form-control text-danger" type="text"
                                                                    value="{{ $listp->mascota->REGGAL }}" readonly>
                                                            </div>
                                                        </div>
                                                        {{-- Weight --}}
                                                        <div class="row mb-2">
                                                            <label
                                                                class="col-sm-4 col-form-label">{{ __('Weight') }}:</label>
                                                            <div class="col-sm-8">
                                                                <input type="number" class="form-control text-danger" id="mp"
                                                                    name="peso" required min="{{ $listp->evento->miw }}"
                                                                    max="{{ $listp->evento->maw }}"
                                                                    onKeyPress="if(this.value.length==3) return false;"
                                                                    onkeydown="return event.keyCode !== 69 && event.keyCode !== 189">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-9 mx-auto">
                                                            {{-- IMAGEN --}}
                                                            <img id="preview{{ $listp->mascota->id }}"
                                                                class="mx-auto d-block bg-black" height="200" width="180" />
                                                            <input id="foto{{ $listp->mascota->id }}" type="file"
                                                                class="form-control" name="foto" value="{{ old('foto') }}"
                                                                required autofocus accept="image/*">
                                                            <script>
                                                                /* PREVIEW */
                                                                foto{{ $listp->mascota->id }}.onchange = evt => {
                                                                    const [file] = foto{{ $listp->mascota->id }}.files
                                                                    if (file) {
                                                                        preview{{ $listp->mascota->id }}.src = URL.createObjectURL(file)
                                                                    }
                                                                };
                                                            </script>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer p-0">
                                                        <button type="submit" class="btn btn-primary mx-auto">
                                                            {{ __('Change weight') }}
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endcan
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#Foto{{ $listp->id }}">
                                    {{ __('View') }}
                                </button>
                                <!-- Modal FOTO-->
                                <div class="modal fade" id="Foto{{ $listp->id }}" aria-hidden="true"
                                    aria-labelledby="Foto{{ $listp->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered modal-md">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="btn btn-danger bg-danger btn-close"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body mx-auto">
                                                <figure class="figure">
                                                    <img src="@if (!empty($listp->mascota->fotos->where('nfoto', 1)->first())) {{ asset($listp->mascota->fotos->where('nfoto', 1)->first()->ruta) }} @else{{ asset('storage/img/pata.jpg') }} @endif"
                                                        class="figure-img d-block mx-auto" width="300vh" height="400vh">
                                                    <figcaption class="figure-caption">
                                                        {{ $listp->mascota->nombre }}
                                                    </figcaption>
                                                </figure>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>REGGAL</th>
                        <th>{{ __('Weight') }}</th>
                        <th>{{ __('Shed') }}</th>
                        <th>{{ __('Disability') }}</th>
                        <th>{{ __('Seal') }}</th>
                        <th>{{ __('BOX') }} MIN.</th>
                        <th>{{ __('BOX') }} MAX.</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- MODAL ADD -->
    @can('addanimal')
        <div class="modal fade" id="AddExemplar" aria-hidden="true" aria-labelledby="AddExemplar" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title text-black fw-bold">{{ __('Choose exemplar') }}</div>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="form-horizontal" method="POST" action="{{ route('participants.store') }}"
                        enctype="multipart/form-data" autocomplete="off">
                        {!! csrf_field() !!}
                        <div class="modal-body bg-black">
                            {{-- SELECT MASCOTA --}}
                            <div class="row mb-2">
                                <label class="col-sm-4 col-form-label">{{ __('Exemplar') }}:</label>
                                <div class="col-sm-8">
                                    <select class="form-select" id="mascota_id" name="mascota_id"
                                        value="{{ old('mascota_id') }}" required>
                                        <option value="" selected disabled>Seleccionar mascota</option>
                                        @foreach (Auth::user()->mascotas as $mascota)
                                            <option value="{{ $mascota->id }}"
                                                @if (old('mascota_id') == $mascota->id) selected @endif>
                                                {{ $mascota->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- EVENTO_ID --}}
                            <div>
                                <input type="text" id="evento_id" name="evento_id" value="{{ $evento->id }}" hidden>
                            </div>
                            {{-- REGGAL --}}
                            <div class="row mb-2">
                                <label class="col-sm-4 col-form-label">{{ __('REGGAL') }}:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control text-danger" id="mreggal" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer p-0">
                            <button type="submit" class="btn btn-primary mx-auto">
                                {{ __('Add Exemplar') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan

    <!-- MODAL EVENTO -->
    <div class="modal fade" id="Event" aria-hidden="true" aria-labelledby="AddExemplar" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content bg-black border border-danger">
                <div class="modal-header bg-black border border-danger">
                    {{-- <div class="modal-title fw-bold fs-4">{{ __('Event') }} {{ $evento->tevent }}</div> --}}
                    <button type="button" class="btn btn-danger bg-danger btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body bg-black border border-danger">
                    <div class="row">
                        <div class="col-12 col-xl-6">
                            <div class="card h-100 bg-black border border-danger">
                                <div class="card-header border border-danger fw-bold"> {{ __('EVENT') }}</div>
                                <div class="card-body border border-danger">
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <label for="title" class="form-label">{{ __('Type Event') }}</label>
                                            <select class="form-control text-danger fw-bold" disabled
                                                style="-webkit-appearance: none;">
                                                <option value="cmp" @if ($evento->tevent == 'cmp') selected @endif>
                                                    {{ __('Championship') }}
                                                </option>
                                                <option value="cct" @if ($evento->tevent == 'cmp') selected @endif>
                                                    {{ __('Concentration') }}
                                                </option>
                                                <option value="chk" @if ($evento->tevent == 'chk') selected @endif>
                                                    {{ __('Chuscas') }}
                                                </option>
                                                <option value="drb" @if ($evento->tevent == 'drb') selected @endif>
                                                    {{ __('Derby') }}
                                                </option>
                                                <option value="prt" @if ($evento->tevent == 'prt') selected @endif>
                                                    {{ __('Party') }}
                                                </option>
                                                <option value="thr" @if ($evento->tevent == 'thr') selected @endif>
                                                    {{ __('Other') }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="hours" class="form-label">{{ __('Coliseum') }}</label>
                                            <input type="text" class="form-control text-danger" id="hours"
                                                value="{{ $evento->coliseum->nombre }}" readonly>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <label for="title" class="form-label">{{ __('Weight') }}</label>
                                            <div class="col-auto input-group-text">
                                                Min
                                                <div class="form-control form-control-sm m-0 text-danger">
                                                    {{ $evento->miw }}</div>
                                                Max
                                                <div class="form-control form-control-sm m-0 text-danger">
                                                    {{ $evento->maw }}</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <label for="hours" class="form-label">{{ __('Time start') }}</label>
                                            <input type="time" class="form-control text-danger" id="hours"
                                                value="{{ $evento->hstart }}" readonly>
                                        </div>
                                        <div class="col-sm-8 mb-3">
                                            <label for="dates" class="form-label">{{ __('Dates') }}</label>
                                            <div class="row">
                                                @foreach ($evento->fechas as $fecha)
                                                    <div class="col-6 mb-1">
                                                        <label type="text" class="form-control text-danger">
                                                            {{ $fecha }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mb-3">
                                            <label class="form-label">{{ __('Spurs') }}</label>
                                            <ul class="list-group list-group-flush">
                                                @foreach ($evento->spl as $spl)
                                                    <li class="list-group-item text-danger">
                                                        @if ($spl == 'lbr')
                                                            Libre
                                                        @elseif($spl == 'fbr')
                                                            Fibra
                                                        @elseif($spl == 'plt')
                                                            Plastica
                                                        @elseif($spl == 'cry')
                                                            Carey
                                                        @elseif($spl == 'spn')
                                                            Espina
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-6">
                            <div class="card h-100 bg-black border border-danger">
                                <div class="card-header border border-danger fw-bold">
                                    {{ __('AWARDS') . ': ' . $evento->awards }}</div>
                                <div class="card-body border border-danger">
                                    <div class="row">
                                        <div class="col-12 col-lg-4 mb-3 my-auto">
                                            <label for="TROPHY" class="form-label">{{ __('TROPHYS') }}</label>
                                            <div class="input-group">
                                                <div class="input-group-text">S/.</div>
                                                <input type="text" class="form-control text-danger" id="trophy"
                                                    value="{{ $evento->trophys }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-6 col-lg-4 mb-3">
                                            <label for="ROOSTER"
                                                class="form-label">{{ __('ROOSTER') . ' ' . $evento->trooster . ' ' . __('seconds') }}</label>
                                            <div class="input-group">
                                                <div class="input-group-text">S/.</div>
                                                <input type="text" class="form-control text-danger" id="rooster"
                                                    value="{{ $evento->rooster }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-6 col-lg-4 mb-3">
                                            <label for="ROOSTER"
                                                class="form-label">{{ __('ROOSTER') . ' 10 ' . __('seconds') }}
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-text">S/.</div>
                                                <input type="text" class="form-control text-danger" id="rooster"
                                                    value="{{ $evento->rooster }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-4 mb-3">
                                            <label for="fft" class="form-label">{{ __('1er Frente') }}</label>
                                            <div class="input-group">
                                                <div class="input-group-text">S/.</div>
                                                <input type="text" class="form-control text-danger" id="fft"
                                                    value="{{ $evento->fft }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-4 mb-3">
                                            <label for="sft" class="form-label">{{ __('2do Frente') }}</label>
                                            <div class="input-group">
                                                <div class="input-group-text">S/.</div>
                                                <input type="text" class="form-control text-danger" id="sft"
                                                    value="{{ $evento->sft }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-4 mb-3">
                                            <label for="tft" class="form-label">{{ __('3er Frente') }}</label>
                                            <div class="input-group">
                                                <div class="input-group-text">S/.</div>
                                                <input type="text" class="form-control text-danger" id="tft"
                                                    value="{{ $evento->tft }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-4 mb-3">
                                            <label for="tft" class="form-label">{{ __('Fight quality') }}</label>
                                            <div class="input-group">
                                                <div class="input-group-text">S/.</div>
                                                <input type="text" class="form-control text-danger" id="fcd"
                                                    value="{{ $evento->fcd }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-4 mb-3">
                                            <label for="pvs" class="form-label">{{ __('Turkeys') }}</label>
                                            <input type="number" class="form-control text-danger" id="pvs"
                                                value="{{ $evento->pvs }}" readonly>
                                        </div>
                                        <div class="col-6 col-md-4  mb-3">
                                            <label for="lch" class="form-label">{{ __('Piglets') }}</label>
                                            <input type="number" class="form-control text-danger" id="lch"
                                                value="{{ $evento->lch }}" readonly>
                                        </div>
                                        <div class="col-5 mb-3">
                                            <label for="cnt" class="form-label">{{ __('Baskets') }}</label>
                                            <input type="number" class="form-control text-danger" id="cnt"
                                                value="{{ $evento->cnt }}" readonly>
                                        </div>
                                        <div class="col-7 mb-3">
                                            <label for="skg" class="form-label">{{ __('Bags') }}</label>
                                            <input id="skg" type="number" class="form-control text-danger"
                                                value="{{ $evento->skg }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL TICKETS -->
    <div class="modal fade" id="Tickets" aria-hidden="true" aria-labelledby="AddExemplar" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-black border border-danger">
                <div class="modal-header bg-black border border-danger">
                    {{-- <div class="modal-title fw-bold fs-4">{{ __('Event') }} {{ $evento->tevent }}</div> --}}
                    <button type="button" class="btn btn-danger bg-danger btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-black border border-danger">
                    <div class="mb-3">
                        <div class="card h-100 bg-black border border-danger">
                            <div class="card-header border border-danger fw-bold text-uppercase">
                                {{ __('Tickets') }}</div>
                            <div class="card-body border border-danger">
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label for="egn" class="form-label">{{ __('GENERAL') }}</label>
                                        <input type="text" class="form-control text-danger" id="egn"
                                            value="{{ $evento->egn }}" readonly>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="evp" class="form-label">{{ __('VIP') }}</label>
                                        <input type="text" class="form-control text-danger" id="evp"
                                            value="{{ $evento->evp }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="card h-100 bg-black border border-danger">
                            <div class="card-header border border-danger fw-bold text-uppercase">
                                {{ __('inscriptions') }}</div>
                            <div class="card-body border border-danger">
                                <div class="row">
                                    <div class="col-12 col-lg-4 mb-3">
                                        <label for="ift" class="form-label">{{ __('Forehead') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-text">S/.</div>
                                            <input type="text" class="form-control text-danger" id="ift"
                                                value="{{ $evento->ift }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 mb-3">
                                        <label for="gll" class="form-label">{{ __('Cock') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-text">S/.</div>
                                            <input type="text" class="form-control text-danger" id="gll"
                                                value="{{ $evento->gll }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 mb-3">
                                        <label for="glp" class="form-label">{{ __('Shed') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-text">S/.</div>
                                            <input type="text" class="form-control text-danger" id="glp"
                                                value="{{ $evento->glp }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/datatable/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
    {{-- JS --}}
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
    {{-- DATATABLE --}}
    <script>
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
            language: {
                "url": getLanguage()
            },
            "columnDefs": [{
                "targets": 0,
                "type": "date-eu"
            }],
            bInfo: false,
            pageLength: false,
            pageLength: 10,
            lengthMenu: [
                [10],
                [10]
            ]
        });
        /* MASCOTA */
        function displayVals() {
            var id = $('#mascota_id').val();
            $.ajax({
                type: 'GET', //THIS NEEDS TO BE GET
                url: '/participants/' + id,
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    $.each(data, function(i, item) {
                        $("#mreggal").val(item.REGGAL);
                    });
                },
                error: function() {
                    console.log(data);
                }
            });
        };
        $("#mascota_id").change(displayVals);
        displayVals();
        //HIDE
        setTimeout(function() {
            $('.alert').fadeOut(3000);
        });
        /*  DONT COPY OR PASTE*/
        $(document).ready(function() {
            $('input').bind('copy paste', function(e) {
                e.preventDefault();
            });
        });
    </script>
@endsection
