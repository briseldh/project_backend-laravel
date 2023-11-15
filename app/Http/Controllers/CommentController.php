<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function insert(Request $request)
    {
        try {

            $policyResp = Gate::inspect('insert', Comment::class);

            if ($policyResp->allowed()) {

                $rules = [
                    'user_id' => 'required|numeric',
                    'post_id' => 'required|numeric',
                    'text' => 'required|max:255',
                ];

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return response()->json(['message' => $validator->errors()], 400);
                }

                $comment = new Comment();
                $comment->user_id = $request->input('user_id');
                $comment->post_id = $request->input('post_id');
                $comment->text = $request->input('text');

                $comment->save();

                return response()->json(['message' => $policyResp->message()], 201);
            }

            return response()->json(['message' => $policyResp->message()], 403);
        } catch (Exception $e) {

            return response()->json(['message' => '=== FATAL ===' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {

            $comment = Comment::find($id);

            $policyResp = Gate::inspect('update', $comment);

            if ($policyResp->allowed()) {

                $rules = [
                    'text' => 'required|max:255'
                ];

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return response()->json(['message' => $validator->errors()], 400);
                }

                $comment->text = $request->input('text');

                $comment->save();

                return response()->json(['message' => $policyResp->message()], 200);
            }

            return response()->json(['message' => $policyResp->message()], 403);
        } catch (Exception $e) {

            return response()->json(['message' => '=== FATAL ===' . $e->getMessage()], 500);
        }
    }

    public function delete(Request $request, string $id)
    {
        try {

            $comment = Comment::find($id);

            $policyResp = Gate::inspect('delete', $comment);

            if ($policyResp->allowed()) {

                $comment->delete();

                return response()->json(['message' => $policyResp->message()], 200);
            }

            return response()->json(['message' => $policyResp->message()], 403);
        } catch (Exception $e) {

            return response()->json(['message' => '=== FATAL ===' . $e->getMessage()], 500);
        }
    }

    public function getById(Request $request, string $id)
    {
        try {

            $policyResp = Gate::inspect('getById', Comment::class);

            if ($policyResp->allowed()) {

                $comment = Comment::find($id);

                return response()->json(['message' => $policyResp->message(), 'comment' => $comment], 200);
            }

            return response()->json(['message' => $policyResp->message()], 403);
        } catch (Exception $e) {

            return response()->json(['message' => '=== FATAL ===' . $e->getMessage()], 500);
        }
    }
}
