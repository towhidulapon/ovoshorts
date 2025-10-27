<?php

namespace App\Traits;

use App\Models\Comment;
use App\Models\CommentReaction;
use Illuminate\Http\Request;

trait CommentManager {

    public function store(Request $request) {
        $request->validate([
            'shorts_id' => 'required|exists:shorts,id',
            'message'   => 'required|string|max:1000',
        ]);

        $comment             = new Comment();
        $comment->shorts_id  = $request->shorts_id;
        $comment->user_id    = auth()->user()->id;
        $comment->message    = $request->message;
        $comment->created_at = now();

        $comment->save();

        $comment->load('user', 'short.user');

        $comment->is_liked = CommentReaction::where('comment_id', $comment->id)
            ->where('user_id', auth()->user()->id)
            ->exists();

        $commentCount = Comment::where('shorts_id', $request->shorts_id)->whereNull('parent_id')->count();

        $shortUser = $comment->short->user->id;

        notify($shortUser, 'COMMENT_ADDED', [
            'username'   => $comment->user->username,
            'comment'    => $comment->message,
            'created_at' => $comment->created_at,
        ], ['push']);

        if (isApiRequest()) {
            return apiResponse('message_store', 'success', ['Comment added successfully'], [
                'success'       => true,
                'comment'       => $comment,
                'comment_count' => $commentCount,
            ]);
        }

        $html = view('Template::user.short.view.comment.comment_item', ['comment' => $comment])->render();

        return response()->json([
            'success'       => true,
            'comment'       => $comment,
            'html'          => $html,
            'comment_count' => $commentCount,
        ]);
    }

    public function replyStore(Request $request) {
        $request->validate([
            'comment_id' => 'required|exists:comments,id',
            'message'    => 'required|string|max:1000',
        ]);

        $parentComment = Comment::find($request->comment_id);

        $reply            = new Comment();
        $reply->user_id   = auth()->user()->id;
        $reply->shorts_id = $parentComment->shorts_id;
        $reply->parent_id = $parentComment->id;
        $reply->message   = $request->message;
        $reply->save();

        $reply->load('user');

        $reply->is_liked = CommentReaction::where('comment_id', $reply->id)
            ->where('user_id', auth()->user()->id)
            ->exists();

        if (isApiRequest()) {
            return apiResponse('message_reply', 'success', [], [
                'success' => true,
                'comment' => $reply,
            ]);
        }

        $html = view('Template::user.short.view.comment.reply_item', ['reply' => $reply])->render();

        return response()->json([
            'success' => true,
            'comment' => $reply,
            'html'    => $html,
        ]);
    }

    public function reaction(Request $request) {
        $request->validate([
            'comment_id' => 'required|exists:comments,id',
        ]);

        $comment = Comment::find($request->comment_id);
        $userId  = auth()->user()->id;

        $existingReaction = CommentReaction::where('comment_id', $comment->id)
            ->where('user_id', $userId)
            ->first();

        if ($existingReaction) {
            $existingReaction->delete();
            $comment->likes_count--;
            $comment->save();
            $status = 'unliked';
        } else {
            $reaction             = new CommentReaction();
            $reaction->comment_id = $comment->id;
            $reaction->user_id    = $userId;
            $reaction->save();
            $comment->likes_count++;
            $comment->save();
            $status = 'liked';
        }

        return apiResponse('message_reaction', 'success', [], [
            'success' => true,
            'status'  => $status,
            'likes'   => $comment->likes_count,
            'message' => $status === 'liked' ? 'liked' : 'unliked',
        ]);
    }
}
