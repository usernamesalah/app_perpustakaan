<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;
use DB;
use Yajra\DataTables\DataTables;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'setting' => Setting::first(),
        ];

        return view('admin.setting.form', $data);
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
        //
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
        $data = [
            'denda'         => $request->input('denda'),
            'max_pinjam'    => $request->input('max_pinjam'),
            'hari_pinjam'   => $request->input('hari_pinjam'),
            'hari_extend'   => $request->input('hari_extend'),
            'alamat'        => $request->input('alamat'),
            'telpon'        => $request->input('telpon'),
            'email'         => $request->input('email'),
            'pemangku'      => $request->input('pemangku'),
            'nip_pemangku'  => $request->input('nip_pemangku'),
        ];

        $setting = Setting::find($id);
        $setting->update($data);

        return redirect()->route('admin.setting.index')
            ->with('success','Pengaturan berhasil dirubah!');
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
