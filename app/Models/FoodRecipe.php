<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FoodRecipe extends Model
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
        'category_id',
        'cuisine_country_id',
        'vegetarian',
        'description',
        'way_of_preparing'
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
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ingredients(): HasMany
    {
        return $this->hasMany(Ingredient::class);
    }

    public function rates(): HasMany
    {
        return $this->hasMany(RecipeRate::class);
    }

    public function scopeWithCategoryAndCuisineCountryAndUser($query) {
        return $query->addSelect([
            'category' => function ($query) {
                $query->select('name')
                    ->from('food_categories')
                    ->whereColumn('food_recipes.category_id', 'food_categories.id')
                    ->limit(1);
            },
            'cuisine_country' => function ($query) {
                $query->select('name')
                    ->from('cuisine_countries')
                    ->whereColumn('food_recipes.cuisine_country_id', 'cuisine_countries.id')
                    ->limit(1);
            },
            'user_name' => function ($query) {
                $query->select('name')
                    ->from('users')
                    ->whereColumn('food_recipes.user_id', 'users.id')
                    ->limit(1);
            }
        ]);
    }
}
