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
                <div>Tambah Cuti Bersama

                </div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        {!! Form::open(['route' => 'cuti-bersama.store', 'enctype' => 'multipart/form-data']) !!}
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-dark">
                    <b>Terdapat beberapa kesalahan. Silahkan diperbaiki.</b><br>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif

            @csrf


            @foreach ($user as $key => $item)
                <div class="row ml-1 mb-3">
                    <div class="form-check form-check-inline col-12">
                        <input class="form-check-input" type="checkbox" id="{{ $key }}" value="option1">
                        <label class="form-check-label" for="{{ $key }}">{{ $key }}</label>
                    </div>
                    <div class="row ml-1">
                        @foreach ($item as $items)
                            <div class="col-3 mb-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox"
                                        id="{{ $key }}_{{ $loop->iteration }}" name="user_cuti[]"
                                        value="{{ $items->id }}">
                                    <label class="form-check-label"
                                        for="{{ $key }}_{{ $loop->iteration }}">{{ $items->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach



            <div class="position-relative row form-group">
                <label class="col-sm-3 col-form-label">Keterangan</label>
                <div class="col-sm-8">
                    <textarea name="keterangan" class="form-control" id="" cols="30" rows="10"></textarea>
                </div>
            </div>

            <div class="position-relative row form-group">
                <label class="col-sm-3 col-form-label">File Pendukung (wajib)</label>
                <div class="col-sm-8">
                    <input class="form-control-file" type="file" name="file">
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
                <label class="col-sm-3 col-form-label">Pelaksana</label>
                <div class="col-sm-8">
                    <input class="form-control" type="text" value="{{ $data['setuju']->name }}" readonly>
                    <input class="form-control" type="hidden" name="user_pj" value="{{ $data['setuju']->id }}">
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
            // Fungsi untuk menangani checked all pada setiap grup checkbox
            function handleCheckAll(key) {
                // Mendapatkan elemen checkbox utama pada grup dengan key tertentu
                var mainCheckbox = $('#' + key);

                // Mendapatkan semua checkbox pada grup dengan key tertentu
                var checkboxes = $('input[name="user_cuti[]"][id^="' + key + '"]');

                // Menangani perubahan pada checkbox utama
                mainCheckbox.change(function() {
                    checkboxes.prop('checked', mainCheckbox.prop('checked'));
                });

                // Menangani perubahan pada setiap checkbox dalam grup
                checkboxes.change(function() {
                    // Jika semua checkbox dalam grup tercentang, centang juga checkbox utama
                    mainCheckbox.prop('checked', checkboxes.filter(':checked').length === checkboxes
                        .length);
                });
            }

            // Memanggil fungsi handleCheckAll untuk setiap $key pada loop
            @foreach ($user as $key => $item)
                handleCheckAll('{{ $key }}');
            @endforeach
        });
    </script>
    <script>
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
