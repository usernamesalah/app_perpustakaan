<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use App\Models\Book;
use App\Models\BookDetail;
use App\Models\Borrow;
use App\Models\User;
use DB;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data = [
            'tot_members'   => Member::count(),
            'tot_title'     => $this->_totalTitle(),
            'tot_exemplar'  => $this->_totalExemplar(),
            'tot_borrow'    => Borrow::count(),
            'tot_admin'     => User::role('Admin')->count(),
            'chart1'        => $this->_dataChart1(),
            'chart2'        => $this->_dataChart2(),
        ];

        return view('admin.dashboard', $data);
    }

    function _totalTitle()
    {
        $books = Book::query()
            ->join('book_details', 'books.id', '=', 'book_details.book_id')
            ->join('location', 'book_details.location_id', '=', 'location.id');

        if (Auth::user()->location_id != '') {
            $books = $books->where('location.id', Auth::user()->location_id);
        }

        $books = $books->groupBy('books.id')
            ->select(DB::raw('count(books.id) as total'))
            ->get();
            
        return count($books);
    }

    function _totalExemplar()
    {
        $exemplar = BookDetail::query()
            ->join('location', 'book_details.location_id', '=', 'location.id');

        if (Auth::user()->location_id != '') {
            $exemplar = $exemplar->where('location.id', Auth::user()->location_id);
        }

        return $exemplar->count();
    }

    function _dataChart1()
    {
        $label = [];
        $total = [];
        for ($i = 0; $i <= 5; $i++)  {
            array_unshift($label, date("M-Y", strtotime( date( 'Y-m-01' )." -$i months")));
            
            $count = DB::table('shetabit_visits')
                ->whereYear('created_at', '=', date("Y", strtotime( date( 'Y-m-01' )." -$i months")))
                ->whereMonth('created_at', '=', date("m", strtotime( date( 'Y-m-01' )." -$i months")))
                ->count();

            array_unshift($total, $count);
        }

        $chart = array(
            'total'     => $total,
      		'label_all' => $label,
        );
        
        return $chart;
    }

    function _dataChart2()
    {
        $label = [];
        $total = [];

        $members = DB::table('members')
                    ->selectRaw('count(members.id) as total, gender.name as gender')
                    ->join('gender', 'members.gender', '=', 'gender.id')
                    ->groupBy('members.gender', 'gender.name')
                    ->get();

        foreach ($members as $key => $value) {
            array_unshift($label, $value->gender);
            array_unshift($total, $value->total);
        }

        $chart = array(
            'total'     => $total,
      		'label_all' => $label,
        );
        
        return $chart;
    }
}
