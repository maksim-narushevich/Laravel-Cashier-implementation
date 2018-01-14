@extends('default')

@section('content')
    @if ($user->subscription('main') && !$user->subscription('main')->cancelled())
            @if ($user->subscribed('main'))
                <p>You are subscribed to {{ucfirst($plan->stripe_plan)}} plan <br>
                <a href="{{ URL::to('subscription/cancel' ) }}">Cancel</a></p>
                @php
                if($plan->stripe_plan=='small'){
                $plan="Large";
                }else{
                $plan="Small";
                }
                    @endphp
                <a href="{{ URL::to('subscription/change' ) }}">Change plan to {{$plan}} plan</a></p>
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