<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'file_path',
        'form_fields',
        'is_active',
        'type',
    ];

    protected $casts = [
        'form_fields' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get all surats using this template
     */
    public function surats()
    {
        return $this->hasMany(Surat::class);
    }

    /**
     * Check if template is system template
     */
    public function isSystemTemplate(): bool
    {
        return $this->type === 'system';
    }

    /**
     * Check if template is admin template
     */
    public function isAdminTemplate(): bool
    {
        return $this->type === 'admin';
    }

    /**
     * Scope for system templates
     */
    public function scopeSystem($query)
    {
        return $query->where('type', 'system');
    }

    /**
     * Scope for admin templates
     */
    public function scopeAdmin($query)
    {
        return $query->where('type', 'admin');
    }
}
