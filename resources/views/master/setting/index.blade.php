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
          <div>Pengaturan

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
      {{-- {!! Form::model($data_edit, [
          'method' => 'PATCH',
          'url' => ['master/setting', $data_edit->id],
          'enctype' => 'multipart/form-data'
      ]) !!} --}}
       <form method="POST" action="{{ route('setting.update', $data_edit->id) }}" enctype="multipart/form-data">
          @csrf
          @method('PATCH')

          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Nomor Terakhir Surat SEP</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('last_number_sep', null, ['class' => 'form-control'] ) !!} --}}
                <input type="text" name="last_number_sep" class="form-control" value="{{ old('last_number_sep', $data_edit->last_number_sep) }}">
              </div>
          </div>

          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Nomor Terakhir Surat DIR</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('last_number_dir', null, ['class' => 'form-control'] ) !!} --}}
                <input type="text" name="last_number_dir" class="form-control" value="{{ old('last_number_dir', $data_edit->last_number_dir) }}">
              </div>
          </div>

          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Nomor Terakhir Surat MSK</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('last_number_msk', null, ['class' => 'form-control'] ) !!} --}}
                <input type="text" name="last_number_msk" class="form-control" value="{{ old('last_number_msk', $data_edit->last_number_msk) }}">
              </div>
          </div>

          <div class="position-relative row form-check">
              <div class="col-sm-10 offset-sm-2">
                  {{-- {!! Form::button('Simpan', ['class' => 'btn btn-secondary simpan', 'type' => 'submit', 'data-swa-text' => 'Merubah Pengaturan']) !!} --}}
                    <button class="btn btn-secondary simpan" type="submit" data-swa-text="Merubah Pengaturan">Simpan</button>
              </div>
          </div>
      {{-- {!! Form::close() !!} --}}
          </form>
  </div>
</div>
@endsection
