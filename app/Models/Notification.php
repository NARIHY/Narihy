<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    /*
    $table->string('titre');
            $table->string('icons');
            $table->string('contenu');
    */

    protected $fillable = [
        'titre',
        'icons',
        'contenu'
    ];
}
