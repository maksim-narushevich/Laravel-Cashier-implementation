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
        $user = User::find(1);

        return view('subscription.index',compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::find(1);
        return view('subscription.form',compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::find(1);

        if(!$user->subscription('main')){
            $creditCardToken = $request->stripeToken;
            $res = $user->newSubscription('main', 'small')
                ->trialDays(30)
                ->create($creditCardToken, [
                    'plan' => 'small',
                    'email' => $user->email,

                ]);
            return $res;
        }else{
$info="You have already subscribed";
            return view('subscription.index',compact('user','info'));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function cancel()
    {
        $user = User::find(1);
        //-- If i want immediately stop subscription without ability to resume it again
//        $user->subscription('main')->cancelNow();
        $user->subscription('main')->cancel();

        return redirect('/subscription');
    }

    public function resume()
    {
        $user = User::find(1);
        $user->subscription('main')->resume();

        return redirect('/subscription');
    }
}
