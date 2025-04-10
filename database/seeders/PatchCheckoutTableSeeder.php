<?php

namespace Database\Seeders;

use App\Models\Checkout;
use Illuminate\Database\Seeder;

class PatchCheckoutTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Update all checkouts with total 0 to the camp price
        // This is a patch for the checkout table
        // because the total is not updated when the checkout is created
        // and the camp price is not updated when the checkout is created
        // so we need to update the total to the camp price
        // Get all checkouts with total 0
        // and update the total to the camp price
        // how to run this seeder?
        // php artisan db:seed --class=PatchCheckoutTableSeeder
        $checkouts = Checkout::whereTotal(0)->get();
        foreach ($checkouts as $checkout) {
            $checkout->update([
                'total' => $checkout->Camp->price,
            ]);
        }
    }
}
