@extends('default')

@section('content')
    @if (!$user->subscription('main')->cancelled())
            @if ($user->subscribed('main'))
                <p>You are subscribed
                <a href="{{ URL::to('subscription/cancel' ) }}">Cancel</a></p>
            @else
                <p>You are not subscribed</p>
            @endif
    @else
        <p> <a href="{{ URL::to('subscription/resume' ) }}">Resume subscription</a></p></p>
    @endif
@endsection

@section('scripts')
    <script>

    </script>
@endsection