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
          <div>Tambah Barang

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

      {{-- {!! Form::open(['route' => 'barang.store','enctype' => 'multipart/form-data']) !!} --}}
      <form method="POST" action="{{ url('master/barang') }}" enctype="multipart/form-data">
          @csrf

          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Nama Barang</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('name', null, ['class' => 'form-control'] ) !!} --}}
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
              </div>
          </div>

          <div class="position-relative row form-check">
              <div class="col-sm-10 offset-sm-2">
                  {{-- {!! Form::button('Simpan', ['class' => 'btn btn-secondary simpan', 'type' => 'submit', 'data-swa-text' => 'Menambahkan Barang']) !!} --}}
                    <button class="btn btn-secondary simpan" type="submit" data-swa-text="Menambahkan Barang">Simpan</button>
              </div>
          </div>
      {{-- {!! Form::close() !!} --}}
        </form>
  </div>
</div>
@endsection
