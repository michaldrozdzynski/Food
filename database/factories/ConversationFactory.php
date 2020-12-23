<?php

namespace Database\Factories;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConversationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Conversation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        return [
            'user1_id' => $user1->id,
            'user2_id' => $user2->id,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Conversation $conversation) {
            $max = $this->faker->numberBetween(10,20);

            for ($i = 0; $i < $max; $i++) {
                $conversation->messages()->create([
                    'content' => $this->faker->text,
                    'user_id' => $this->faker->boolean ? $conversation->user1_id : $conversation->user2_id,
                ]);
            }
        });
    }
}
