<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\web\ProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use function Symfony\Component\String\u;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $data['user'] = $user;
        return view('web.pages.profile')->with($data);
    }
    public function update(ProfileRequest $request, $id)
    {
        $input = $request->all();
        try {
            $user = User::find($id);
            if (!$user) {
                abort(404);
            }
            $user->name = $input['name'];
            $user->email = $input['email'];
            $user->phone = $input['phone'];
            if (!$input['password']){
                $user->password = bcrypt($input['password']);
            }
            if ($input['avata']){
                $user->avata = $input['avata'];
            }
            $user->save();
            return redirect()->back()->with(['success' => __('register.update_ss')]);
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => __('register.update_f')]);
        }
    }
}
