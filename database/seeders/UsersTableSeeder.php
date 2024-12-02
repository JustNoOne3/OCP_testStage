<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Artisan;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $est = DB::table('establishments')->insert([
            'est_name' => 'null',
            'est_street' => 'null',
            'region_id' => 0,
            'province_id' => 0,
            'city_id' => 0,
            'barangay_id' => 0,
            'psic_section'=> 'null',
            'psic_division'=> 'null',
            'psic_class'=> 'null',
            'psic_group'=> 'null',
            'est_products'=> 'null',
            'est_class'=> 'null',
            'est_tin'=> 'null',
            'est_sss'=> 'null',
            'est_payment'=> 'null',
            'est_yearImplemented'=> 'null',
            'est_numworkMale' => 0,
            'est_numworkFemale' => 0,
            'est_numworkManager' => 0,
            'est_numworkSupervisor' => 0,
            'est_numworkRanks' => 0,
            'est_numworkTotal' => 0,
            'est_owner'=> 'null',
            'est_designation'=> 'null',
            'est_telNum'=> 'null',
            'est_contactNum'=> 0,
            'est_email'=> 'null@mail.com',
        ]);

        // Superadmin user
        $sid = Str::uuid();

        DB::table('users')->insert([
            'id' => $sid,
            'username' => 'superadmin',
            'firstname' => 'Super',
            'lastname' => 'Admin',
            'email' => 'bonaobraryan@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('@Bwc12345'),
            'authority' => 20,
            'est_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Bind superadmin user to FilamentShield
        Artisan::call('shield:super-admin', ['--user' => $sid]);

        // user
        $sid2 = Str::uuid();
        DB::table('users')->insert([
            'id' => $sid2,
            'username' => 'user',
            'firstname' => 'user',
            'lastname' => 'type',
            'email' => 'user@mail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'est_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('model_has_roles')->insert([
            'role_id' => DB::table('roles')->where('name', 'user')->value('id'),
            'model_type' => 'App\Models\User',
            'model_id' => $sid2,
        ]);

        // focal
        $sid3 = Str::uuid();
        DB::table('users')->insert([
            'id' => $sid3,
            'username' => 'focal',
            'firstname' => 'focal',
            'lastname' => 'focal',
            'email' => 'focal@mail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'est_id' => null,
            'authority' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('model_has_roles')->insert([
            'role_id' => DB::table('roles')->where('name', 'focal')->value('id'),
            'model_type' => 'App\Models\User',
            'model_id' => $sid3,
        ]);

        // bwc focal
        $sid4 = Str::uuid();
        DB::table('users')->insert([
            'id' => $sid4,
            'username' => 'bwc',
            'firstname' => 'bwc',
            'lastname' => 'bwc',
            'email' => 'bwc_focal@mail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'est_id' => null,
            'authority' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('model_has_roles')->insert([
            'role_id' => DB::table('roles')->where('name', 'bwc_focal')->value('id'),
            'model_type' => 'App\Models\User',
            'model_id' => $sid4,
        ]);

        $sid5 = Str::uuid();
        DB::table('users')->insert([
            'id' => $sid5,
            'username' => 'admin',
            'firstname' => 'admin',
            'lastname' => 'admin',
            'email' => 'bwc_admin@mail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'est_id' => null,
            'authority' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('model_has_roles')->insert([
            'role_id' => DB::table('roles')->where('name', 'admin')->value('id'),
            'model_type' => 'App\Models\User',
            'model_id' => $sid5,
        ]);

        // $roles = DB::table('roles')->whereNot('name', 'super_admin')->get();
        // foreach ($roles as $role) {
        //     for ($i = 0; $i < 10; $i++) {
        //         $userId = Str::uuid();
        //         DB::table('users')->insert([
        //             'id' => $userId,
        //             'username' => $faker->unique()->userName,
        //             'firstname' => $faker->firstName,
        //             'lastname' => $faker->lastName,
        //             'email' => $faker->unique()->safeEmail,
        //             'email_verified_at' => now(),
        //             'password' => Hash::make('password'),
        //             'est_id' => null,
        //             'created_at' => now(),
        //             'updated_at' => now(),
        //         ]);
        //         DB::table('model_has_roles')->insert([
        //             'role_id' => $role->id,
        //             'model_type' => 'App\Models\User',
        //             'model_id' => $userId,
        //         ]);
        //     }
        // }
    }
}

