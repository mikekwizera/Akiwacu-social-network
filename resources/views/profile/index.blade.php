@extends('templates.default')

@section('content')
<div class="row">
    <div class="col-lg-5">
        @include('user.partials.userblock')
        <hr>
        
        @if (!$statuses->count())
            <p>{{ $user->getFirstNameOrUserName() }} hasn't posted anything yet.</p>
            @else
            @foreach ($statuses as $status)
            <div class="media">
                    <a class="pull-left" href="{{ route('profile.index', [
                        'username' => $status->user->username]) }}">
                        <img class="media-object" alt="{{ $status->user->getNameOrUsername() }}" src="{{ $status->user->get_gravatar_url() }}">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><a href="{{ route('profile.index', [
                        'username' => $status->user->username]) }}">{{ $status->user->getNameOrUsername() }}</a></h4>
                        <p>{{ $status->body }}</p>
                        <ul class="list-inline">
                            <li>{{ $status->updated_at->diffForHumans() }}</li>

                            @if ($status->user->id !== Auth::user()->id)
                                <li><a href="{{ route('status.like', ['statusId' => $status->id]) }}">Like</a></li>
                             @endif
                                <li>{{ $status->likes->count() }} {{ Str::plural('like', $status->likes->count()) }}</li>
                        </ul>

                @foreach ($status->replies as $reply)
                    <div class="media">
                          <a class="pull-left" href="{{ route('profile.index', [
                        'username' => $reply->user->username]) }}">
                              <img class="media-object" alt="{{ $reply->user->getNameOrUsername() }}" src="{{ $reply->user->get_gravatar_url() }}">
                          </a>
                    </div>
                    <div class="media-body">
                            <h5 class="media-heading"><a href="{{ route('profile.index', [
                        'username' => $reply->user->username]) }}">{{ $reply->user->getNameOrUsername() }}</a></h5>
                              <p>{{ $reply->body}}</p>
                             <ul class="list-inline">
                                <li>{{ $reply->updated_at->diffForHumans() }}</li>

                                @if ($reply->user->id !== Auth::user()->id)
                                  <li><a href="{{ route('status.
                                  like', ['statusId' => $reply->id]
                                  ) }}">Like</a></li>
                                @endif
                                 <li>{{ $reply->likes->count() }} {{
                                     Str::plural('like', $reply->likes->
                                     count()) }}</li>
                             </ul>
                        </div>
                    </div>
                @endforeach
                   
                @if ($authUserIsFriend || Auth::user()->id === $status->user->id)
                <form role="form" action="{{ route('status.reply', 
                ['statusId' => $status->id]) }}" method="post">
                    <div class="form-group{{ $errors->has('reply-
                    {$status->id}') ? 'has-error': ''}}">
                        <textarea name="reply-{{ $status->id}}" class="form-control" rows="2" placeholder="Reply to this status"
                        class="btn btn-default btn-sm"></textarea>
                        @if ($errors->has("reply-{$status->id}"))
                           <span class="help-block">{{ $errors->first("reply-{$status->id}") }}</span>
                        @endif
                    </div>
                    <input type="submit" value="Reply" class="btn btn-default btn-sm">
                    <input type="hidden" name="_token" value="{{ Session::token() }}">    
                </form>
                @endif
           </div>
        </div>
            @endforeach
          @endif
    </div>
    <div class="col-lg-4-col-lg-offset-3">
        @if (Auth::user()->hasFriendRequestPending($user))
        <p>Request sent</p>
        @elseif (Auth::user()->hasFriendRequestReceived($user))
        <a href="{{ route('friend.accept', ['username' => $user->username]) }}" class="btn btn-primary">Confirm</a>
        <h4>{{ $user->getFirstNameOrUserName() }}'s friends.</h4>
        @elseif (Auth::user()->isFriendsWith($user))
        <p>You and {{ $user->getNameOrUsername() }} are friends</p>

        <form action="{{ route('friend.delete', ['username' => $user->username]) }}" method="post">
            <input type="submit" value="Delete friend" class="btn btn-primary">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>

        @elseif (Auth::user()->id !==$user->id)
        <a href="{{ route('friend.add', ['username' => $user->username]) }}" class="btn btn-primary">Add friend</a>
        @endif

        @if (!$user->friends()->count())
            <p>{{ $user->getFirstNameOrUserName() }} has no friends.</p>
        @else
            @foreach ($user->friends() as $user)
                @include('user/partials/userblock')
            @endforeach    
        @endif
    </div>
</div>
@stop