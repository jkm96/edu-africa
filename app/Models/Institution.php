<?php

namespace App\Models;

use App\Utils\Enums\AccreditationStatus;
use App\Utils\Enums\InstitutionType;
use App\Utils\Enums\OwnershipType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'type',
        'accreditation_status',
        'ownership_type',
        'founded_year',
        'website_url',
        'email',
        'phone',
        'logo_url',
        'location_id',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'type' => InstitutionType::class,
        'accreditation_status' => AccreditationStatus::class,
        'ownership_type' => OwnershipType::class,
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function programs()
    {
        return $this->hasMany(Program::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
