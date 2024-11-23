
        <nav class="navbar navbar-default" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <!-- <a class="navbar-brand" href="{{ route('home') }}" style="font-family: Hervetica, sans-serif"> ASN</a> -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="300" height="60" viewBox="0 0 300 100">
                    <circle cx="50" cy="50" r="40" fill="#4CAF50" />
                    <path d="M20 50 Q50 30, 80 50 T140 50" fill="none" stroke="#ffffff" stroke-width="4" />
                    <text x="100" y="60" font-family="Helvetica, sans-serif" font-size="25" fill="#2E7DFF">Akiwacu</text>
                    </svg>
                </div>
                <div class="collapse navbar-collapse">
                    @if (Auth::check())
                     <ul class="nav navbar-nav">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('friends.index')}}">👥</a></li>
                     </ul>
                     <form class="navbar-form navbar-left" role="search" action="{{ route('search.results') }}">
                        <div class="form-group">
                            <input type="text" name="query" class="form-control" placeholder="Find people">
                        </div>
                        <button type="submit" class="btn btn-default">Search</button>
                     </form>
                     @endif
                      <ul class="nav navbar-nav navbar-right">
                        @if (Auth::check())
                        <li><a href="{{ route('profile.index', ['username' => 
                        Auth::user()->username ]) }}">{{ Auth::user()->getNameOrUsername()}}</a></li>
                        <li><a href="{{ route('profile.edit') }}">Update profile</a></li>
                        <li><a href="{{ route('auth.signout') }}">Sign out</a></li>
                        @else
                        <li><a href="{{ route('auth.signup') }}">Sign up</a></li>
                        <li><a href="{{ route('auth.signin') }}">Sign in</a></li>
                        @endif
                      </ul>
                </div>
            </div>
        </nav>