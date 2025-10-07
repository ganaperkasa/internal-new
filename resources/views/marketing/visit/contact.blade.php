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
          <div>Daftar Kontak Pelanggan
            
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
        
    </div>
    <div class="card-body">
      <table class="table table-hover table-striped table-bordered" id="table1">
        <thead>
          <tr>
            <th> Instansi </th>
            <th> Nama </th>
            <th> Telp 1 </th>
            <th> Telp 2 </th>
            <th> Jabatan </th>
            <th> Aksi </th>
          </tr>
        </thead>
        <tfoot>
            <tr>
              <th class="">Instansi</th>
              <th class="">Nama</th>
              <th class="">Telp 1</th>
              <th class="">Telp 2</th>
              <th class="">Jabatan</th>
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
            ajax: '{!! url('marketing/visit/contact') !!}',
            columns: [
              {data: 'instansi', name: 'instansi'},
              {data: 'nama', name: 'nama'},
              {data: 'telp_1', name: 'telp_1'},
              {data: 'telp_2', name: 'telp_2'},
              {data: 'jabatan', name: 'jabatan'},
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

            }
        });
    });
</script>

@endpush
