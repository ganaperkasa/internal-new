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
          <div>Ubah Aset {{ $data_edit->number }}

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
      {{-- {!! Form::model($data_edit, [
          'method' => 'PATCH',
          'url' => ['admin/aset', $data_edit->id],
          'enctype' => 'multipart/form-data'
      ]) !!} --}}
       <form method="POST" action="{{ route('aset.update', $data_edit->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Jenis Barang*</label>
              <div class="col-sm-8">
                {{-- {{ Form::select('barang_id', $barang, null, ['class' => 'form-control select2']) }} --}}
                <select name="barang_id" class="form-control select2" required>
                  <option value="">-- Pilih Jenis Barang --</option>
                  @foreach($barang as $id => $name)
                    <option value="{{ $id }}" {{ $data_edit->barang_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                  @endforeach
                </select>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Merk Barang *</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('name', null, ['class' => 'form-control'] ) !!} --}}
                <input type="text" name="name" class="form-control" value="{{ $data_edit->name }}" required>
              </div>
          </div>
          

          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Speksifikasi*</label>
              <div class="col-sm-8">
                {{-- {!! Form::textarea('spesifikasi', null, ['class' => 'form-control'] ) !!} --}}
                <textarea name="spesifikasi" class="form-control" rows="2" required>{{ $data_edit->spesifikasi }}</textarea>
              </div>
          </div>
          <div class="position-relative row form-group" >
              <label class="col-sm-3 col-form-label">Kondisi Barang*</label>
              <div class="col-sm-8">
                  {{-- {{ Form::select('kondisi', ['Pinjam/Sewa'=>'Pinjam/Sewa','Kantor'=>'Kantor','Rusak'=>'Rusak','Diserahkan'=>'Diserahkan','Hilang'=>'Hilang'], null, ['class' => 'form-control','id'=>'kondisi']) }} --}}
                  <select name="kondisi" class="form-control" id="kondisi" required>
                      <option value="">-- Pilih Kondisi --</option>
                      <option value="Pinjam/Sewa" {{ $data_edit->kondisi == 'Pinjam/Sewa' ? 'selected' : '' }}>Pinjam/Sewa</option>
                      <option value="Kantor" {{ $data_edit->kondisi == 'Kantor' ? 'selected' : '' }}>Kantor</option>
                      <option value="Rusak" {{ $data_edit->kondisi == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                      <option value="Diserahkan" {{ $data_edit->kondisi == 'Diserahkan' ? 'selected' : '' }}>Diserahkan</option>
                      <option value="Hilang" {{ $data_edit->kondisi == 'Hilang' ? 'selected' : '' }}>Hilang</option>
                  </select>
              </div>
          </div>
          @php
            if($data_edit->kondisi == 'Pinjam/Sewa'){
              $status = "block";
            }else{
              $status = "none";
            }
          @endphp
          <div id="instansi" style="display: {{ $status }};">
              <div class="position-relative row form-group">
                <label class="col-sm-3 col-form-label">Instansi*</label>
                  <div class="col-sm-8">
                    {{-- {{ Form::select('instansi_id', $instansi, null, ['class' => 'form-control','--Pilih Instansi--']) }} --}}
                    <select name="instansi_id" class="form-control">
                      <option value="">-- Pilih Instansi --</option>
                      @foreach($instansi as $id => $name)
                        <option value="{{ $id }}" {{ $data_edit->instansi_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                      @endforeach
                    </select>
                  </div>
              </div>
          </div>

          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Keterangan</label>
              <div class="col-sm-8">
                {{-- {!! Form::textarea('keterangan', null, ['class' => 'form-control','rows'=>'2'] ) !!} --}}
                <textarea name="keterangan" class="form-control" rows="2">{{ $data_edit->keterangan }}</textarea>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">File Pendukung</label>
              <div class="col-sm-8">
                {{-- {!! Form::file('document', null, ['class' => 'form-control'] ) !!} --}}
                <input type="file" name="document" class="form-control">
              </div>
          </div>

          <div class="position-relative row form-check">
              <div class="col-sm-10 offset-sm-2">
                  <a href="{{ URL::previous() }}" class="btn-shadow mr-3 btn btn-primary">Kembali</a>
                  {{-- {!! Form::button('Simpan', ['class' => 'btn btn-secondary simpan', 'type' => 'submit', 'data-swa-text' => 'Merubah Aset']) !!} --}}
                    <button class="btn btn-secondary simpan" type="submit" data-swa-text="Merubah Aset">Simpan</button>
              </div>
          </div>
      {{-- {!! Form::close() !!} --}}
       </form>
  </div>
</div>
@endsection


@push('custom-scripts')
<script>
$(document).ready(function(){

  $( "#kondisi" ).change(function() {
    var val = $(this).val();
    if(val == 'Pinjam/Sewa'){
      $('#instansi').css('display','block');
    }else{
      $('#instansi').css('display','none');
    }
  });

});
</script>
@endpush
