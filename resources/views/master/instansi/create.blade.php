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
          <div>Tambah Instansi

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

      {{-- {!! Form::open(['route' => 'instansi.store','enctype' => 'multipart/form-data']) !!} --}}
      <form method="POST" action="{{ route('instansi.store') }}" enctype="multipart/form-data">
          @csrf
          <h5 class="card-title">Data Instansi</h5>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Nama Instansi</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('name', null, ['class' => 'form-control'] ) !!} --}}
                <input type="text" name="name" class="form-control" required>
              </div>
          </div>

          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Jenis</label>
              <div class="col-sm-8">
                {{-- {{ Form::select('type', ['Perangkat Daerah'=>'Perangkat Daerah','BUMD'=>'BUMD','BUMN'=>'BUMN','Swasta'=>'Swasta'], null, ['class' => 'form-control select2']) }} --}}
                <select name="type" class="form-control" required>
                  <option value="Perangkat Daerah">Perangkat Daerah</option>
                  <option value="BUMD">BUMD</option>
                  <option value="BUMN">BUMN</option>
                  <option value="Swasta">Swasta</option>
                </select>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Alamat</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('address', null, ['class' => 'form-control'] ) !!} --}}
                <input type="text" name="address" class="form-control" required>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Email</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('email', null, ['class' => 'form-control'] ) !!} --}}
                <input type="email" name="email" class="form-control" required>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Telp</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('telp', null, ['class' => 'form-control'] ) !!} --}}
                <input type="text" name="telp" class="form-control" required>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Fax</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('fax', null, ['class' => 'form-control'] ) !!} --}}
                <input type="text" name="fax" class="form-control" required>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Website</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('website', null, ['class' => 'form-control'] ) !!} --}}
                <input type="text" name="website" class="form-control" required>
              </div>
          </div>

          <h5 class="card-title">Kontak Pelanggan</h5>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Nama</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('nama', null, ['class' => 'form-control'] ) !!} --}}
                <input type="text" name="nama_pelanggan" class="form-control" required>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Jabatan</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('jabatan', null, ['class' => 'form-control'] ) !!} --}}
                <input type="text" name="jabatan_pelanggan" class="form-control" required>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Email</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('email_pelanggan', null, ['class' => 'form-control'] ) !!} --}}
                <input type="email" name="email_pelanggan" class="form-control" required>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Telepon 1</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('telp_1', null, ['class' => 'form-control'] ) !!} --}}
                <input type="text" name="telp_1" class="form-control" required>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Telepon 2</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('telp_2', null, ['class' => 'form-control'] ) !!} --}}
                <input type="text" name="telp_2" class="form-control" required>
              </div>
          </div>

          <div class="position-relative row form-check">
              <div class="col-sm-10 offset-sm-2">
                  {{-- {!! Form::button('Simpan', ['class' => 'btn btn-secondary simpan', 'type' => 'submit', 'data-swa-text' => 'Menambahkan Instansi']) !!} --}}
                  <button class="btn btn-secondary simpan" type="submit" data-swa-text="Menambahkan Instansi">Simpan</button>
              </div>
          </div>
      {{-- {!! Form::close() !!} --}}
      </form>
  </div>
</div>
@endsection
