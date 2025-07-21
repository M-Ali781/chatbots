<?php

// database/migrations/xxxx_xx_xx_create_chatbots_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('chatbots', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onDelete('cascade');
      $table->string('name');
      $table->string('type');
      $table->string('pdf_path');
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('chatbots');
  }
};
