<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vote';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_vote';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_user',
        'id_pertanyaan',
        'id_jawaban',
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
     * Many to one relation to Jawaban model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jawaban(): BelongsTo
    {
        return $this->belongsTo(Jawaban::class, 'id_jawaban');
    }
}
