<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Star;
use Illuminate\Http\Request;

class StarController extends Controller
{
    public function index()
    {
        $pageTitle = 'Star Packages';
        $stars     = Star::filter(['id'])->orderBy('id', getOrderBy())->paginate(getPaginate());
        return view('admin.star.index', compact('pageTitle', 'stars'));
    }

    public function save(Request $request, $id = 0)
    {
        $request->validate([
            'name'  => 'required|string|max:40',
            'stars' => 'required|int|gt:0',
            'price' => 'required|int|gt:0',
        ]);

        $star = $id ? Star::findOrFail($id) : new Star();

        $star->name  = $request->name;
        $star->stars = $request->stars;
        $star->price = $request->price;
        $star->save();

        $message = $id ? 'Star package updated successfully' : 'Star package added successfully';

        return back()->withNotify([['success', $message]]);
    }
    public function status($id)
    {
        return Star::changeStatus($id);
    }
}
