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
          <div>Ubah Kunjungan
            
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
          'method' => 'PATCH',
          'url' => ['marketing/visit', $data_edit->id],
          'enctype' => 'multipart/form-data'
      ]) !!}

        <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Instansi</label>
              <div class="col-sm-8">
                {{ Form::select('instansi_id', $instansi, null, ['class' => 'form-control select2']) }}
              </div>
          </div>
          <h5 class="card-title">Kunjungan</h5>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Tanggal</label>
              <div class="col-sm-2">
                {!! Form::date('tanggal', null, ['class' => 'form-control'] ) !!}
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Jam Mulai</label>
              <div class="col-sm-2">
                {!! Form::text('jam1', null, ['class' => 'form-control datetimepicker3','autocomplete'=>'off'] ) !!}
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Jam Akhir</label>
              <div class="col-sm-2">
                {!! Form::text('jam2', null, ['class' => 'form-control datetimepicker3','autocomplete'=>'off'] ) !!}
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Aktifitas</label>
              <div class="col-sm-8">
                {!! Form::textarea('keterangan', null, ['class' => 'form-control autosize-input'] ) !!}
              </div>
          </div>
         
          <div class="position-relative row form-check">
              <div class="col-sm-10 offset-sm-2">
                  <a href="{{ URL::previous() }}" class="btn-shadow mr-3 btn btn-primary">Kembali</a>
                  {!! Form::button('Simpan', ['class' => 'btn btn-secondary simpan', 'type' => 'submit', 'data-swa-text' => 'Merubah Kunjungan']) !!}
              </div>
          </div>
      {!! Form::close() !!}
  </div>
</div>
@endsection
