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
          <div>Permohonan Aplikasi
            <div class="page-title-subheading">Form yang digunakan untuk melakukan pengajuan Aplikasi Baru</div>
          </div>
      </div>
    </div>
</div>
<div class="main-card mb-3 card">
    {!! Form::open(['url' => url('permohonan/step2'),'method'=>'POST','enctype' => 'multipart/form-data']) !!}
    <div class="card-body">
        <div  class="forms-wizard-vertical sw-main sw-theme-default">
            <ul class="forms-wizard nav nav-tabs step-anchor">
                <li class="nav-item">
                    <a href="#step-122" class="nav-link">
                        <em>1</em><span>Informasi Aplikasi</span>
                    </a>
                </li>
                <li class="nav-item active">
                    <a href="#step-222" class="nav-link">
                        <em>2</em><span>Dokumen Aplikasi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#step-322" class="nav-link">
                        <em>3</em><span>File Pendukung</span>
                    </a>
                </li>
            </ul>

            <div class="form-wizard-content sw-container tab-content" style="min-height: 698px;">

                <div id="step-222" class="tab-pane step-content" style="display: block;">
                    <div id="accordion" class="accordion-wrapper mb-3">
                        <div class="card">
                            <div id="headingTwo" class="b-radius-0 card-header">
                                <button type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" class="text-left m-0 p-0 btn btn-link btn-block">
                                    <span class="form-heading">Dokumen Aplikasi<p>Form yang harus diisi tentang Aplikasi yang akan diajukan</p></span>
                                </button>
                            </div>
                            <div data-parent="#accordion" id="collapseTwo" class="collapse show">
                                <div class="card-body">
                                  @if ($errors->any())
                                      <div class="alert alert-dark">
                                          <b>Terdapat beberapa kesalahan. Silahkan diperbaiki.</b><br>
                                          @foreach ($errors->all() as $error)
                                              <li>{{ $error }}</li>
                                          @endforeach
                                      </div>
                                  @endif
                                    <div class="form-row">
                                        <div class="col-md-6">
                                          <div class="position-relative form-group">
                                            <label class="badge badge-pill badge-success" >Paket Pekerjaan</label>
                                            <p class="form-control-plaintext">{{ $data->paket_pekerjaan }}</p>
                                            <input type="hidden" name="id" value="{{ $data->id }}">
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="position-relative form-group">
                                            <label class="badge badge-pill badge-success" >Kegiatan</label>
                                            <p class="form-control-plaintext">{{ $data->kegiatan }}</p>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                          <div class="position-relative form-group">
                                            <label class="badge badge-pill badge-success">Jenis Pekerjaan</label>
                                            <p class="form-control-plaintext">{{ jenisPekerjaan($data->jenis_pekerjaan) }}</p>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="position-relative form-group">
                                            <label  class="badge badge-pill badge-success">Anggaran</label>
                                            <p class="form-control-plaintext">{{ toRp($data->anggaran) }}</p>
                                          </div>
                                        </div>
                                    </div>
                                    <hr>
                                    @foreach($document_type as $value)
                                      <div class="position-relative form-group">
                                        <label><b>{{ $value->name }}</b> </label>
                                        {!! Form::textarea('deskripsi[]', null, ['class' => 'form-control'] ) !!}
                                        <input type="hidden" name="document[]" value="{{ $value->id }}">
                                        <input type="hidden" name="labelDocument[]" value="{{ $value->name }}">
                                        *{{ $value->step }}
                                      </div>
                                      <hr>
                                    @endforeach



                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="divider"></div>
        <div class="clearfix">
          <button type="button" id="reset-btn" class="btn-shadow float-left btn btn-danger">Batal</button>
          <!-- <button type="button" id="next-btn22" class="btn-shadow btn-wide float-right btn-pill btn-hover-shine btn btn-primary">Sebelumnya</button> -->
          {!! Form::button('Selanjutnya', ['class' => 'btn-shadow float-right btn-wide btn-pill mr-3 btn btn-outline-secondary simpan', 'type' => 'submit', 'data-swa-text' => 'Melanjutkan Permohonan']) !!}
        </div>

    </div>
    {!! Form::close() !!}
</div>
@endsection



@push('custom-scripts')

<script src="{{url('assets/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{url('assets/laravel-ckeditor/adapters/jquery.js') }}"></script>
<script>
    $('textarea').ckeditor();
    // $('.textarea').ckeditor(); // if class is prefered.
</script>
<script>
$( "#reset-btn" ).click(function() {
  swal({
      title: "Apakah anda yakin?",
      text: "Membatalkan Permohonan",
      type: "warning",
      showCancelButton: true
  }).then(function() {
      location.href = "{{url('permohonan/batal?kd='.$data->id)}}";
      // form.submit();
  }).catch(swal.noop);
});
</script>

@endpush
