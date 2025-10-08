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


      <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="position-relative row form-group">
                <label class="col-sm-3 col-form-label">Perusahaan*</label>
                <div class="col-sm-2">
                    {{-- {{ Form::select('type', ['SEP'=>'SEP','DIR'=>'DIR','MSK'=>'MSK'], null, ['class' => 'form-control select2','id'=>'perusahaan']) }} --}}
                    <select name="type" id="perusahaan" class="form-control select2">
                      <option value="SEP" selected>Surat Eksternal Perusahaan</option>
                      <option value="DIR">Surat Direksi</option>
                      <option value="MSK">Surat Masuk</option>
                    </select>
                </div>
            </div>
            <div id="jenis_surat" style="display: none;">
            <div class="position-relative row form-group" >
                <label class="col-sm-3 col-form-label">Jenis Surat</label>
                <div class="col-sm-8">
                    <select name="type_msk" class="form-control">
                    <option value="BA">Berita Acara</option>
                    <option value="DO">Delivery Order</option>
                    <option value="KWI">Kwitansi</option>
                    <option value="IVC">Invoice</option>
                    <option value="RB">Refrensi Bank</option>
                    <option value="SK1">Surat Kuasa</option>
                    <option value="SK">Surat Keluar</option>
                    <option value="SPH">Surat Penawaran Harga</option>
                    <option value="ST">Surat Tugas</option>
                </select>
                </div>
            </div>
            </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Instansi*</label>
              <div class="col-sm-8">
                <select name="instansi_id" class="form-control select2">
                    @foreach($instansi as $id => $nama)
                        <option value="{{ $id }}">{{ $nama }}</option>
                    @endforeach
                </select>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Alamat</label>
              <div class="col-sm-8">
                <input type="text" name="address" class="form-control" value="{{ old('address') }}">
              </div>
          </div>

          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Perihal*</label>
              <div class="col-sm-8">
                 <input type="text" name="perihal" class="form-control" value="{{ old('perihal') }}">
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Tanggal*</label>
              <div class="col-sm-4">
                 <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal') }}">
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">File Pendukung</label>
              <div class="col-sm-8">
                 <input type="file" name="document" class="form-control">
              </div>
          </div>

          <div class="position-relative row form-check">
              <div class="col-sm-10 offset-sm-2">
                <a href="{{ URL::previous() }}" class="btn-shadow mr-3 btn btn-primary">Kembali</a>
                <button class="btn-shadow btn btn-secondary simpan" type="submit" data-swa-text="Menambahkan Surat">Simpan</button>
              </div>
          </div>
      </form>
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
