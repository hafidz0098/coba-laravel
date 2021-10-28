<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;
use App\Models\Rumpun;

class DaftarController extends Controller
{
    public function index(){
        return view('daftar.index', [
            'title' => 'daftar',
            'active' => 'daftar',
            'rumpuns' => Rumpun::all()
        ]);
    }

    public function store(Request $request){

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:dns|unique:pesertas',
            'asal_sekolah' => 'required|max:255',
            'nomor_wa' => 'required|max:20',
            'rumpun_id' => 'required',
            'bukti_tf' => 'required|image|file|max:1024'
        ]);

        $validatedData['bukti_tf'] = $request->file('bukti_tf')->store('bukti-tf');

        Peserta::create($validatedData);

        // $request->session()->flash('success', 'Registration successfully! Please login');

        return redirect('/daftar')->with('success', 'Pendaftaran berhasil, silahkan cek inbox/spam email anda!');
    }
}
