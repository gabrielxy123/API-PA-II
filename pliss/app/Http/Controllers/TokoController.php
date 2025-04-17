<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokoController extends Controller
{
    public function index()
    {
        $tokos = Toko::all();
        return response()->json([
            'message' => 'Data toko berhasil diambil',
            'data' => $tokos
        ], 200);
    }

    public function store(Request $request)
    {
        // Pastikan user login
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'noTelp' => 'required|string|regex:/^[0-9]{10,15}$/',
            'email' => 'required|email|unique:tokos,email|max:255',
            'deskripsi' => 'nullable|string|max:500',
            'jalan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kabupaten' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'waktuBuka' => 'required|date_format:H:i:s',
            'waktuTutup' => 'required|date_format:H:i:s|after:waktuBuka',
        ]);

        $userId = Auth::id();

        if (Toko::where('userID', $userId)->exists()) {
            return response()->json([
                'message' => 'User sudah memiliki toko'
            ], 422);
        }

        // Menyimpan data toko
        $toko = Toko::create([
            'userID' => $userId,
            'nama' => $validated['nama'],
            'noTelp' => $validated['noTelp'],
            'email' => $validated['email'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'jalan' => $validated['jalan'],
            'kecamatan' => $validated['kecamatan'],
            'kabupaten' => $validated['kabupaten'],
            'provinsi' => $validated['provinsi'],
            'waktuBuka' => $validated['waktuBuka'],
            'waktuTutup' => $validated['waktuTutup'],
        ]);

        return response()->json([
            'message' => 'Toko berhasil dibuat',
            'data' => $toko
        ], 201);
    }

    public function show(Toko $toko)
    {
        return response()->json([
            'message' => 'Detail toko berhasil diambil',
            'data' => $toko
        ], 200);
    }

    public function update(Request $request, Toko $toko)
    {
        $validated = $request->validate([
            'nama' => 'sometimes|required',
            'no_telp' => 'sometimes|required',
            'email' => 'sometimes|required|email|unique:tokos,email,' . $toko->id,
            'deskripsi' => 'nullable',
            'jalan' => 'sometimes|required',
            'kecamatan' => 'sometimes|required',
            'kabupaten' => 'sometimes|required',
            'provinsi' => 'sometimes|required',
            'waktu_buka' => 'sometimes|required',
            'waktu_tutup' => 'sometimes|required',
        ]);

        $toko->update($validated);
        return response()->json([
            'message' => 'Toko berhasil diperbarui',
            'data' => $toko
        ], 200);
    }

    public function destroy(Toko $toko)
    {
        $toko->delete();
        return response()->json([
            'message' => 'Toko berhasil dihapus',
            'data' => null
        ], 200);
    }
}
