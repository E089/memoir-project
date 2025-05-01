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
        Schema::table('entry_tag', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entry_tag', function (Blueprint $table) {
            // Drop the foreign key constraint by specifying the constraint name
            $table->dropForeign('entry_tag_user_id_foreign');  // Use the exact name of the foreign key constraint

            // Now drop the column
            $table->dropColumn('user_id');
        });
    }
};
