<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sizes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->integer('width');
            $table->integer('height');
            $table->timestamps();
        });

        DB::table('sizes')->insert([
            ['code' => 'big', 'width' => 800, 'height' => 600],
            ['code' => 'med', 'width' => 640, 'height' => 480],
            ['code' => 'min', 'width' => 320, 'height' => 240],
            ['code' => 'mic', 'width' => 150, 'height' => 150],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sizes');
    }
};
