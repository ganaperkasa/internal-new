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
          <div>Master User
            <div class="page-title-subheading">Daftar user akses aplikasi</div>
          </div>
      </div>
      <div class="page-title-actions">
        <a href="{{ url('master/user/create') }}" class="btn-shadow d-inline-flex align-items-center btn btn-success"><i class="fa fa-plus"></i> Tambah</a>
      </div>
    </div>
</div>
<div class="main-card mb-3 card">
    <div class="card-body">
      <table class="table table-hover table-striped table-bordered" id="table1">
        <thead>
          <tr>
            <th> Email </th>
            <th> Nama </th>
            <th> Level </th>
            <th> Jabatan </th>
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
        $("#table1").DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! url('master/user') !!}',
            columns: [
              {data: 'email', name: 'email'},
              {data: 'name', name: 'name'},
              {data: 'role', name: 'role'},
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

                SweetAlert2Plugin.init();
            },
            drawCallback: function( settings ) {
              SweetAlert2Plugin.init();
            }
        });
    });
</script>

@endpush
