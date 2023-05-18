<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'nama',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_admin' => 'boolean',
        'email_verified_at' => 'timestamp',
    ];

    /**
     * One to many relation to Pertanyaan model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pertanyaan(): HasMany
    {
        return $this->hasMany(Pertanyaan::class, 'id_user');
    }

    /**
     * One to many relation to Jawaban model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jawaban(): HasMany
    {
        return $this->hasMany(Jawaban::class, 'id_user');
    }

    /**
     * One to many relation to Vote model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vote(): HasMany
    {
        return $this->hasMany(Vote::class, 'id_user');
    }
}
