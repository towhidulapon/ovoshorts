<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Star;
use Illuminate\Http\Request;

class StarController extends Controller
{
    public function index()
    {
        $pageTitle = 'Star';
        $stars     = Star::orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.star.index', compact('pageTitle', 'stars'));
    }

    public function save(Request $request, $id = 0)
    {
        $request->validate([
            'stars' => 'required|numeric|gt:0',
            'price' => 'required|numeric|gt:0',
        ]);
        if($id) {
            $star = Star::findOrFail($id);
            $star->stars = $request->stars;
            $star->price = $request->price;
            $star->save();
            $message = 'Star package updated successfully';
        }else {
            $star = new Star();
            $star->stars = $request->stars;
            $star->price = $request->price;
            $star->save();
            $message = 'Star package added successfully';
        }
        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    public function status($id)
    {
        return Star::changeStatus($id);
    }
}
