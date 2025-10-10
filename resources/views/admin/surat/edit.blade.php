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
          <div>Ubah Surat {{ $data_edit->number }}

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
      <form action="{{ route('surat.update', $data_edit->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PATCH')

        <div class="position-relative row form-group">
              <label class="col-sm-3 col-form-label">Instansi*</label>
              <div class="col-sm-8">
                  <select name="instansi_id" class="form-control select2">
                      <option value="">-- Pilih Instansi --</option>
                      @foreach($instansi as $id => $nama)
                          <option value="{{ $id }}" {{ old('instansi_id', $data_edit->instansi_id) == $id ? 'selected' : '' }}>
                              {{ $nama }}
                          </option>
                      @endforeach
                  </select>
              </div>
          </div>

          <div class="position-relative row form-group">
              <label class="col-sm-3 col-form-label">Alamat</label>
              <div class="col-sm-8">
                  <input type="text" name="address" class="form-control"
                         value="{{ old('address', $data_edit->address) }}">
              </div>
          </div>

          <div class="position-relative row form-group">
              <label class="col-sm-3 col-form-label">Perihal*</label>
              <div class="col-sm-8">
                  <input type="text" name="perihal" class="form-control"
                         value="{{ old('perihal', $data_edit->perihal) }}">
              </div>
          </div>

          <div class="position-relative row form-group">
              <label class="col-sm-3 col-form-label">Tanggal*</label>
              <div class="col-sm-4">
                  <input type="date" name="tanggal" class="form-control"
                         value="{{ old('tanggal', $data_edit->tanggal) }}">
              </div>
          </div>

          <div class="position-relative row form-group">
              <label class="col-sm-3 col-form-label">File Pendukung</label>
              <div class="col-sm-8">
                  <input type="file" name="document" class="form-control">
                  @if($data_edit->document)
                      <small class="form-text text-muted">
                          File sekarang: <a href="{{ asset('storage/'.$data_edit->document) }}" target="_blank">Lihat</a>
                      </small>
                  @endif
              </div>
          </div>

          <div class="position-relative row form-check">
              <div class="col-sm-10 offset-sm-2">
                  <a href="{{ URL::previous() }}" class="btn-shadow mr-3 btn btn-primary">Kembali</a>
                  <button type="submit" class="btn btn-secondary simpan" data-swa-text="Merubah Surat">
                      Simpan
                  </button>
              </div>
          </div>
      </form>
  </div>
</div>
@endsection
