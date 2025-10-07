@extends('layouts.backend')

@push('custom-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css"
        rel="stylesheet" />
@endpush

@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-note2 icon-gradient bg-night-fade">
                    </i>
                </div>
                <div>Tambah Laporan Harian

                </div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-dark">
                    <b>Terdapat beberapa kesalahan. Silahkan diperbaiki.</b><br>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('daily.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

               
                <div class="position-relative row form-group">
                    <label class="col-sm-3 col-form-label">Tempat</label>
                    <div class="col-sm-8">
                        <input type="text" name="tempat" value="{{ old('tempat') }}" class="form-control"
                            autocomplete="off">
                    </div>
                </div>

                <div class="position-relative row form-group">
                    <label class="col-sm-3 col-form-label">Tanggal</label>
                    <div class="col-sm-4">
                        <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}"
                            class="form-control">
                    </div>
                </div>

                <div class="position-relative row form-group">
                    <label class="col-sm-3 col-form-label">Jam Mulai</label>
                    <div class="col-sm-2">
                        <input type="text" name="jam1" value="{{ old('jam1') }}"
                            class="form-control datetimepicker3" autocomplete="off">
                    </div>
                </div>

                <div class="position-relative row form-group">
                    <label class="col-sm-3 col-form-label">Jam Akhir</label>
                    <div class="col-sm-2">
                        <input type="text" name="jam2" value="{{ old('jam2') }}"
                            class="form-control datetimepicker3" autocomplete="off">
                    </div>
                </div>

                <div class="position-relative row form-group">
                    <label class="col-sm-3 col-form-label">Aktifitas</label>
                    <div class="col-sm-8">
                        <textarea name="aktifitas" class="form-control autosize-input">{{ old('aktifitas') }}</textarea>
                    </div>
                </div>


                <div class="position-relative row form-check">
                    <div class="col-sm-10 offset-sm-2">
                        <a href="{{ URL::previous() }}" class="btn-shadow mr-3 btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary simpan" data-swa-text="Menambah Laporan Harian">
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection


@push('custom-scripts')
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
    </script>
    <script>
        $(document).ready(function() {


            $('.datetimepicker3').datetimepicker({
                format: 'HH:mm'
            });

        });
    </script>
@endpush
