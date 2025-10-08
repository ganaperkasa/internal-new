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
          <div>Surat

          </div>
      </div>
    </div>
</div>
<div class="main-card mb-3 card">
    <div class="card-header-tab card-header">
        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
            <i class="header-icon lnr-charts icon-gradient bg-happy-green"> </i>


            <select id="myInputTextField" class="form-control">
                <option>--Pilih Perusahaan--</option>
                <option>SEP</option>
                <option>DIR</option>
                <option>MSK</option>
            </select>
        </div>
        <div class="btn-actions-pane-right text-capitalize">

            <a href="{{ url('admin/surat/create') }}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm">Tambah</a>
        </div>
    </div>
    <div class="card-body">
      <table class="table table-hover table-striped table-bordered" id="table1">
        <thead>
          <tr>
          <th> Perusahaan </th>
          <th> Tahun </th>
            <th> Nomor </th>
            <th> Instansi </th>
            <th> Perihal </th>
            <th> Tanggal </th>
            <th> Pembuat </th>
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
        oTable =  $("#table1").DataTable({
            processing: true,
            serverSide: true,
            //"order": [[ 4, "desc" ],[ 1, "desc" ]],
            "order": [[ 1, "desc" ],[ 2, "desc" ]],
            "iDisplayLength": 50,
            ajax: '{{ route('surat.index') }}',
            columns: [
                {data: 'type', name: 's.type'},
                {data: 'tahun', name: 'tahun'},
                {data: 'number', name: 's.number'},
                {data: 'instansi', name: 'i.name'},
                {data: 'perihal', name: 's.perihal'},
                {data: 'tanggal', name: 's.tanggal'},
                {data: 'created', name: 'u.name'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            initComplete: function () {
                this.api().columns().every(function (index) {
                    var column = this;
                    var colCount = this.columns().nodes().length - 1;
                    if(index !== colCount){
                        var input = document.createElement("input");
                        $(input).addClass('form-control');
                        if(index == 3)
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


        $( "#myInputTextField" ).change(function() {
            oTable.search($(this).val()).draw() ;
        });
    });
</script>

@endpush
