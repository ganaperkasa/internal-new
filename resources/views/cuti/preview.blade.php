@extends('layouts.backend')

@push('css')
    <style>
        .embed-responsive {
            position: relative;
            display: block;
            width: 100%;
            padding: 0;
            overflow: hidden;
        }

        .embed-responsive .embed-responsive-item,
        .embed-responsive embed,
        .embed-responsive iframe,
        .embed-responsive object,
        .embed-responsive video {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        .embed-responsive-16by9::before {
            padding-top: 56.25%;
        }

        .embed-responsive::before {
            display: block;
            content: "";
        }
    </style>
@endpush


@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-10">
                    <h5 class="">Show Berkas </h5>
                </div>
                <div class="col-lg-2">
                    <a href="{{ URL::previous() }}" type="button" class="btn btn-primary btn-rounded btn-fw">
                        Kembali
                        <i class="mdi mdi-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="embed-responsive embed-responsive-16by9">
                <iframe id="iframeid" class="embed-responsive-item" allowfullscreen src="{{ asset('uploads/'. $cuti->file_terima) }}"></iframe>
            </div>
        </div>
    </div>
@endsection
