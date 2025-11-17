@foreach($replies as $reply)
    @include('Template::user.short.view.comment.reply_item', ['reply' => $reply])
    @if($reply->replies && $reply->replies->count())
        @include('Template::user.short.view.comment.comment_replies_flat', ['replies' => $reply->replies])
    @endif
@endforeach