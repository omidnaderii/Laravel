<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            //who follow sb
            $table->foreignId('follower_id')->constrained('users')->onDelete('cascade'); 
            //who has followed by follower
            $table->foreignId('following_id')->constrained('users')->onDelete('cascade'); // کاربر دنبال شونده
            $table->timestamps();
        
            $table->unique(['follower_id', 'following_id']); 
        });
        
    }

   
    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};