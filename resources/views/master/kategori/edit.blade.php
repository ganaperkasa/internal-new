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
          <div>Ubah Kategori
            <div class="page-title-subheading">Kategori untuk upload file pendukung Aplikasi</div>
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
      {!! Form::model($data_edit, [
          'method' => 'PATCH',
          'url' => ['master/kategori', $data_edit->id],
          'enctype' => 'multipart/form-data'
      ]) !!}

          <div class="position-relative row form-group">
            <label for="exampleEmail" class="col-sm-3 col-form-label">Nama Kategori</label>
              <div class="col-sm-8">
                {!! Form::text('name', null, ['class' => 'form-control'] ) !!}
              </div>
          </div>
    
          <div class="position-relative row form-check">
              <div class="col-sm-10 offset-sm-2">
                  {!! Form::button('Simpan', ['class' => 'btn btn-secondary simpan', 'type' => 'submit', 'data-swa-text' => 'Merubah Kategori']) !!}
              </div>
          </div>
      {!! Form::close() !!}
  </div>
</div>
@endsection
