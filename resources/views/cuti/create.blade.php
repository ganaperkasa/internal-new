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
                <div>Tambah Cuti

                </div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        {!! Form::open(['route' => 'cuti.store', 'enctype' => 'multipart/form-data']) !!}
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-dark">
                    <b>Terdapat beberapa kesalahan. Silahkan diperbaiki.</b><br>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif


            <div class="form-check mb-3">
                <input class="form-check-input" type="radio" name="pilihan" id="exampleRadios1" value="0" checked>
                <label class="form-check-label" for="exampleRadios1" id="p1">

                </label>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="radio" name="pilihan" id="exampleRadios2" value="1">
                <label class="form-check-label" for="exampleRadios2" id="p2">

                </label>
            </div>

            @csrf
            @if (Auth::user()->role_id == 1)
                <div class="position-relative row form-group">
                    <label class="col-sm-3 col-form-label">Nama*</label>
                    <div class="col-sm-8">
                        <select class="form-control select2" name="user_cuti" id="user1">
                            <option value="">Pilih</option>
                            @foreach ($user as $item)
                                <option value="{{ $item->id }}" {{ Auth::user()->id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @else
                <div class="position-relative row form-group">
                    <label class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-8">
                        <input class="form-control" type="text" value="{{ $user->name }}" readonly>
                        <input class="form-control" type="hidden" id="user2" name="user_cuti"
                            value="{{ $user->id }}">
                    </div>
                </div>
            @endif
            <div id="a">
                <div class="position-relative row form-group">
                    <label class="col-sm-3 col-form-label">Sisa</label>
                    <div class="col-sm-8">
                        <input class="form-control" type="text" id="sisa1" name="sisa1" value="" readonly>
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label class="col-sm-3 col-form-label">Dipakai</label>
                    <div class="col-sm-8">
                        <input class="form-control" type="text" id="pakai1" name="pakai1" value="" readonly>
                    </div>
                </div>
            </div>
            <div id="b" style="display: none;">
                <div class="position-relative row form-group">
                    <label class="col-sm-3 col-form-label">Sisa</label>
                    <div class="col-sm-8">
                        <input class="form-control" type="text" name="sisa2" id="sisas2" value="" readonly>
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label class="col-sm-3 col-form-label">Dipakai</label>
                    <div class="col-sm-8">
                        <input class="form-control" type="text" name="pakai2" id="pakais2" value="" readonly>
                    </div>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label class="col-sm-3 col-form-label">Keterangan</label>
                <div class="col-sm-8">
                    <textarea name="keterangan" class="form-control" id="" cols="30" rows="10"></textarea>
                </div>
            </div>

            <div class="position-relative row form-group">
                <label class="col-sm-3 col-form-label">File Pendukung (opsional)</label>
                <div class="col-sm-8">
                    <input class="form-control-file" type="file" name="file" required>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label class="col-sm-3 col-form-label">Tanggal*</label>
                <div class="col-sm-7">
                    <input class="form-control" type="date" name="tanggal[]" placeholder="Tanggal" required>
                </div>
                <div class="col-2">
                    <button class="btn btn-primary" type="button" onclick="tambahDokumen()">+</button>
                </div>
            </div>

            <div id="tambahData">

            </div>

            <div class="position-relative row form-group">
                <label class="col-sm-3 col-form-label">Pelaksana Tugas*</label>
                <div class="col-sm-8">
                    <select class="form-control select2" name="user_pj">
                        <option value="">Pilih</option>
                        @foreach ($pj as $item)
                            <option value="{{ $item->id }}" {{ Auth::user()->id == $item->id ? 'disabled' : '' }}>
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label class="col-sm-3 col-form-label">Menyetujui</label>
                <div class="col-sm-8">
                    <input class="form-control" type="text" value="{{ $data['setuju']->name }}" readonly>
                    <input class="form-control" type="hidden" name="user_setuju" value="{{ $data['setuju']->id }}">
                </div>
            </div>
            <div class="position-relative row form-group">
                <label class="col-sm-3 col-form-label">Mengetahui</label>
                <div class="col-sm-8">
                    <input class="form-control" type="text" value="{{ $data['tau']->name }}" readonly>
                    <input class="form-control" type="hidden" name="user_tau" value="{{ $data['tau']->id }}">
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-sm-12 text-end">
                    <a href="{{ URL::previous() }}" class="btn-shadow mr-3 btn btn-warning">Kembali</a>
                    {!! Form::button('Simpan', [
                        'class' => 'btn btn-success simpan',
                        'type' => 'submit',
                        'data-swa-text' => 'Menambahkan Cuti',
                    ]) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection


@push('custom-scripts')
    <script>
        @if (session()->has('dangerss'))
            swal("Error!", '{{ session()->get('dangerss') }}', "error");
        @endif
    </script>
    <script>
        $(document).ready(function() {
            var dataUser1 = $('#user1').val();
            var dataUser2 = $('#user2').val();
            var selectedData = dataUser1;

            if (dataUser1 == null) {
                selectedData = dataUser2;
            }

            $('input[name="pilihan"]').change(function() {
                if ($(this).val() === '0') {

                    loadData(selectedData);

                    $('#a').show();
                    $('#b').hide();
                } else if ($(this).val() === '1') {

                    loadData1(selectedData);

                    $('#a').hide();
                    $('#b').show();
                }
            });

            if ($('input[name="pilihan"]:checked').val() === '0') {

                loadData(selectedData);

                $('#a').show();
                $('#b').hide();
            } else if ($('input[name="pilihan"]:checked').val() === '1') {

                loadData1(selectedData);

                $('#a').hide();
                $('#b').show();
            }

            $('#user1').change(function() {
                selectedData = $(this).val();
                if ($('input[name="pilihan"]:checked').val() === '0') {
                    loadData(selectedData);
                } else if ($('input[name="pilihan"]:checked').val() === '1') {
                    loadData1(selectedData);
                }
            });
        });


        function loadData(datas) {
            $.ajax({
                url: "{{ url('data-user') }}/" + datas + "?param=0",
                success: function(data) {
                    if (data != null) {
                        $('#p1').html("Periode Sekarang " + data[0].pawal + ' ' + 'sd' + ' ' + data[0].pakhir);
                        $('#p2').html("Periode Depan " + data[0].p2awal + ' ' + 'sd' + ' ' + data[0].p2akhir);
                        $('#pakai1').val(data[2]);
                        $('#sisa1').val(12 - data[2]);
                    }
                },
                complete: function() {}
            });
        }

        function loadData1(datas) {
            $.ajax({
                url: "{{ url('data-user') }}/" + datas + "?param=1",
                success: function(data) {
                    if (data != null) {
                        $('#p1').html("Periode Sekarang " + data[0].pawal + ' ' + 'sd' + ' ' + data[0].pakhir);
                        $('#p2').html("Periode Depan " + data[0].p2awal + ' ' + 'sd' + ' ' + data[0].p2akhir);
                        $('#pakais2').val(data[2]);
                        $('#sisas2').val(12 - data[2]);
                    }
                },
                complete: function() {}
            });
        }

        let hitung = 0;

        function makeid(length) {
            var result = '';
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }


        function tambahDokumen(e) {
            hitung++;
            let count = makeid(10);
            let html = `
                <div id="body_${count}">
                    <div class="position-relative row form-group">
                        <label class="col-sm-3 col-form-label">Tanggal*</label>
                        <div class="col-sm-7">
                            <input class="form-control" type="date" name="tanggal[]" placeholder="Tanggal" required>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-danger delete_${count}" data-target="${ count }" onclick="delButton(this)">-</button>
                        </div>
                    </div>
                </div>
                `;
            $('#tambahData').append(html);
        }

        function delButton(e) {
            hitung--;
            console.log(e)
            let id = $(e).data('target');
            $('#body_' + id).remove();
        }
    </script>
@endpush
