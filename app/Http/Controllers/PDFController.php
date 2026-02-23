<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function index()
    {
        return view('pdf.index');
    }

    public function generateSertifikat(Request $request) 
    {
        // Mengirim seluruh data input ($request) ke view sertifikat
        $pdf = Pdf::loadView('pdf.sertifikat', compact('request'))->setPaper('a4', 'landscape');
        return $pdf->stream('Sertifikat_' . $request->nama . '.pdf');
    }

    public function generatePengumuman(Request $request) 
    {
        // Mengirim seluruh data input ($request) ke view pengumuman
        $pdf = Pdf::loadView('pdf.pengumuman', compact('request'))->setPaper('a4', 'portrait');
        return $pdf->stream('Surat_Undangan.pdf');
    }
}