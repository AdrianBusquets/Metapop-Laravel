<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('isAdmin');
    }
    public function index(){
        $users = User::all();
        $roles = Role::all();
        $revisorRole = Role::where('name', 'revisor')->first();
        $reviewers = $revisorRole ? $revisorRole->users : collect();
        $ad = Ad::where('is_accepted', null)
                        ->orderBy('created_at', 'desc')
                        ->first();
        return view('admin.home', compact('users','roles', 'reviewers', 'ad'));
    }

    // public function assignReviewer(Request $request, User $user)
    // {
    //     $revisorRoleID = Role::where('name', 'revisor')->first()->id;
    //     if (!$user->roles->contains($revisorRoleID)) {
    //         $user->roles()->attach($revisorRoleID);
    //         return redirect()->back()->withMessage(['type' => 'success', 'text' => 'Rol de Revisor asignado correctamente']);
    //     } else {
    //         return redirect()->back()->withMessage(['type' => 'warning', 'text' => 'El usuario ya tiene el rol de Revisor']);
    //     }
    // }
    public function assignReviewer(Request $request, User $user)
{
    $revisorRole = Role::where('name', 'revisor')->first();
    if ($revisorRole) {
        $revisorRoleID = $revisorRole->id;
        if (!$user->roles->contains($revisorRoleID)) {
            $user->roles()->attach($revisorRoleID);
            return redirect()->back()->withMessage(['type' => 'success', 
                                                    'text' => 'Rol de Revisor asignado correctamente']);
        } else {
            return redirect()->back()->withMessage(['type' => 'warning', 
                                                    'text' => 'El usuario ya tiene el rol de Revisor']);
        }
    } else {
        return redirect()->back()->withMessage(['type' => 'error', 
                                                'text' => 'El rol de Revisor no está definido']);
    }
}


    public function removeReviewer(Request $request, User $user)
{
    $reviewerRoleID = Role::where('name', 'revisor')->first()->id;
    $user->roles()->detach($reviewerRoleID);
    return redirect()->back()->withMessage(['type' => 'success', 'text' => 'El usuario ya no es revisor']);
}

    public function acceptAd (Ad $ad) {
        $ad->setAccepted(true);
        $ad->save();
        return redirect()->back()->withMessage(['type'=>'success', 'text'=>'Anuncio aceptado']);
    }

    public function rejectAd (Ad $ad) {
        $ad->setAccepted(false);
        $ad->save();
        return redirect()->back()->withMessage(['type'=>'danger', 'text'=>'Anuncio rechazado']);
    }

}