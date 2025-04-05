<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Checkout\Store;
use App\Models\Camp;
use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Checkout\AfterCheckout;
use Exception;
use Illuminate\Support\Str;
use Midtrans\Snap;
use Midtrans\Config;

class CheckoutController extends Controller
{

    public function __construct()
    {
        Config::$serverKey = config('MIDTRANS_SERVER_KEY');
        Config::$isProduction = config('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = config('MIDTRANS_IS_SANITIZED');
        Config::$is3ds = config('MIDTRANS_IS_3DS');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Camp $camp, Request $request)
    {

        // check if the user is registered for the camp
        if ($camp->isRegistered) {
            $request->session()->flash('error', 'You are already registered for this camp');
            return redirect()->route('user.dashboard');
        }

        return view('checkout.create', [
            'camp' => $camp,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request, Camp $camp)
    {
        // mapping request data
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['camp_id'] = $camp->id;

        // update user information in the checkout
        $user = Auth::user();
        $user->email = $data['email'];
        $user->name = $data['name'];
        $user->occupation = $data['occupation'];
        $user->save();

        // create checkout
        $checkout = Checkout::create($data);

        $this->getSnapRedirect($checkout);

        // send email to user
        Mail::to($user->email)->send(new AfterCheckout($checkout));

        // redirect to success page or back with error
        return $checkout
            ? redirect()->route('checkout.success')->with('message', 'Checkout successful')
            : redirect()->back()->with('error', 'Checkout failed');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function show(Checkout $checkout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function edit(Checkout $checkout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Checkout $checkout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function destroy(Checkout $checkout)
    {
        //
    }

    public function success()
    {
        return view('checkout.success', [
            'message' => 'Checkout successful',
        ]);
    }

    public function invoice(Checkout $checkout)
    {
        return $checkout;
    }

    /**
     * Midtrans handler.
     *
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function getSnapRedirect(Checkout $checkout)
    {
        $orderId = $checkout->id . '-' . Str::random(5);
        $checkout->midtrans_booking_code = $orderId;

        $transaction_details = [
            'order_id' => $orderId,
            'gross_amount' => $checkout->Camp->price, // no decimal allowed for creditcard
        ];

        $item_details[] = [
            'id' => $checkout->Camp->id,
            'price' => $checkout->Camp->price,
            'quantity' => 1,
            'name' => "Payment for {$checkout->Camp->title} Camp",
        ];

        $userData = [
            'first_name' => $checkout->User->name,
            'last_name' => '',
            'address' => $checkout->User->address,
            'city' => "",
            'postal_code' => "",
            'phone' => $checkout->User->phone,
            'country_code' => "ID",
        ];

        $customer_details = [
            'first_name' => $checkout->User->name,
            'last_name' => '',
            'email' => $checkout->User->email,
            'phone' => $checkout->User->phone,
            'billing_address' => $userData,
            'shipping_address' => $userData,
        ];

        $midtrans_params = [
            'transaction_details' => $transaction_details,
            'item_details' => $item_details,
            'customer_details' => $customer_details,
        ];

        try {
            // Get Snap payment page
            $paymentUrl = Snap::createTransaction($midtrans_params)->redirect_url;
            $checkout->midtrans_url = $paymentUrl;
            $checkout->save();
            return redirect($paymentUrl);
        } catch (Exception $e) {
            // Handle exception
            return false;
        }
    }
}
