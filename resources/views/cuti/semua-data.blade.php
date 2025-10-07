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
                <div>Data Cuti Terakhir
                    <div class="page-title-subheading">Data Cuti Terakhir</div>
                </div>
            </div>
            <div class="page-title-actions">
                <a href="{{ route('cuti.index') }}"
                    class="btn-shadow d-inline-flex align-items-center btn btn-warning"><i
                        class="fa fa-undo"></i> Kembali</a>
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
                        <th> Divisi </th>
                        <th> Nama </th>
                        <th> Sisa </th>
                        <th> Cuti Di pakai </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user as $item)
                        @if ($item->cuti != null)
                            <tr>
                                <td>{{ $item->divisi->name }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->cuti[0]->sisa }}</td>
                                <td>{{ $item->cuti[0]->dipakai + $item->cuti[0]->detail->count() }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
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
@endpush