@extends('templates.default')

@section('content')
<h3>Sign In</h3>
<div class="row">
    <div class="col-lg-6">
        <form class="form-vertical" role="form" method="post" action="{{ route('auth.signin') }}">
            <div class="form-group{{ $errors->has('email') ? 'has-error' :''}}">
                <label for="email" class="controll-label">Email</label>
                <input type="text" name="email" class="form-control" id="email">
                @if ($errors->has('email'))
                  <span class="help-block">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('email') ? 'has-error' :''}}">
                <label for="password" class="controll-label">Password</label>
                <input type="password" name="password" class="form-control" id="password">
                @if ($errors->has('password'))
                  <span class="help-block">{{ $errors->first('password') }}</span>
                @endif
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember">Remember me
                </label>
             <div class="form-group">
                <button type="submit" class="btn btn-default">Sign In</button>
             </div>   
            <input type="hidden" name="_token" value="{{ Session::token() }}">    
        </form>
        </div>
    </div>
</div>
@stop