<?php

namespace App\Http\Controllers;

use App\Models\ProfilePicUpload;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class ProfilePicController extends Controller
{
    public function insert(Request $request)
    {
        try {

            $policyResp = Gate::inspect('insert', ProfilePicUpload::class);

            if ($policyResp->allowed()) {

                $rules = [
                    'avatar' => 'required|mimes:jpeg,png|max:2048'
                ];

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return response()->json(['message' => $validator->errors()], 400);
                }

                $file = $request->file('avatar');


                if ($request->hasFile('avatar')) {

                    $fileName = date('Y-m-d') . '_' . $file->getClientOriginalName();
                    $path = 'storage/profileImgs/' . $fileName;
                    $onlyName = explode(".", $file->getClientOriginalName());

                    $profile_images = new ProfilePicUpload();

                    // Preventing a user from having more than one prfile pic.
                    $query = DB::select('select 1 from project_backend.profile_images where user_id = :userId', ['userId' => $request->user()->id]);
                    if ($query) {
                        return response()->json(['message' => 'You cant have more than one profile pic!'], 400);
                    }


                    $profile_images->user_id = $request->user()->id;
                    $profile_images->path = $path;
                    $profile_images->alt_text = 'Profile pic of' . " " . $request->user()->name;

                    $profile_images->save();

                    $request->file('avatar')->storeAs('public/profileImgs', $fileName);


                    return response()->json(['message' => $policyResp->message(), 'profilePic' => $profile_images], 201);
                }
            }

            return response()->json(['message' => $policyResp->message()], 403);
        } catch (Exception $e) {
            return response()->json(['message' => '===FATAL=== ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {

            $profilePic = ProfilePicUpload::find($id);

            if (!$profilePic) {
                return response()->json(['message' => 'The profile picture that you want to change can not be found'], 404);
            }

            $policyResp = Gate::inspect('update', $profilePic);

            if ($policyResp->allowed()) {
                $rules = [
                    'avatar' => 'required|mimes:jpeg,png|max:2048',
                ];

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return response()->json(['message' => $validator->errors()], 400);
                }

                $file = $request->file('avatar');

                // return response()->json(['profilePic' => $profilePic, 'file' => $file], 200);

                if ($request->hasFile('avatar')) {

                    $fileName = date('Y-m-d') . '_' . $file->getClientOriginalName();
                    $path = 'storage/profileImgs/' . $fileName;

                    $profilePic->path = $path;

                    $profilePic->save();

                    $request->file('avatar')->storeAs('public/profileImgs', $fileName);


                    return response()->json(['message' => $policyResp->message(), 'profilePic' => $profilePic], 200);
                }

                return response()->json(['message' => $policyResp->message()], 403);
            }
        } catch (Exception $e) {

            return response()->json(['message' => 'update Successful'], 200);
        }
    }

    public function delete(Request $request, string $id)
    {
        try {

            $profilePic = ProfilePicUpload::find($id);
            // $query = DB::select('select * from project_backend.profile_images where user_id = :userId', ['userId' => $id]);
            // $profilePic = $query[0];
            // return response()->json(['profilePic' => $profilePic], 404);


            if (!$profilePic) {
                return response()->json(['message' => 'The profile picture that you want to delete can not be found'], 404);
            }

            // return response()->json(['profilePic' => $profilePic], 200);

            $policyResp = Gate::inspect('delete', $profilePic);

            if ($policyResp->allowed()) {
                $profilePic->delete();

                return response()->json(['message' => $policyResp->message()], 200);
            }

            return response()->json(['message' => $policyResp->message()], 403);
        } catch (Exception $e) {
            return response()->json(['message' => '===FATAL=== ' . $e->getMessage()], 500);
        }
    }

    public function getById(Request $request, string $id)
    {
        try {
            $profilePic = ProfilePicUpload::find($id);

            $policyResp = Gate::inspect('getById', $profilePic);

            if ($policyResp->allowed()) {
                return response()->json(['message' => $policyResp->message(), 'profilePic' => $profilePic], 200);
            }

            return response()->json(['message' => $policyResp->message()], 403);
        } catch (Exception $e) {

            return response()->json(['message' => '===FATAL=== ' . $e->getMessage()], 500);
        }
    }

    public function getAll(Request $request)
    {
        try {
            $policyResp = Gate::inspect('getAll', ProfilePicUpload::class);

            if ($policyResp->allowed()) {
                $allProfilePics = ProfilePicUpload::all();

                return response()->json(['message' => $policyResp->message(), 'allProfilePics' => $allProfilePics], 200);
            }

            return response()->json(['message' => $policyResp->message()], 403);
        } catch (Exception $e) {
            return response()->json(['message' => '===FATAL=== ' . $e->getMessage()], 500);
        }
    }
}
