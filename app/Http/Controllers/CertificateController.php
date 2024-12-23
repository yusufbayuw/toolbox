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
            'nomor_certificate' => $participant->nomor,
            'nama_penerima' => $participant->nama_penerima,
            'asal_penerima' => $participant->asal_penerima,
            'deskripsi_sertifikat' => $certificate->deskripsi,
            'lokasi' => $certificate->lokasi,
            'tanggal_penerbitan' => $certificate->tanggal_terbit,
            'nama_penandatangan' => $certificate->nama_penandatangan,
            'jabatan_penandatangan' => $certificate->jabatan_penandatangan,
            'file_tandatangan' => env('BASE_CERT').'/'.$certificate->file_tandatangan,
            'qr_code_path' => env('BASE_CERT_VAL').'/'.$participant->uuid_val,
            'download_link' => env('BASE_CERT').'/'.$participant->uuid,
        ];
        $pdf = Pdf::loadView('certificate.template', $data);
        return $pdf->download('abc.pdf');
    }
}
