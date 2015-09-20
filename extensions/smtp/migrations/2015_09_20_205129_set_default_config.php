<?php

namespace Flarum\Migrations\SMTP;

use Flarum\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class SetDefaultConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->settings->set('mail_driver', 'smtp');
        $this->settings->set('mail_from', '');
        $this->settings->set('mail_host', '');
        $this->settings->set('mail_port', 25);
        $this->settings->set('mail_username', '');
        $this->settings->set('mail_password', '');
        $this->settings->set('mail_encryption', '');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->settings->delete('mail_host');
        $this->settings->delete('mail_port');
        $this->settings->delete('mail_username');
        $this->settings->delete('mail_password');
        $this->settings->delete('mail_encryption');
        $this->settings->set('mail_driver', 'mail');
    }
}
