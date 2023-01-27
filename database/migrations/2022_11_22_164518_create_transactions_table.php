<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('user_id')
                ->constrained()
                ->onUpdate('cascade');
            // $table->morphs('transactable');
            $table->integer('amount');
            $table->string('currency', 3)->default('NGN');
            $table->boolean('status')->default(\App\Enums\TransactionStatus::INITIATED());
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
