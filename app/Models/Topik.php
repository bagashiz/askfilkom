<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Topik extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'topik';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_topik';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
    ];

    /**
     * Many to many relation to Pertanyaan model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pertanyaan(): BelongsToMany
    {
        return $this->belongsToMany(Pertanyaan::class, 'pertanyaan_topik', 'id_topik', 'id_pertanyaan');
    }
}
