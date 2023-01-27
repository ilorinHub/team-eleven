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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('transaction_id')->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('gateway', 20);
            $table->string('gateway_transation_identifier', 100)->nullable();
            $table->integer('amount');
            $table->integer('charged_amount')->default(0);
            $table->string('transaction_reference', 20)->unique();
            $table->string('currency', 3)->default('NGN');
            $table->tinyInteger('status')->default(\App\Enums\PaymentStatus::INITIATED());
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
        Schema::dropIfExists('payments');
    }
};
