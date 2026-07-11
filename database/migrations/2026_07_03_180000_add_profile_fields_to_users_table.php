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

            if (!Schema::hasColumn('users', 'profile_photo')) {
                $table->string('profile_photo')->nullable()->after('border_style');
            }

            if (!Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable()->after('profile_photo');
            }

            if (!Schema::hasColumn('users', 'instagram_link')) {
                $table->string('instagram_link')->nullable()->after('bio');
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $columns = [];

            if (Schema::hasColumn('users', 'profile_photo')) {
                $columns[] = 'profile_photo';
            }

            if (Schema::hasColumn('users', 'bio')) {
                $columns[] = 'bio';
            }

            if (Schema::hasColumn('users', 'instagram_link')) {
                $columns[] = 'instagram_link';
            }

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }

        });
    }
};
