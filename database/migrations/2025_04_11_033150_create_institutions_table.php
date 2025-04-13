<?php

use App\Utils\Enums\AccreditationStatus;
use App\Utils\Enums\InstitutionType;
use App\Utils\Enums\OwnershipType;
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
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->enum('type', InstitutionType::values());
            $table->enum('accreditation_status', AccreditationStatus::values())->nullable();
            $table->enum('ownership_type', OwnershipType::values());
            $table->year('founded_year')->nullable();
            $table->string('website_url')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('logo_url')->nullable();
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institutions');
    }
};
