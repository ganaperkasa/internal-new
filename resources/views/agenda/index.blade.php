@extends('layouts.backend')

@push('custom-css')

@endpush

@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
      <div class="page-title-heading">
          <div class="page-title-icon">
              <i class="pe-7s-note2 icon-gradient bg-night-fade">
              </i>
          </div>
          <div>Laporan Harian
            
          </div>
      </div>
    </div>
</div>
<div class="main-card mb-3 card">
    <div class="card-header-tab card-header">
        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
            <i class="header-icon lnr-charts icon-gradient bg-happy-green"> </i>
            Data
        </div>
        <div class="btn-actions-pane-right text-capitalize">
            <a href="{{ url('daily/create') }}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm">Tambah</a>
        </div>
    </div>
    <div class="card-body">
      <table class="table table-hover table-striped table-bordered" id="table1">
        <thead>
          <tr>
            <!-- <th> Judul </th> -->
            <th> Tanggal </th>
            <th> Jam Mulai </th>
            <th> Jam Akhir </th>
            
            <th> Aktifitas </th>
            <th> Tempat </th>
            <th> Aksi </th>
          </tr>
        </thead>
        <tfoot>
            <tr>
              <!-- <th class="">Judul</th> -->
              <th class="">Tanggal</th>
              <th class="">Jam Mulai</th>
              <th class="">Jam Akhir</th>
              
              <th class="">Aktifitas</th>
              <th class="">Tempat</th>
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
            "order": [[ 0, "desc" ]],
            ajax: '{!! url('daily') !!}',
            columns: [
              // {data: 'judul', name: 'judul'},
              {data: 'tanggal', name: 'tanggal'},
              {data: 'jam1', name: 'jam1'},
              {data: 'jam2', name: 'jam2'},
              
              {data: 'perihal', name: 'perihal'},
              {data: 'tempat', name: 'tempat'},
              
                {data: 'action', name: 'action', sClass: 'text-center', orderable: false, searchable: false}
            ],
            initComplete: function () {
                this.api().columns().every(function (index) {
                    var column = this;
                    var colCount = this.columns().nodes().length - 1;
                    if(index !== colCount){
                        var input = document.createElement("input");
                        $(input).addClass('form-control');
                        // if(index == 1)
                        // {
                        //     $(input).attr('type', 'date');
                        // }
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
