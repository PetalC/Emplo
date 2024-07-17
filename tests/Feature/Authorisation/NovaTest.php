<?php

namespace Tests\Feature\Authorisation;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Seeders\AuthorisationSeeder;

class NovaTest extends \Tests\TestCase
{
    use RefreshDatabase;

    private static User $developer; // developer.super permissions
    private static $novaAdmin;
    private static $taxonomyOnlyAdmin;
    private static $unauthUser;

    public static function novaResourceEndpointsDataProvider() {
        return [
            // resource, developerStatusCode, novaSuperUserAccess, taxonomyOnly, unauthorisedUser
            'users' => ['users', 200, 200, 200, 403],
            'permissions' => ['permissions', 200, 403, 403, 403],
            'roles' => ['roles', 200, 200, 200, 403], // Any nova access should manage roles
            'user certifications' => ['certifications', 200, 200, 403, 403],
            'schools' => ['schools', 200, 200, 403, 403],
            'campuses' => ['campuses', 200, 200, 403, 403],
            'campus-profiles' => ['campus-profiles', 200, 200, 403, 403],
            'jobs' => ['jobs', 200, 200, 403, 403],
            'job-lengths' => ['job-lengths', 200, 200, 200, 403],
        ];
    }

    /**
     * @dataProvider novaResourceEndpointsDataProvider
     * @return void
     */
    public function test_nova_endpoints_authorization($resource, $developerStatus, $novaSuperUserStatus, $taxonomyStatus, $unauthStatus) {
        $this->loadTest();
        $endpoint = '/nova/resources/'.$resource;
        $this->actingAs(self::$developer)->get($endpoint)->assertStatus($developerStatus);
        $this->actingAs(self::$novaAdmin)->get($endpoint)->assertStatus($novaSuperUserStatus);
        $this->actingAs(self::$taxonomyOnlyAdmin)->get($endpoint)->assertStatus($taxonomyStatus);
        $this->actingAs(self::$unauthUser)->get($endpoint)->assertStatus($unauthStatus);
    }

    protected function loadTest() {
        if (!User::where('email', 'admin@developer.com')->first()) {
            // Only seed the db if the expected test data is missing
            echo "Seeding test db...".PHP_EOL;
            $this->seed(AuthorisationSeeder::class);
        }
        self::$developer = User::where('email', 'admin@developer.com')->first();
        self::$novaAdmin = User::where('email', 'admin@nova.com')->first();
        self::$taxonomyOnlyAdmin = User::where('email', 'admin@taxonomy.com')->first();
        self::$unauthUser = User::where('email', 'basic@test.com')->first();
    }

}
