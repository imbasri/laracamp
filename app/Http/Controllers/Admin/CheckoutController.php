<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\Checkout\Paid;
use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function update(Request $request, Checkout $checkout)
    {
        $checkout->is_paid = true;
        $checkout->save();
        $request->session()->flash('success', "Checkout updated ID: {$checkout->id} - {$checkout->User->name} successfully");
        Mail::to($checkout->User->email)->send(new Paid($checkout));
        return redirect()->route('admin.dashboard');
    }
}
