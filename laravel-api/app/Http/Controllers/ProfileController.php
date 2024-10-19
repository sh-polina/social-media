<?php

namespace App\Http\Controllers;

use App\Models\UserAvatar;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ProfileController extends Controller
{
    public function uploadImage(Request $request): JsonResponse
    {
        $request->validate([
            'profile-picture' => 'required|image|mimes:png,jpg,jpeg|max:5000'
        ]);

        $uploadedFile = $request->file('profile-picture');

        if (!$uploadedFile) {
            throw new BadRequestHttpException();
        }

        $uploadedFileURL = Storage::disk('public')->put('/photos', $uploadedFile);

        if (!$uploadedFileURL) {
            throw new BadRequestHttpException();
        }

        $user = Auth::user()->getAuthIdentifier();

        $getPreviousAvatar = UserAvatar::where('user_id', $user);
        if ($getPreviousAvatar) {
            $getPreviousAvatar->delete();
        }

        $userAvatar = new UserAvatar();
        $userAvatar->avatar_path = "/storage/" . $uploadedFileURL;
        $userAvatar->user_id = $user;

        $userAvatar->save();

        return new JsonResponse($userAvatar->avatar_path);
    }

    public function getImage(): JsonResponse
    {
        $profileImage = UserAvatar::where('user_id', Auth::user()->getAuthIdentifier())->first();

        return new JsonResponse($profileImage);
    }


}
