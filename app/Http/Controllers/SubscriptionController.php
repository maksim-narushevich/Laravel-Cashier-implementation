<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::id());
        $plan=$user->subscription('main');
        //$user->subscription('main')->updateQuantity(10);

        return view('subscription.index', compact('user','plan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::find(Auth::id());
        return view('subscription.form', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::find(Auth::id());
        $stripe_plan = $request['stripe_plan'];

        $creditCardToken = $request->stripeToken;
        if (!$user->subscription('main')) {
            if (!empty($stripe_plan)) {
                $res = $user->newSubscription('main', $stripe_plan)
                    ->trialDays(30)
                    ->create($creditCardToken, [
                        'plan' => $stripe_plan,
                        'email' => $user->email,

                    ]);

                return view('subscription.index', compact('user'));
            }
        } else {
            return view('subscription.index', compact('user'));
        }
//        if (!$user->subscription('main')) {
//
//                return view('subscription.index', compact('user'));
//            }else{
//                $info = "Please select any plan for subscription!";
//                return view('subscription.form', compact('user', 'info'));
//            }
//
//        } else {
//            $info = "You have already subscribed";
//            return view('subscription.index', compact('user', 'info'));
//        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function cancel()
    {
        $user = User::find(Auth::id());
        //-- If i want immediately stop subscription without ability to resume it again
//        $user->subscription('main')->cancelNow();
        $user->subscription('main')->cancel();

        return redirect('/subscription');
    }

    public function resume()
    {
        $user = User::find(Auth::id());
        $user->subscription('main')->resume();

        return redirect('/subscription');
    }

    public function change()
    {
        $user = User::find(Auth::id());

        $plan=$user->subscription('main');
        if($plan->stripe_plan=='small'){
            $plan="large";
        }else{
            $plan="small";
        }
        $user->subscription('main')->swap($plan);

        return redirect('/subscription');
    }

}
