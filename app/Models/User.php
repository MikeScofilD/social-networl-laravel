<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

    public function getAvatarUrl()
    {
        return asset('img/avatar.png');
    }

    public function friendsOfMine()
    {
        return $this->belongsToMany('App\Models\User', 'friends', 'user_id', 'friend_id');
    }

    public function friendOf()
    {
        return $this->belongsToMany('App\Models\User', 'friends', 'friend_id', 'user_id');
    }

    public function friends()
    {
        return $this->friendsOfMine()->wherePivot('accepted', true)->get()
            ->merge($this->friendOf()->wherePivot('accepted', true)->get());
    }

    public function friendRequests()
    {
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
        return $this->friendOf()->attach($user->id);
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
