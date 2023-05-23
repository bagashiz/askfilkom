<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * test_register_new_user tests the registration of a new user
     *
     * @return void
     */
    public function test_register_new_user(): void
    {
        // Create a new user password
        $password = $this->faker->password(8);

        // Create a request form data
        $request = [
            'username' => $this->faker->userName(5),
            'nama' => $this->faker->name(5),
            'email' => $this->faker->safeEmail,
            'password' => $password,
            'password_confirmation' => $password,
        ];

        // Send a request to register a new user
        $response = $this->post('/users', $request);

        // Ensure that the user is stored in the database
        $this->assertDatabaseHas('user', [
            'username' => $request['username'],
            'nama' => $request['nama'],
            'email' => $request['email'],
        ]);

        // Ensure that the user is redirected to the login page
        $response->assertRedirect('/login');

        // Ensure that the success message is flashed
        $response->assertSessionHas('success', 'Registrasi berhasil! Silakan login menggunakan akun yang telah dibuat.');
    }


    /**
     * test_register_new_user_by_auth_user tests the registration of a new user by an authenticated user
     *
     * @return void
     */
    public function test_register_new_user_by_auth_user(): void
    {
        // Create an authenticated user
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a new user password
        $password = $this->faker->password(8);

        // Create a request form data
        $request = [
            'username' => $this->faker->userName(5),
            'nama' => $this->faker->name(5),
            'email' => $this->faker->safeEmail,
            'password' => $password,
            'password_confirmation' => $password,
        ];

        // Send a request to register a new user
        $response = $this->post('/users', $request);

        // User should not be registered
        $this->assertDatabaseMissing('user', [
            'username' => $request['username'],
            'nama' => $request['nama'],
            'email' => $request['email'],
        ]);

        // User should be redirected to homepage
        $response->assertRedirect('/');
    }

    /**
     * test_reset_user_password tests reseting a user password by an authenticated user.
     *
     * @return void
     */
    public function test_update_user_password(): void
    {
        // Create an authenticated user
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a request form data
        $password = 'newpassword';
        $request = [
            'password' => $password,
            'password_confirmation' => $password,
        ];

        // Send a request to update the user password
        $response = $this->patch('/profile/reset', $request);

        // Get the user from the database
        $updatedUser = User::find($user->id_user);

        // Ensure that the user password is updated in the database
        $this->assertTrue(Hash::check($password, $updatedUser->password));

        // Ensure that the user is redirected to the profile page
        $response->assertRedirect('/profile');

        // Ensure that the success message is flashed
        $response->assertSessionHas('success', 'Password berhasil diperbarui!');
    }

    /**
     * test_update_user_profile_by_admin tests updating a user profile by an admin.
     *
     * @return void
     */
    public function test_update_user_profile_by_admin(): void
    {
        // Create an admin user
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);
        $this->actingAs($admin);

        // Create a user to be updated
        $user = User::factory()->create();

        // Create a request form data
        $request = [
            'username' => 'newusername',
            'nama' => 'newname',
            'email' => 'new@mail.com',
            'is_admin' => false,
        ];

        // Send a request to update the user profile
        $response = $this->patch('/users/' . $user->id_user, $request);

        // Ensure that the user profile is updated in the database
        $this->assertDatabaseHas('user', [
            'id_user' => $user->id_user,
            'username' => $request['username'],
            'nama' => $request['nama'],
            'email' => $request['email'],
            'is_admin' => $request['is_admin'],
        ]);

        // Ensure that the user is redirected to the manage users page
        $response->assertRedirect('/users/manage');

        // Ensure that the success message is flashed
        $response->assertSessionHas('success', 'Data user berhasil diperbarui!');
    }

    /**
     * test_update_user_profile_by_unauthorized tests unauthorized user attempting to update a user profile.
     *
     * @return void
     */
    public function test_update_user_profile_by_unauthorized(): void
    {
        // Create an authenticated user
        $user = User::factory()->create([
            'is_admin' => false,
        ]);
        $this->actingAs($user);

        // Create a user to be updated
        $user2 = User::factory()->create();

        // Create a request form data
        $request = [
            'username' => 'newusername',
            'nama' => 'newname',
            'email' => 'new@mail.com',
            'is_admin' => false,
        ];

        // Send a request to update the user profile
        $response = $this->patch('/users/' . $user2->id_user, $request);

        // Ensure that the user profile is not updated in the database
        $this->assertDatabaseMissing('user', [
            'id_user' => $user2->id_user,
            'username' => $request['username'],
            'nama' => $request['nama'],
            'email' => $request['email'],
        ]);

        // Ensure abort 403 is returned
        $response->assertStatus(403);
    }

    /**
     * test_update_user_profile_by_guest tests a guest attempting to update a user profile.
     *
     * @return void
     */
    public function test_update_user_profile_by_guest(): void
    {
        // Create a user to be updated
        $user = User::factory()->create([
            'is_admin' => false,
        ]);

        // Create a user to be updated
        $user2 = User::factory()->create();

        // Create request form data
        $request = [
            'username' => 'newusername',
            'nama' => 'newname',
            'email' => 'new@mail.com',
            'is_admin' => false,
        ];

        // Send a request to update the user profile
        $response = $this->patch('/users/' . $user->id_user, $request);

        // Ensure that the user profile is not updated in the database
        $this->assertDatabaseMissing('user', [
            'id_user' => $user2->id_user,
            'username' => $request['username'],
            'nama' => $request['nama'],
            'email' => $request['email'],
        ]);

        // Ensure that the user is redirected to the login page
        $response->assertRedirect('/login');
    }

    /**
     * test_delete_user_by_admin tests deleting a user by an admin.
     *
     * @return void
     */
    public function test_delete_user_by_admin(): void
    {
        // Create an admin user
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);
        $this->actingAs($admin);

        // Create a user to be deleted
        $user = User::factory()->create();

        // Send a request to delete the user
        $response = $this->delete('/users/' . $user->id_user);

        // Ensure that the user is deleted from the database
        $this->assertDatabaseMissing('user', [
            'id_user' => $user->id_user,
        ]);

        // Ensure that the admin is redirected to the user management page
        $response->assertRedirect('/users/manage');

        // Ensure that the success message is flashed
        $response->assertSessionHas('success', 'User berhasil dihapus!');
    }

    /**
     * test_delete_user_by_unauthorized tests unauthorized user attempting to delete a user.
     *
     * @return void
     */
    public function test_delete_user_by_unauthorized(): void
    {
        // Create a user
        $user = User::factory()->create();

        // Send a delete request without authentication
        $response = $this->delete('/users/' . $user->id_user);

        // Ensure that the user is not deleted
        $this->assertDatabaseHas('user', ['id_user' => $user->id_user]);

        // Ensure redirect to login page
        $response->assertRedirect('/login');
    }

    /**
     * test_delete_user_by_guest tests a guest attempting to delete a user.
     *
     * @return void
     */
    public function test_delete_user_by_guest(): void
    {
        // Create a user to be deleted
        $user = User::factory()->create();

        // Send a request to delete the user
        $response = $this->delete('/users/' . $user->id_user);

        // Ensure that the user is not deleted from the database
        $this->assertDatabaseHas('user', [
            'id_user' => $user->id_user,
        ]);

        // Ensure redirect to login page
        $response->assertRedirect('/login');
    }

    /**
     * test_auth_success tests the auth function when the request is valid
     *
     * @return void
     */
    public function test_auth_success(): void
    {
        // Create a user
        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => bcrypt('testpassword'),
        ]);

        // Create a request form data
        $request = [
            'username' => $user->username,
            'password' => 'testpassword',
        ];

        $response = $this->post('/auth', $request);

        $response->assertRedirect('/');
        $response->assertSessionHas('success', 'Login berhasil!');
    }

    /**
     * test_auth_invalid tests the auth function when the request is invalid
     *
     * @return void
     */
    public function test_auth_invalid(): void
    {
        $request = [
            'username' => 'invaliduser',
            'password' => 'invalidpassword',
        ];

        $response = $this->post('/auth', $request);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['username']);
        $response->assertSessionDoesntHaveErrors(['password']);
    }

    /**
     * test_logout_success tests the logout function
     *
     * @return void
     */
    public function test_logout_success(): void
    {
        // Create an authenticated user
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect('/login');
        $response->assertSessionHas('success', 'Logout berhasil!');
    }
}
