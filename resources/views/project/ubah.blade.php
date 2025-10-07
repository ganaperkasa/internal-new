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
          <div>Ubah Informasi Aplikasi
            
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
      {!! Form::model($data_edit, [
          'method' => 'POST',
          'url' => ['project/simpanperubahan', $data_edit->id],
          'enctype' => 'multipart/form-data'
      ]) !!}

        <div class="position-relative form-group">
            <label>Paket Pekerjaan</label>
            {!! Form::text('paket_pekerjaan', null, ['class' => 'form-control'] ) !!}
        </div>
        <div class="position-relative form-group">
            <label>Kegiatan</label>
            {!! Form::text('kegiatan', null, ['class' => 'form-control'] ) !!}
        </div>
        <div class="position-relative form-group">
            <label>Jenis Pekerjaan</label>
            {{ Form::select('jenis_pekerjaan', ['1'=>'Pembuatan Baru','2'=>'Pengembangan'], null, ['class' => 'form-control']) }}
        </div>
        <div class="position-relative  form-group">
            <label>Kategori Aplikasi</label>
            {{ Form::select('kategori_id', $kategori, null, ['class' => 'form-control']) }}
            
        </div>
        <div class="position-relative form-group">
            <label>Anggaran</label>
            {!! Form::text('anggaran', null, ['class' => 'form-control rupiah'] ) !!}
        </div>
        <div class="position-relative form-group">
            <label>Jangka Waktu</label>

            <div class="input-group">
            {!! Form::number('jangka_waktu', null, ['class' => 'form-control'] ) !!}
                <div class="input-group-append"><span class="input-group-text">Hari</span></div>
            </div>
        </div>
        <div class="position-relative form-group">
            <label>Tanggal Mulai Pekerjaan</label>
            {!! Form::date('tanggal_mulai', null, ['class' => 'form-control'] ) !!}
        </div>
          <div class="position-relative row form-check">
              <div class="col-sm-10 offset-sm-2">
                  {!! Form::button('Simpan', ['class' => 'btn btn-secondary simpan', 'type' => 'submit', 'data-swa-text' => 'Merubah Informasi Aplikasi']) !!}
              </div>
          </div>
      {!! Form::close() !!}
  </div>
</div>
@endsection
@push('custom-scripts')
<script src="{{url('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/scripts/inputmask-global.js')}}" type="text/javascript"></script>

@endpush
