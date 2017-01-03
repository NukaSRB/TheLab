<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $display_name
 * @property string $timezone
 * @property string $location
 * @property string $url
 * @property bool $status_id
 * @property string $remember_token
 * @property bool $super_flag
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \JumpGate\Database\Collection|\JumpGate\Users\Models\Role[] $roles
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $readNotifications
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $unreadNotifications
 * @property-read \JumpGate\Database\Collection|\JumpGate\Users\Models\User\Social[] $socials
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereDisplayName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereTimezone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereLocation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereStatusId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereSuperFlag($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\JumpGate\Users\Models\User orderByNameAsc()
 * @method static \Illuminate\Database\Query\Builder|\JumpGate\Core\Models\BaseModel orderByCreatedAsc()
 * @method static \Illuminate\Database\Query\Builder|\JumpGate\Core\Models\BaseModel active()
 * @method static \Illuminate\Database\Query\Builder|\JumpGate\Core\Models\BaseModel inactive()
 */
	class User extends \Eloquent {}
}

namespace App\Services\Clients\Models{
/**
 * App\Services\Clients\Models\Client
 *
 * @property int $id
 * @property string $asana_id
 * @property string $toggl_id
 * @property string $name
 * @property string $label
 * @property string $color
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Services\Clients\Models\Client whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Services\Clients\Models\Client whereAsanaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Services\Clients\Models\Client whereTogglId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Services\Clients\Models\Client whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Services\Clients\Models\Client whereLabel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Services\Clients\Models\Client whereColor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Services\Clients\Models\Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Services\Clients\Models\Client whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Services\Clients\Models\Client whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\JumpGate\Core\Models\BaseModel orderByCreatedAsc()
 * @method static \Illuminate\Database\Query\Builder|\JumpGate\Core\Models\BaseModel orderByNameAsc()
 * @method static \Illuminate\Database\Query\Builder|\JumpGate\Core\Models\BaseModel active()
 * @method static \Illuminate\Database\Query\Builder|\JumpGate\Core\Models\BaseModel inactive()
 * @method static \Illuminate\Database\Query\Builder|\App\Services\Clients\Models\Client findSimilarSlugs(\Illuminate\Database\Eloquent\Model $model, $attribute, $config, $slug)
 */
	class Client extends \Eloquent {}
}

namespace App\Services\Scheduling\Models{
/**
 * App\Services\Scheduling\Models\ScheduledHour
 *
 * @property int $id
 * @property int $user_id
 * @property int $client_id
 * @property \Carbon\Carbon $date
 * @property int $hours
 * @property string $note
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \App\Models\User $user
 * @property-read \App\Services\Clients\Models\Client $client
 * @method static \Illuminate\Database\Query\Builder|\App\Services\Scheduling\Models\ScheduledHour whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Services\Scheduling\Models\ScheduledHour whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Services\Scheduling\Models\ScheduledHour whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Services\Scheduling\Models\ScheduledHour whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Services\Scheduling\Models\ScheduledHour whereHours($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Services\Scheduling\Models\ScheduledHour whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Services\Scheduling\Models\ScheduledHour whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Services\Scheduling\Models\ScheduledHour whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Services\Scheduling\Models\ScheduledHour whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\JumpGate\Core\Models\BaseModel orderByCreatedAsc()
 * @method static \Illuminate\Database\Query\Builder|\JumpGate\Core\Models\BaseModel orderByNameAsc()
 * @method static \Illuminate\Database\Query\Builder|\JumpGate\Core\Models\BaseModel active()
 * @method static \Illuminate\Database\Query\Builder|\JumpGate\Core\Models\BaseModel inactive()
 */
	class ScheduledHour extends \Eloquent {}
}

