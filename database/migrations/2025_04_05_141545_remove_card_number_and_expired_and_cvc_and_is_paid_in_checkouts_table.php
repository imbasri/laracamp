<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveCardNumberAndExpiredAndCvcAndIsPaidInCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('checkouts', function (Blueprint $table) {
            // remove card_number, expired, cvc, and is_paid columns
            $table->dropColumn('card_number', 'expired', 'cvc', 'is_paid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('checkouts', function (Blueprint $table) {
            // add card_number, expired, cvc, and is_paid columns
            $table->string('card_number', 20)->nullable();
            $table->date('expired')->nullable();
            $table->string('cvc', 3)->nullable();
            $table->boolean('is_paid')->default(false)->nullable();
        });
    }
}
