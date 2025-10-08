@extends('layouts.backend')

@push('custom-css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
@endpush

@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
      <div class="page-title-heading">
          <div class="page-title-icon">
              <i class="pe-7s-car icon-gradient bg-night-fade">
              </i>
          </div>
          <div>Kunjungan Pelanggan

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

      {{-- {!! Form::open(['route' => 'visit.store','enctype' => 'multipart/form-data']) !!} --}}
      <form method="POST" action="{{ route('visit.store') }}" enctype="multipart/form-data">
            @csrf
        <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Instansi</label>
              <div class="col-sm-8">
                {{-- {{ Form::select('instansi_id', $instansi, null, ['class' => 'form-control select2']) }} --}}
                <select name="instansi_id" class="form-control select2">
                    <option value="">-- Pilih Instansi --</option>
                    @foreach($instansi as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
              </div>
          </div>
          <h5 class="card-title">Kunjungan</h5>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Tanggal</label>
              <div class="col-sm-2">
                {{-- {!! Form::date('tanggal', null, ['class' => 'form-control'] ) !!} --}}
                <input type="date" name="tanggal" class="form-control">
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Jam Mulai</label>
              <div class="col-sm-2">
                {{-- {!! Form::text('jam1', null, ['class' => 'form-control datetimepicker3','autocomplete'=>'off'] ) !!} --}}
                <input type="text" name="jam1" class="form-control datetimepicker3" autocomplete="off">
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Jam Akhir</label>
              <div class="col-sm-2">
                {{-- {!! Form::text('jam2', null, ['class' => 'form-control datetimepicker3','autocomplete'=>'off'] ) !!} --}}
                <input type="text" name="jam2" class="form-control datetimepicker3" autocomplete="off">
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Aktifitas</label>
              <div class="col-sm-8">
                {{-- {!! Form::textarea('keterangan', null, ['class' => 'form-control autosize-input'] ) !!} --}}
                <textarea name="keterangan" class="form-control autosize-input"></textarea>
              </div>
          </div>
          <h5 class="card-title">Kontak Pelanggan</h5>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Nama</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('nama', null, ['class' => 'form-control'] ) !!} --}}
                <input type="text" name="nama" class="form-control">
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Jabatan</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('jabatan', null, ['class' => 'form-control'] ) !!} --}}
                <input type="text" name="jabatan" class="form-control">
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Email</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('nama', null, ['class' => 'form-control'] ) !!} --}}
                <input type="text" name="email" class="form-control">
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Telepon 1</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('telp_1', null, ['class' => 'form-control'] ) !!} --}}
                <input type="text" name="telp_1" class="form-control">
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Telepon 2</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('telp_2', null, ['class' => 'form-control'] ) !!} --}}
                <input type="text" name="telp_2" class="form-control">
              </div>
          </div>


          <div class="position-relative row form-check">
              <div class="col-sm-10 offset-sm-2">
                  {{-- {!! Form::button('Simpan', ['class' => 'btn btn-secondary simpan', 'type' => 'submit', 'data-swa-text' => 'Menambahkan Kunjungan Pelanggan']) !!} --}}
                    <button class="btn btn-secondary simpan" type="submit" data-swa-text="Menambahkan Kunjungan Pelanggan">Simpan</button>
              </div>
          </div>
      {{-- {!! Form::close() !!} --}}
      </form>
  </div>
</div>
@endsection

@push('custom-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script>
$(document).ready(function(){


    $('.datetimepicker3').datetimepicker({
        format: 'HH:mm'
    });

});
</script>
@endpush
