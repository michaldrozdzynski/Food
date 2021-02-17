<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Id',
        'user1_id',
        'user2_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user1(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user1_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user2_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function scopeWithUsers($query) {
        return $query->addSelect([
            'user_1_name' => function ($query) {
                $query->select('name')
                    ->from('users')
                    ->whereColumn('conversations.user1_id', 'users.id')
                    ->limit(1);
            },
            'user_2_name' => function ($query) {
                $query->select('name')
                    ->from('users')
                    ->whereColumn('conversations.user2_id', 'users.id')
                    ->limit(1);
            }
        ]);
    }
}