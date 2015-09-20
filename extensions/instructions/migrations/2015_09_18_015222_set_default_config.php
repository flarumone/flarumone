<?php

namespace Flarum\Migrations\Instructions;

use Illuminate\Database\Schema\Blueprint;
use Flarum\Migrations\Migration;

class SetDefaultConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->settings->set('instructions.start_instructions_max_discussions', 2);
        $this->settings->set('instructions.reply_instructions_max_posts', 2);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->settings->delete('instructions.%');
    }
}
