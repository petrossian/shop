<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('currency')->nullable();
            $table->string('percent_off')->nullable(); // zexchi tokos@
            $table->string('duration')->nullable(); // tevoxutyun@
            $table->string('max_redemptions')->nullable(); //qani angam kara ogtagorcvi et coupon@
            $table->string('redeem_by')->nullable();  // sahmanapakvum a en producteri qanak@, voronq kogtagorcen et coupon@
            $table->string('applies_to')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
