@extends('layouts.app')

@section('content')
    <div class="mx-auto">
        <div class="mb-5">
            <a href="{{ route('mascotas.create') }}" class="fw-bold text-uppercase btn btn-outline-danger px-5">
                {{ __('Add Pet') }}
            </a>
        </div>

        <div class="row row-cols-1 row-cols-md-2 g-4">
            @foreach ($mascotas as $mascota)
                <div class="col">
                    <div class="card border-dark mb-3 h-100">
                        <div class="row g-0">
                            <div class="col-md-4 my-auto">
                                <a href="{{ route('mascotas.show', $mascota->id) }}"
                                    class="fw-bold nav-link link-danger text-uppercase">
                                    <img src="@if (!empty($mascota->fotos->where('nfoto', 1)->first())) {{ asset($mascota->fotos->where('nfoto', 1)->first()->ruta) }}
                                @else
                                {{ asset('storage/img/pata.jpg') }} @endif"
                                        class="img-fluid rounded-start d-block mx-auto" alt="...">
                                </a>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="{{ route('mascotas.show', $mascota->id) }}"
                                            class="fw-bold nav-link link-danger text-uppercase">{{ $mascota->REGGAL }}
                                        </a>
                                    </h5>
                                    <div class="card-text">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <div>{{ __('Name') }}: {{ $mascota->nombre }}</div>
                                            </li>
                                            <li class="list-group-item">
                                                <div>{{ __('Birthday') }}: {{ $mascota->fnac }}</div>
                                            </li>
                                            <li class="list-group-item">
                                                <div>{{ __('Weight') }}: {{ $mascota->sss }}</div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
