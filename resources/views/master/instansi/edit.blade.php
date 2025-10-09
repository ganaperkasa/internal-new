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
          <div>Ubah Instansi

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
          'url' => ['master/instansi', $data_edit->id],
          'enctype' => 'multipart/form-data'
      ]) !!} --}}
        <form method="POST" action="{{ route('instansi.update', $data_edit->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Nama Instansi</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('name', null, ['class' => 'form-control'] ) !!} --}}
                <input type="text" name="name" class="form-control" value="{{ $data_edit->name }}" required>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Jenis</label>
              <div class="col-sm-8">
                {{-- {{ Form::select('type', ['Perangkat Daerah'=>'Perangkat Daerah','BUMD'=>'BUMD','BUMN'=>'BUMN','Swasta'=>'Swasta'], null, ['class' => 'form-control select2']) }} --}}
                <select name="type" class="form-control" required>
                  <option value="Perangkat Daerah" {{ $data_edit->type == 'Perangkat Daerah' ? 'selected' : '' }}>Perangkat Daerah</option>
                  <option value="BUMD" {{ $data_edit->type == 'BUMD' ? 'selected' : '' }}>BUMD</option>
                  <option value="BUMN" {{ $data_edit->type == 'BUMN' ? 'selected' : '' }}>BUMN</option>
                  <option value="Swasta" {{ $data_edit->type == 'Swasta' ? 'selected' : '' }}>Swasta</option>
                </select>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Alamat</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('address', null, ['class' => 'form-control'] ) !!} --}}
                <input type="text" name="address" class="form-control" value="{{ $data_edit->address }}" required>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Email</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('email', null, ['class' => 'form-control'] ) !!} --}}
                <input type="email" name="email" class="form-control" value="{{ $data_edit->email }}" required>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Telp</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('telp', null, ['class' => 'form-control'] ) !!} --}}
                <input type="text" name="telp" class="form-control" value="{{ $data_edit->telp }}" required>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Fax</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('fax', null, ['class' => 'form-control'] ) !!} --}}
                <input type="text" name="fax" class="form-control" value="{{ $data_edit->fax }}" required>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Website</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('website', null, ['class' => 'form-control'] ) !!} --}}
                <input type="text" name="website" class="form-control" value="{{ $data_edit->website }}" required>
              </div>
          </div>
          <div class="position-relative row form-check">
              <div class="col-sm-10 offset-sm-2">
                  {{-- {!! Form::button('Simpan', ['class' => 'btn btn-secondary simpan', 'type' => 'submit', 'data-swa-text' => 'Merubah Perangkat Daerah']) !!} --}}
                    <button class="btn btn-secondary simpan" type="submit" data-swa-text="Merubah Perangkat Daerah">Simpan</button>
              </div>
          </div>
      {{-- {!! Form::close() !!} --}}
        </form>
  </div>
</div>
@endsection
