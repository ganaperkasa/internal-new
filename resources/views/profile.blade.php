@extends('layouts.backend')

@push('custom-css')

@endpush

@section('content')

<div class="app-page-title">
    <div class="page-title-wrapper">
      <div class="page-title-heading">
          <div class="page-title-icon">
              <i class="pe-7s-graph2 icon-gradient bg-night-fade">
              </i>
          </div>
          <div>Profil

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
          'method' => 'POST',
          'url' => url('profil-update'),
          'enctype' => 'multipart/form-data'
      ]) !!} --}}
       <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data">
        @csrf

          <div class="position-relative row form-group">
            <label for="exampleEmail" class="col-sm-3 col-form-label">Email</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('email', null, ['class' => 'form-control'] ) !!} --}}
                <input type="email" name="email" class="form-control" value="{{ $data_edit->email }}" readonly>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Nama</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('name', null, ['class' => 'form-control'] ) !!} --}}
                <input type="text" name="name" class="form-control" value="{{ $data_edit->name }}">
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Password</label>
              <div class="col-sm-8">
                {{-- {!! Form::password('password', ['class' => 'form-control', 'id' => 'password'] ) !!} --}}
                <input type="password" name="password" class="form-control" id="password">
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Ulangi Password</label>
              <div class="col-sm-8">
                {{-- {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password_confirmation'] ) !!} --}}
                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
              </div>
          </div>
          <div class="position-relative row form-check">
              <div class="col-sm-10 offset-sm-2">
                  {{-- {!! Form::button('Simpan', ['class' => 'btn btn-secondary simpan', 'type' => 'submit', 'data-swa-text' => 'Merubah Profil']) !!} --}}
                    <button class="btn btn-secondary simpan" type="submit" data-swa-text="Merubah Profil">Simpan</button>
              </div>
          </div>
      {{-- {!! Form::close() !!} --}}
         </form>
  </div>
</div>
@endsection
