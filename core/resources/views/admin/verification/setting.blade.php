@extends('admin.layouts.app')
@section('panel')
    <div class="submitRequired form-change-alert d-none">
        <i class="fas fa-exclamation-triangle"></i>
        @lang('You\'ve to click on the submit button to apply the changes')
    </div>
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{ route('admin.verification.setting.update') }}">
                @csrf
                <x-generated-form :form=$form generateTitle="Generate Verification Form for Users" formTitle="Verification Form for Users" formSubtitle="Securely verify user identity through our simple Verification form." generateSubTitle="Quickly generate Verification forms for easy user identity verification." :randerbtn=true />
            </form>
        </div>
    </div>
@endsection