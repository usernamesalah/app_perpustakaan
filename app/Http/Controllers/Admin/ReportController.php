<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Exports\MembersExport;
use App\Exports\BooksExport;
use App\Exports\BookIndukExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Carbon\Carbon;
use App\Models\Setting;
use App\Models\BookDetail;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.report.form');
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

    public function member_export(Request $request)
	{
        $extension = '_member_export_'.$request->get('extension');
        return $this->{$extension}($request);
    }

    function _member_export_excel(Request $request)
	{
        $tgl_awal  = $request->get('tgl_awal');
        $tgl_akhir = $request->get('tgl_akhir');
        $filename  = $request->get('type');;
        return Excel::download(
            new MembersExport($tgl_awal, $tgl_akhir, $filename), 
            $filename.'.xlsx'
        );
    }

    function _member_export_pdf(Request $request)
	{
        $tgl_awal  = $request->get('tgl_awal');
        $tgl_akhir = $request->get('tgl_akhir');
        $filename  = $request->get('type');

        switch ($filename) {
            case 'Laporan Anggota Berdasarkan Jenis Keanggotaan':
                $report = DB::table('members')
                    ->selectRaw('count(members.id) as total, type.name as type')
                    ->rightJoin('type', 'members.type', '=', 'type.id')
                    ->whereRaw("members.created_at BETWEEN ? AND ?", [$tgl_awal." 00:00:00", $tgl_akhir." 23:59:59"])
                    ->groupBy('type.name')
                    ->get();
                $view = 'admin.report.pdf.pdf_1';
                break;
            case 'Laporan Anggota Berdasar Jenis Kelamin':
                $report = DB::table('members')
                    ->selectRaw('count(members.id) as total, gender.name as gender')
                    ->rightJoin('gender', 'members.gender', '=', 'gender.id')
                    ->whereRaw("members.created_at BETWEEN ? AND ?", [$tgl_awal." 00:00:00", $tgl_akhir." 23:59:59"])
                    ->groupBy('gender.name')
                    ->get();
                $view = 'admin.report.pdf.pdf_2';
                break;
            default:
                //
        }

        $data = [
            'type'         => $filename,
            'tgl_awal'     => Carbon::createFromFormat('Y-m-d', $tgl_awal)->format('d-m-Y'),
            'tgl_akhir'    => Carbon::createFromFormat('Y-m-d', $tgl_akhir)->format('d-m-Y'),
            'tgl_sekarang' => Carbon::now()->isoFormat('Do MMMM YYYY'),
            'members'      => $report,
            'setting'      => Setting::first(),
        ];
        // return view($view, $data);
        $pdf = PDF::loadView($view, $data);
        return $pdf->stream($filename.'.pdf');
    }

    public function book_export(Request $request)
	{
        $extension = '_book_export_'.$request->get('extension');
        return $this->{$extension}($request);
    }

    function _book_export_excel(Request $request)
	{
        $tgl_awal  = $request->get('tgl_awal');
        $tgl_akhir = $request->get('tgl_akhir');
        $filename  = $request->get('type');
        return Excel::download(
            new BooksExport($tgl_awal, $tgl_akhir, $filename), 
            $filename.'.xlsx'
        );
    }

    function _book_export_pdf(Request $request)
	{
        $tgl_awal  = $request->get('tgl_awal');
        $tgl_akhir = $request->get('tgl_akhir');
        $filename  = $request->get('type');
        
        switch ($filename) {
            case 'Laporan Buku Berdasar Sumber Perolehan':
                $report = DB::table('books')
                    ->selectRaw('source.name as sumber, count(books.id) as total_judul, count(book_details.id) as total_exemplar')
                    ->leftJoin('book_details', 'book_details.book_id', '=', 'books.id')
                    ->rightJoin('source', 'source.id', '=', 'book_details.source_id')
                    ->whereRaw("book_details.created_at BETWEEN ? AND ?", [$tgl_awal." 00:00:00", $tgl_akhir." 23:59:59"])
                    ->groupBy('source.name');
                $view = 'admin.report.pdf.pdf_3';
                break;
            case 'Laporan Buku Berdasar Klasifikasi':
                $report = DB::table('books')
                    ->selectRaw('category.name as category, count(books.id) as total_judul, count(book_details.id) as total_exemplar')
                    ->leftJoin('book_details', 'book_details.book_id', '=', 'books.id')
                    ->rightJoin('category', 'category.id', '=', 'books.category_id')
                    ->whereRaw("book_details.created_at BETWEEN ? AND ?", [$tgl_awal." 00:00:00", $tgl_akhir." 23:59:59"])
                    ->groupBy('category.name');
                $view = 'admin.report.pdf.pdf_4';
                break;
            default:
                //
        }

        if (Auth::user()->location_id != '') {
            $report = $report->where('book_details.location_id', Auth::user()->location_id);
        }

        $report = $report->get();

        $data = [
            'type'         => $filename,
            'tgl_awal'     => Carbon::createFromFormat('Y-m-d', $tgl_awal)->format('d-m-Y'),
            'tgl_akhir'    => Carbon::createFromFormat('Y-m-d', $tgl_akhir)->format('d-m-Y'),
            'tgl_sekarang' => Carbon::now()->isoFormat('Do MMMM YYYY'),
            'books'        => $report,
            'setting'      => Setting::first(),
        ];

        $pdf = PDF::loadView($view, $data);
        return $pdf->stream($filename.'.pdf');
    }

    public function book_induk_export(Request $request)
	{
        $extension = '_bookinduk_export_'.$request->get('extension');
        return $this->{$extension}($request);
    }

    function _bookinduk_export_excel(Request $request)
	{
        $tgl_awal  = $request->get('tgl_awal');
        $tgl_akhir = $request->get('tgl_akhir');
        $filename  = $request->get('type');
        return Excel::download(
            new BookIndukExport($tgl_awal, $tgl_akhir, $filename), 
            $filename.'.xlsx'
        );
    }

    function _bookinduk_export_pdf(Request $request)
	{
        $tgl_awal  = $request->get('tgl_awal');
        $tgl_akhir = $request->get('tgl_akhir');
        $filename  = $request->get('type');
        
        $report = BookDetail::whereRaw("created_at BETWEEN ? AND ?", [$tgl_awal." 00:00:00", $tgl_akhir." 23:59:59"]);

        if (Auth::user()->location_id != '') {
            $report = $report->where('location_id', Auth::user()->location_id);
        }

        $report = $report->get();

        $data = [
            'type'         => $filename,
            'tgl_awal'     => Carbon::createFromFormat('Y-m-d', $tgl_awal)->format('d-m-Y'),
            'tgl_akhir'    => Carbon::createFromFormat('Y-m-d', $tgl_akhir)->format('d-m-Y'),
            'tgl_sekarang' => Carbon::now()->isoFormat('Do MMMM YYYY'),
            'books'        => $report,
            'setting'      => Setting::first(),
        ];
        
        $view = 'admin.report.pdf.pdf_5';
        $pdf  = PDF::loadView($view, $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream($filename.'.pdf');
    }
}
