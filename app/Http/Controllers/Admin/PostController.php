<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.post.show');
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
        $post = Post::find($id);
        $data = [
            'post'   => $post,
            'status' => array('Publish', 'Pending'),
        ];
        return view('admin.post.form', $data);
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
        $validasi = [
            'title'     => 'required',
            'content'   => 'required',
            'status'    => 'required',
        ];

        $request->validate($validasi);
    
        $post = Post::find($id);
        $post->update([
            'title'        => $request->title,
            'content'      => $request->content,
            'status'       => $request->status,
        ]);
    
        return redirect()->route('admin.posts.index')
            ->with('success','Data berhasil diupdated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::find($id)->delete();

        return response()->json([
            'status' => true
        ]);
    }

    public function getDataTables(Request $request)
    {
        $query = DB::table('posts')
            ->select('posts.*',
                DB::raw("DATE_FORMAT(posts.created_at, '%d-%m-%Y') as tanggal")
            );
        
        return DataTables::of($query)->toJson();
    }

    public function upload(Request $request)
	{   
        $validasi = [
            'file'  => 'required|mimes:jpg,bmp,png',
        ];

        $validator = Validator::make($request->all(), $validasi);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => false,
                'error'  => $errors->first('file')
            ]);
        }

        $path = '';
        if($request->hasFile('file')) {
            $upload_path = 'public/posts';
            $filename = time().'_'.$request->file('file')->getClientOriginalName();
            $path = $request->file('file')->storeAs(
                $upload_path, $filename
            );
            $json['url'] = url(Storage::url($path));
        }

		return response()->json($json);
    }
}
