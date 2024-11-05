<?php

namespace App\Http\Controllers;

use App\Models\Akun; // Import the Akun model
use Illuminate\Http\Request;

class AkunController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $akuns = Akun::all(); // Get all accounts
        return view('akun', compact('akuns')); // Pass accounts to the view
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $request->validate([
            'no_akun' => 'required|string|max:255',
            'nama_akun' => 'required|string|max:255',
            'tipe_akun' => 'required|in:d,k',
        ]);

        Akun::create($request->all()); // Create a new account

        return redirect()->route('akun.index')->with('success', 'Akun berhasil ditambahkan.'); // Redirect with success message
    }

    // Update the specified resource in storage.
    public function update(Request $request, Akun $akun)
    {
        $request->validate([
            'no_akun' => 'required|string|max:255',
            'nama_akun' => 'required|string|max:255',
            'tipe_akun' => 'required|in:d,k',
        ]);

        $akun->update($request->all()); // Update the account
        return redirect()->route('akun.index')->with('success', 'Akun berhasil diupdate.'); // Redirect with success message
    }

    // Remove the specified resource from storage.
    public function destroy(Akun $akun)
    {
        $akun->delete(); // Delete the account
        return redirect()->route('akun.index')->with('success', 'Akun berhasil dihapus.'); // Redirect with success message
    }
}
