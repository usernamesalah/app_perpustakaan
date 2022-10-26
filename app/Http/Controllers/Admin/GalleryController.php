<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\GalleryDirectory;
use App\Models\GalleryFiles;
use Illuminate\Support\Facades\Storage;
// use Illuminate\Filesystem\Filesystem;
// use Illuminate\Contracts\Filesystem;
use Illuminate\Filesystem;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.gallery.show');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['images'] = array();
        return view('admin/pages/gallery-form', $data);
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

    public function createFolder(Request $request)
	{
        $validator = Validator::make($request->all(), array(
            'title' => 'required',
            'description' => 'required'
        ));

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
		
        GalleryDirectory::create([
            'title' => $request->input('title'),
            'description' => $request->input('description')
        ]);
            
        return response()->json([
            'status' => true
        ]);
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

        $id_directory = $request->input('id_directory');
        //echo $id_directory; die;
        $path = '';
        if($request->hasFile('file')) {
            $upload_path = 'public/gallery';
            $originalname = $request->file('file')->getClientOriginalName();
            $filename = time().'_'.$request->file('file')->getClientOriginalName();
            $path = $request->file('file')->storeAs(
                $upload_path, $filename
            );
        }

        GalleryFiles::create([
            'id_directory' => $id_directory,
            'path'         => $path,
            'file_name'    => $originalname,
        ]);

		return response()->json([
            'status'  => true,
            'success' => 'Success: berhasil di upload!',
        ]);
    }
    
    public function getDirectory()
    {
        $directory = GalleryDirectory::get();

        return response()->json([
            'directory' => $directory,
        ]);
    }

    public function getFiles($id_directory)
    {
        $files = GalleryFiles::where('id_directory',$id_directory)->get();

        return response()->json([
            'files' => $files,
        ]);
    }

    public function delete(Request $request) 
	{
		if ($request->input('path')) {
			$paths = $request->input('path');
		} else {
			$paths = array();
		}

		if (!empty($paths)) {
            //echo var_dump($paths); die;
			foreach ($paths as $path) {
                //echo $path; die;
				if (Storage::disk('public')->exists(str_replace('public', '', $path))) {
                    Storage::delete($path);
                    GalleryFiles::where('path', $path)->delete();
				} else {
                    $directory = GalleryDirectory::find($path);
                    // $files = glob($path.'/*'); //get all file names
                    $files = GalleryFiles::where('id_directory', $directory->id);
                    foreach($files as $file){
                        // if(is_file($file))
                        // unlink($file); //delete file
                        Storage::delete($file->path);
                    }
                    // rmdir($path);
                    // echo $path; die;
                    // Storage::deleteDirectory($path);
                    GalleryFiles::where('id_directory', $directory->id)->delete();
                    GalleryDirectory::where('id', $directory->id)->delete();
				}
			}
		}

		$json['success'] = 'Success: Your file or directory has been deleted!';

		return response()->json($json);
	}
}
