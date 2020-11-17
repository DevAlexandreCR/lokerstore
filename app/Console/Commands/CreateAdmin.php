<?php

namespace App\Console\Commands;

use App\Constants\Roles;
use App\Models\Admin\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command create a new user admin';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->makeUser();
    }

    public function makeUser(): void
    {
        $name = $this->ask('What is your name?');
        $email = $this->ask('What is your email address?');

        if (!$this->checkEmail($email)) {
            $this->error('Write a valid email address.');
        }
        $password = $this->secret('Write password: ');
        $passwordVerify = $this->secret('Repeat password verification: ');

        if ($password === $passwordVerify) {
            $admin = Admin::create([
                'name'      => $name,
                'email'     => $email,
                'password'  => Hash::make($password),
                'is_active' => true,
                ]);
            $admin->assignRole(Roles::ADMIN);
            $this->info('Admin created successfully... bye!');
        } else {
            $this->error('password verification failed');
        }
    }

    public function checkEmail(string $email): bool
    {
        $find1 = strpos($email, '@');
        $find2 = strpos($email, '.');

        return ($find1 !== false && $find2 !== false && $find2 > $find1);
    }
}
