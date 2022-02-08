<?php

namespace App\Traits;

use App\Models\Annotation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Undocumented trait
 */
trait HasManyAnnotations
{
    /**
     * Annotations related models.
     *
     * @return MorphMany
     */
    public function annotations(): MorphMany
    {
        return $this->morphMany(Annotation::class, 'annotable');
    }
}
