<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PIC;

class AdminController extends Controller
{
    public function listPIC()
    {
        $pics = PIC::all();
        return view('admin.listPIC', compact('pics'));
    }

    public function addPIC()
    {
        return view('admin.addPIC');
    }

    public function storePIC(Request $request)
    {
        $pic = new PIC();
        $pic->name = $request->name;
        $pic->email = $request->email;
        $pic->department = $request->department;
        $pic->section = $request->section;
        $pic->save();
        return redirect()->route('admin.list-pic');
    }

    //delete pic
    public function deletePIC($id)
    {
        $pic = PIC::find($id);
        $pic->delete();
        return redirect()->route('admin.list-pic');
    }
}