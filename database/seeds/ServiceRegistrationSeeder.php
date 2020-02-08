<?php

use Illuminate\Database\Seeder;

class ServiceRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(App\Models\VishwaServiceRegistration::class, 100)->create()->each(function($u) {
      $u->regDocs()->save(factory(App\Models\VishwaServiceRegistrationDocs::class)->make());
      $u->regProject()->save(factory(App\Models\VishwaServiceRegistrationProjects::class)->make());
      });
    }
}
