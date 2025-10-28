<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Models\Form;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function setting()
    {
        $pageTitle = "Verification Setting";
        $form      = Form::where('act', 'verification')->first();
        return view('admin.verification.setting', compact('pageTitle', 'form'));
    }

    public function settingUpdate(Request $request)
    {

        $formProcessor       = new FormProcessor();
        $generatorValidation = $formProcessor->generatorValidation();
        $request->validate($generatorValidation['rules'], $generatorValidation['messages']);
        $exist = Form::where('act', 'verification')->first();
        $formProcessor->generate('verification', $exist, 'act');

        $notify[] = ['success', 'Verification data updated successfully'];
        return back()->withNotify($notify);
    }
}
