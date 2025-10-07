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
          <div>Permohonan Aplikasi
            <div class="page-title-subheading">Form yang digunakan untuk melakukan pengajuan Aplikasi Baru</div>
          </div>
      </div>
    </div>
</div>
<div class="main-card mb-3 card">
    {!! Form::open(['route' => 'permohonan.store','enctype' => 'multipart/form-data']) !!}
    <div class="card-body">
        <div  class="forms-wizard-vertical sw-main sw-theme-default">
            <ul class="forms-wizard nav nav-tabs step-anchor">
                <li class="nav-item active">
                    <a href="#step-122" class="nav-link">
                        <em>1</em><span>Informasi Aplikasi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#step-222" class="nav-link">
                        <em>2</em><span>Dokumen Aplikasi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#step-322" class="nav-link">
                        <em>3</em><span>File Pendukung</span>
                    </a>
                </li>
            </ul>
            <div class="form-wizard-content sw-container tab-content" style="min-height: 458px;">
                <div id="step-122" class="tab-pane step-content" style="display: block;">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-dark">
                                <b>Terdapat beberapa kesalahan. Silahkan diperbaiki.</b><br>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </div>
                        @endif
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
                    </div>
                </div>

            </div>
        </div>
        <div class="divider"></div>
        <div class="clearfix">
          <button type="button" id="reset-btn" class="btn-shadow float-left btn btn-danger">Batal</button>
          {!! Form::button('Selanjutnya', ['class' => 'btn-shadow float-right btn-wide btn-pill mr-3 btn btn-outline-secondary simpan', 'type' => 'submit', 'data-swa-text' => 'Melanjutkan Permohonan']) !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>
@endsection


@push('custom-scripts')
<script src="{{url('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/scripts/inputmask-global.js')}}" type="text/javascript"></script>
<script>
$( "#reset-btn" ).click(function() {
  location.reload();
});
</script>
@endpush
