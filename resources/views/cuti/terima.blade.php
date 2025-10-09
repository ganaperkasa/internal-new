@extends('layouts.backend')

@push('custom-css')
@endpush

@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-ribbon icon-gradient bg-night-fade">
                    </i>
                </div>
                <div>Menerima Cuti

                </div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
         <form action="{{ route('terima.cuti', $cuti->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-dark">
                    <b>Terdapat beberapa kesalahan. Silahkan diperbaiki.</b><br>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif

            @csrf

            <div class="position-relative row form-group">
                <label class="col-sm-3 col-form-label">File Terima</label>
                <div class="col-sm-8">
                    <input class="form-control-file" type="file" name="file_terima" required>
                </div>
                <span class="text-danger ml-2">*File berbentuk pdf</span>
            </div>


        <div class="card-footer">
            <div class="row">
                <div class="col-sm-12 text-end">
                    <a href="{{ URL::previous() }}" class="btn-shadow mr-3 btn btn-warning">Kembali</a>
                    {{-- {!! Form::button('Simpan', [
                        'class' => 'btn btn-success simpan',
                        'type' => 'submit',
                        'data-swa-text' => 'Menerima Cuti',
                    ]) !!} --}}
                    <button class="btn btn-success simpan" type="submit" data-swa-text="Menerima Cuti">Simpan</button>
                </div>
            </div>
            {{-- {!! Form::close() !!} --}}
        </form>
        </div>
    </div>
@endsection


@push('custom-scripts')

@endpush
