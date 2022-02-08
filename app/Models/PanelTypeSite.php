<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PanelTypeSite extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'panel_type_site';
}
