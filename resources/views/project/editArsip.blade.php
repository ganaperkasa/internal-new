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
          <div>Ubah File Pendukung Aplikasi
            <div class="page-title-subheading">{{ $project->paket_pekerjaan }}</div>
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
      {!! Form::model($data, [
          'method' => 'PATCH',
          'url' => ['project', $data->id],
          'enctype' => 'multipart/form-data'
      ]) !!}
      <div class="position-relative row form-group">
        <label for="exampleEmail" class="col-sm-3 col-form-label">File {{ $label->name }}</label>
          <div class="col-sm-8">
            <input name="file" type="file" class="form-control-file">
            <input type="hidden" name="type" value="arsip">
            <input type="hidden" name="label" value="Arsip">
          </div>
      </div>
          <div class="position-relative row form-group">
            <label for="exampleEmail" class="col-sm-3 col-form-label">Link {{ $label->name }}</label>
              <div class="col-sm-8">
                {!! Form::text('link', null, ['class' => 'form-control'] ) !!}
              </div>
          </div>
          <div class="position-relative row form-group">
            <label for="exampleEmail" class="col-sm-3 col-form-label">Keterangan {{ $label->name }}</label>
              <div class="col-sm-8">
                {!! Form::text('deskripsi', null, ['class' => 'form-control'] ) !!}
              </div>
          </div>

          <div class="position-relative row form-check">
              <div class="col-sm-10 offset-sm-2">
                  {!! Form::button('Simpan', ['class' => 'btn btn-secondary simpan', 'type' => 'submit', 'data-swa-text' => 'Merubah File Pendukung Aplikasi']) !!}
              </div>
          </div>
      {!! Form::close() !!}
  </div>
</div>
@endsection


@push('custom-scripts')

@endpush
