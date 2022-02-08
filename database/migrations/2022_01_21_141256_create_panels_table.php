<?php

use App\Models\PanelType;
use App\Models\Site;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePanelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('panels', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Site::class, 'site_id')->constrained('sites_information', 'id')->cascadeOnDelete();
            $table->string('panel_id')->unique();
            $table->string('panel_serial');
            $table->string('panel_zone')->nullable();
            $table->string('panel_sub_zone')->nullable();
            $table->string('panel_string')->nullable();
            $table->json('custom_properties')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('panels');
    }
}
