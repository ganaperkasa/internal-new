    <head>
        <link href="{{ asset('print') }}/bootstrap.min.css" rel="stylesheet">
        <script src="{{ asset('print') }}/bootstrap.bundle.min.js"></script>
        <style>
            @media print {
                body {
                    visibility: hidden;
                }

                #section-to-print {
                    visibility: visible;
                    position: absolute;
                    left: 0;
                    top: 0;
                }
            }

            @page {
                size: a4 portrait;
                margin: 0;
            }

            .a4 {
                width: 21cm;
                height: 29.7cm;
                margin: 0 auto;
            }

            .a4-body {
                padding: 1.27cm 1.27cm 0 1.27cm;
                height: 28cm;
            }
        </style>
    </head>
    <div style="margin: 0 auto; width: 21cm; padding: 10px;">
        <button type="button" class="btn btn-primary" id="format1">Format 1</button>
        <button type="button" class="btn btn-primary" id="format2">Format 2</button>
        <button type="button" class="btn btn-primary" id="printBtn">Print</button>
    </div>
    <div id="section-to-print" class="a4">
        <div class="a4-body">
            <div class="mb-3">
                <img style="width: 140px;" src="{{ asset('print') }}/SCOMPTEC.png">
            </div>
            <div class="mb-4" style="font: bold 14pt Calibri;text-align: center;">SURAT PERMOHONAN CUTI</div>
            <table class="table align-middle table-nowrap table-centered table-borderless mb-0">
                <tbody style="font: 11pt Calibri;line-height: 2;">
                    <tr>
                        <td class="p-0" colspan="3">Dengan Hormat</td>
                    </tr>
                    <tr>
                        <td class="p-0" style="width: 20%;text-indent: 13mm;">Nama</td>
                        <td class="p-0" style="width: 2%;">:</td>
                        <td class="p-0" style="width: 78%;">{{ $cuti->user->name }}</td>
                    </tr>
                    <tr>
                        <td class="p-0" style="text-indent: 13mm;">Jabatan</td>
                        <td class="p-0">:</td>
                        <td class="p-0">{{ $cuti->user->jabatan->name }}</td>

                    </tr>
                    <tr>
                        <td class="p-0" style="text-indent: 13mm;">Divisi</td>
                        <td class="p-0">:</td>
                        <td class="p-0">{{ strtoupper($cuti->user->divisi->name) }}</td>
                    </tr>
                    <tr>
                        <td class="p-0" colspan="3">dengan ini mengajukan permohonan untuk mengambil cuti :</td>
                    </tr>
                    <tr style="vertical-align: top;">
                        <td class="p-0" style="text-indent: 13mm;">Tanggal</td>
                        <td class="p-0">:</td>
                        <td class="p-0">
                            @foreach ($cuti->detail as $item)
                                {{ tglIndo($item->tanggal_cuti) }}
                                {{ $loop->last ? '' : ',' }}
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td class="p-0" style="text-indent: 13mm;">Lama Cuti</td>
                        <td class="p-0">:</td>
                        <td class="p-0">{{ $cuti->detail->count() }} Hari</td>
                    </tr>
                    <tr>
                        <td class="p-0" style="text-indent: 13mm;">Keterangan</td>
                        <td class="p-0">:</td>
                        <td class="p-0">{{ $cuti->keterangan }}</td>
                    </tr>
                </tbody>
            </table>
            <table class="table align-middle table-nowrap table-centered table-borderless mb-4">
                <tbody style="font: 11pt Calibri;line-height: 2;">
                    <tr>
                        <td class="p-0" colspan="4">Adapun Perincian Hak Cuti saya sampaikan dengan hari ini
                            adalah
                            sebagai berikut</td>
                    </tr>
                    <tr>
                        <td class="p-0" style="width: 27%;text-indent: 13mm;">Hak cuti tahun ini</td>
                        <td class="p-0" style="width: 7%;">:</td>
                        <td class="p-0" style="width: 7%;">12</td>
                        <td class="p-0" style="width: 59%;">hari</td>
                    </tr>
                    <tr>
                        <td class="p-0" style="text-indent: 13mm;">Jumlah cuti</td>
                        <td class="p-0">:</td>
                        <td class="p-0">{{ $cuti->detail->count() }}</td>
                        <td class="p-0">hari</td>
                    </tr>
                    <tr>
                        <td class="p-0" style="text-indent: 13mm;">Sudah diambil</td>
                        <td class="p-0">:</td>
                        <td class="p-0">{{ $cuti->dipakai }}</td>
                        <td class="p-0">hari</td>
                    </tr>
                    <tr>
                        <td class="p-0" style="text-indent: 13mm;">Sisa cuti</td>
                        <td class="p-0">:</td>
                        <td class="p-0">{{ 12 - ($cuti->detail->count() + $cuti->dipakai) }}</td>
                        <td class="p-0">hari</td>
                    </tr>
                    <tr>
                        <td class="p-0" colspan="4">Demikian permohonan saya, dan atas perhatian serta perkenannya
                            saya mengucapkan terima Kasih.</td>
                    </tr>
                </tbody>
            </table>
            <div class="clearfix">
                <div id="ttd1" style="display: block">
                    <div style="width: 50%;float: left;">
                        <div style="font: 11pt Calibri;text-align: center;">
                            <span>Surabaya, {{ tglIndo($cuti->created_at) }}</span><br>
                            <div>
                                <img style="height: 130px;" src="{{ asset('print') }}/Picture3.jpeg">
                            </div>
                            <span class="fw-bold">{{ $cuti->user->name }}</span><br>
                            <div class="fw-bold" style="position:relative;top:-4mm">………………………………………………</div>
                        </div>
                    </div>
                    <div style="width: 50%;float: left;">
                        <div style="font: 11pt Calibri;text-align: center;">
                            <span>Pelaksana Tugas</span><br>
                            <div>
                                <img style="height: 130px;" src="{{ asset('print') }}/Picture3.jpeg">
                            </div>
                            <span class="fw-bold">{{ $cuti->pj->name }}</span><br>
                            <div class="fw-bold" style="position:relative;top:-4mm">………………………………………………</div>
                        </div>
                    </div>
                    <div style="width: 50%;float: left;">
                        <div style="font: 11pt Calibri;text-align: center;">
                            <span>Mengetahui</span><br>
                            <div>
                                <img style="height: 130px;" src="{{ asset('print') }}/Picture3.jpeg">
                            </div>
                            <span class="fw-bold">{{ $cuti->mg->name }}</span><br>
                            <div class="fw-bold" style="position:relative;top:-4mm">………………………………………………</div>
                        </div>
                    </div>
                    <div style="width: 50%;float: left;">
                        <div style="font: 11pt Calibri;text-align: center;">
                            <span>Menyetujui</span><br>
                            <div>
                                <img style="height: 130px;" src="{{ asset('print') }}/Picture3.jpeg">
                            </div>
                            <span class="fw-bold">{{ $cuti->mn->name }}</span><br>
                            <div class="fw-bold" style="position:relative;top:-4mm">………………………………………………</div>
                        </div>
                    </div>
                </div>
                <div id="ttd2" style="display: none">
                    <div style="width: 50%;float: left;">
                        <div style="font: 11pt Calibri;text-align: center;">
                            <span>Surabaya, {{ tglIndo($cuti->created_at) }}</span><br>
                            <div style="height: 130px">
                                {{-- <img style="height: 130px;" src="{{ asset('print') }}/Picture3.jpeg"> --}}
                            </div>
                            <span class="fw-bold">{{ $cuti->user->name }}</span><br>
                            <div class="fw-bold" style="position:relative;top:-4mm">………………………………………………</div>
                        </div>
                    </div>
                    <div style="width: 50%;float: left; opacity: 0">
                        <div style="font: 11pt Calibri;text-align: center;">
                            <span>Pelaksana Tugas</span><br>
                            <div>
                                <img style="height: 130px;" src="{{ asset('print') }}/Picture3.jpeg">
                            </div>
                            <span class="fw-bold">{{ $cuti->pj->name }}</span><br>
                            <div class="fw-bold" style="position:relative;top:-4mm">………………………………………………</div>
                        </div>
                    </div>
                    <div style="width: 50%;float: left;">
                        <div style="font: 11pt Calibri;text-align: center;">
                            <span>Mengetahui</span><br>
                            <div style="height: 130px">
                                {{-- <img style="height: 150px;" src="{{ asset('print') }}/Picture3.jpeg"> --}}
                            </div>
                            <span class="fw-bold"></span><br>
                            <div class="fw-bold" style="position:relative;top:-4mm">………………………………………………</div>
                        </div>
                    </div>
                    <div style="width: 50%;float: left;">
                        <div style="font: 11pt Calibri;text-align: center;">
                            <span>Menyetujui</span><br>
                            <div style="height: 130px">
                                {{-- <img style="height: 150px;" src="{{ asset('print') }}/Picture3.jpeg"> --}}
                            </div>
                            <span class="fw-bold"></span><br>
                            <div class="fw-bold" style="position:relative;top:-4mm">………………………………………………</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="a4-footear" style="font: 8.5pt Arial;text-align: center;">
            <span>Head Office : Jl. Kayun 24 Surabaya 60271 – Indonesia. Phone : (031)-5315678 (Hunting). Facs :
                (031)-5319806, 5467945<br>Email address : sco@scomptec.co.id</span>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('format1').addEventListener('click', function() {
                // Show all sections
                document.getElementById('ttd1').style.display = 'block';
                document.getElementById('ttd2').style.display = 'none';
            });

            document.getElementById('format2').addEventListener('click', function() {
                // Hide penanggung jawab section
                document.getElementById('ttd1').style.display = 'none';
                // Show mengetahui and menyetujui sections
                document.getElementById('ttd2').style.display = 'block';
            });

            document.getElementById('printBtn').addEventListener('click', function() {
                // Trigger window.print() for printing
                window.print();
            });
        });
    </script>
