<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Uspdev\Replicado\Pessoa;
use App\Models\User;

class LoginAdminController extends Controller
{
    public function show(){
        $this->authorize('admin');
        return view('login_admin.login');
    }

    public function login(Request $request){
        $this->authorize('admin');
        $request->validate([
            'codpes' => 'required|integer',
        ]);

        $pessoa = Pessoa::dump($request->codpes);
        if(!$pessoa) {
            $request->session()->flash('alert-danger', 'Não foi possível logar com essa pessoa');
            return redirect('/login_admin');
        }

        $user = User::where('codpes',$request->codpes)->first();
        if (is_null($user)) {
            $user = new User;
            $user->codpes = $request->codpes;
            $user->email = Pessoa::emailusp($request->codpes);
            $user->name = $pessoa['nompes'];
            $user->save();
        } 
        auth()->login($user, true);
        return redirect('/home');
        
    }
}