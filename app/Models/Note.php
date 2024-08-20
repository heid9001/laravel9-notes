<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'title',
        'content',
        'user_id'
    ];

    protected $appends = ['shortContent', 'shortTitle'];

    protected $visible = [
        'id',
        'title',
        'content',
        'shortContent',
        'shortTitle'
    ];

    public $timestamps = true;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getShortTitleAttribute()
    {
        $num = 10;
        if (mb_strlen($this->title) > $num) {
            return mb_substr($this->title, 0, 10) . "...";
        }
        return $this->title;
    }

    public function getShortContentAttribute()
    {
        $num = 10;
        if (mb_strlen($this->content) > $num) {
            return mb_substr($this->content, 0, 10) . "...";
        }
        return $this->content;
    }
}
