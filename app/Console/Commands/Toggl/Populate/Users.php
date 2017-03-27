<?php

namespace App\Console\Commands\Toggl\Populate;

use App\Apis\Toggl\Client;
use App\Models\User;
use Illuminate\Console\Command;
use JumpGate\Users\Models\User\Social;

class Users extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'toggl:populate:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Take all users from toggl and store locally.  (This will not overwrite existing users)';

    /**
     * @var \App\Apis\Toggl\Client
     */
    private $client;

    /**
     * @var \App\Models\User
     */
    private $User;

    /**
     * @var \JumpGate\Users\Models\User\Social
     */
    private $socials;

    /**
     * @param \App\Apis\Toggl\Client             $client
     * @param \App\Models\User                   $users
     * @param \JumpGate\Users\Models\User\Social $socials
     */
    public function __construct(Client $client, User $users, Social $socials)
    {
        parent::__construct();

        $this->client  = $client;
        $this->users   = $users;
        $this->socials = $socials;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        collect($this->client->handle('GetWorkspaceUsers', ['id' => (int)env('TOGGL_WORKSPACE_ID')]))->each(function ($togglUser) {
            $names     = explode(' ', $togglUser['fullname']);
            $firstName = null;
            $lastName  = null;

            if (isset($names[0])) {
                $firstName = $names[0];
            }
            if (isset($names[1])) {
                $lastName = $names[1];
            }
            if (isset($names[2])) {
                $lastName = $names[2];
            }

            $email = str_replace('emersonmedia', 'siterocket', $togglUser['email']);

            $user = $this->users->where('email', $email)->first();

            if (is_null($user)) {
                $user = $this->users->create([
                    'username'     => $email,
                    'email'        => $email,
                    'display_name' => $email,
                    'first_name'   => $firstName,
                    'last_name'    => $lastName,
                ]);
            }

            $this->socials->firstOrCreate(
                [
                    'user_id'  => $user->id,
                    'provider' => 'toggl',
                ],
                [
                    'user_id'       => $user->id,
                    'provider'      => 'toggl',
                    'social_id'     => $togglUser['id'],
                    'email'         => $email,
                    'avatar'        => $togglUser['image_url'],
                    'token'         => '',
                    'refresh_token' => null,
                    'expires_in'    => null,
                ]
            );

            if (! in_array($email, ['elena@siterocket.com', 'cole@siterocket.com', 'matt@siterocket.com', 'richard@siterocket.com'])) {
                if (! $user->hasRole('employee')) {
                    $user->assignRole('employee');
                }
            }

            if (in_array($email, ['david@siterocket.com', 'liat@siterocket.com', 'chip@siterocket.com'])) {
                if (! $user->hasRole('admin')) {
                    $user->assignRole('admin');
                }
            }
        });
    }
}
