<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\GalleryFiles;
use DB;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $query = DB::table('polling')
                ->select(
                    DB::raw('SUM(sangatbaik) as sangatbaik'),
                    DB::raw('SUM(baik) as baik'),
                    DB::raw('SUM(cukup) as cukup'),
                    DB::raw('SUM(kurang) as kurang')
                )
                ->first();

        $total = DB::table('polling')->count();

        $polling = [
            'sangatbaik' => ( $total == 0 ) ? 0 : round(($query->sangatbaik * 100) / $total),
            'baik'       => ( $total == 0 ) ? 0 : round(($query->baik * 100) / $total),
            'cukup'      => ( $total == 0 ) ? 0 : round(($query->cukup * 100) / $total),
            'kurang'     => ( $total == 0 ) ? 0 : round(($query->kurang * 100) / $total),
        ];

        //var_dump($polling); die;

        $data = [
            'gallery' => GalleryFiles::where('id_directory', 8)->get(),
            'polling' => $polling,
        ];
        return view('welcome', $data);
    }
}
