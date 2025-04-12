<?php

namespace App\Models;

use App\Utils\Enums\ProgramLevel;
use App\Utils\Enums\ProgramMode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'institution_id',
        'name',
        'slug',
        'level',
        'mode',
        'duration',
        'faculty_or_school',
        'entry_requirements',
        'tuition_fee',
        'currency',
        'language_of_instruction',
    ];

    protected static function booted()
    {
        static::creating(function ($program) {
            if (empty($program->slug)) {
                $program->slug = Str::slug($program->name . '-' . uniqid());
            }
        });

        static::updating(function ($program) {
            if ($program->isDirty('name')) {
                $program->slug = Str::slug($program->name . '-' . uniqid());
            }
        });
    }

    protected $casts = [
        'level' => ProgramLevel::class,
        'mode' => ProgramMode::class,
    ];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
}
