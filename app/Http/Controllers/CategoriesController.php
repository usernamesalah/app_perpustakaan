<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Book;
use DB;

class CategoriesController extends Controller
{
    public function getBooks($slug)
    {
        $category  = Category::where('slug', $slug)->first();
        $books     = Book::query();
        if ($category) {
            $books = $books->where('category_id', $category->id);
        } 
        $filter_by = request()->query('filter_by');
        $keyword   = request()->query('keyword');
        
        switch ($filter_by) {
            case 'judul':
                $books = $books->where('title', 'like', '%' . $keyword . '%');
                break;

            case 'pengarang':
                $books = $books->join('authors', 'books.author_id', '=', 'authors.id')
                    ->where('authors.name', 'like', '%' . $keyword . '%');
                break;

            case 'penerbit':
                $books = $books->join('publishers', 'books.publisher_id', '=', 'publishers.id')
                    ->where('publishers.name', 'like', '%' . $keyword . '%');
                break;
            
            default:
                # code...
                break;
        }

        $books = $books->orderBy('books.created_at', 'desc');
        $search = request()->query('keyword') ?? $slug;
        $data = [
            'slug'     => $slug,
            'search'   => str_replace("-"," ", $search),
            'books'    => $books->paginate(20)->withQueryString(),
            'category' => Category::all(),
        ];
        return view('books', $data);
    }
}
