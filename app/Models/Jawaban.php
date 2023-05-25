<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jawaban extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jawaban';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_jawaban';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_user',
        'deskripsi',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'jumlah_vote' => 'int',
    ];

    /**
     * Many to one relation to User model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Many to one relation to Pertanyaan model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pertanyaan(): BelongsTo
    {
        return $this->belongsTo(Pertanyaan::class, 'id_pertanyaan');
    }

    /**
     * One to Many relation to Vote model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vote(): HasMany
    {
        return $this->hasMany(Vote::class, 'id_jawaban');
    }
}
