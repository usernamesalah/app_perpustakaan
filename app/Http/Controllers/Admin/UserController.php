<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Location;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        return view('admin.user.show', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'location'  => Location::all(),
            'roles'     => Role::whereNotIn('id', [2])->get()
        ];
        return view('admin.user.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id_role  = $request->id_role;
        $validasi = [
            'name'       => 'required|string|max:255',
            'username'   => 'required|min:5|unique:users',
            'password'   => 'required|string|confirmed|min:8',
            'image'      => 'mimes:jpg,bmp,png',
        ];

        if ($id_role == 'Petugas') {
            $validasi['location_id'] = 'required';
        }

        $request->validate($validasi);

        $path = '';
        if($request->hasFile('image')) {
            $upload_path = 'public/users/image';
            $filename = time().'_'.$request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs(
                $upload_path, $filename
            );
        }

        $data = [
            'name'         => $request->name,
            'username'     => $request->username,
            'email'        => $request->username,
            'password'     => Hash::make($request->password),
            'location_id'  => ($id_role == 'Petugas') ? $request->location_id : '',
            'image'        => $path,
            'status'       => 1,
            'email_verified_at' => now()
        ];

        $user = User::create($data);
        $user->assignRole($id_role);

        return redirect()->route('admin.users.index')
            ->with('success','Admin berhasil ditambahkan!');
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
        $user = User::find($id);
        foreach($user->getRoleNames() as $v){
            $roleName = $v;
        }
        $data = [
            'location'  => Location::all(),
            'user'      => $user,
            'roles'     => Role::whereNotIn('id', [2])->get(),
            'roleName'  => $roleName,
        ];
        return view('admin.user.form', $data);
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
        $id_role  = $request->id_role;
        $validasi = [
            'name'       => 'required|string|max:255',
            'username'   => 'required|unique:users,username,'.$id,
            'password'   => 'same:confirm-password',
            'image'      => 'mimes:jpg,bmp,png',
        ];

        if ($id_role == 'Petugas') {
            $validasi['location_id'] = 'required';
        }

        $request->validate($validasi);

        $input = [
            'name'         => $request->name,
            'username'     => $request->username,
            'email'        => $request->username,
            'location_id'  => ($id_role == 'Petugas') ? $request->location_id : '',
        ];

        if(!empty($request->password)){ 
            $input['password'] = Hash::make($request->password);
        }

        $path = '';
        if($request->hasFile('image')) {
            $upload_path = 'public/users/image';
            $filename = time().'_'.$request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs(
                $upload_path, $filename
            );
            $input['image'] = $path;
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $id_role = $request->id_role;
        $user->assignRole($id_role);
    
        return redirect()->route('admin.users.index')
            ->with('success','Admin berhasil dirubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();

        return response()->json([
            'status' => true,
        ]);
    }

    public function getDataTables(Request $request)
    {
        $users = User::doesntHave('Member')->orderBy('id','DESC');
        return Datatables::of($users)
            ->addColumn('role',function(User $users){
                foreach($users->getRoleNames() as $v){
                    return $v;
                }
            })
            ->make(true);
    }
}
