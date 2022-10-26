<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Book;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use DB;

class BooksController extends Controller
{
    public function search(Request $request)
    {
        $pagination  = 20;
        $books = Book::join('authors', 'books.author_id', '=', 'authors.id')
            ->join('publishers', 'books.publisher_id', '=', 'publishers.id')
            ->when($request->keyword, function ($query) use ($request) {
                $query
                    ->where('title', 'like', "%{$request->keyword}%")
                    ->orWhere('authors.name', 'like', "%{$request->keyword}%")
                    ->orWhere('publishers.name', 'like', "%{$request->keyword}%");
                })->orderBy('books.created_at', 'desc')
            ->paginate($pagination)->withQueryString();

        $books->appends($request->only('keyword'));

        $data = [
            'search' => $request->keyword,
            'books'  => $books
        ];
        return view('books', $data);
    }

    public function getBook($slug)
    {
        $book = Book::where('slug', $slug)->first();
        
        $exemplars = DB::table('book_details')
            ->selectRaw('count(book_details.id) as total, location.name as location_name, book_details.position')
            ->join('location', 'book_details.location_id', '=', 'location.id')
            ->groupBy('location_name', 'position')
            ->where('book_id', $book->id)
            ->get();
        
        $totals = DB::table('book_details')
            ->where('book_id', $book->id)
            ->count();

        $disabled = 'disabled';
        if (Auth::check()) 
        {
            if (Auth::user()->hasRole('Member')) 
            {
                $member = Auth::user()->member;   
                $cart = Cart::where('member_id', $member->id)
                    ->where('book_id', $book->id);
                $disabled = ($cart->exists()) ? 'disabled' : '';
            }
        }

        $data = [
            'search'    => str_replace("-"," ", $slug),
            'book'      => $book,
            'exemplars' => $exemplars,
            'totals'    => $totals,
            'disabled'  => $disabled
        ];

        return view('book_detail', $data);
    }
}
