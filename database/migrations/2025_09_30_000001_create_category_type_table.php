<?php

declare(strict_types=1);

/**
 * NOTICE OF LICENSE.
 *
 * UNIT3D Community Edition is open-sourced software licensed under the GNU Affero General Public License v3.0
 * The details is bundled with this project in the file LICENSE.txt.
 *
 * @project    UNIT3D Community Edition
 *
 * @author     HDVinnie <hdinnovations@protonmail.com>
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html/ GNU Affero General Public License v3.0
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('category_type', function (Blueprint $table): void {
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('type_id');

            $table->primary(['category_id', 'type_id']);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
        });

        $categoryIds = DB::table('categories')->pluck('id');
        $typeIds = DB::table('types')->pluck('id');

        if ($categoryIds->isEmpty() || $typeIds->isEmpty()) {
            return;
        }

        $rows = [];

        foreach ($categoryIds as $categoryId) {
            foreach ($typeIds as $typeId) {
                $rows[] = [
                    'category_id' => $categoryId,
                    'type_id'     => $typeId,
                ];
            }
        }

        DB::table('category_type')->insert($rows);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_type');
    }
};
