<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class Publicite extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'titre',
        'description_pub',
        'contenu_pub',
        'suprimer',
        'status'
    ];
}
