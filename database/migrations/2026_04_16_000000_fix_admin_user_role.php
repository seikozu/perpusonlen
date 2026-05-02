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
        // Dapatkan ID dari role admin
        $adminRoleId = DB::table('roles')->where('name', 'admin')->value('id');
        
        if ($adminRoleId) {
            // Update semua user yang memiliki role string 'admin' atau nama 'admin'
            DB::table('users')->where('role', 'admin')->update([
                'role_id' => $adminRoleId
            ]);
            
            DB::table('users')->whereRaw("LOWER(name) LIKE '%admin%'")->update([
                'role_id' => $adminRoleId
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reset to customer role if needed
        $customerRoleId = DB::table('roles')->where('name', 'customer')->value('id');
        if ($customerRoleId) {
            DB::table('users')->whereRaw("LOWER(name) LIKE '%admin%'")->update([
                'role_id' => $customerRoleId
            ]);
        }
    }
};
