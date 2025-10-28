<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $pageTitle  = 'Manage Categories';
        $categories = Category::searchable(['name'])->filter(['id'])->orderBy('id', getOrderBy())->paginate(getPaginate());
        return view('admin.category.index', compact('pageTitle', 'categories'));
    }

    public function save(Request $request, $id = 0)
    {
        $request->validate([
            'name' => 'required|unique:categories|string|max:255',
        ]);

        if ($id) {
            $category = Category::findOrFail($id);
            $message  = 'Category updated successfully';
        } else {
            $category = new Category();
            $message  = 'Category created successfully';
        }

        $category->name = $request->name;
        $category->save();
        $notify[] = ['success', $message];

        return back()->withNotify($notify);
    }

    public function status($id)
    {
        return Category::changeStatus($id);
    }
}
