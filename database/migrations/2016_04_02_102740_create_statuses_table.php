<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user')->unsigned();
            $table->text('message')->nullable()->default(null);
            $table->text('link')->nullable()->default(null);
            $table->text('image')->nullable()->default(null);
            $table->enum('provider',['facebook','twitter']);
            $table->string('social_post_id')->nullable()->default(null);
            $table->enum('status', ['live','pending','deleted'])->default('pending');
            $table->datetime('post_in');
            $table->datetime('delete_in');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('statuses', function (Blueprint $table) {
            $table->foreign('user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('statuses');
    }
}
