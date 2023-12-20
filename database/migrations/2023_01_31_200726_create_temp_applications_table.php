<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTempApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_applications', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('age');
            $table->string('steam_url');

            $table->string('discord_avatar');
            $table->string('discord_username');
            $table->string('discord_id');

            $table->longText('rules_opinion');
            $table->longText('rp_definition');
            $table->longText('past_characters');
            $table->longText('character_idea');
            $table->longText('streamer');
            $table->longText('me_do');
            $table->longText('ooc_vs_ic');
            $table->longText('do_lying');
            $table->longText('revenge_kill');
            $table->longText('brutally_wounded');
            $table->longText('meta_gaming');
            $table->longText('power_gaming');

            $table->longText('rp_action_1');
            $table->longText('rp_action_2');
            $table->longText('rp_action_3');
            $table->longText('rp_action_4');
            $table->longText('rp_action_5');
            $table->longText('rp_action_6');
            $table->longText('rp_action_7');
            $table->longText('rp_action_8');
            $table->longText('rp_action_9');
            $table->longText('rp_action_10');

            $table->integer('state');
            $table->string('admin')->nullable();

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
        Schema::dropIfExists('temp_applications');
    }
}
