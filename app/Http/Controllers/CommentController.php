<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function store(Request $request) {
        
        $comment = new Comment([
            'content' => $request->get('content'),
            'reply' => $request->get('reply'),
            'post_id' => $request->get('post_id'),
        ]);

        $comment->save();

        return response()->json('successfully added');
    }

    public function delete($id) {
        $comment = Comment::find($id);

        $comment->delete();

        return response()->json('successfully deleted');
    }
}
