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
                <div>Daftar Data Master Divisi
                    <div class="page-title-subheading">Daftar Data Master Divisi</div>
                </div>
            </div>
            <div class="page-title-actions">
                <a href="{{ route('divisi.create') }}"
                    class="btn-shadow d-inline-flex align-items-center btn btn-success"><i
                        class="fa fa-plus"></i> Tambah</a>
            </div>
        </div>
    </div>
    {{-- <div class="main-card mb-3 card">
        <div class="card-body">
            <form action="#" method="get">
                <div class="row">
                    <div class="col-4 form-group">
                        <label for="exampleFormControlInput1">Nama cuti</label>
                        <input type="text" name="nama" class="form-control" id="exampleFormControlInput1" placeholder="Nama cuti">
                    </div>
                    <div class="col-4 form-group">
                        <label for="exampleFormControlInput1">Tanggal Awal</label>
                        <input type="date" class="form-control" name="start_date" id="exampleFormControlInput1"
                            placeholder="Tanggal Awal cuti">
                    </div>
                    <div class="col-4 form-group">
                        <label for="exampleFormControlInput1">Tanggal Akhir</label>
                        <input type="date" class="form-control" name="end_date" id="exampleFormControlInput1"
                            placeholder="Tanggal Akhir cuti">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div> --}}
    <div class="main-card mb-3 card">
        <div class="card-body">
            <table class="table table-hover table-striped table-bordered" id="tablex">
                <thead>
                    <tr>
                        <th> Id cuti</th>
                        <th> Nama </th>
                        <th> Aksi </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($divisi as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                {{-- <a href="{{ url('divisi.edit', $item->id) }}" class="btn btn-primary mb-2">Edit</a> --}}
                                {{-- <button type="button" class="btn btn-secondary mb-2"
                                    onclick="deleteData({{ $item->id }})">Hapus
                                </button> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- {{ route('edit', ['id' => $item->id]) }}  --}}
@endsection



@push('custom-scripts')
    <script type="text/javascript" src="{{ url('/assets/datatables/jquery.dataTables.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ url('/assets/datatables/jquery.dataTables.css') }}" />

    <script type="text/javascript">
        $('#tablex').DataTable({
            "iDisplayLength": 10
        });
    </script>
    <script>
        function deleteData(id) {
            swal({
                title: "Delete?",
                text: "Please ensure and then confirm!",
                showCancelButton: !0,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: !0
            }).then(function(e) {

                if (e === true) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        type: 'DELETE',
                        url: "{{ url('master/divisi') }}/" + id,
                        data: {
                            _token: CSRF_TOKEN,
                            id: id
                        },
                        dataType: 'JSON',
                        success: function(results) {
                            console.log(results)

                            if (results.success === true) {
                                swal(
                                    'Deleted!',
                                    results.message,
                                    'success'
                                )
                                // refresh page after 2 seconds
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            } else {
                                swal("Error!", results.message, "error");
                            }
                        }
                    });

                } else {
                    console.log('b');
                    e.dismiss;
                }

            }, function(dismiss) {
                return false;
            });
        }
    </script>
@endpush
