<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
        {
            Schema::create('notes', function (Blueprint $table) {
                $table->id();                          // auto-increment primary key
                $table->string('title');               // title field
                $table->text('content');               // content field
                $table->timestamps();                  // created_at & updated_at
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
