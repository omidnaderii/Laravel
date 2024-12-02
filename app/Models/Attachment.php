<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'file_path', 'type'];

    
    public function post() {
        return $this->belongsTo(Post::class);
    }
}
