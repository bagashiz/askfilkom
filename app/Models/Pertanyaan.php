<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pertanyaan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pertanyaan';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_pertanyaan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'judul',
        'deskripsi',
        'jumlah_vote',
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
     * Many to many relation to Topik model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function topik(): BelongsToMany
    {
        return $this->belongsToMany(Topik::class, 'pertanyaan_topik', 'id_pertanyaan', 'id_topik');
    }

    /**
     * One to many relation to Jawaban model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jawaban(): HasMany
    {
        return $this->hasMany(Jawaban::class, 'id_pertanyaan');
    }

    /**
     * One to many relation to Vote model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vote(): HasMany
    {
        return $this->hasMany(Vote::class, 'id_pertanyaan');
    }

    /**
     * scopeFilter defines filter that used in query
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $search
     * @param string|null $topik
     * @param string|null $sort
     * @return void
     */
    public function scopeFilter($query, ?string $search = null, ?string $topik = null, ?string $sort = null): void
    {
        if ($search ?? false) {
            $query->where('judul', 'like', '%' . $search . '%')
                ->orWhere('deskripsi', 'like', '%' . $search . '%');
        }
        if ($topik ?? false) {
            $query->whereHas('topik', function ($query) use ($topik) {
                $query->where('nama', $topik);
            });
        }

        if ($sort ?? false) {
            if ($sort === 'votes') {
                $query->orderBy('jumlah_vote', 'desc');
            } else if ($sort === 'latest') {
                $query->latest();
            }
        }
    }
}
