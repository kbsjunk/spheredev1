<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('message_id');
            $table->string('in_reply_to')->nullable();
            $table->string('references')->nullable();
            $table->string('subject');
            $table->text('sender');
            $table->text('recipients');
            $table->text('body_text');
            $table->text('body_html');
            $table->text('files');
            $table->integer('from_user_id')->unsigned()->nullable();
            $table->boolean('spam')->default(false);
            $table->timestamps();
            $table->dateTime('sent_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mails');
    }
}
