@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card ">
                    <div class="card-header">
                        <h5 class="card-title">@lang('KYC Documents')</h5>
                    </div>
                    <div class="card-body">
                        @if($user->kyc_data)
                        <ul class="list-group">
                          @foreach($user->kyc_data as $val)
                          @continue(!$val->value)
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{__($val->name)}}
                            <span>
                                @if($val->type == 'checkbox')
                                    {{ implode(',',$val->value) }}
                                @elseif($val->type == 'file')
                                    <a href="{{ route('user.download.attachment',encrypt(getFilePath('verify').'/'.$val->value)) }}"><i class="fa-regular fa-file"></i>  @lang('Attachment') </a>
                                @else
                                <p>{{__($val->value)}}</p>
                                @endif
                            </span>
                          </li>
                          @endforeach
                        </ul>
                        @else
                        <h5 class="text-center">@lang('KYC data not found')</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
