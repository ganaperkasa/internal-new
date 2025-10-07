@extends('layouts.backend')

@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
      <div class="page-title-heading">
          <div class="page-title-icon">
              <i class="pe-7s-car icon-gradient bg-night-fade">
              </i>
          </div>
          <div>Ubah Kontak Pelanggan
            
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
          'url' => ['marketing/contact', $data_edit->id],
          'enctype' => 'multipart/form-data'
      ]) !!}
        <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Instansi</label>
              <div class="col-sm-8">
                {{ Form::select('instansi_id', $instansi, null, ['class' => 'form-control select2']) }}
              </div>
          </div>
         
          <h5 class="card-title">Kontak Pelanggan</h5>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Nama</label>
              <div class="col-sm-8">
                {!! Form::text('nama', null, ['class' => 'form-control'] ) !!}
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Jabatan</label>
              <div class="col-sm-8">
                {!! Form::text('jabatan', null, ['class' => 'form-control'] ) !!}
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Email</label>
              <div class="col-sm-8">
                {!! Form::text('email', null, ['class' => 'form-control'] ) !!}
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Telepon 1</label>
              <div class="col-sm-8">
                {!! Form::text('telp_1', null, ['class' => 'form-control'] ) !!}
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Telepon 2</label>
              <div class="col-sm-8">
                {!! Form::text('telp_2', null, ['class' => 'form-control'] ) !!}
              </div>
          </div>
          
          
          <div class="position-relative row form-check">
              <div class="col-sm-10 offset-sm-2">
                  {!! Form::button('Simpan', ['class' => 'btn btn-secondary simpan', 'type' => 'submit', 'data-swa-text' => 'Merubah Kontak Pelanggan']) !!}
              </div>
          </div>
      {!! Form::close() !!}
  </div>
</div>
@endsection
