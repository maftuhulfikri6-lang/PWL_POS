<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// Tambahkan ini jika file LevelModel ada di folder yang sama
use App\Models\LevelModel; 

class UserModel extends Model
{
    protected $table = 'm_user';
    protected $primaryKey = 'user_id';
    protected $fillable = ['level_id', 'username', 'nama', 'password'];

    // Mendefinisikan relasi: Setiap User 'milik' satu Level
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }
}