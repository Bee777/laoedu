<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DictionaryComment extends Model
{

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dictionary()
    {
        return $this->belongsTo(Dictionary::class);
    }

    public function replies()
    {
        return $this->hasMany(DictionaryCommentReply::class, 'dictionary_comment_id');
    }
}
