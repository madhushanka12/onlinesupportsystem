<?php

namespace Domain\Ticket\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Support\Database\Model;

class Ticket extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'reference_number',
        'name',
        'problem',
        'email',
        'mobile',
        'reply',
        'status',
    ];

    protected $casts = [
        'created_at' => 'date:Y-m-d H:i a',
        'updated_at' => 'date:Y-m-d H:i a',
    ];
}
