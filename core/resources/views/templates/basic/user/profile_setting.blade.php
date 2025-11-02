@extends($activeTemplate . 'layouts.dashboard_frontend')
@section('content')
    <div class="dashboard-body">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="custom--card card">
                        <div class="card-header">
                            <h4>@lang('Profile Setting')</h4>
                        </div>
                        <div class="card-body">

                            <form class="register" method="post" enctype="multipart/form-data">
                                @csrf
                                {{-- todo --}}

                                {{-- <div class="user-data-profile-image">
                                    <x-image-uploader :size="getFileSize('userProfile')" name="image" :imagePath="getImage(
                                        getFilePath('userProfile') . '/' . $user->image,
                                        getFileSize('userProfile'),
                                    )"
                                        :required="false" />
                                </div> --}}

                                <input type="hidden" name="_token" value="qBwaYHQClu5mAt0lMXdLVnLqRsSmgXwROQ3SDU2y"
                                    autocomplete="off">
                                <div class="auth-user-pic">
                                    <img class="auth-user-pic__thumb"
                                        src="{{ getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile')) }}"
                                        alt="img">
                                    <div class="auth-user-pic__btns">
                                        <input class="d-none" type="file" name="image" id="auth-user-pic"
                                            accept=".png,.jpg,.jpeg">
                                        <label class="btn btn--sm btn-outline--base" for="auth-user-pic">Change
                                            picture</label>
                                    </div>
                                </div>


                                <div class="row mt-4">

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('First Name')</label>
                                            <input type="text" class="form-control form--control" name="firstname"
                                                value="{{ $user->firstname }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Last Name')</label>
                                            <input type="text" class="form-control form--control" name="lastname"
                                                value="{{ $user->lastname }}" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Bio')</label>
                                            <input type="text" class="form-control form--control" name="bio"
                                                value="{{ $user->bio }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="from-group">
                                            <label class="form-label">@lang('E-mail Address')</label>
                                            <input class="form-control form--control" value="{{ $user->email }}" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Mobile Number')</label>
                                            <input class="form-control form--control" value="{{ $user->mobile }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Address')</label>
                                            <input type="text" class="form-control form--control" name="address"
                                                value="{{ @$user->address }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('State')</label>
                                            <input type="text" class="form-control form--control" name="state"
                                                value="{{ @$user->state }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Zip Code')</label>
                                            <input type="text" class="form-control form--control" name="zip"
                                                value="{{ @$user->zip }}">
                                        </div>

                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('City')</label>
                                            <input type="text" class="form-control form--control" name="city"
                                                value="{{ @$user->city }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Country')</label>
                                            <input class="form-control form--control" value="{{ @$user->country_name }}"
                                                disabled>
                                        </div>
                                    </div>

                                </div>

                                <div class="d-grid mt-3">
                                    <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- <section class="account position-relative">
        <div class="account-inner">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="custom--card">

                        </div>
                        <div class="account-form__wrapper d-flex justify-content-center pb-4">
                            <div class="account-form col-12 p-4">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
@endsection


@push('script')
    <script>
        (function($) {
            "use strict";
            $(document).on("change", "input[name='image']", function(e) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $(this).closest(".user-data-profile-image")
                        .find("img")
                        .attr("src", e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
            });

        })(jQuery);
    </script>
@endpush
