<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CustomerController extends Controller
{
    public function tambah1() {
        return view('customer.tambah1');
    }

    public function simpan1(Request $request) {
        $customer = new Customer();
        $customer->nama = $request->nama;
        // Kita simpan string base64 dari kamera langsung ke kolom foto_blob
        $customer->foto_blob = $request->foto; 
        $customer->save();

        return redirect()->back()->with('success', 'Data Customer berhasil disimpan sebagai Blob!');
    }

    public function tambah2() {
        return view('customer.tambah2');
    }

    public function simpan2(Request $request) {
        $img = $request->foto; // Ambil data Base64
        $folderPath = public_path('uploads/customers/');
        
        // Buat folder jika belum ada
        if (!File::isDirectory($folderPath)) {
            File::makeDirectory($folderPath, 0777, true, true);
        }

        // Pisahkan header Base64 dari datanya
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        
        // Beri nama file unik
        $fileName = uniqid() . '.png';
        $file = $folderPath . $fileName;
        
        // Simpan file ke folder
        file_put_contents($file, $image_base64);

        // Simpan path-nya saja ke database
        $customer = new Customer();
        $customer->nama = $request->nama;
        $customer->foto_path = 'uploads/customers/' . $fileName; 
        $customer->save();

        return redirect()->back()->with('success', 'Foto disimpan ke folder dan path disimpan ke DB!');
    }
    public function index() {
        $customers = Customer::all(); // Mengambil data dari table customer 
        return view('customer.index', compact('customers'));
    }
}
