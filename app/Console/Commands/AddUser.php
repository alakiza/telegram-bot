<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class AddUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:addUser {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add admin user';

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
     * @return int
     */
    public function handle()
    {
        $user = new User();
        $user->name = "";
        $user->email = $this->argument('email');
        $user->password = bcrypt($this->argument('password'));
        $user->save();
            
        return 0;
    }
}
