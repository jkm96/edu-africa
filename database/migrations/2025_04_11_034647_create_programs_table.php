<?php

use App\Utils\Enums\ProgramLevel;
use App\Utils\Enums\ProgramMode;
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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('level', ProgramLevel::values());
            $table->enum('mode', ProgramMode::values())->nullable();
            $table->string('duration')->nullable();
            $table->string('faculty_or_school')->nullable();
            $table->text('entry_requirements')->nullable();
            $table->decimal('tuition_fee', 10, 2)->nullable();
            $table->string('currency')->nullable();
            $table->string('language_of_instruction')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
