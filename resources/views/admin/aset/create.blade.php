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
          <div>Tambah Aset
            
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

      {!! Form::open(['route' => 'aset.store','enctype' => 'multipart/form-data']) !!}
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Nomor Aset *</label>
              <div class="col-sm-8">
                {!! Form::text('number', null, ['class' => 'form-control'] ) !!}
              </div>
          </div>
          
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Jenis Barang*</label>
              <div class="col-sm-8">
                {{ Form::select('barang_id', $barang, null, ['class' => 'form-control select2']) }}
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Merk Barang *</label>
              <div class="col-sm-8">
                {!! Form::text('name', null, ['class' => 'form-control'] ) !!}
              </div>
          </div>
          
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Speksifikasi*</label>
              <div class="col-sm-8">
                {!! Form::textarea('spesifikasi', null, ['class' => 'form-control'] ) !!}
              </div>
          </div>
          <div class="position-relative row form-group" >
              <label class="col-sm-3 col-form-label">Kondisi Barang*</label>
              <div class="col-sm-8">
                  {{ Form::select('kondisi', ['Pinjam/Sewa'=>'Pinjam/Sewa','Kantor'=>'Kantor','Rusak'=>'Rusak','Diserahkan'=>'Diserahkan','Hilang'=>'Hilang'], null, ['class' => 'form-control','id'=>'kondisi']) }}
              </div>
          </div>
          <div id="instansi" style="display: block;">
              <div class="position-relative row form-group">
                <label class="col-sm-3 col-form-label">Instansi</label>
                  <div class="col-sm-8">
                    {{ Form::select('instansi_id', $instansi, null, ['class' => 'form-control select2']) }}
                  </div>
              </div>
          </div>

          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Keterangan</label>
              <div class="col-sm-8">
                {!! Form::textarea('keterangan', null, ['class' => 'form-control','rows'=>'2'] ) !!}
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
                  {!! Form::button('Simpan', ['class' => 'btn btn-secondary simpan', 'type' => 'submit', 'data-swa-text' => 'Menambahkan Aset']) !!}
              </div>
          </div>
      {!! Form::close() !!}
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