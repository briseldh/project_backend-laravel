<?php

namespace App\Http\Controllers;

use App\Models\FileUpload;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function insert(Request $request)
    {
        try {
            $policyResp = Gate::inspect('insert', Post::class);

            if ($policyResp->allowed()) {

                $rules = [
                    'user_id' => 'required|numeric',
                    'title' => 'required|min:5|max:50',
                    'text' => 'required|min:10|max:2000',
                ];

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return response()->json(['message' => $validator->errors()], 400);
                }

                $post = new Post();
                $post->user_id = $request->input('user_id');
                $post->title = $request->input('title');
                $post->text = $request->input('text');

                $post->save();

                return response()->json(['message' => $policyResp->message()], 201);
            }

            return response()->json(['message' => $policyResp->message()], 403);
        } catch (Exception $e) {
            return response()->json(['message' => '===FATAL=== ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $post = Post::find($id);

            $policyResp = Gate::inspect('update', $post);

            if ($policyResp->allowed()) {
                $rules = [
                    'title' => 'min:5|max:50',
                    'text' => 'min:10|max:2000',
                ];

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return response()->json(['message' => $validator->errors()], 400);
                }

                $post->title = $request->input('title');
                $post->text = $request->input('text');

                $post->save();

                return response()->json(['message' => $policyResp->message()], 200);
            }

            return response()->json(['message' => $policyResp->message()], 403);
        } catch (Exception $e) {
            return response()->json(['message' => '===FATAL=== ' . $e->getMessage()], 500);
        }
    }

    public function delete(string $id)
    {
        try {
            $post = Post::find($id);

            $policyResp = Gate::inspect('delete', $post);

            if ($policyResp->allowed()) {
                $post->delete();

                return response()->json(['message' => $policyResp->message()], 200);
            }

            return response()->json(['message' => $policyResp->message()], 403);
        } catch (Exception $e) {
            return response()->json(['message' => '===FATAL=== ' . $e->getMessage()], 500);
        }
    }

    public function getById(string $id)
    {
        try {
            $post = Post::find($id);

            $policyResp = Gate::inspect('getById', $post);

            if ($policyResp->allowed()) {

                return response()->json(['message' => $policyResp->message(), 'post' => $post], 200);
            }

            return response()->json(['message' => $policyResp->message()], 403);
        } catch (Exception $e) {
            return response()->json(['message' => '===FATAL=== ' . $e->getMessage()], 500);
        }
    }

    public function getAll()
    {
        try {
            $policyResp = Gate::inspect('getAll', Post::class);

            if ($policyResp->allowed()) {
                $posts = Post::all();

                return response()->json(['message' => $policyResp->message(), 'posts' => $posts], 200);
            }

            return response()->json(['message' => $policyResp->message()], 403);
        } catch (Exception $e) {
            return response()->json(['message' => '===FATAL=== ' . $e->getMessage()], 500);
        }
    }

    public function uploadFile(Request $request, $postId)
    {
        try {

            $file = $request->file('avatar');
            $post = Post::findOrFail($postId);
            // if ($post->id !== $postId) {
            //     return response()->json('post not found');
            // }


            $policyResp = Gate::inspect('uploadFile', $post);

            if ($policyResp->allowed()) {

                //-File Validation
                $request->validate([
                    'avatar' => ['required', 'mimes:jpeg,pdf', 'max:2048']
                ]);

                $fileName = date('Y-m-d') . '_' . time() . $file->getClientOriginalName();
                $path = 'uploads/' . $fileName;
                $onlyName = explode('.', $file->getClientOriginalName());

                $post_images = new FileUpload();

                $post_images->post_id = $post->id;
                $post_images->path = $path;
                $post_images->alt_text = $onlyName[0];
                $post_images->uploaded_at = date('Y-m-d H:i:s');

                $post_images->save();

                Storage::putFileAs('uploads', $file, $fileName);

                return response()->json(['message' => 'File uploaded successfully.'], 200);
            }

            return response()->json(['message' => $policyResp->message()], 403);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
