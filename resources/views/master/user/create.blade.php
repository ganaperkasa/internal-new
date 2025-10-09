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

      {{-- {!! Form::open(['route' => 'user.store','enctype' => 'multipart/form-data']) !!} --}}
      <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
          @csrf
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Email</label>
              <div class="col-sm-8">
                {{-- {!! Form::email('email', null, ['class' => 'form-control', 'id' => 'email'] ) !!} --}}
                <input type="email" name="email" class="form-control" id="email" required>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Password</label>
              <div class="col-sm-8">
                {{-- {!! Form::password('password', ['class' => 'form-control', 'id' => 'password'] ) !!} --}}
                <input type="password" name="password" class="form-control" id="password" required>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Ulangi Password</label>
              <div class="col-sm-8">
                {{-- {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password_confirmation'] ) !!} --}}
                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Tanggal Masuk</label>
              <div class="col-sm-8">
                {{-- {!! Form::date('tgl_msk', null, ['class' => 'form-control'] ) !!} --}}
                <input type="date" name="tgl_msk" class="form-control" id="tgl_msk" required>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Nama</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('name', null, ['class' => 'form-control'] ) !!} --}}
                <input type="text" name="name" class="form-control" id="name" required>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Level</label>
              <div class="col-sm-8">
                {{-- {{ Form::select('role_id', $role, null, ['class' => 'form-control select2']) }} --}}
                <select name="role_id" class="form-control select2" required>
                  <option value="">-- Pilih Level --</option>
                  @foreach ($role as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                  @endforeach
                </select>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Jabatan</label>
              <div class="col-sm-8">
                {{-- {{ Form::select('jabatan_id', $jabatan, null, ['class' => 'form-control select2']) }} --}}
                <select name="jabatan_id" class="form-control select2" required>
                  <option value="">-- Pilih Jabatan --</option>
                  @foreach ($jabatan as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                    {{-- <option value="{{ $item->id }}">{{ $item->name }}</option> --}}
                  @endforeach
                </select>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Divisi</label>
              <div class="col-sm-8">
                {{-- {{ Form::select('divisi_id', $divisi, null, ['class' => 'form-control select2']) }} --}}
                <select name="divisi_id" class="form-control select2" required>
                  <option value="">-- Pilih Divisi --</option>
                  @foreach ($divisi as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                    {{-- <option value="{{ $item->id }}">{{ $item->name }}</option> --}}
                  @endforeach
                </select>
              </div>
          </div>

          <div class="position-relative row form-check">
              <div class="col-sm-10 offset-sm-2">
                  {{-- {!! Form::button('Simpan', ['class' => 'btn btn-secondary simpan', 'type' => 'submit', 'data-swa-text' => 'Menambahkan User']) !!} --}}
                  <button class="btn btn-secondary simpan" type="submit" data-swa-text="Menambahkan User">Simpan</button>
              </div>
          </div>
      {{-- {!! Form::close() !!} --}}
      </form>
  </div>
</div>
@endsection
