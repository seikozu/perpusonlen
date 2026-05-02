<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ensure roles table has timestamps
        if (!Schema::hasColumn('roles', 'created_at')) {
            Schema::table('roles', function (Blueprint $table) {
                $table->timestamps();
            });
        }

        // Ensure roles table punya data yang tepat
        $roles = ['admin', 'vendor', 'customer'];
        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['name' => $role],
                ['name' => $role, 'created_at' => now(), 'updated_at' => now()]
            );
        }

        // Tambahkan role_id foreign key ke users table jika belum ada
        if (!Schema::hasColumn('users', 'role_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('role_id')->nullable()->after('email');
                $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
            });

            // Populate role_id dari string role yang sudah ada
            $roles = DB::table('roles')->pluck('id', 'name');
            
            DB::table('users')->whereNotNull('role')->update([
                'role_id' => DB::raw("(SELECT id FROM roles WHERE roles.name = users.role LIMIT 1)")
            ]);

            // Default ke customer jika still null
            DB::table('users')->whereNull('role_id')->update([
                'role_id' => $roles['customer'] ?? 1
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'role_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['role_id']);
                $table->dropColumn('role_id');
            });
        }
    }
};
