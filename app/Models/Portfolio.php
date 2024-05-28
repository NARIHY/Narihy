<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'contenu',
        'lien_portfolio',
        'media',
        'status',
        'users_id',
        'category_portfolio_id',
        'suprimer'
    ];

    /**
     * La relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * La relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoryPortfolio(): BelongsTo
    {
        return $this->belongsTo(\App\Models\CategoryPortfolio::class);
    }
}
