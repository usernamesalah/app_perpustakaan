<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use App\Models\User;
use App\Models\Member;
use App\Models\Gender;
use App\Models\Type;
use Illuminate\Support\Facades\Validator;
use App\Models\Borrow;
use Yajra\DataTables\DataTables;
use DB;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = [
            'profile' => Member::where('user_id', $user->id)->first(),
            'type'    => Type::all(),
            'gender'  => Gender::all(),
        ];
        //var_dump($data); die;
        return view('profile', $data);
    }

    public function update(Request $request)
    {
        //
    }

    public function updateProfileInformation(Request $request)
    {
        $user = Auth::user();
        $member = Member::where('user_id', $user->id)->first();

        $rules = [
            'no_identity' => ['required', 'string', 'unique:members,no_identity,'.$member->id],
            'name'        => ['required', 'string', 'max:255'],
            'address'     => ['required', 'string'],
            'agency'      => ['required', 'string'],
            'no_telp'     => ['required', 'string'],
            'type'        => ['required', 'string'],
            'gender'      => ['required', 'string'],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        try{
            DB::beginTransaction();

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
                //'status'   => $request->status,
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

    function updatePassword(Request $request)
    {
        $rules = [
            'current_password' => 'required',
            'password' => 'required|string|confirmed|min:8',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        $user = Auth::user();
        if (! Hash::check($request->input('current_password'), $user->password)) {
            return response()->json([
                'status' => false,
                'errors' => [
                    'current_password' => 'Password yang dimasukan salah',
                ]
            ]);
        }

        $user->forceFill([
            'password' => Hash::make($request->input('password')),
        ])->save();

        return response()->json([
            'status' => true,
        ]);
    }

    public function card()
    {
        $user = Auth::user();
        $data = [
            'profile' => Member::with("user")->where('user_id', $user->id)->first(),
            'type'    => Type::all(),
            'gender'  => Gender::all(),
        ];
        //var_dump($data); die;
        return view('member-card', $data);
    }

    public function getDataTables(Request $request)
    {
        $user   = Auth::user();
        $borrow = Borrow::join('members', 'members.id', '=', 'borrows.member_id')
            ->join('book_details', 'book_details.id', '=', 'borrows.exemplar_id')
            ->join('books', 'books.id', '=', 'book_details.book_id')
            ->select('borrows.*','books.title as book_title', 'books.slug as slug', 'book_details.code as book_code', 'members.name as member_name',
            DB::raw('(
                CASE 
                    WHEN borrows.date_return is not null THEN 1
                    WHEN DATE(NOW()) > borrows.due_date THEN 2
                    WHEN borrows.is_extend = 1 THEN 3
                ELSE 0 END) AS status')
            )
            ->where('members.user_id', $user->id)
            ->orderBy('id','desc');

        return Datatables::of($borrow)
            ->make(true);
    }
}
