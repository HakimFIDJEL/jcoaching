<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class MemberController extends Controller
{
    public function index()
    {
        $members = User::members()->get();
        return view('admin.members.index')->with(['members' => $members]);
    }

    public function show(User $user)
    {
        return view('admin.members.show')->with(['member' => $user]);
    }

    public function edit(User $user)
    {
        return view('admin.members.edit')->with(['member' => $user]);
    }
}
