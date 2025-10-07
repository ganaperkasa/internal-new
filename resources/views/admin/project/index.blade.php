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
          <div>Pekerjaan
            
          </div>
      </div>
    </div>
</div>
<div class="main-card mb-3 card">
    <div class="card-header-tab card-header">
        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
            <i class="header-icon lnr-charts icon-gradient bg-happy-green"> </i>
            
            
        </div>
        <div class="btn-actions-pane-right text-capitalize">
            
            <a href="{{ url('admin/project/create') }}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm">Tambah</a>
        </div>
    </div>
    <div class="card-body">
      <table class="table table-hover table-striped table-bordered" id="table1">
        <thead>
          <tr>
            <th> Pekerjaan </th>
            <th> Instansi </th>
            <th> Tanggal Mulai  (SPK)</th>
            <th> Tanggal Selesai </th>
            <th> Waktu Pekerjaan </th>
            <th> Progress </th>
            <th> Marketing & Penanggung Jawab </th>
            <th> Perusahaan </th>
            <th> Aksi </th>
          </tr>
        </thead>
        <tfoot>
            <tr>
                <th class="">Pekerjaan</th>
                <th class="">Instansi</th>
                <th class="">Tanggal Mulai (SPK)</th>
                <th class="">Tanggal Selesai</th>
                <th class="">Waktu Pekerjaan</th>
                <th class="">Progress</th>
                <th class="">Marketing & Penanggung Jawab</th>
                <th class="">Perusahaan</th>
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
        oTable =  $("#table1").DataTable({
            processing: true,
            serverSide: true,
            // "order": [[ 4, "desc" ],[ 1, "desc" ]],
            "order": [[ 1, "desc" ]],
            "iDisplayLength": 50,
            ajax: '{!! url('admin/project') !!}',
            columns: [
                {data: 'name', name: 'name'},
                {data: 'instansi', name: 'instansi'},
                {data: 'start', name: 'start'},
                {data: 'end', name: 'end'},
                {data: 'time', name: 'time'},
                {data: 'progress', name: 'progress'},
                {data: 'marketing', name: 'marketing'},
                {data: 'perusahaan', name: 'perusahaan'},
                {data: 'action', name: 'action', sClass: 'text-center', orderable: false, searchable: false}
            ],
            initComplete: function () {
                this.api().columns().every(function (index) {
                    var column = this;
                    var colCount = this.columns().nodes().length - 1;
                    if(index !== colCount){
                        var input = document.createElement("input");
                        $(input).addClass('form-control');
                        if(index == 3 || index == 2)
                        {
                            $(input).attr('type', 'date');
                        }
                        $(input).appendTo($(column.footer()).empty())
                        .on('change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });

                    }

                });
                SweetAlert2Plugin.init();
            },
            drawCallback: function( settings ) {
              SweetAlert2Plugin.init();
            }
        });

        
    });
</script>

@endpush
