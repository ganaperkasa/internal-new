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
                <div>Daftar Data cuti
                    <div class="page-title-subheading">Daftar Data cuti</div>
                </div>
            </div>
            <div class="page-title-actions">
                <a href="{{ route('halaman.data') }}"
                    class="btn-shadow d-inline-flex align-items-center btn btn-warning"><i class="fa fa-magnifying-glass"></i> Data Cuti Terakhir</a>
                @if (Auth::user()->role_id == '1')
                    <a href="{{ route('cuti-bersama.create') }}"
                        class="btn-shadow d-inline-flex align-items-center btn btn-primary"><i class="fa fa-plus"></i>
                        Tambah Cuti Bersama</a>
                @endif
                <a href="{{ route('cuti.create') }}"
                    class="btn-shadow d-inline-flex align-items-center btn btn-success {{ Auth::user()->role_id != '1' && $jumlah != 0 ? 'disabled' : '' }}"><i
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
                        <th> Tanggal Buat</th>
                        <th> Nama cuti </th>
                        <th> Keterangan cuti </th>
                        <th> Jumlah Hari </th>
                        <th> Divisi</th>
                        <th> Status</th>
                        <th> Aksi </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ tglIndo($item->created_at) }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->keterangan }}</td>
                            <td>{{ $item->detail->count() }}</td>
                            <td>{{ $item->user->divisi->name }}</td>
                            <td>{{ statusCuti($item->status) }}</td>
                            <td>
                                @if (Auth::user()->role_id == 1)
                                    @if ($item->status != '0')
                                        <button type="button" class="btn btn-primary mb-2 disabled"><i
                                                class="fa fa-pencil"></i>Terima</button>
                                    @else
                                        <a href="{{ route('halaman.cuti', $item->id) }}"
                                            class="btn btn-primary mb-2">Terima</a>
                                    @endif
                                @endif
                                @if ($item->status != '0')
                                    <button type="button" class="btn btn-secondary mb-2 disabled">Hapus
                                    </button>
                                @else
                                    <button type="button" class="btn btn-secondary mb-2"
                                        onclick="deleteData({{ $item->id }})">Hapus
                                    </button>
                                @endif
                                @if ($item->status == '0')
                                    <a href="{{ route('halaman.print', $item->id) }}"
                                        class="btn btn-warning mb-2">Preview</a>
                                @else
                                    <a href="{{ route('halaman.preview', $item->id) }}"
                                        class="btn btn-warning mb-2">Preview</a>
                                @endif
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
            "iDisplayLength": 10,
            "ordering" : false,
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
                        url: "{{ url('cuti') }}/" + id,
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
