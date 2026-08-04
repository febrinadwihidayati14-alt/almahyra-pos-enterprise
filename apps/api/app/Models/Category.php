<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [

        'public_id',

        'code',

        'name',

        'description',

        'active',

        'created_by',

        'updated_by',

        'deleted_by',

    ];

    protected $casts = [

        'active' => 'boolean',

    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {

            if (empty($category->public_id)) {

                $category->public_id = (string) Str::uuid();

            }

        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
