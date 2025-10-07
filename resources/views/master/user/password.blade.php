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
          <div>Ubah Password User
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

      {!! Form::open(['url' => url('master/user/password'),'method'=>'POST','enctype' => 'multipart/form-data']) !!}
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Nama</label>
              <div class="col-sm-8">
                {{ $data_edit->name }}
                <input type="hidden" name="id" value="{{ $data_edit->id }}">
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Email</label>
              <div class="col-sm-8">
                {{ $data_edit->email }}
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


          <div class="position-relative row form-check">
              <div class="col-sm-10 offset-sm-2">
                  {!! Form::button('Simpan', ['class' => 'btn btn-secondary simpan', 'type' => 'submit', 'data-swa-text' => 'Merubah Password']) !!}
              </div>
          </div>
      {!! Form::close() !!}
  </div>
</div>
@endsection
