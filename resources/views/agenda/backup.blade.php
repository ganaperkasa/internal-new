@extends('layouts.backend')

@push('custom-css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
@endpush

@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
      <div class="page-title-heading">
          <div class="page-title-icon">
              <i class="pe-7s-note2 icon-gradient bg-night-fade">
              </i>
          </div>
          <div>Tambah Laporan Harian
            
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

      {!! Form::open(['route' => 'daily.store','enctype' => 'multipart/form-data']) !!}
       
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Judul</label>
              <div class="col-sm-8">
                {!! Form::text('judul', null, ['class' => 'form-control','autocomplete'=>'off'] ) !!}
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Pelatihan</label>
              <div class="col-sm-8">
              <select class="form-control select2" name="type"><option value="Perangkat Daerah">Pelatihan Komputer</option><option value="BUMD">BUMD</option><option value="BUMN">BUMN</option><option value="Swasta">Swasta</option></select>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Tempat</label>
              <div class="col-sm-8">
                {!! Form::text('tempat', null, ['class' => 'form-control'] ) !!}
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Tanggal</label>
              <div class="col-sm-8">
                {!! Form::text('tanggal', null, ['class' => 'form-control','data-toggle'=>'datepicker','autocomplete'=>'off'] ) !!}
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Jam Mulai</label>
              <div class="col-sm-8">
                {!! Form::text('jam1', null, ['class' => 'form-control datetimepicker3','autocomplete'=>'off'] ) !!}
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Jam Akhir</label>
              <div class="col-sm-8">
                {!! Form::text('jam2', null, ['class' => 'form-control datetimepicker3','autocomplete'=>'off'] ) !!}
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Aktifitas</label>
              <div class="col-sm-8">
                {!! Form::textarea('aktifitas', null, ['class' => 'form-control autosize-input'] ) !!}
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Foto</label>
              <div class="col-sm-8">
                {!! Form::file('foto', null, ['class' => 'form-control autosize-input'] ) !!}
              </div>
          </div>
          
          
          <div class="position-relative row form-check">
              <div class="col-sm-10 offset-sm-2">
                  {!! Form::button('Simpan', ['class' => 'btn btn-secondary simpan', 'type' => 'submit', 'data-swa-text' => 'Menambahkan Laporan Harian']) !!}
              </div>
          </div>
      {!! Form::close() !!}
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