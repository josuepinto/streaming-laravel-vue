<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('favourites', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->morphs('favouritable');
                $table->timestamps();

                $table->unique(
                    ['user_id', 'favouritable_id', 'favouritable_type'],
                    'favourites_user_item_unique'
                );
        });
    }

    public function down()
    {
        Schema::dropIfExists('favourites');
    }
};
