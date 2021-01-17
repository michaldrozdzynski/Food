<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Foodporn extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Id',
        'user_id',
        'name',
        'image',
        'points',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rates(): HasMany
    {
        return $this->hasMany(FoodpornRate::class);
    }

    public function scopeWithUserName($query) {
        return $query->addSelect([
            'user_name' => function ($query) {
                $query->select('name')
                    ->from('users')
                    ->whereColumn('foodporns.user_id', 'users.id')
                    ->limit(1);
            }
        ]);
    }
}
