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
  {!! Form::open(['url' => url('permohonan/step3'),'method'=>'POST','enctype' => 'multipart/form-data']) !!}
    <div class="card-body">
        <div  class="forms-wizard-vertical sw-main sw-theme-default">
            <ul class="forms-wizard nav nav-tabs step-anchor">
                <li class="nav-item">
                    <a href="#step-122" class="nav-link">
                        <em>1</em><span>Informasi Aplikasi</span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="#step-222" class="nav-link">
                        <em>2</em><span>Dokumen Aplikasi</span>
                    </a>
                </li>
                <li class="nav-item active">
                    <a href="#step-322" class="nav-link">
                        <em>3</em><span>File Pendukung</span>
                    </a>
                </li>
            </ul>
            <div class="form-wizard-content sw-container tab-content" style="min-height: 698px;">


                <div id="step-322" class="tab-pane step-content" style="display: block;">
                  <div id="accordion" class="accordion-wrapper mb-3">
                      <div class="card">
                          <div id="headingTwo" class="b-radius-0 card-header">
                              <button type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" class="text-left m-0 p-0 btn btn-link btn-block">
                                  <span class="form-heading">File Pendukung<p>File yang harus diupload tentang Aplikasi yang akan diajukan</p></span>
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
                                        <input type="hidden" name="status" id="status">
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
                                @foreach($arsip as $value)

                                  <div class="form-row">
                                      <div class="col-md-6">
                                        <div class="position-relative form-group">
                                          <label ><b>File</b> {{ $value->name }}</label>
                                          <input name="file[]" type="file" class="form-control-file">
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="position-relative form-group">
                                          <label ><b>Link</b> {{ $value->name }}</label>
                                          {!! Form::text('link[]', null, ['class' => 'form-control'] ) !!}
                                        </div>
                                      </div>
                                  </div>
                                  <div class="position-relative form-group">
                                    <label><b>Keterangan</b> {{ $value->name }}</label>
                                    {!! Form::text('keterangan[]', null, ['class' => 'form-control'] ) !!}
                                    <input type="hidden" name="arsip[]" value="{{ $value->id }}">
                                    <input type="hidden" name="labelArsip[]" value="{{ $value->name }}">
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
            
            {!! Form::button('Mengirim Permohonan', ['class' => 'btn-shadow float-right btn-wide btn-pill mr-3 btn btn-primary simpanProject', 'type' => 'submit', 'data-swa-text' => 'Mengirim Permohonan', 'data-status' => '1']) !!}
            {!! Form::button('Simpan sebagai Draft', ['class' => 'btn-shadow float-right btn-wide btn-pill mr-3  btn-outline-secondary btn simpanProject', 'type' => 'submit', 'data-swa-text' => 'Simpan Sebagai Draft', 'data-status' => '3']) !!}
        </div>
    </div>
  {!! Form::close() !!}
</div>
@endsection


@push('custom-scripts')
<script src="{{url('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/scripts/inputmask-global.js')}}" type="text/javascript"></script>
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

$("button:submit.simpanProject").on("click", function(e){
  e.preventDefault();
      var form = $(this).parents('form');
      var status = $(this).data('status');
      $("#status").val(status);
      swal({
          title: "Apakah anda yakin?",
          text: $(this).data("swa-text"),
          type: "warning",
          showCancelButton: true
      }).then(function() {

          form.submit();
      }).catch(swal.noop);
});
</script>
@endpush
