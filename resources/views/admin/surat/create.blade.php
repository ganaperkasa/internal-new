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
          <div>Tambah Surat
            
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

      {!! Form::open(['route' => 'surat.store','enctype' => 'multipart/form-data']) !!}
            <div class="position-relative row form-group">
                <label class="col-sm-3 col-form-label">Perusahaan*</label>
                <div class="col-sm-2">
                    {{ Form::select('type', ['SEP'=>'SEP','DIR'=>'DIR','MSK'=>'MSK'], null, ['class' => 'form-control select2','id'=>'perusahaan']) }}
                </div>
            </div>
            <div id="jenis_surat" style="display: none;">
            <div class="position-relative row form-group" >
                <label class="col-sm-3 col-form-label">Jenis Surat</label>
                <div class="col-sm-8">
                    {{ Form::select('type_msk', ['BA'=>'Berita Acara','DO'=>'Delivery Order','KWI'=>'Kwitansi','IVC'=>'Invoice','RB'=>'Refrensi Bank','SK1'=>'Surat Kuasa','SK'=>'Surat Keluar','SPH'=>'Surat Penawaran Harga','ST'=>'Surat Tugas'], null, ['class' => 'form-control']) }}
                </div>
            </div>
            </div>
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
                  {!! Form::button('Simpan', ['class' => 'btn btn-secondary simpan', 'type' => 'submit', 'data-swa-text' => 'Menambahkan Surat']) !!}
              </div>
          </div>
      {!! Form::close() !!}
  </div>
</div>
@endsection


@push('custom-scripts')

<script>
$(document).ready(function(){

  $( "#perusahaan" ).change(function() {
    var val = $(this).val();
    if(val == 'MSK'){
      $('#jenis_surat').css('display','block');
    }else{
      $('#jenis_surat').css('display','none');
    }
  });

});
</script>
@endpush