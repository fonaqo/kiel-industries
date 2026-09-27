<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $map = [
            'paid' => 'processing',
            'pending' => 'processing',
            'confirmed' => 'processing',
            'shipped' => 'shipping',
        ];

        foreach ($map as $from => $to) {
            DB::table('orders')->where('status', $from)->update(['status' => $to]);
        }
    }

    public function down(): void
    {
        // Non réversible sans sauvegarde des anciens statuts.
    }
};
