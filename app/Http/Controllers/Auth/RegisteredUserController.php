<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Member;
use App\Models\Gender;
use App\Models\Type;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data = [
            'type'   => Type::all(),
            'gender' => Gender::all()
        ];
        return view('auth.register', $data);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_identity' => ['required', 'string', 'unique:members', 'min:16'],
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'    => ['required', 'confirmed', Rules\Password::defaults()],
            'address'     => ['required', 'string'],
            // 'agency'      => ['required', 'string'],
            'no_telp'     => ['required', 'string'],
            'type'        => ['required', 'string'],
            'gender'      => ['required', 'string'],
            'image'       => 'mimes:jpg,bmp,png|max:2000',
        ]);

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
            'status'   => 1,
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

        event(new Registered($user));

        Auth::login($user);

        // return redirect(RouteServiceProvider::HOME);

        return redirect()->route('profile.index');
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
}
