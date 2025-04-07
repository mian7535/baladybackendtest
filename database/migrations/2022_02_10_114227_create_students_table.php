<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('bankId');
            $table->string('Name');
            $table->string('birthDate');
            $table->string('email');
            $table->string('gender');
            $table->string('identityNumber');
            $table->string('mobileNumber');
            $table->string('observationType');
            $table->string('subMunicipalityId');
            $table->string('subMunicipalityName');
            $table->string('MunicipalityId');
            $table->string('MunicipalityName');
            $table->string('api_key');
            $table->enum('status',['pass','fail','rejected']);
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
        Schema::dropIfExists('students');
    }
}
