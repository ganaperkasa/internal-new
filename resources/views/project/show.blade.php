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
          <div>{{ $data->paket_pekerjaan }}
            <div class="page-title-subheading">{{ $perangkatdaerah->name }} 
              <br>
              @if($data->status == 1)
              <!-- <label class="badge badge-pill badge-primary" >Permohonan</label> -->
              <div class="mb-3 progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="25" style="width: 25%;">Permohonan - 25%</div>
                </div>
              @elseif($data->status == 2)
              <!-- <label class="badge badge-pill badge-info" >Kelengkapan</label> -->
              <div class="mb-3 progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="50" style="width: 50%;">Kelengkapan - 75%</div>
                </div>
              @elseif($data->status == 4)
              <!-- <label class="badge badge-pill badge-primary" >Dokumen Lengkap</label> -->
                <div class="mb-3 progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">Dokumen Lengkap - 100%</div>
                </div>
              @else
              <label class="badge badge-pill badge-primary" >Draft</label>
           
              @endif
            </div>

          </div>
      </div>
      <div class="page-title-actions">

      </div>
    </div>
</div>

<ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
    <li class="nav-item">
        <a role="tab" class="nav-link show active" id="tab-0" data-toggle="tab" href="#tab-content-0" aria-selected="true">
            <span>Informasi Aplikasi</span>
        </a>
    </li>
    <li class="nav-item">
        <a role="tab" class="nav-link show" id="tab-1" data-toggle="tab" href="#tab-content-1" aria-selected="false">
            <span>Dokumen Aplikasi</span>
        </a>
    </li>
    <li class="nav-item">
        <a role="tab" class="nav-link show" id="tab-2" data-toggle="tab" href="#tab-content-2" aria-selected="false">
            <span>File Pendukung</span>
        </a>
    </li>
    <!-- <li class="nav-item">
        <a role="tab" class="nav-link show" id="tab-4" data-toggle="tab" href="#tab-content-4" aria-selected="false">
            <span>Forum</span>
        </a>
    </li> -->
    <li class="nav-item">
        <a role="tab" class="nav-link show" id="tab-3" data-toggle="tab" href="#tab-content-3" aria-selected="false">
            <span>Riwayat</span>
        </a>
    </li>
    <li class="nav-item">
        <a role="tab" class="nav-link show" id="tab-5" data-toggle="tab" href="#tab-content-5" aria-selected="false">
            <span>Cetak</span>
        </a>
    </li>

</ul>

<div class="tab-content">
    <div class="tab-pane tabs-animation fade active show" id="tab-content-0" role="tabpanel">
        <div class="main-card mb-3 card">
            
            <div class="card-body">

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
              <div class="form-row">
                  <div class="col-md-6">
                    <div class="position-relative form-group">
                      <label class="badge badge-pill badge-success">Jangka Waktu</label>
                      <p class="form-control-plaintext">{{ $data->jangka_waktu }} Hari</p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="position-relative form-group">
                      <label  class="badge badge-pill badge-success">Tanggal Mulai Pekerjaan</label>
                      <p class="form-control-plaintext">{{ tglIndo($data->tanggal_mulai) }}</p>
                    </div>
                  </div>
              </div>
              <div class="form-row">
                  <div class="col-md-6">
                    <div class="position-relative form-group">
                      <label class="badge badge-pill badge-success">Kategori Aplikasi</label>
                      <p class="form-control-plaintext">{{ $kategori->name }}</p>
                    </div>
                  </div>
                  
              </div>
              @if($data->status == 3)
                {!! Form::open(['url' => url('draft/lanjutkan'),'enctype' => 'multipart/form-data']) !!}
                    <input type="hidden" name="kode" value="{{ $data->id }}">
                    {!! Form::button('Lanjutkan Sebagai Permohonan', ['class' => 'btn btn-secondary simpan', 'type' => 'submit', 'data-swa-text' => 'Lanjutkan Sebagai Permohonan']) !!}
                    <a href="{{ url('project/ubah/'.$data->id.'') }}" class="btn btn-primary" style="color:#FFF">Ubah Informasi Aplikasi</a>
                    
                {!! Form::close() !!}
              @endif
                @if($data->status == 1)
                    <a href="{{ url('project/ubah/'.$data->id.'') }}" class="btn btn-primary" style="color:#FFF">Ubah Informasi Aplikasi</a>
                @endif
            </div>
        </div>

    </div>
    <div class="tab-pane tabs-animation fade" id="tab-content-1" role="tabpanel">
        <div class="main-card mb-3 card">
            <div class="card-body">
              <ul class="list-group list-group-flush">
                  @foreach($document as $value)
                  <li class="list-group-item">
                      <div class="widget-content p-0">
                          <div class="widget-content-wrapper">
                              <div class="widget-content-left">
                                  <h3>{{ $value->label_document }} </h3>
                              </div>
                              <div class="widget-content-right">

                                  @if($value->konfirmasi != 1)
                                  <div class="d-inline-block dropdown">
                                      <div class="dropdown d-inline-block">
                                          <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="dropdown-toggle btn btn-focus">Aksi</button>
                                          <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu">
                                            @if(\Auth::user()->role_id == 3)
                                              <a href="{{ url('project/'.$value->id.'/edit?type=dokumen') }}" class="dropdown-item" >  Ubah</a>
                                              @else
                                              <button type="button" tabindex="0" class="dropdown-item konfirmasiData" data-swa-text="Konfirmasi {{ $value->label_document }}" data-swa-label="{{ $value->label_document }}" data-swa-kode="{{ $value->id }}" data-swa-type="dokumen">Konfirmasi</button>
                                              <a href="{{ url('project/revisi?kd='.$value->id.'&type=dokumen'.'&label='.$value->label_document) }}" class="dropdown-item" >  Revisi</a>
                                              @endif
                                          </div>
                                      </div>
                                  </div>
                                  @endif
                                  {!! statusForm($value->konfirmasi) !!}
                              </div>
                          </div>
                      </div>
                      {!! $value->deskripsi !!}
                  </li>
                  @endforeach
              </ul>

            </div>
        </div>
    </div>
    <div class="tab-pane tabs-animation fade" id="tab-content-2" role="tabpanel">
        <div class="main-card mb-3 card">
            <div class="card-body">
              <ul class="list-group list-group-flush">
                  @foreach($arsip as $value)
                  <li class="list-group-item">
                      <div class="widget-content p-0">
                          <div class="widget-content-wrapper">
                              <div class="widget-content-left">
                                  <h5>{{ $value->label_arsip }} </h5>
                              </div>
                              <div class="widget-content-right">

                                  @if($value->konfirmasi != 1)
                                  <div class="d-inline-block dropdown">
                                      <div class="dropdown d-inline-block">
                                          <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="dropdown-toggle btn btn-focus">Aksi</button>
                                          <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu">
                                              
                                              @if(\Auth::user()->role_id == 3)
                                              
                                              <a href="{{ url('project/'.$value->id.'/edit?type=arsip') }}" class="dropdown-item" >  Ubah</a>
                                              @else
                                              <button type="button" tabindex="0" class="dropdown-item konfirmasiData" data-swa-text="Konfirmasi {{ $value->label_arsip }}" data-swa-label="{{ $value->label_arsip }}" data-swa-kode="{{ $value->id }}" data-swa-type="arsip">Konfirmasi</button>
                                              <a href="{{ url('project/revisi?kd='.$value->id.'&type=arsip') }}" class="dropdown-item" >  Revisi</a>
                                              @endif
                                          </div>
                                      </div>
                                  </div>
                                  @endif
                                  {!! statusForm($value->konfirmasi) !!}
                              </div>
                          </div>
                      </div>
                      
                      {{ $value->link }}
                      <br>{{ $value->deskripsi }}
                      <br>
                      @if($value->file != null)
                      <a href="{{ url('download/'.$value->id) }}" class="btn btn-primary">Download {{ $value->label_arsip }}</a>
                      @endif
                  </li>
                  @endforeach
              </ul>

            </div>
        </div>
    </div>
    <div class="tab-pane tabs-animation fade" id="tab-content-3" role="tabpanel">
        <div class="main-card mb-3 card">
            <div class="card-body">
              <div class="vertical-without-time vertical-timeline vertical-timeline--animate vertical-timeline--one-column">


                  @foreach($log as $value)
                  <div class="vertical-timeline-item vertical-timeline-element">
                      <div><span class="vertical-timeline-element-icon bounce-in">
                        <i class="badge badge-dot badge-dot-xl {{ warnaLog($value->type) }}"> </i></span>
                          <div class="vertical-timeline-element-content bounce-in"><p>{{ $value->petugas }}, <b class="text-danger">{{ tglWaktuIndo($value->created_at) }}</b></p>
                              <p>{{ $value->massage }}</p></div>
                      </div>
                  </div>
                  @endforeach
              </div>
            </div>
        </div>
    </div>
    <div class="tab-pane tabs-animation fade" id="tab-content-4" role="tabpanel">

    </div>

    <div class="tab-pane tabs-animation fade" id="tab-content-5" role="tabpanel">
        <div class="main-card mb-3 card">
            <div class="card-body">

                <a href="{{ url('report/dokumen/'.$data->id.'') }}" class="btn btn-primary" style="color:#FFF" target="_blank">Cetak Jenis Dokumen</a>
                <!-- <a href="{{ url('report/file/'.$data->id.'') }}" class="btn btn-primary" style="color:#FFF">Export Word - File Pendukung</a> -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-lg-6">
            <div class="card-hover-shadow-2x mb-3 card">
                <div class="card-header-tab card-header">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal">Forum</div>
                
                </div>
                <div class="scroll-area-lg">
                    <div class="scrollbar-container ps ps--active-y" id="divScroll">
                        <div class="p-2">
                            <div class="chat-wrapper p-1">
                                <div id="listChat"></div>
                            </div>
                        </div>
                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 400px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 240px;"></div></div></div>
                </div>
                <div class="card-footer">
                    <input placeholder="Write here and hit enter to send..." type="text" class="form-control-sm form-control" id="sendChat">
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-6">
            <div class="card no-shadow bg-transparent no-border rm-borders mb-12">
                    <div class="card">
                        <div class="no-gutters row">
                            <div class="col-md-12 col-lg-12">
                                <ul class="list-group list-group-flush">
                                    <li class="bg-transparent list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-outer">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Dokumen Aplikasi</div>
                                                        <div class="widget-subheading">Total Sudah Konfirmasi</div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="widget-numbers text-success">{{ $totalDokumenStatus1 }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="bg-transparent list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-outer">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Dokumen Aplikasi</div>
                                                        <div class="widget-subheading">Total Revisi</div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="widget-numbers text-warning">{{ $totalDokumenStatus2 }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="bg-transparent list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-outer">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Dokumen Aplikasi</div>
                                                        <div class="widget-subheading">Total Belum Konfirmasi</div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="widget-numbers text-danger">{{ $totalDokumenStatus0 }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                
            </div>
            <br>
            <div class="card no-shadow bg-transparent no-border rm-borders mb-12">
                    <div class="card">
                        <div class="no-gutters row">
                            <div class="col-md-12 col-lg-12">
                                <ul class="list-group list-group-flush">
                                    <li class="bg-transparent list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-outer">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">File Pendukung Aplikasi</div>
                                                        <div class="widget-subheading">Total Sudah Konfirmasi</div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="widget-numbers text-success">{{ $totalArsipStatus1 }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="bg-transparent list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-outer">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">File Pendukung Aplikasi</div>
                                                        <div class="widget-subheading">Total Revisi</div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="widget-numbers text-warning">{{ $totalArsipStatus2 }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="bg-transparent list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-outer">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">File Pendukung Aplikasi</div>
                                                        <div class="widget-subheading">Total Belum Konfirmasi</div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="widget-numbers text-danger">{{ $totalArsipStatus0 }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                
            </div>
        </div>
    </div>
    
    
    
</div>

@endsection



@push('custom-scripts')
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$( ".konfirmasiData" ).click(function() {
  var kode = $(this).data("swa-kode");
  var type = $(this).data("swa-type");
  var label = $(this).data("swa-label");
  swal({
      title: "Apakah anda yakin?",
      text: $(this).data("swa-text"),
      type: "warning",
      showCancelButton: true
  }).then(function() {
      location.href = "{{url('project/konfirmasi?kd=')}}"+kode+"&type="+type+"&label="+label;
  }).catch(swal.noop);
});


$('#sendChat').on('keypress', function (e) {
    if(e.which === 13){

        var message = $(this).val();
        var project = "{{$data->id}}";
        $.ajax({
    		type: "POST",
    		url: "{{ url('chat/send') }}",
            data:{message:message, project:project},
    		dataType: "html",
    		success:function(data){
                $("#sendChat").val("");
                getDetailChat();
                var objDiv = document.getElementById("listChat");
                objDiv.scrollTop = objDiv.scrollHeight;
                $('#divScroll').animate({
                    scrollTop: $('#divScroll').get(0).scrollHeight
                }, 1500);
    		},
    		error: function(xhr){
                $("#sendChat").val("");
    		}
    	});
       
    }
});

getDetailChat();

function getDetailChat(){
    var project = "{{$data->id}}";
    $.ajax({
        type: "get",
        url: "{{ url('chat/detail') }}?project="+project,
        dataType: "html",
        success:function(data){

            $("#listChat").html(data);
           
        },
        error: function(xhr){
            
        }
    });
}

$( "#tab-4" ).click(function() {
    
    var objDiv = document.getElementById("listChat");
    objDiv.scrollTop = objDiv.scrollHeight;

});
</script>
@endpush
