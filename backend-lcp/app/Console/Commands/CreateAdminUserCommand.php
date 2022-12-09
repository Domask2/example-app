<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUserCommand extends Command
{
    protected $signature = 'create:adminuser {--e|email=} {--p|password=}';

    protected $description = 'Create admin user for LCP repository base.';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::where('email', '=', '2519483@gmail.com')->first();
        $mess = 'The user exists';
        if (!$user) {
            User::create([
                'name' => 'AdminUser',
                'email' => $this->option('email'),
                'password' => Hash::make($this->option('password')),
                'role' => 'admin',
            ]);
            $mess = 'AdminUser was created.';
        }

        return $mess;
    }
}
