<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Short;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller {
    public function profile() {
        $pageTitle = "Profile Setting";
        $user      = auth()->user();
        return view('Template::user.profile_setting', compact('pageTitle', 'user'));
    }

    public function submitProfile(Request $request) {
        $request->validate([
            'firstname' => 'required|string',
            'lastname'  => 'required|string',
            'bio'       => 'nullable|string',
            'image'     => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ], [
            'firstname.required' => 'The first name field is required',
            'lastname.required'  => 'The last name field is required',
        ]);

        $user = auth()->user();

        $user->firstname = $request->firstname;
        $user->lastname  = $request->lastname;

        if ($request->hasFile('image')) {
            try {
                $user->image = fileUploader($request->image, getFilePath('userProfile'), getFileSize('userProfile'), $user->image);
            } catch (\Exception $exp) {
                $notify[] = ['errors', 'Image could not be uploaded'];
                return back()->withNotify($notify);
            }
        }

        $user->bio     = $request->bio;
        $user->address = $request->address;
        $user->city    = $request->city;
        $user->state   = $request->state;
        $user->zip     = $request->zip;

        $user->save();
        $notify[] = ['success', 'Profile updated successfully'];
        return back()->withNotify($notify);
    }

    public function changePassword() {
        $pageTitle = 'Change Password';
        return view('Template::user.password', compact('pageTitle'));
    }

    public function submitPassword(Request $request) {

        $passwordValidation = Password::min(6);
        if (gs('secure_password')) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $request->validate([
            'current_password' => 'required',
            'password'         => ['required', 'confirmed', $passwordValidation],
        ]);

        $user = auth()->user();
        if (Hash::check($request->current_password, $user->password)) {
            $password       = Hash::make($request->password);
            $user->password = $password;
            $user->save();
            $notify[] = ['success', 'Password changed successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'The password doesn\'t match!'];
            return back()->withNotify($notify);
        }
    }

    public function profileDetails(Request $request) {
        $pageTitle = 'Profile Details';
        $user      = auth()->user();
        $sort      = $request->input('sort', 'latest');

        $shortsQuery = $this->baseQuery()->where('user_id', $user->id);
        switch ($sort) {
            case 'popular':
                $shortsQuery->withCount('likes')->orderBy('likes_count', 'desc');
                break;
            case 'oldest':
                $shortsQuery->orderBy('created_at', 'asc');
                break;
            case 'latest':
            default:
                $shortsQuery->orderBy('created_at', 'desc');
                break;
        }
        $shorts = $shortsQuery->paginate(getPaginate(), ['*'], 'page', 1);
        $shorts->getCollection()->transform(fn($short) => prepareShortData($short));
        $favShortIds = $user->savedShorts()->pluck('shorts_id')->toArray();
        $likedShortIds = $user->likes()->pluck('shorts_id')->toArray();
        $favShorts = $this->baseQuery()->whereIn('id', $favShortIds)->orderBy('id', 'desc')->paginate(getPaginate(), ['*'], 'page', 1);

        $likedShorts = $this->baseQuery()->whereIn('id', $likedShortIds)
            ->orderBy('id', 'desc')
            ->paginate(getPaginate(), ['*'], 'page', 1);

        $totalLikes = $shorts->sum(function ($short) {
            return $short->likes->count();
        });

        return view('Template::user.profile_details', compact('pageTitle', 'user', 'shorts', 'favShorts', 'likedShorts', 'totalLikes', 'sort'));
    }

    public function profileTabContent(Request $request) {
        $tab  = $request->input('tab', 'home');
        $sort = $request->input('sort', 'latest');
        $page = $request->input('page', 2);
        $user = auth()->user();

        if ($tab == 'home') {
            $shortsQuery = $this->baseQuery()->where('user_id', $user->id);
            switch ($sort) {
                case 'popular':
                    $shortsQuery->withCount('likes')->orderBy('likes_count', 'desc');
                    break;
                case 'oldest':
                    $shortsQuery->orderBy('created_at', 'asc');
                    break;
                case 'latest':
                default:
                    $shortsQuery->orderBy('created_at', 'desc');
                    break;
            }
            $collection = $shortsQuery->paginate(getPaginate(), ['*'], 'page', $page);
        } elseif ($tab == 'profile') {
            $favShortIds = $user->savedShorts()->pluck('shorts_id')->toArray();
            $collection = $this->baseQuery()->whereIn('id', $favShortIds)
                ->orderBy('id', 'desc')
                ->paginate(getPaginate(), ['*'], 'page', $page);
        } elseif ($tab == 'contact') {
            $likedShortIds = $user->likes()->pluck('shorts_id')->toArray();
            $collection = $this->baseQuery()->whereIn('id', $likedShortIds)
                ->orderBy('id', 'desc')
                ->paginate(getPaginate(), ['*'], 'page', $page);
        }

        $collection->getCollection()->transform(fn($short) => prepareShortData($short));

        $html = view('Template::user.tab_content', compact('collection', 'tab'))->render();

        return apiResponse("profile_tab", 'success', ['tab_content'], [
            'data'         => $html,
            'hasMorePages' => $collection->hasMorePages(),
        ]);
    }


    private function baseQuery() {
        return Short::query()
            ->with('likes')
            ->where('status', Status::PUBLISHED)
            ->where(function ($query) {
                $query->where('storage_driver', 'local')
                    ->orWhereIn('storage_driver', function ($subQuery) {
                        $subQuery->select('alias')
                            ->from('storage_settings')
                            ->where('status', Status::ENABLE);
                    });
            });
    }


    public function profilePrivacySetting() {
        $pageTitle = 'Profile Privacy Setting';
        $user      = auth()->user();
        return view('Template::user.privacy_setting', compact('pageTitle', 'user'));
    }
}
