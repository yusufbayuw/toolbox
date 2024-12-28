<?php

namespace App\Http\Controllers;

use App\Models\CertificateParticipant;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function generate(string $urlx) 
    {
        $participant = CertificateParticipant::where('uuid', $urlx)->first();
        $certificate = $participant->certificate;
        
        $data = [
            'jenis_sertifikat' => $certificate->jenis,
            'nomor_sertifikat' => $participant->nomor,
            'nama_penerima' => $participant->nama_penerima,
            'asal_penerima' => $participant->asal_penerima,
            'deskripsi_sertifikat' => $certificate->deskripsi,
            'lokasi' => $certificate->lokasi,
            'tanggal_penerbitan' => $certificate->tanggal_terbit,
            'nama_penandatangan' => $certificate->nama_penandatangan,
            'jabatan_penandatangan' => $certificate->jabatan_penandatangan,
            'file_tandatangan' => config('base_urls.base_cert').'/storage/'.$certificate->file_tandatangan,
            'qr_code_path' => config('base_urls.base_cert_val').'/val/'.$participant->uuid_val,
            'download_link' => config('base_urls.base_cert').'/'.$participant->uuid,
        ];
        //dompdf
        $pdf = Pdf::loadView('certificate.template', $data)
        ->setPaper('a4', 'landscape');
        return $pdf->stream($certificate->jenis.'-'.$participant->nomor.'-'.$participant->nama_penerima.'.pdf');

    }
}
