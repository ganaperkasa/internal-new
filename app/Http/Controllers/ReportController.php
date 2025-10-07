<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DocumentType;
use App\Models\Arsip;
use App\Models\Type;
use App\Models\Project;
use App\Models\ProjectArsip;
use App\Models\ProjectDocument;
use App\Models\PerangkatDaerah;
use App\Models\Chat;
use App\Models\Log;
use App\Models\Kategori;
use App\User;
use DB,Auth,Response,PDF;

class ReportController extends Controller
{
    public function dokumen_word($id)
    {
        $data = Project::findOrFail($id);
        
        $perangkatdaerah = PerangkatDaerah::findOrFail($data->pd_id);
        $kategori = Kategori::findOrFail($data->kategori_id);
        
        $query = "select pd.*, dt.name as label_document from project_document pd
                inner join document_types dt on dt.id = pd.document_id
                where project_id = $id
                order by dt.sort asc";
        $document =DB::select($query);

        $query = "select pa.*, a.name as label_arsip from project_arsip pa
                inner join arsip a on a.id = pa.arsip_id
                where project_id = $id
                order by a.sort asc";
        $arsip =DB::select($query);


        $xml_external_path = storage_path('word/DokumenAplikasi.xml');
        $file = storage_path('dword/DokumenAplikasi.xml');
        $xml = file_get_contents($xml_external_path);

        $start[] = 'val_pd';
        $replace[] = strtoupper($perangkatdaerah->name);

        $start[] = 'val_paket_pekerjaan';
        $replace[] = $data->paket_pekerjaan;

        $start[] = 'val_kegiatan';
        $replace[] = $data->kegiatan;

        $start[] = 'val_jenis_pekerjaan';
        $replace[] = jenisPekerjaan($data->jenis_pekerjaan);

        $start[] = 'val_anggaran';
        $replace[] = toRp($data->anggaran);

        $start[] = 'val_jangka_waktu';
        $replace[] = $data->jangka_waktu." Hari";

        $start[] = 'val_tanggal_mulai';
        $replace[] = tglIndo($data->tanggal_mulai);

        $start[] = 'val_kategori';
        $replace[] = $kategori->name;


        $labelDocument = "";
        $no=1;
        foreach ($document as $value) {
            
            $labelDocument .= $no.". ".$value->label_document;
            $labelDocument .= "<w:br/>";
            $labelDocument .= strip_tags($value->deskripsi);
            $labelDocument .= "<w:br/>";
            
            // $labelDocument .= "<w:br/>";
            $labelDocument .= "<w:br/>";
            
            $no++;
        }
        
        $start[] = 'val_dokumen_aplikasi';
        $replace[] = $labelDocument;

        $text = str_replace($start,$replace,$xml);
        file_put_contents($file, $text);

        return Response::download($file);
    }

    public function dokumen($id)
    {
        $data['data'] = Project::findOrFail($id);
        $data['perangkatdaerah'] = PerangkatDaerah::findOrFail($data['data']->pd_id);
        $data['kategori'] = Kategori::findOrFail($data['data']->kategori_id);
        
        $query = "select pd.*, dt.name as label_document from project_document pd
                inner join document_types dt on dt.id = pd.document_id
                where project_id = $id
                order by dt.sort asc";
        $data['document'] =DB::select($query);

        $query = "select pa.*, a.name as label_arsip from project_arsip pa
                inner join arsip a on a.id = pa.arsip_id
                where project_id = $id
                order by a.sort asc";
        $data['arsip'] =DB::select($query);

        $data['totalDokumenStatus0'] =ProjectDocument::where('konfirmasi',0)->where('project_id', $id)->count();
        $data['totalDokumenStatus1'] =ProjectDocument::where('konfirmasi',1)->where('project_id', $id)->count();
        $data['totalDokumenStatus2'] =ProjectDocument::where('konfirmasi',2)->where('project_id', $id)->count();

        $data['totalArsipStatus0'] =ProjectArsip::where('konfirmasi',0)->where('project_id', $id)->count();
        $data['totalArsipStatus1'] =ProjectArsip::where('konfirmasi',1)->where('project_id', $id)->count();
        $data['totalArsipStatus2'] =ProjectArsip::where('konfirmasi',2)->where('project_id', $id)->count();

        $query = "select l.*, u.name as petugas from logs l inner join users u on u.id = l.created_by where project_id = $id order by l.created_at desc";
        $data['log'] =DB::select($query);

        return view('print.jenis', $data);
    }

}
