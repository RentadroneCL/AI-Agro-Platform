<?php

namespace App\Models;

use App\Traits\HasManyAnnotations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Inspection extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasManyAnnotations;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inspections_information';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'site_id',
        'name',
        'commissioning_date',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'commissioning_date',
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class, 'site_id');
    }
}
