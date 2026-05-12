<div>
    <h1>Dashboard</h1>

    @auth
        <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
        <p>
            <strong>Email verified:</strong>
            @if(auth()->user()->email_verified_at)
                Yes ({{ auth()->user()->email_verified_at->toDayDateTimeString() }})
            @else
                No — please check your inbox for a verification link.
            @endif
        </p>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    @else
        <p>Please <a href="{{ route('login') }}">login</a> or <a href="{{ route('register') }}">register</a>.</p>
    @endauth
</div>
