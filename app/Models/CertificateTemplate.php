<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CertificateTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'background_image_path',
        'signature_image_path',
        'layout_settings',
        'signatory_name',
        'signatory_title',
        'created_by',
    ];

    protected $casts = [
        'layout_settings' => 'array',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class, 'certificate_template_id');
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class, 'template_id');
    }
}
