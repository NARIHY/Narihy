<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Contacte extends Model
{
    use HasFactory, Notifiable;

    /**
     * instanciation des atribut fillable
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'prenon',
        'email',
        'sujet_conversation',
        'status',
        'message',
        'reponse',
        'publie_par'
    ];
}
