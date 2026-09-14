<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['title', 'description', 'image'])]
class Project extends Model
{
    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('position');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function coverImage(): ?string
    {
        return $this->images->first()->path ?? $this->image;
    }
}
