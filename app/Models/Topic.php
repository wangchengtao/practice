<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;

class Topic extends Model
{
    use Filterable;

    protected $fillable = [
        'title', 'body', 'category_id', 'excerpt', 'slug',
    ];

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lastReplyUser()
    {
        return $this->belongsTo(User::class, 'last_reply_user_id');
    }

    public function scopeRecent(Builder $builder): Builder
    {
        return $builder->orderBy('created_at', 'desc');
    }

    public function scopeRecentReplied(Builder $builder): Builder
    {
        return $builder->orderBy('updated_at', 'desc');
    }
}
