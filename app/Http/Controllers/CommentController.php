<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function store(Request $request) {

        $parentComment = $request->get('parent');

        if ($parentComment) {
            
            $prevComments = Comment::where('reorder', '>', $parentComment['reorder'])->get();
            foreach ($prevComments as $pct) {
                $pct->reorder += 1;
                $pct->update();
            }

            $comment = new Comment([
                'content' => $request->get('content'),
                'post_id' => $request->get('post_id'),
                'parent_id' => $parentComment['id'],
                'redepth' => $parentComment['redepth'] + 1,
                'reorder' => $parentComment['reorder'] + 1
            ]);
            $comment->save();
        } else {
            $prevComments = Comment::all();
            foreach ($prevComments as $pct) {
                $pct->reorder += 1;
                $pct->update();
            }

            $comment = new Comment([
                'content' => $request->get('content'),
                'post_id' => $request->get('post_id'),
                'parent_id' => null,
                'redepth' => 0,
                'reorder' => 1
            ]);
            $comment->save();
        }

        return response()->json('successfully added');
    }

    public function delete($id) {
        $comment = Comment::find($id);
        $depth = $comment['redepth'];
        $order = $comment['reorder'];
        $comment->delete();

        $children = Comment::where('reorder', '>', $order)->orderBy('reorder', 'asc')->get();

        foreach ($children as $chi) {
            if ($chi['redepth'] > $depth) {
                $chi->delete();
            } else {
                break;
            }
        }

        return response()->json('successfully deleted');
    }
}
