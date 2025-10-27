@extends($activeTemplate . 'layouts.app')
@section('app-content')

    <section class="account position-relative bg-img" data-background-image="{{ asset($activeTemplateTrue . 'images/account-bg.png') }}">

        <div class="account__header">
            <a href="{{ route('home') }}"> <img src="{{ siteLogo() }}" alt="img"> </a>
        </div>

        <div class="account-inner">
            <div class="container">

                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="account-form__wrapper d-flex justify-content-center pb-4">
                            <div class="account-form col-12 p-4">
                                <h3 class="text-center mb-4">@lang('Profile')</h3>

                                <form class="register" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-xl-9 col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label">@lang('First Name')</label>
                                                <input type="text" class="form-control form--control" name="firstname" value="{{$user->firstname}}" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">@lang('Last Name')</label>
                                                <input type="text" class="form-control form--control" name="lastname" value="{{$user->lastname}}" required>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-sm-6">
                                            <div class="form-group text-center">
                                                <div class="user-data-profile-image">
                                                    <x-image-uploader :size="getFileSize('userProfile')" name="image" :imagePath="getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile'))" :required="false" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="form-group col-12">
                                            <label class="form-label">@lang('Bio')</label>
                                            <input type="text" class="form-control form--control" name="bio" value="{{$user->bio}}" required>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="form-label">@lang('E-mail Address')</label>
                                            <input class="form-control form--control" value="{{$user->email}}" readonly>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="form-label">@lang('Mobile Number')</label>
                                            <input class="form-control form--control" value="{{$user->mobile}}" readonly>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="form-group col-sm-6">
                                            <label class="form-label">@lang('Address')</label>
                                            <input type="text" class="form-control form--control" name="address" value="{{@$user->address}}">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="form-label">@lang('State')</label>
                                            <input type="text" class="form-control form--control" name="state" value="{{@$user->state}}">
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="form-group col-sm-4">
                                            <label class="form-label">@lang('Zip Code')</label>
                                            <input type="text" class="form-control form--control" name="zip" value="{{@$user->zip}}">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label class="form-label">@lang('City')</label>
                                            <input type="text" class="form-control form--control" name="city" value="{{@$user->city}}">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label class="form-label">@lang('Country')</label>
                                            <input class="form-control form--control" value="{{@$user->country_name}}" disabled>
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
    </section>
@endsection


@push('script')
    <script> (function ($) {
            "use strict"; $(document).on("change", "input[name='image']", function (e) {
                let reader = new FileReader(); reader.onload = (e) => {
                    $(this).closest(".user-data-profile-image")
                        .find("img")
                        .attr("src", e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
            });

        })(jQuery);
    </script>
@endpush