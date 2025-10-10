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
          <div>Ubah Pekerjaan {{ $data_edit->number }}

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
          'url' => ['admin/project', $data_edit->id],
          'enctype' => 'multipart/form-data'
      ]) !!} --}}
       <form method="POST" action="{{ route('project.update', $data_edit->id) }}" enctype="multipart/form-data">
          @csrf
          @method('PATCH')
          <div class="position-relative row form-group">
              <label class="col-sm-3 col-form-label">Perusahaan*</label>
              <div class="col-sm-2">
              {{-- {{ Form::select('perusahaan', ['SEP'=>'SEP','DIR'=>'DIR','MSK'=>'MSK','STR'=>'STR','AL'=>'AL','VRC'=>'VRC','NP'=>'NP','LAINNYA'=>'LAINNYA'], null, ['class' => 'form-control select2','id'=>'perusahaan']) }} --}}
                    <select name="perusahaan" class="form-control select2" id="perusahaan">
                        <option value="SEP" {{ $data_edit->perusahaan == 'SEP' ? 'selected' : '' }}>SEP</option>
                        <option value="DIR" {{ $data_edit->perusahaan == 'DIR' ? 'selected' : '' }}>DIR</option>
                        <option value="MSK" {{ $data_edit->perusahaan == 'MSK' ? 'selected' : '' }}>MSK</option>
                        <option value="STR" {{ $data_edit->perusahaan == 'STR' ? 'selected' : '' }}>STR</option>
                        <option value="AL" {{ $data_edit->perusahaan == 'AL' ? 'selected' : '' }}>AL</option>
                        <option value="VRC" {{ $data_edit->perusahaan == 'VRC' ? 'selected' : '' }}>VRC</option>
                        <option value="NP" {{ $data_edit->perusahaan == 'NP' ? 'selected' : '' }}>NP</option>
                        <option value="LAINNYA" {{ $data_edit->perusahaan == 'LAINNYA' ? 'selected' : '' }}>LAINNYA</option>
                    </select>
              </div>
          </div>
      <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Nama Pekerjaan*</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('name', null, ['class' => 'form-control'] ) !!} --}}
                <input type="text" name="name" class="form-control" value="{{ old('name', $data_edit->name) }}" />
              </div>
          </div>
          <!-- <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Judul Aplikasi</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('label', null, ['class' => 'form-control'] ) !!} --}}
              </div>
          </div> -->
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Instansi*</label>
              <div class="col-sm-8">
                {{-- {{ Form::select('instansi_id', $instansi, null, ['class' => 'form-control select2']) }} --}}
                <select name="instansi_id" class="form-control select2">
                  <option value="" selected>-- Pilih Instansi --</option>
                  @foreach($instansi as $id => $name)
                      <option value="{{ $id }}" {{ (old('instansi_id', $data_edit->instansi_id) == $id) ? 'selected' : '' }}>{{ $name }}</option>
                  @endforeach
                </select>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Jenis Pekerjaan*</label>
              <div class="col-sm-8">
                {{-- {{ Form::select('type_project_id', $type, null, ['class' => 'form-control select2']) }} --}}
                <select name="type_project_id" class="form-control select2">
                  <option value="" selected>-- Pilih Jenis Pekerjaan --</option>
                  @foreach($type as $id => $name)
                      <option value="{{ $id }}" {{ (old('type_project_id', $data_edit->type_project_id) == $id) ? 'selected' : '' }}>{{ $name }}</option>
                  @endforeach
                </select>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Nominal Pekerjaan</label>
              <div class="col-sm-4">
              {{-- {!! Form::text('nominal', null, ['class' => 'form-control rupiah'] ) !!} --}}
                <input type="text" name="nominal" class="form-control rupiah" value="{{ old('nominal', $data_edit->nominal) }}" />
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Tanggal Mulai Pekerjaan  (SPK)*</label>
              <div class="col-sm-4">
                {{-- {!! Form::date('start', null, ['class' => 'form-control'] ) !!} --}}
                <input type="date" name="start" class="form-control" value="{{ old('start', $data_edit->start) }}" />
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Tanggal Selesai Pekerjaan*</label>
              <div class="col-sm-4">
                {{-- {!! Form::date('end', null, ['class' => 'form-control'] ) !!} --}}
                <input type="date" name="end" class="form-control" value="{{ old('end', $data_edit->end) }}" />
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Waktu Pekerjaan*</label>
              <div class="col-sm-2">
                {{-- {!! Form::number('time', null, ['class' => 'form-control'] ) !!} --}}
                <input type="number" name="time" class="form-control" value="{{ old('time', $data_edit->time) }}" />
              </div>
              <div class="col-sm-3">
                    {{-- {{ Form::select('time_type', ['Hari Kalender'=>'Hari Kalender','Hari Kerja'=>'Hari Kerja','Bulan'=>'Bulan','Kunjungan'=>'Kunjungan'], null, ['class' => 'form-control']) }} --}}
                    <select name="time_type" class="form-control">
                        <option value="Hari Kalender" {{ (old('time_type', $data_edit->time_type) == 'Hari Kalender') ? 'selected' : '' }}>Hari Kalender</option>
                        <option value="Hari Kerja" {{ (old('time_type', $data_edit->time_type) == 'Hari Kerja') ? 'selected' : '' }}>Hari Kerja</option>
                        <option value="Bulan" {{ (old('time_type', $data_edit->time_type) == 'Bulan') ? 'selected' : '' }}>Bulan</option>
                        <option value="Kunjungan" {{ (old('time_type', $data_edit->time_type) == 'Kunjungan') ? 'selected' : '' }}>Kunjungan</option>
                    </select>
                </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Progress Pekerjaan*</label>
            <div class="col-sm-3">
                  <div class="input-group">
                    {{-- {!! Form::number('progress', null, ['class' => 'form-control'] ) !!} --}}
                    <input type="number" name="progress" class="form-control" value="{{ old('progress', $data_edit->progress) }}" />
                      <div class="input-group-append"><span class="input-group-text">%</span></div>
                  </div>
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Catatan</label>
              <div class="col-sm-8">
                {{-- {!! Form::text('catatan', null, ['class' => 'form-control'] ) !!} --}}
                <input type="text" name="catatan" class="form-control" value="{{ old('catatan', $data_edit->catatan) }}" />
              </div>
          </div>
          <div class="position-relative row form-group">
            <label class="col-sm-3 col-form-label">Marketing & Penanggung Jawab</label>
              <div class="col-sm-8">
                {{-- {{ Form::select('marketing_id', $user, null, ['class' => 'form-control select2','placeholder'=>'-- Pilih Marketing & Penanggung Jawab --']) }} --}}
                <select name="marketing_id" class="form-control select2">
                  <option value="" selected>-- Pilih Marketing & Penanggung Jawab --</option>
                  @foreach($user as $id => $name)
                    <option value="{{ $id }}" {{ $data_edit->marketing_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                  @endforeach
                </select>
              </div>
          </div>

          <div class="position-relative row form-check">
              <div class="col-sm-10 offset-sm-2">
                  <a href="{{ URL::previous() }}" class="btn-shadow mr-3 btn btn-primary">Kembali</a>
                  {{-- {!! Form::button('Simpan', ['class' => 'btn btn-secondary simpan', 'type' => 'submit', 'data-swa-text' => 'Merubah Pekerjaan']) !!} --}}
                    <button class="btn btn-secondary simpan" type="submit" data-swa-text="Merubah Pekerjaan">Simpan</button>
              </div>
          </div>
      {{-- {!! Form::close() !!} --}}
       </form>
  </div>
</div>
@endsection
