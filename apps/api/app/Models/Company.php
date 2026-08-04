<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $fillable = [

        'name',

        'owner',

        'phone',

        'email',

        'address',

        'city',

        'province',

        'postal_code',

        'logo',

        'tax_number',

        'qris_image',

        'receipt_footer',

        'active'

    ];
}