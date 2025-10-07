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
          <div>Tambah User
            <div class="page-title-subheading">Daftar user akses aplikasi</div>
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

      {!! Form::open(['route' => 'user.store','enctype' => 'multipart/form-data']) !!}
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Email</label>
              <div class="col-sm-8">
                {!! Form::email('email', null, ['class' => 'form-control', 'id' => 'email'] ) !!}
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Password</label>
              <div class="col-sm-8">
                {!! Form::password('password', ['class' => 'form-control', 'id' => 'password'] ) !!}
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Ulangi Password</label>
              <div class="col-sm-8">
                {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password_confirmation'] ) !!}
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Tanggal Masuk</label>
              <div class="col-sm-8">
                {!! Form::date('tgl_msk', null, ['class' => 'form-control'] ) !!}
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Nama</label>
              <div class="col-sm-8">
                {!! Form::text('name', null, ['class' => 'form-control'] ) !!}
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Level</label>
              <div class="col-sm-8">
                {{ Form::select('role_id', $role, null, ['class' => 'form-control select2']) }}
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Jabatan</label>
              <div class="col-sm-8">
                {{ Form::select('jabatan_id', $jabatan, null, ['class' => 'form-control select2']) }}
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Divisi</label>
              <div class="col-sm-8">
                {{ Form::select('divisi_id', $divisi, null, ['class' => 'form-control select2']) }}
              </div>
          </div>

          <div class="position-relative row form-check">
              <div class="col-sm-10 offset-sm-2">
                  {!! Form::button('Simpan', ['class' => 'btn btn-secondary simpan', 'type' => 'submit', 'data-swa-text' => 'Menambahkan User']) !!}
              </div>
          </div>
      {!! Form::close() !!}
  </div>
</div>
@endsection
