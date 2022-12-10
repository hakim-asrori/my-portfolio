<?php

namespace App\Models;

use App\Http\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Document extends Model
{
    use HasFactory, Uuid;

    protected $guarded = ['created_at', 'updated_at'];

    public function documentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getDocumentPathAttribute($path)
    {
        return url('storage/' . $path);
    }
}
