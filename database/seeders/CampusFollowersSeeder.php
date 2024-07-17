<?php

namespace Database\Seeders;

use App\Models\Campus;
use App\Models\Profile;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\CampusFollower;

class CampusFollowersSeeder extends Seeder
{
    public function run()
    {
        // Get all schools
        $campuses = Campus::all();

        // User IDs
        $userIds = User::where('id', '!=', 1)->pluck('id')->toArray();

        // Create followers
        for ($i = 0; $i < 5; $i++) {
//        for ($i = 0; $i < 50; $i++) {

            // Select a random school
            /**
             * @var Campus $randomCampus
             */
            $randomCampus = $campuses->random();

            $type = rand(1, 4);
            $randomUserId = $userIds[array_rand($userIds)];

            $user = User::find($randomUserId);

            if($user->profile === null) {
                $this->command->info("Seeding profile for user " . $randomUserId . "...");
                $user->profile()->save(Profile::factory()->make());
            }

            if( $randomCampus->followers()->where( 'user_id', '=', $randomUserId )->exists() ){
                $randomCampus->followers()->create( [
                    'user_id' => $randomUserId,
                    'type' => $type,
                ] );
            } else {
                $this->command->info( 'User already following school.' );
            }

        }

    }

}
