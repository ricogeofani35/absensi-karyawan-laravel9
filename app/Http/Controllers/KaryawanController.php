<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaryawanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admins.karyawan.karyawan');
    }

    public function api()
    {
        $karyawans = Karyawan::all();
        $api_karyawans = datatables()->of($karyawans)->addIndexColumn();

        return $api_karyawans->make(true);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama'      => 'required',
            'ttl'       => 'required',
            'email'     => 'required|unique:karyawans',
            'no_telp'   => 'required',
            'alamat'    => 'required',
            'jabatan'   => 'required',
        ]);

        Karyawan::create([
            'nama'      => $request->nama,
            'ttl'       => $request->ttl,
            'email'       => $request->email,
            'no_telp'       => $request->no_telp,
            'alamat'       => $request->alamat,
            'jabatan'       => $request->jabatan,
        ]);

        return redirect('/karyawan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
