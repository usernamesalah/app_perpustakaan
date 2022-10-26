<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Member;
use App\Models\Gender;
use App\Models\Type;
use App\Models\Cart;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Yajra\DataTables\DataTables;
use DB;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.member.show');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'no_member' => $this->_generateNoMember(),
            'type'      => Type::all(),
            'gender'    => Gender::all()
        ];
        return view('admin.member.form', $data);
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
            if($request->hasFile('image')) {
                $upload_path = 'public/users/image';
                $filename = time().'_'.$request->file('image')->getClientOriginalName();
                $path = $request->file('image')->storeAs(
                    $upload_path, $filename
                );
            }

            $user = User::create([
                'name'     => $request->name,
                'username' => $request->email,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'image'    => $path,
                'status'   => $request->status,
                'email_verified_at' => now()
            ]);

            $user->assignRole('Member');

            $member = Member::create([
                'user_id'     => $user->id,
                'no_member'   => $this->_generateNoMember(),
                'no_identity' => $request->no_identity,
                'name'        => $request->name,
                'address'     => $request->address,
                'agency'      => $request->agency,
                'no_telp'     => $request->no_telp,
                'type'        => $request->type,
                'gender'      => $request->gender,
            ]);

            // event(new Registered($user));

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
            'type'     => Type::all(),
            'gender'   => Gender::all(),
            'member'   => Member::find($id),
        ];
        return view('admin.member.form', $data);
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

            $member = Member::find($id);
            $member->update([
                'no_identity' => $request->no_identity,
                'name'        => $request->name,
                'address'     => $request->address,
                'agency'      => $request->agency,
                'no_telp'     => $request->no_telp,
                'type'        => $request->type,
                'gender'      => $request->gender,
            ]);

            $user = User::find($member->user_id);
            $data = [
                'name'     => $request->name,
                'username' => $request->email,
                'email'    => $request->email,
                'status'   => $request->status,
            ];

            $path = '';
            if($request->hasFile('image')) {
                $upload_path = 'public/users/image';
                $filename = time().'_'.$request->file('image')->getClientOriginalName();
                $path = $request->file('image')->storeAs(
                    $upload_path, $filename
                );
                $data['image'] = $path;
            }

            if ($request->password) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            // event(new Registered($user));

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
        try{
            DB::beginTransaction();

            $member  = Member::find($id);
            $user_id = $member->user_id;
            Cart::where('member_id', $id)->delete();
            $member->delete();
            User::find($user_id)->delete();

            DB::commit();
        
        }catch(\Exception $e){
            DB::rollback();

            return response()->json([
                'status' => false,
                'msg'    => $e->getMessage(),
            ]);
        }

        return response()->json([
            'status' => true,
        ]);
    }

    public function getDataTables(Request $request)
    {
        $member = Member::orderBy('id','desc');
        return Datatables::of($member)
            ->make(true);
    }

    function _generateNoMember() 
	{ 
		$thbln = date("Y").date("m");
		
        $query = DB::table('members')
            ->select(DB::raw('MAX(CAST(SUBSTR(`no_member`, 7, 4) AS SIGNED)) AS code'))
            ->whereRaw('SUBSTR(`no_member`, 1, 6) = ?', [$thbln])
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
        $query = Member::query();
        
        if ($search = $request->input('search')) {
            $query->where('no_member','LIKE','%'.$search.'%');
        }

        $books = $query->offset(0)->limit(5)->get();

        return response()
            ->json(
                $books,
            200);
    }

    public function _rules(Request $request)
    {       
        $rules = [
            'no_identity' => ['required', 'string', 'unique:members', 'min:16'],
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'    => ['required', 'confirmed', Rules\Password::defaults()],
            'address'     => ['required', 'string'],
            'agency'      => ['required', 'string'],
            'no_telp'     => ['required', 'string'],
            'type'        => ['required', 'string'],
            'gender'      => ['required', 'string']
        ];

        if ($id = $request->id) {
            $rules['no_identity'] = ['required', 'string', 'unique:members,no_identity,'.$id];
            $member = Member::find($id);
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$member->user_id];
            if (empty($request->password)) {
                $rules['password'] = '';
            }
        }

        return $rules;
    }
}
