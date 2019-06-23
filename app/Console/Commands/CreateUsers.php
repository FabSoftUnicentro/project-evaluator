<?php

namespace App\Console\Commands;

use App\Mail\UserCreated;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CreateUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates the users allowed to use the application and send the e-mails with the credentials';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $handle = fopen(base_path() . '/users.csv', "r");
        $header = true;

        $this->info('Creating users...');
        while ($csvLine = fgetcsv($handle, 1000, ",")) {
            if ($header) {
                $header = false;
            } else {
                $name = $csvLine[0];
                $email = $csvLine[1];
                $admin = $csvLine[2] === 1;
                $generatedPassword = Str::random(8);

                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'admin' => $admin,
                    'password' => Hash::make($generatedPassword)
                ]);

                Mail::to($user)->send(new UserCreated($user, $generatedPassword));

                $this->info("User: $user->name, email: $user->email created!");
            }
        }
        $this->info('Users created');
    }
}
