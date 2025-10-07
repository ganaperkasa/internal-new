<!DOCTYPE html>
<html>

<head>
  <title>Cetak Dokumen Aplikasi</title>
  <link rel="shortcut icon" href="{{ url('/assets/images/favicon.ico') }}" />
</head>
<style type="text/css">
     
    body {
     font-family: Arial, Helvetica, sans-serif;
     
    }

    .txtbold{
        font-weight: bold;
    }

    p {
    text-align: justify;
    text-justify: inter-word;
    }
  </style>
<body onload="window.print()"> 
        <table class="MsoTableGrid" width="720" style="border-collapse: collapse; border: none;" border="0" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr style="height: 70.15pt;">
                        <td style="width: 58.8pt; padding: 0in 5.4pt 0in 5.4pt; height: 70.15pt;" valign="top" align="center" width="78">
                            <p style="margin: 0in 0in 0.0001pt; line-height: normal; font-size: 12pt; font-family: Arial, sans-serif;"><img
                                    src="{{ url('jatim.png') }}" width="64" height="90" /></p>
                        </td>
                        <td style="width: 408.7pt; padding: 0in 5.4pt 0in 5.4pt; height: 70.15pt;" colspan="2" valign="top"
                            width="545">
                            <p style="text-align: center; margin: 0in 0in 0.0001pt; font-size: 12pt; font-family: Arial, sans-serif;"
                                align="center"><strong>PEMERINTAH PROVINSI JAWA TIMUR</strong></p>
                            <p style="text-align: center; margin: 0in 0in 0.0001pt; font-size: 18pt; font-family: Arial, sans-serif;"
                                align="center"><strong><span style="font-size: 14.0pt;">{{ strtoupper($perangkatdaerah->name) }}</span></strong></p>
                                <p style="text-align: center; margin: 0in 0in 0.0001pt; font-size: 10pt; font-family: Arial, sans-serif;"
                                align="center">{{ $perangkatdaerah->alamat }} Telp. {{ $perangkatdaerah->telp }} Fax.
                                {{ $perangkatdaerah->fax }}</p>
                            <p style="text-align: center; margin: 0in 0in 0.0001pt; font-size: 10pt; font-family: Arial, sans-serif;"
                            align="center">E-Mail : <span style="color: #0563c1; text-decoration: underline;"><a style="color: #0563c1; text-decoration: underline;"
                                    href="mailto:{{ $perangkatdaerah->email }}">{{ $perangkatdaerah->email }}</a></span> Website
                            <span style="color: #0563c1; text-decoration: underline;"><a style="color: #0563c1; text-decoration: underline;"
                                    href="{{ $perangkatdaerah->website }}">{{ $perangkatdaerah->website }}</a></span></p>
                        </td>
                    </tr>
                    
                    
                    <tr style="height: 15.25pt;">
                        <td style="width: 454.25pt; padding: 0in 5.4pt 0in 5.4pt; height: 15.25pt;" colspan="2" valign="top"
                            width="606">
                            <p style="margin: 0in 0in 0.0001pt; text-align: right; line-height: normal; font-size: 12pt; font-family: Arial, sans-serif;"
                                align="right">{{ tglIndo(date('Y-m-d')) }}</p>
                        </td>
                        <td style="width: 13.25pt; padding: 0in 5.4pt 0in 5.4pt; height: 15.25pt;" valign="top" width="18">
                            <p style="margin: 0in 0in 0.0001pt; line-height: normal; font-size: 12pt; font-family: Arial, sans-serif;"><strong><span
                                        style="font-size: 12.0pt;">&nbsp;</span></strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: none;" width="78">&nbsp;</td>
                        <td style="border: none;" width="527">&nbsp;</td>
                        <td style="border: none;" width="18">&nbsp;</td>
                    </tr>
                </tbody>
            </table>

<table border="0" width="720">
    <tr>
        <td width="200" class="txtbold" valign="top">Paket Pekerjaan</td>
        <td valign="top">:</td>
        <td>{{ $data->paket_pekerjaan }}</td>
    </tr>
    <tr>
        <td class="txtbold">Kegiatan</td>
        <td>:</td>
        <td>{{ $data->kegiatan }}</td>
    </tr>
    <tr>
        <td class="txtbold">Jenis Pekerjaan</td>
        <td>:</td>
        <td>{{ jenisPekerjaan($data->jenis_pekerjaan) }}</td>
    </tr>
    <tr>
        <td class="txtbold">Kategori Aplikasi</td>
        <td>:</td>
        <td>{{ $kategori->name }}</td>
    </tr>
    <tr>
        <td class="txtbold">Anggaran</td>
        <td>:</td>
        <td>{{ toRp($data->anggaran) }}</td>
    </tr>
    <tr>
        <td class="txtbold">Jangka Waktu</td>
        <td>:</td>
        <td>{{ $data->jangka_waktu }} Hari</td>
    </tr>
    <tr>
        <td class="txtbold">Tanggal Mulai Pekerjaan</td>
        <td>:</td>
        <td>{{ tglIndo($data->tanggal_mulai) }}</td>
    </tr>
    

</table>   
<br>
<hr>
<br>
<?php $no =1 ?>
@foreach($document as $value)
<h3>{{ $no.'. '.$value->label_document }}</h3>

{!! $value->deskripsi !!}
<br>
<?php $no++; ?>
@endforeach
</body>

</html>
