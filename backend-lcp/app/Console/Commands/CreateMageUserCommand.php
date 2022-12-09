<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateMageUserCommand extends Command
{
    protected $signature = 'create:mageuser {--e|email=} {--p|password=}';

    protected $description = 'Create mage user for LCP repository base. It is SuperAdmin';


    /**
     * Execute the console command.
     *
     * @return intj
     */
    public function handle()
    {
        User::create([
            'name' => 'MageUser',
            'email' => $this->option('email'),
            'password' => Hash::make($this->option('password')),
            'role' => 'mage',
        ]);

        return 'MageUser was created.';
    }
}
