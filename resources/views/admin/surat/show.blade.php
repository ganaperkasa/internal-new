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
          <div>Informasi Surat

          </div>
      </div>
      <div class="page-title-actions">
        <a href="{{ route('surat.index') }}" class="btn-shadow mr-3 btn btn-primary">Kembali</a>
        <a href="{{ route('surat.edit', $data_edit->id) }}" class="btn-shadow mr-3 btn btn-info">Ubah</a>
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



          <div class="position-relative row form-group">
            <label class="col-sm-3">Nomor Surat</label>
              <div class="col-sm-8">
                <b>{{ $data_edit->number }}</b>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3">Instansi</label>
              <div class="col-sm-8">
                <b>{{ $instansi->name }}</b>
              </div>
          </div>

          <div class="position-relative row form-group">
            <label class="col-sm-3">Alamat</label>
              <div class="col-sm-8">
                <b>{{ $data_edit->address }}</b>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3">Perihal</label>
              <div class="col-sm-8">
              <b>{{ $data_edit->perihal }}</b>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3">Tanggal</label>
              <div class="col-sm-3">
                <b>{{ tglIndo($data_edit->tanggal) }}</b>
              </div>
          </div>
         <div class="position-relative row form-group">
            <label class="col-sm-3">File Pendukung</label>
              <div class="col-sm-3">
                @if($data_edit->document != null)
                <a target="_blank" href="{{asset('uploads/surat/'.$data_edit->document)}}" class="mb-2 mr-2 btn btn-warning" >Download</a>
                @endif
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3">Dibuat Oleh</label>
              <div class="col-sm-3">
                <b>{{ $user->name }}</b>
              </div>
          </div>

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
