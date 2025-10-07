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
          <div>Ubah Surat {{ $data_edit->number }}
            
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
          'url' => ['admin/surat', $data_edit->id],
          'enctype' => 'multipart/form-data'
      ]) !!}

        <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Instansi*</label>
              <div class="col-sm-8">
                {{ Form::select('instansi_id', $instansi, null, ['class' => 'form-control select2']) }}
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Alamat</label>
              <div class="col-sm-8">
                {!! Form::text('address', null, ['class' => 'form-control'] ) !!}
              </div>
          </div>
          
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Perihal*</label>
              <div class="col-sm-8">
                {!! Form::text('perihal', null, ['class' => 'form-control'] ) !!}
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Tanggal*</label>
              <div class="col-sm-4">
                {!! Form::date('tanggal', null, ['class' => 'form-control'] ) !!}
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">File Pendukung</label>
              <div class="col-sm-8">
                {!! Form::file('document', null, ['class' => 'form-control'] ) !!}
              </div>
          </div>
         
          <div class="position-relative row form-check">
              <div class="col-sm-10 offset-sm-2">
                  <a href="{{ URL::previous() }}" class="btn-shadow mr-3 btn btn-primary">Kembali</a>
                  {!! Form::button('Simpan', ['class' => 'btn btn-secondary simpan', 'type' => 'submit', 'data-swa-text' => 'Merubah Surat']) !!}
              </div>
          </div>
      {!! Form::close() !!}
  </div>
</div>
@endsection
