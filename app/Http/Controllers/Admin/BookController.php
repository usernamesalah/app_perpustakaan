<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookDetail;
use App\Models\Author;
use App\Models\Location;
use App\Models\Category;
use App\Models\Source;
use App\Models\Status;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Yajra\DataTables\DataTables;
use Cviebrock\EloquentSluggable\Services\SlugService;
use DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.book.show');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'location' => Location::all(),
            'category' => Category::all(),
            'source'   => Source::all(),
            'status'   => Status::all()
        ];
        return view('admin.book.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules     = $this->_rules($request);
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        try{
            DB::beginTransaction();

            $path = '';
            if($request->hasFile('book_main_image')) {
                $upload_path = 'public/book_cover';
                $filename = time().'_'.$request->file('book_main_image')->getClientOriginalName();
                $path = $request->file('book_main_image')->storeAs(
                    $upload_path, $filename
                );
            }

            $book = Book::create([
                'title'             => $request->title,
                'synopsis'          => $request->synopsis,
                'author_id'         => $request->author_id,
                'category_id'       => $request->category_id,
                'publisher_id'      => $request->publisher_id,
                'isbn'              => $request->isbn,
                'year_publication'  => $request->year_publication,
                'jumlah_halaman'    => $request->jumlah_halaman,
                'panjang'           => $request->panjang,
                'lebar'             => $request->lebar,
                'berat'             => $request->berat,
                'book_main_image'   => $path,
                'slug'              => SlugService::createSlug(Book::class, 'slug', $request->title)
            ]);

            if ($details = $request->input('details')) 
            {
                foreach ($details as $key => $value) 
                {
                    BookDetail::create([
                        'book_id'     => $book->id,
                        'location_id' => $value['location'],
                        'position'    => $value['position'],
                        'source_id'   => $value['source'],
                        'price'       => $value['price'],
                        'status_id'   => $value['status'],
                        'code'        => $value['code'],
                    ]);
                }
            }

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
        $data = [
            'location'  => Location::all(),
            'category'  => Category::all(),
            'status'    => Status::all(),
            'source'    => Source::all(),
            'book'      => Book::find($id),
        ];

        $exemplars = BookDetail::where('book_id', $id);
        if (Auth::user()->location_id != '') {
            $exemplars = $exemplars->where('location_id', Auth::user()->location_id);
        }
        $data['exemplars'] = $exemplars->get();

        return view('admin.book.form', $data);
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
        $rules     = $this->_rules($request);
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        try{
            DB::beginTransaction();

            $dataBook = [
                'title'             => $request->title,
                'synopsis'          => $request->synopsis,
                'author_id'         => $request->author_id,
                'category_id'       => $request->category_id,
                'publisher_id'      => $request->publisher_id,
                'isbn'              => $request->isbn,
                'year_publication'  => $request->year_publication,
                'jumlah_halaman'    => $request->jumlah_halaman,
                'panjang'           => $request->panjang,
                'lebar'             => $request->lebar,
                'berat'             => $request->berat,
                'slug'              => SlugService::createSlug(Book::class, 'slug', $request->title)
            ];
            
            $path = '';
            if($request->hasFile('book_main_image')) {
                $upload_path = 'public/book_cover';
                $filename = time().'_'.$request->file('book_main_image')->getClientOriginalName();
                $path = $request->file('book_main_image')->storeAs(
                    $upload_path, $filename
                );
                $dataBook['book_main_image'] = $path;
            }

            $book = Book::find($id);
            $book->update($dataBook);

            if ($details = $request->input('details')) 
            {
                $arr_id = array_filter(array_column($details, 'id'));
                $bookDetails = BookDetail::whereNotIn('id', $arr_id)
                    ->where('book_id',$book->id);
                if (Auth::user()->location_id != '') {
                    $bookDetails = $bookDetails->where('location_id', Auth::user()->location_id);
                }
                $bookDetails->delete();

                foreach ($details as $key => $value) 
                {
                    $dataDetail = [
                        'book_id'     => $book->id,
                        'location_id' => $value['location'],
                        'position'    => $value['position'],
                        'source_id'   => $value['source'],
                        'price'       => $value['price'],
                        'status_id'   => $value['status'],
                    ];

                    $detail_id = $value['id'];
                    if ($detail_id != '') {
                        $bookDetail = BookDetail::find($detail_id); 
                        $bookDetail->update($dataDetail);
                    } 
                    else {
                        $dataDetail['code'] = $value['code'];
                        BookDetail::create($dataDetail);
                    }
                }
            }

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detail = BookDetail::where('book_id', $id);
        if ($location_id = Auth::user()->location_id) {
            $detail = $detail->where('location_id', $location_id);
        }
        $detail->delete();
        
        $cek = BookDetail::where('book_id', $id)->get();
        if (!$cek) {
            Book::find($id)->delete();
        }
        
        return response()->json([
            'status' => true,
        ]);
    }

    public function getDataTables(Request $request)
    {
        $books = DB::table('books')
            ->join('book_details', 'books.id', '=', 'book_details.book_id')
            ->join('location', 'book_details.location_id', '=', 'location.id')
            ->join('category', 'books.category_id', '=', 'category.id')
            ->join('authors', 'books.author_id', '=', 'authors.id')
            ->join('publishers', 'books.publisher_id', '=', 'publishers.id')
            ->select('books.id', 'books.title', 'books.isbn', 'authors.name as author_name', 'category.name as category_name', 'publishers.name as publisher_name', DB::raw('COUNT(books.id) AS exemplar'))
            ->groupBy('books.id', 'books.title', 'books.isbn', 'authors.name', 'category.name', 'publishers.name');

        if (Auth::user()->location_id != '') {
            $books = $books->where('location.id', Auth::user()->location_id);
        }

        $books->orderBy('books.id','desc');

        return Datatables::of($books)
            ->make(true);
    }

    public function ajaxModal($id)
    {
        $exemplars = BookDetail::where('book_id', $id);
        if (Auth::user()->location_id != '') {
            $exemplars = $exemplars->where('location_id', Auth::user()->location_id);
        }
        $data = [
            'exemplars' => $exemplars->get()
        ];
        return view('admin.book.ajax-modal', $data);
    }

    public function barcode($id)
    {
        $data = [
            'exemplar' => BookDetail::find($id),
        ];

        return view('admin.book.barcode', $data);
    }

    function _generateCode() 
	{ 
		$thbln = date("Y").date("m");
		
        $query = DB::table('book_details')
            ->select(DB::raw('MAX(CAST(SUBSTR(`code`, 7, 4) AS SIGNED)) AS code'))
            ->whereRaw('SUBSTR(`code`, 1, 6) = ?', [$thbln])
            ->first();
		
		if ($query != null) {
			$last_number = $query->code + 1; 
			$code = date("Y").date("m").sprintf("%04d", $last_number);
		} else {
            $code = date("Y").date("m").'0001';
		}
		
		return $code;
	}

    public function ajaxSearch(Request $request)
    {
        $query = BookDetail::with('book')
            ->whereNotIn('id', function($q) {
                $q->select('exemplar_id')->from('borrows')->whereNull('date_return');
            });
        
        if ($search = $request->input('search')) {
            $query->where('code','LIKE','%'.$search.'%');
        }

        $books = $query->offset(0)->limit(5)->get();

        return response()
            ->json(
                $books,
            200);
    }

    public function cekIsbn($isbn)
    {
        $data = DB::table('books')
            ->where('isbn', $isbn)->first();

        return response()->json([
            'status' => ($data) ? true : false,
            'data'   => $data,
        ]);
    }

    public function _rules(Request $request)
    {       
        $rules = [
            'title' => ['required'],
            'isbn'  => ['required', 'unique:books'],
        ];

        if ($id = $request->id) {
            $rules['isbn'] = ['required', 'unique:books,isbn,'.$id];
        }

        return $rules;
    }
}
