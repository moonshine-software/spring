<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use PHPUnit\Framework\Attributes\Test;

class ProfileUpdateTest extends AuthTestCase
{
    #[Test]
    public function profileScreen(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('profile'))
            ->assertOk()
            ->assertSee($user->email)
            ->assertSee('name="current_password"', escape: false);
    }

    #[Test]
    public function profileUpdate(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->post(route('profile.update'), [
                'name' => $user->name,
                'email' => fake()->freeEmail(),
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');
    }
}
