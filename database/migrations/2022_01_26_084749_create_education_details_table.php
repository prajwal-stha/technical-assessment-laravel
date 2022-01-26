<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('education_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_detail_id')->references('id')->on('customer_details');
            $table->enum('education_type', ['School', 'HighSchool', 'Bachelors', 'Master', 'Phd']);
            $table->string('institution_name');
            $table->string('institution_address');
            $table->string('grade')->nullable();
            $table->string('start_date');
            $table->string('end_date')->nullable();
            $table->enum('current_status', ['Ongoing', 'Completed'])->default('Completed');
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
        Schema::dropIfExists('education_details');
    }
}
