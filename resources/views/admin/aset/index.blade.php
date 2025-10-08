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
          <div>Aset

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
            <a href="{{ url('admin/aset/create') }}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm">Tambah</a>
        </div>
    </div>
    <div class="card-body">
      <table class="table table-hover table-striped table-bordered" id="table1">
        <thead>
          <tr>
            <th> Jenis Barang </th>
            <th> Nomor </th>
            <th> Merk Barang </th>
            <th> Spesifikasi </th>
            <th> Kondisi </th>
            <th> Aksi </th>
          </tr>
        </thead>
      </table>
    </div>
</div>
@endsection



@push('custom-scripts')
<script type="text/javascript" src="{{url('/assets/datatables/jquery.dataTables.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{url('/assets/datatables/jquery.dataTables.css') }}" />
<script type="text/javascript">
    $(document).ready(function(){
    var table = $("#table1").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{!! url('admin/aset') !!}',
            type: 'GET',
            error: function(xhr, error, code) {
                console.log('Ajax Error:', xhr.responseText);
                console.log('Status:', xhr.status);
                console.log('Error:', error);
                console.log('Code:', code);
                alert('Error: ' + xhr.responseText);
            }
        },
        order: [[ 4, "desc" ],[ 1, "desc" ]],
        columns: [
            {data: 'barang', name: 'i.name', defaultContent: '-'},
            {data: 'number', name: 's.number', defaultContent: '-'},
            {data: 'name', name: 's.name', defaultContent: '-'},
            {data: 'spesifikasi', name: 's.spesifikasi', defaultContent: '-'},
            {data: 'kondisi', name: 's.kondisi', defaultContent: '-'},
            {data: 'action', name: 'action', className: 'text-center', orderable: false, searchable: false}
        ],
        initComplete: function () {
            console.log('DataTable initialized');
            this.api().columns().every(function (index) {
                var column = this;
                var colCount = column.table().columns().nodes().length - 1;

                if(index !== colCount){
                    var input = document.createElement("input");
                    $(input).addClass('form-control');
                    $(input).appendTo($(column.footer()).empty())
                    .on('keyup change', function () {
                        if (column.search() !== this.value) {
                            column.search(this.value).draw();
                        }
                    });
                }
            });

            if(typeof SweetAlert2Plugin !== 'undefined') {
                SweetAlert2Plugin.init();
            }
        },
        drawCallback: function( settings ) {
            if(typeof SweetAlert2Plugin !== 'undefined') {
                SweetAlert2Plugin.init();
            }
        }
    });
});
</script>

@endpush
