<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


/**
 * App\Models\User
 *
 * @property int $id
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $location
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $friendOf
 * @property-read int|null $friend_of_count
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $friendsOfMine
 * @property-read int|null $friends_of_mine_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Status[] $statuses
 * @property-read int|null $statuses_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'username', 'password', 'first_name', 'last_name', 'location',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getName()
    {
        if ($this->first_name && $this->last_name) {
            return "{$this->first_name}  {$this->last_name}";
        }

        if ($this->first_name) {
            return "{$this->first_name}";
        }

        return null;
    }

    public function getNameOrUserName()
    {
        return $this->getName() ?: $this->username;
    }
    public function getFirstNameOrUserName()
    {
        return $this->first_name ?: $this->username;
    }

    //Получить аватарку
    public function getAvatarUrl()
    {
        return asset('img/avatar.png');
    }


    //Пользователяю пренадлежит статус
    public function statuses()
    {
        return $this->hasMany('App\Models\Status', 'user_id');
    }

    //Отношения многие ко многим мои друзья
    public function friendsOfMine()
    {
        return $this->belongsToMany('App\Models\User', 'friends', 'friend_id', 'user_id');
    }

    // Отношения многие ко многим, Друг
    public function friendOf()
    {
        return $this->belongsToMany('App\Models\User', 'friends', 'user_id', 'friend_id');
    }

    //Получить друзей с обеих сторон
    public function friends()
    {
        return $this->friendsOfMine()->wherePivot('accepted', true)->get()
            ->merge($this->friendOf()->wherePivot('accepted', true)->get());
    }

    //Запрос в друзья
    public function friendRequests()
    {
        // dd($this->friendsOfMine());
        return $this->friendsOfMine()->wherePivot('accepted', false)->get();
    }

    #Запрос на ожидание друга
    public function friendRequestPending()
    {
        return $this->friendOf()->wherePivot('accepted', false)->get();
    }

    #Есть запрос на добавление в друзья
    public function hasFriendRequestsPending(User $user)
    {
        return (bool) $this->friendRequestPending()->where('id', $user->id)->count();
    }

    #Получил запрос о дружбе
    public function hasFriendRequestReceived(User $user)
    {
        // return true;
        return (bool) $this->friendRequests()->where('id', $user->id)->count();
    }

    #Добавить друга
    public function addFriend(User $user)
    {
        // dd($user->id);
        return $this->friendOf()->attach($user->id);
    }

    #Удалить друга
    public function deleteFriend(User $user)
    {
        $this->friendOf()->detach($user->id);
        $this->friendsOfMine()->detach($user->id);
    }

    #Принять запрос на дружбу
    public function acceptFriendRequest(User $user)
    {
        return $this->friendRequests()->where('id', $user->id)->first()->pivot->update(['accepted' => true]);
    }

    #Пользователь уже в друзьях

    public function isFriendWith(User $user)
    {
        return (bool) $this->friends()->where('id', $user->id)->count();
    }
}
