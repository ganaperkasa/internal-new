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
          <div>Informasi Aset
            
          </div>
      </div>
      <div class="page-title-actions">
        <a href="{{ url('admin/aset') }}" class="btn-shadow mr-3 btn btn-primary">Kembali</a>
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
          'url' => ['asman', $data_edit->id],
          'enctype' => 'multipart/form-data'
      ]) !!}
       
          <div class="position-relative row form-group">
            <label class="col-sm-3">Nomor Aset</label>
              <div class="col-sm-8">
                <b>{{ $data_edit->number }}</b>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3">Jenis Barang</label>
              <div class="col-sm-8">
                <b>{{ $barang->name }}</b>
              </div>
          </div>
          
          <div class="position-relative row form-group">
            <label class="col-sm-3">Merk Barang</label>
              <div class="col-sm-8">
                <b>{{ $data_edit->name }}</b>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3">Speksifikasi</label>
              <div class="col-sm-8">
              <b>{{ $data_edit->spesifikasi }}</b>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3">Kondisi Barang</label>
              <div class="col-sm-3">
              <b>{{ $data_edit->kondisi }}</b>
              </div>
          </div>
          @if($data_edit->kondisi == 'Pinjam/Sewa')
          <div class="position-relative row form-group">
            <label class="col-sm-3">Instansi</label>
              <div class="col-sm-8">
                @if(isset($instansi))
                <b>{{ $instansi->name }}</b>
                @endif
              </div>
          </div>
          @endif
          <div class="position-relative row form-group">
            <label class="col-sm-3">Keterangan</label>
              <div class="col-sm-8">
                <b>{{ $data_edit->keterangan }}</b>
              </div>
          </div>
         <div class="position-relative row form-group">
            <label class="col-sm-3">File Pendukung</label>
              <div class="col-sm-3">
                @if($data_edit->document != null)
                <a target="_blank" href="{{asset('uploads/aset/'.$data_edit->document)}}" class="mb-2 mr-2 btn btn-warning" >Download</a>
                @endif
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3">Dibuat Oleh</label>
              <div class="col-sm-3">
                <b>{{ $user->name }}</b>
              </div>
          </div>
      {!! Form::close() !!}
  </div>
</div>
@endsection



@push('custom-scripts')

<script type="text/javascript">
  $(document).ready(function() {
      $('.js-example-basic-single').select2();
  });

</script>

@endpush
