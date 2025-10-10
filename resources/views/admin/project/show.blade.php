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
          <div>Informasi Pekerjaan

          </div>
      </div>
      <div class="page-title-actions">
        <a href="{{ route('project.index') }}" class="btn-shadow mr-3 btn btn-primary">Kembali</a>
        <a href="{{ route('project.edit', $data_edit->id) }}" class="btn-shadow mr-3 btn btn-info">Ubah</a>
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
            <label class="col-sm-3">Perusahaan</label>
              <div class="col-sm-8">
                <b>{{ $data_edit->perusahaan }}</b>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3">Nama Pekerjaan</label>
              <div class="col-sm-8">
                <b>{{ $data_edit->name }}</b>
              </div>
          </div>
          <!-- <div class="position-relative row form-group">
            <label class="col-sm-3">Judul Aplikasi</label>
              <div class="col-sm-8">
                <b>{{ $data_edit->label }}</b>
              </div>
          </div> -->
          <div class="position-relative row form-group">
            <label class="col-sm-3">Instansi</label>
              <div class="col-sm-8">
                <b>{{ $instansi->name }}</b>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3">Jenis Pekerjaan</label>
              <div class="col-sm-8">
                <b>{{ $type->name }}</b>
              </div>
          </div>

          <div class="position-relative row form-group">
            <label class="col-sm-3">Nominal Pekerjaan</label>
              <div class="col-sm-8">
                <b>{{ toRp($data_edit->nominal) }}</b>
              </div>
          </div>

          <div class="position-relative row form-group">
            <label class="col-sm-3">Tanggal Mulai Pekerjaan  (SPK)</label>
              <div class="col-sm-3">
                <b>{{ tglIndo($data_edit->start) }}</b>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3">Tanggal Selesai Pekerjaan</label>
              <div class="col-sm-3">
                <b>{{ tglIndo($data_edit->end) }}</b>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3">Waktu Pekerjaan</label>
              <div class="col-sm-8">
                <b>{{ $data_edit->time }} {{ $data_edit->time_type }}</b>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3">Progress Pekerjaan</label>
              <div class="col-sm-8">
                <b>{{ $data_edit->progress }} %</b>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3">Catatan</label>
              <div class="col-sm-8">
                <b>{{ $data_edit->catatan }}</b>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3">Marketing & Penanggung Jawab</label>
              <div class="col-sm-3">
                @if(isset($marketing))
                <b>{{ $marketing->name }}</b>
                @endif
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3">Dibuat Oleh</label>
              <div class="col-sm-3">
                <b>{{ $user->name }}</b>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3">Terakhir Dirubah Oleh</label>
              <div class="col-sm-3">
                <b>{{ $update->name }}</b>
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
