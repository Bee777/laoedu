<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DictionaryCommentReply extends Model
{
    public function comment() {
        return $this->belongsTo(DictionaryComment::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
