<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement($this->dropView());
    }


    private function createView(): string
    {
        return <<<SQL
            CREATE VIEW view_tracking_data AS
            SELECT
                    pengajuans.*,
                    managers.manager,
                    managers.alasan_manager,
                    managers.action_at AS manager_created,
                    finances.finance,
                    finances.alasan_finance,
                    finances.bukti_transfer,
                    finances.created_at AS finance_create,
                    finances.updated_at AS finance_update,
                    users.name 
                FROM
                    pengajuans
                    LEFT JOIN managers ON pengajuans.id = managers.pengajuan_id
                    LEFT JOIN finances ON pengajuans.id = finances.pengajuan_finance_id
                    LEFT JOIN users ON pengajuans.user_id = users.id 
                ORDER BY
                    pengajuans.id DESC 
            SQL;
    }

    private function dropView(): string
    {
        return <<<SQL
            DROP VIEW IF EXISTS `view_tracking_data`;
            SQL;
    }
};
