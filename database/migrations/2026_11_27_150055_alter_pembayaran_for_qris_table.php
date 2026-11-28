<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Hapus CHECK constraint enum lama bawaan PostgreSQL
        DB::statement('ALTER TABLE pembayaran DROP CONSTRAINT IF EXISTS pembayaran_metode_pembayaran_check');
        DB::statement('ALTER TABLE pembayaran DROP CONSTRAINT IF EXISTS pembayaran_status_check');

        // 2. Konversi data lama (jika sudah ada record di tabel)
        DB::table('pembayaran')->where('status', 'menunggu pembayaran')->update(['status' => 'pending']);
        DB::table('pembayaran')->where('status', 'sudah dibayar')->update(['status' => 'paid']);
        DB::table('pembayaran')->whereIn('status', ['gagal', 'expired'])->update(['status' => 'failed']);

        // 3. Set default baru dan tambahkan CHECK constraint enum yang baru
        DB::statement("ALTER TABLE pembayaran ALTER COLUMN metode_pembayaran SET DEFAULT 'qris'");
        DB::statement("ALTER TABLE pembayaran ADD CONSTRAINT pembayaran_metode_pembayaran_check CHECK (metode_pembayaran IN ('qris', 'transfer bank', 'e-wallet', 'cash'))");

        DB::statement("ALTER TABLE pembayaran ALTER COLUMN status SET DEFAULT 'pending'");
        DB::statement("ALTER TABLE pembayaran ADD CONSTRAINT pembayaran_status_check CHECK (status IN ('pending', 'paid', 'failed'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE pembayaran DROP CONSTRAINT IF EXISTS pembayaran_metode_pembayaran_check');
        DB::statement('ALTER TABLE pembayaran DROP CONSTRAINT IF EXISTS pembayaran_status_check');

        DB::table('pembayaran')->where('status', 'pending')->update(['status' => 'menunggu pembayaran']);
        DB::table('pembayaran')->where('status', 'paid')->update(['status' => 'sudah dibayar']);
        DB::table('pembayaran')->where('status', 'failed')->update(['status' => 'gagal']);

        DB::statement("ALTER TABLE pembayaran ALTER COLUMN metode_pembayaran SET DEFAULT 'transfer bank'");
        DB::statement("ALTER TABLE pembayaran ADD CONSTRAINT pembayaran_metode_pembayaran_check CHECK (metode_pembayaran IN ('transfer bank', 'e-wallet', 'cash'))");

        DB::statement("ALTER TABLE pembayaran ALTER COLUMN status SET DEFAULT 'menunggu pembayaran'");
        DB::statement("ALTER TABLE pembayaran ADD CONSTRAINT pembayaran_status_check CHECK (status IN ('menunggu pembayaran', 'sudah dibayar', 'gagal', 'expired'))");
    }
};