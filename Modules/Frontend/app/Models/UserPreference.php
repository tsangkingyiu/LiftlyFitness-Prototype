<?php

namespace Modules\Frontend\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use APP\Models\User;

class UserPreference extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'key', 'value'];

    protected $casts = [
        'user_id'   => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeMyPreference($query)
    {
        $user = auth()->user();
        return $query->where('user_id', $user->id);
    }
}
