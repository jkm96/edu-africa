<?php

namespace App\Models;

use App\Utils\Enums\ContactType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'institution_id',
        'type',
        'label',
        'value',
    ];

    protected $casts = [
        'type' => ContactType::class,
    ];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
}
