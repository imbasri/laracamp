<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountIdAndDiscountPercentageAndTotalOnCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('checkouts', function (Blueprint $table) {
            $table->foreignId('discount_id')->nullable()->after('camp_id');
            $table->unsignedInteger('discount_percentage')->nullable()->after('midtrans_booking_code');
            $table->unsignedInteger('total')->nullable()->default(0)->after('discount_percentage');

            $table->foreign('discount_id')->references('id')->on('discounts');
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
            $table->dropForeign('checkouts_discount_id_foreign');
            $table->dropColumn([
                'discount_id',
                'discount_percentage',
                'total'
            ]);
        });
    }
}
