<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_notification_enabled');
            $table->tinyInteger('notify_likes')->default(1);
            $table->tinyInteger('notify_comments')->default(1);
            $table->tinyInteger('notify_followers')->default(1);
            $table->tinyInteger('notify_stars')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_notification_enabled')->default(1);
            $table->dropColumn(['notify_likes', 'notify_comments', 'notify_followers', 'notify_stars']);
        });
    }
};
