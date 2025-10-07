@extends('layouts.backend')

@push('custom-css')
@endpush

@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-graph2 icon-gradient bg-night-fade">
                    </i>
                </div>
                <div>Beranda
                    <div class="page-title-subheading"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Laporan Cuti Terakhir
                </div>
                <div class="dataTables_scroll">

                    <div class="dataTables_scrollBody"
                        style="position: relative; overflow: auto; max-height: 352px; width: 100%;">
                        <table style="width: 100%;" class="table table-hover table-striped table-bordered dataTable"
                            role="grid">
                            <thead>
                                <tr role="row" style="height: 0px;">
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Laporan Harian Terakhir
                </div>
                <div class="dataTables_scroll">

                    <div class="dataTables_scrollBody"
                        style="position: relative; overflow: auto; max-height: 352px; width: 100%;">
                        <table style="width: 100%;" class="table table-hover table-striped table-bordered dataTable"
                            role="grid">
                            <thead>
                                <tr role="row" style="height: 0px;">
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Aktifitas</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr style="height: 0px;">
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Aktifitas</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Pekerjaan Software Belum Selesai
                </div>
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Pekerjaan</th>
                                <th>Instansi</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th class="text-center">Progress</th>
                            </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Pekerjaan Hardware Belum Selesai
                </div>
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Pekerjaan</th>
                                <th>Instansi</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th class="text-center">Progress</th>
                            </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Pekerjaan Maintenance Software Belum Selesai
                </div>
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Pekerjaan</th>
                                <th>Instansi</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th class="text-center">Progress</th>
                            </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Pekerjaan Maintenance Hardware Belum Selesai
                </div>
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Pekerjaan</th>
                                <th>Instansi</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th class="text-center">Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Pekerjaan Jasa Lainnya Belum Selesai
                </div>
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Pekerjaan</th>
                                <th>Instansi</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th class="text-center">Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
