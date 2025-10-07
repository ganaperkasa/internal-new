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
          <div>Persetujuan Aplikasi
            <div class="page-title-subheading">Daftar Permohonan Aplikasi dari Perangkat Daerah</div>
          </div>
      </div>
    </div>
</div>
<div class="main-card mb-3 card">
    <div class="card-body">
      <table class="table table-hover table-striped table-bordered" id="table1">
        <thead>
          <tr>
            <th> Perangkat Daerah </th>
            <th> Paket Pekerjaan </th>
            <th> Kegiatan </th>
            <th> Jenis Pekerjaan </th>
            <th> Anggaran </th>
            <!-- <th class="none"> Jangka Waktu </th> -->
            <!-- <th class="none"> Mulai Kerja </th> -->
            <th> Aksi </th>
          </tr>
        </thead>
        <tfoot>
            <tr>
              <th class="">Perangkat Daerah</th>
              <th class="">Paket Pekerjaan</th>
              <th class="">Kegiatan</th>
              <th class="">Jenis Pekerjaan</th>
              <th class="">Anggaran</th>
              <!-- <th class="none">Jangka Waktu</th> -->
                <!-- <th class="none">Mulai Kerja</th> -->
                <th class="text-center" width="150">Aksi</th>
            </tr>
        </tfoot>
      </table>
    </div>
</div>
@endsection



@push('custom-scripts')
<script type="text/javascript" src="{{url('/assets/datatables/jquery.dataTables.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{url('/assets/datatables/jquery.dataTables.css') }}" />
<script type="text/javascript">
    $(document).ready(function(){
        $("#table1").DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! url('persetujuan') !!}',
            columns: [
              {data: 'perangkatdaerah', name: 'perangkatdaerah'},
              {data: 'paket_pekerjaan', name: 'paket_pekerjaan'},
              {data: 'kegiatan', name: 'kegiatan'},
              {data: 'jenis_pekerjaan', name: 'jenis_pekerjaan'},
              {data: 'anggaran', name: 'anggaran'},
              // {data: 'jangka_waktu', name: 'jangka_waktu'},
                // {data: 'tanggal_mulai', name: 'tanggal_mulai'},
                {data: 'action', name: 'action', sClass: 'text-center', orderable: false, searchable: false}
            ],
            initComplete: function () {
                this.api().columns().every(function (index) {
                    var column = this;
                    var colCount = this.columns().nodes().length - 1;
                    if(index !== colCount){
                        var input = document.createElement("input");
                        $(input).addClass('form-control');
                        // if(index == 5)
                        // {
                        //     $(input).attr('type', 'date');
                        // }
                        $(input).appendTo($(column.footer()).empty())
                        .on('change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });

                    }

                });

            }
        });
    });
</script>

@endpush
