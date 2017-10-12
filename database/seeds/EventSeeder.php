<?php
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->delete();
        
        DB::table('events')->insert([
            [
                'name' => 'birthday',
                'description' => 'admin',
                'status' => '0'
            ],
            [
                'name' => 'death',
                'description' => 'admin',
                'status' => '0'
            ],
            [
                'name' => 'anniversary',
                'description' => 'admin',
                'status' => '0'
            ]
        ]);
    }
}
