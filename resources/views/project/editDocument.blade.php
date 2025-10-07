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
          <div>Ubah Dokumen Aplikasi
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
            <label for="exampleEmail" class="col-sm-3 col-form-label">{{ $label->name }}</label>
              <div class="col-sm-8">
                {!! Form::textarea('deskripsi', null, ['class' => 'form-control'] ) !!}
                <input type="hidden" name="type" value="dokumen">
                <input type="hidden" name="label" value="Dokumen">
                *{{ $label->step }}
              </div>
          </div>

          <div class="position-relative row form-check">
              <div class="col-sm-10 offset-sm-2">
                  {!! Form::button('Simpan', ['class' => 'btn btn-secondary simpan', 'type' => 'submit', 'data-swa-text' => 'Merubah Dokumen Aplikasi']) !!}
              </div>
          </div>
      {!! Form::close() !!}
  </div>
</div>
@endsection


@push('custom-scripts')

<script src="{{url('assets/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{url('assets/laravel-ckeditor/adapters/jquery.js') }}"></script>
<script>
    $('textarea').ckeditor();
    // $('.textarea').ckeditor(); // if class is prefered.
</script>
@endpush
