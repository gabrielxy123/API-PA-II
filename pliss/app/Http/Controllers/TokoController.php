<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;

class TokoController extends Controller
{
    public function index()
    {
        $tokos = Toko::all();
        return response()->json($tokos);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id|unique:tokos,user_id',
            'nama' => 'required',
            'no_telp' => 'required',
            'email' => 'required|email|unique:tokos,email',
            'deskripsi' => 'nullable',
            'jalan' => 'required',
            'kecamatan' => 'required',
            'kabupaten' => 'required',
            'provinsi' => 'required',
            'waktu_buka' => 'required',
            'waktu_tutup' => 'required',
        ]);

        $toko = Toko::create($validated);
        return response()->json($toko, 201);
    }

    public function show(Toko $toko)
    {
        return response()->json($toko);
    }

    public function update(Request $request, Toko $toko)
    {
        $validated = $request->validate([
            'nama' => 'sometimes|required',
            'no_telp' => 'sometimes|required',
            'email' => 'sometimes|required|email|unique:tokos,email,'.$toko->id,
            'deskripsi' => 'nullable',
            'jalan' => 'sometimes|required',
            'kecamatan' => 'sometimes|required',
            'kabupaten' => 'sometimes|required',
            'provinsi' => 'sometimes|required',
            'waktu_buka' => 'sometimes|required',
            'waktu_tutup' => 'sometimes|required',
        ]);

        $toko->update($validated);
        return response()->json($toko);
    }

    public function destroy(Toko $toko)
    {
        $toko->delete();
        return response()->json(['message' => 'Toko berhasil dihapus']);
    }
}
