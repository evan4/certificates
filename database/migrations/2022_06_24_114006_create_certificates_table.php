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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->unsignedInteger('tree_amount');
            $table->unsignedInteger('amount');
            $table->date('activate_at')->nullable();
            $table->uuid('code')->nullable();

            $table->foreignId('plantation_id')->constrained('plantations')
                ->onDelete('cascade');
            $table->foreignId('payment_option_id')->constrained('payment_options')
                ->onDelete('cascade');
            $table->foreignId('currency_id')->constrained('currencies')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('certificates');
    }
};
