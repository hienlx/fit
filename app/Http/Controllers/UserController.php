<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $req)
    {
        $users = User::paginate(10);
        $roles = Role::orderBy('id')->pluck('desc', 'id');
        return view('users.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required|unique:users|alpha_dash',
            'email' => 'sometimes|nullable|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['role'] = $input['roles'][0];
        if (auth()->user()->roles()->pluck('id')->min() >= intval($input['role'])) {
            Toastr::error("Bạn không thể gắn quyền với quyền lớn hơn.");
            return back()->withInput();
        }
        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        if ($request->get('url')){
            return redirect()->to($request->get('url'))
                ->with('success','Tạo mới thành công!');
        }
        return redirect()->route('users.index')
            ->with('success', 'Tạo mới thành công!');
    }
}
