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
        {{-- {!! Form::open(['route' => 'cuti.store', 'enctype' => 'multipart/form-data']) !!} --}}
        <form action="{{ route('cuti.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
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
                    <input class="form-check-input" type="radio" name="pilihan" id="exampleRadios1" value="0"
                        checked>
                    <label class="form-check-label" for="exampleRadios1" id="p1">
                        Periode Sekarang
                    </label>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="pilihan" id="exampleRadios2" value="1">
                    <label class="form-check-label" for="exampleRadios2" id="p2">
                        Periode Depan
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
                                    <option value="{{ $item->id }}"
                                        {{ Auth::user()->id == $item->id ? 'selected' : '' }}>
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
                        <label class="col-sm-3 col-form-label" for="sisa1">Sisa Cuti</label>
                        <div class="col-md-8">
                            <input type="number" class="form-control" id="sisa1" name="sisa1" readonly>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label class="col-sm-3 col-form-label" for="pakai1">Dipakai</label>
                        <div class="col-md-8">
                            <input type="number" class="form-control" id="pakai1" name="pakai1" readonly>
                        </div>
                    </div>
                </div>
                <div id="b" style="display: none;">
                    <div class="position-relative row form-group">
                        <label class="col-sm-3 col-form-label" for="sisas2">Sisa Cuti</label>
                        <div class="col-md-6">
                            <input type="number" class="form-control" id="sisas2" name="sisa2" readonly>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label class="col-sm-3 col-form-label" for="pakais2">Dipakai</label>
                        <div class="col-md-6">
                            <input type="number" class="form-control" id="pakais2" name="pakai2" readonly>
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
                        <input class="form-control" type="hidden" name="user_setuju"
                            value="{{ $data['setuju']->id }}">
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
                        <a href="{{ route('cuti.index') }}" class="btn-shadow mr-3 btn btn-warning">Kembali</a>
                        {{-- {!! Form::button('Simpan', [
                        'class' => 'btn btn-success simpan',
                        'type' => 'submit',
                        'data-swa-text' => 'Menambahkan Cuti',
                    ]) !!} --}}
                        <button class="btn btn-success simpan" type="submit"
                            data-swa-text="Menambahkan Cuti">Simpan</button>
                    </div>
                </div>
                {{-- {!! Form::close() !!} --}}
        </form>
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
            console.log('Document ready - Initializing cuti form');

            setTimeout(function() {
                // Determine which user element to use based on role
                var selectedData = null;
                var userElement = null;

                @if (Auth::user()->role_id == 1)
                    // For admin - use select2
                    userElement = $('#user1');
                    selectedData = userElement.val();
                    console.log('Admin mode - User selected:', selectedData);
                @else
                    // For non-admin - use hidden input
                    userElement = $('#user2');
                    selectedData = userElement.val();
                    console.log('Non-admin mode - User ID:', selectedData);

                    // Auto-load data for non-admin since user is fixed
                    if (selectedData) {
                        loadInitialData(selectedData);
                    }
                @endif

                console.log('Selected Data:', selectedData);

                // Load data saat halaman pertama kali dibuka (for admin)
                @if (Auth::user()->role_id == 1)
                    if (selectedData) {
                        loadInitialData(selectedData);
                    }
                @endif

                // Event listener untuk radio button (both admin and non-admin)
                $('input[name="pilihan"]').on('change', function() {
                    console.log('Radio changed to:', $(this).val());
                    if (!selectedData) {
                        alert('Pilih user terlebih dahulu');
                        return;
                    }

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

                // Event listener untuk select user (admin only)
                @if (Auth::user()->role_id == 1)
                    $('#user1').on('change', function() {
                        selectedData = $(this).val();
                        console.log('User selected:', selectedData);

                        if (selectedData) {
                            // Reset dan load data baru
                            resetAllFields();
                            loadInitialData(selectedData);
                        } else {
                            resetAllFields();
                        }
                    });
                @endif

            }, 500);
        });

        // Fungsi untuk reset semua field
        function resetAllFields() {
            $('#sisa1').val('');
            $('#pakai1').val('');
            $('#sisas2').val('');
            $('#pakais2').val('');
            $('#p1').text('Periode Sekarang');
            $('#p2').text('Periode Depan');
        }

        // Fungsi untuk load data saat pertama kali
        function loadInitialData(datas) {
            var pilihan = $('input[name="pilihan"]:checked').val();
            console.log('Initial load, pilihan:', pilihan);

            if (pilihan === '0') {
                loadData(datas);
                $('#a').show();
                $('#b').hide();
            } else if (pilihan === '1') {
                loadData1(datas);
                $('#a').hide();
                $('#b').show();
            }
        }

        function loadData(datas) {
            console.log('loadData called with:', datas);
            $.ajax({
                url: "{{ url('data-user') }}/" + datas + "?param=0",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log('loadData response:', response);

                    if (response && response.periods) {
                        var labelText = "Periode Sekarang " + response.periods.pawal + ' sd ' + response.periods
                            .pakhir;
                        var label2Text = "Periode Depan " + response.periods.p2awal + ' sd ' + response.periods
                            .p2akhir;

                        $('#p1').text(labelText);
                        $('#p2').text(label2Text);

                        $('#pakai1').val(response.cuti_count);
                        $('#sisa1').val(12 - response.cuti_count);

                        console.log('Updated - Sisa:', 12 - response.cuti_count, 'Pakai:', response.cuti_count);
                    } else {
                        console.log('No data received');
                        resetAllFields();
                    }
                },
                error: function(err) {
                    console.log('Error loading data:', err);
                    alert('Error loading data: ' + err.responseText);
                    resetAllFields();
                }
            });
        }

        function loadData1(datas) {
            console.log('loadData1 called with:', datas);
            $.ajax({
                url: "{{ url('data-user') }}/" + datas + "?param=1",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log('loadData1 response:', response);

                    if (response && response.periods) {
                        var labelText = "Periode Sekarang " + response.periods.pawal + ' sd ' + response.periods
                            .pakhir;
                        var label2Text = "Periode Depan " + response.periods.p2awal + ' sd ' + response.periods
                            .p2akhir;

                        $('#p1').text(labelText);
                        $('#p2').text(label2Text);

                        $('#pakais2').val(response.cuti_count);
                        $('#sisas2').val(12 - response.cuti_count);

                        console.log('Updated - Sisa:', 12 - response.cuti_count, 'Pakai:', response.cuti_count);
                    } else {
                        console.log('No data received');
                        resetAllFields();
                    }
                },
                error: function(err) {
                    console.log('Error loading data1:', err);
                    alert('Error loading data: ' + err.responseText);
                    resetAllFields();
                }
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
                            <button class="btn btn-danger" data-target="${count}" type="button" onclick="delButton(this)">-</button>
                        </div>
                    </div>
                </div>
            `;
            $('#tambahData').append(html);
        }

        function delButton(e) {
            hitung--;
            let id = $(e).data('target');
            $('#body_' + id).remove();
        }
    </script>
@endpush
