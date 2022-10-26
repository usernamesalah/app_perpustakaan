<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Borrow;
use App\Models\Book;
use App\Models\BookDetail;
use App\Models\Member;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;
use DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::first();
        $data = [
            'setting' => $setting
        ];
        return view('admin.borrow.show', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $setting = Setting::first();
        $data = [
            'setting' => $setting
        ];
        return view('admin.borrow.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validasi = [
            'exemplar_id'   => 'required',
            'member_id'     => 'required',
        ];

        $validator = Validator::make($request->all(), $validasi);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
        
        try{
            DB::beginTransaction();

            $setting = Setting::first();

            Borrow::create([
                'user_id'     => Auth::user()->id,
                'exemplar_id' => $request->input('exemplar_id'),
                'member_id'   => $request->input('member_id'),
                'date_borrow' => Carbon::now(),
                'due_date'    => Carbon::now()->addDays($setting->hari_pinjam),
            ]);

            DB::commit();

        }catch(\Exception $e){
            DB::rollback();

            return response()->json([
                'status' => false,
                'msg' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'status' => true,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $borrow  = Borrow::find($id);
        $book    = BookDetail::with("book")->where('id', $borrow->exemplar_id)->first();
        $member  = Member::with("user")->where('id', $borrow->member_id)->first();
        $setting = Setting::first();
        $data = [
            'book'    => $book,
            'member'  => $member,
            'setting' => $setting
        ];
        return view('admin.borrow.detail', $data);
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
        Borrow::find($id)->delete();
        return response()->json([
            'status' => true,
        ]);
    }

    public function getBook($id) 
    {
        $book = BookDetail::with("book")
            ->where('id', $id)    
            ->first();

        return response()->json([
            'status' => true,
            'data'   => $book,
        ]);
    }

    public function getMember($id) 
    {
        $setting = Setting::first();
        $totals  = Borrow::where('member_id', $id)
            ->whereNull('date_return')
            ->count();

        if ($totals >= $setting->max_pinjam) 
        {
            return response()->json([
                'status' => false,
                'msg'    => 'Jumlah Peminjaman Buku sudah mencapai maksimal!',
            ]);
        }

        $member = Member::with("user")
            ->where('id', $id)    
            ->first();

        return response()->json([
            'status' => true,
            'data'   => $member,
        ]);
    }

    public function returnModal($id)
    {
        $borrow = Borrow::find($id);
        $date1  = Carbon::createFromFormat('Y-m-d', date("Y-m-d"));
        $date2  = Carbon::createFromFormat('Y-m-d', $borrow->due_date);
        
        // echo date("Y-m-d"); die;
        $denda = 0;
        if ($date1->gt($date2)) {
            $setting = Setting::first();
            $denda = $setting->denda;    
        }
        $data = [
            'borrow' => $borrow,
            'denda'  => $denda,
        ];
        return view('admin.borrow.return-modal', $data);
    }

    public function return(Request $request, $id)
    {
        $validasi = [
            'date_return' => 'required',
            'denda'       => 'required',
        ];

        $validator = Validator::make($request->all(), $validasi);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
        
        try{
            DB::beginTransaction();

            $borrow = Borrow::find($id);
            $borrow->update([
                'date_return' => $request->input('date_return'),
                'denda'       => $request->input('denda')
            ]);

            DB::commit();

        }catch(\Exception $e){
            DB::rollback();

            return response()->json([
                'status' => false,
                'msg' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'status' => true,
        ]);
    }

    public function extend(Request $request, $id)
    {
        try{
            DB::beginTransaction();

            $setting = Setting::first();
            $borrow  = Borrow::find($id);
            $borrow->update([
                'is_extend' => 1,
                'due_date'  => Carbon::now()->addDays($setting->hari_extend),
            ]);

            DB::commit();

        }catch(\Exception $e){
            DB::rollback();

            return response()->json([
                'status' => false,
                'msg' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'status' => true,
        ]);
    }

    public function getDataTables(Request $request)
    {
        $borrow = Borrow::join('members', 'members.id', '=', 'borrows.member_id')
            ->join('book_details', 'book_details.id', '=', 'borrows.exemplar_id')
            ->join('books', 'books.id', '=', 'book_details.book_id')
            ->select('borrows.*','books.title as book_title', 'book_details.code as book_code', 'members.name as member_name',
            DB::raw('(
                CASE 
                    WHEN borrows.date_return is not null THEN 1
                    WHEN DATE(NOW()) > borrows.due_date THEN 2
                    WHEN borrows.is_extend = 1 THEN 3
                ELSE 0 END) AS status')
            )
            ->orderBy('id','desc');

        return Datatables::of($borrow)
            ->make(true);
    }
}
