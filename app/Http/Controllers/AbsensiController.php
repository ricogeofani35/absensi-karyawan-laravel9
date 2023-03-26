<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
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
        
        $id = Auth::user()->id;

        $absensi = Absensi::with('user')->where('user_id', $id)->orderBy('id', 'desc')->first();
        return view('admins.absensi.absensi', compact('absensi'));
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Absensi::create([
            'tanggal_absen'     => date('d-m-y'),
            'absen_masuk'       => $request->absen_masuk,
            'tidak_masuk'       => $request->tidak_masuk,
            'status'            => 0,
            'user_id'           => Auth::user()->id,
        ]);

        return back();
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
        $file = $request->file('file_ijin');
   
        //Display File Name
        $file->getClientOriginalName();
     
        //Display File Extension
        $file->getClientOriginalExtension();
     
        //Display File Real Path
        $file->getRealPath();
     
        //Display File Size
        $file->getSize();
     
        //Display File Mime Type
        $file->getMimeType();
     
        //Move Uploaded File
        $destinationPath = 'uploads';
        $file->move($destinationPath,$file->getClientOriginalName());
 
        //  name post to database
        $absensi = Absensi::find($id);
        
        $absensi->status = 1;
        $absensi->file_ijin = $file->getClientOriginalName();
        $absensi->save();

        return redirect('/absensi');
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
