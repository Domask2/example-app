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
        User::create([
            'name' => 'AdminUser',
            'email' => $this->option('email'),
            'password' => Hash::make($this->option('password')),
            'role' => 'admin',
        ]);

        return 'AdminUser was created.';
    }
}
