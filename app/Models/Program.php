<?php

namespace App\Models;

use App\Utils\Enums\ProgramLevel;
use App\Utils\Enums\ProgramMode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'institution_id',
        'name',
        'level',
        'mode',
        'duration',
        'faculty_or_school',
        'entry_requirements',
        'tuition_fee',
        'currency',
        'language_of_instruction',
    ];

    protected $casts = [
        'level' => ProgramLevel::class,
        'mode' => ProgramMode::class,
    ];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
}
