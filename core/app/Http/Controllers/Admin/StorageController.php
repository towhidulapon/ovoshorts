<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\StorageSetting;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    public function index()
    {
        $pageTitle = 'Storage Settings';
        $storages  = StorageSetting::orderBy('id', 'desc')->get();
        return view('admin.storage.index', compact('pageTitle', 'storages'));
    }

    public function update(Request $request, $id)
    {
        $storage = StorageSetting::findOrFail($id);

        $validationRule = [];

        foreach ($storage->parameters as $key => $val) {
            $validationRule = array_merge($validationRule, [$key => 'required']);
        }

        request()->validate($validationRule);

        $parameters = json_decode(json_encode($storage->parameters), true);
        foreach ($parameters as $key => $value) {
            $parameters[$key]['value'] = $request->$key;
        }
        $storage->parameters = $parameters;
        $storage->save();

        $notify[] = ['success', $storage->name . ' updated successfully'];
        return back()->withNotify($notify);

    }

    public function status($id)
    {
        $storage = StorageSetting::where('id', $id)->findOrFail($id);
        StorageSetting::where('id', '!=', $id)->update(['status' => Status::DISABLE]);
        if ($storage->status == Status::DISABLE) {
            $storage->status = Status::ENABLE;
        } else {
            $storage->status = Status::DISABLE;
        }
        $storage->save();
        $notify[] = ['success', 'Storage status updated successfully'];
        return back()->withNotify($notify);
    }
}
