<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendingMachine extends Model
{
    use HasFactory;

    public const PENCES = 'pences';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['balance'];
}
