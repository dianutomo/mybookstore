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
        Schema::table('books', function (Blueprint $table) {
            // add foreign key column
            $table->unsignedBigInteger('author_id')->after('id');

            // define foreign key constraint
            $table->foreign('author_id')
                 ->references('id')->on('authors')
                 ->onDelete('cascade'); // if author deleted, their books also deleted
            // $table->unsignedBigInteger('author_id')->nullable()->after('id');

            // $table->foreign('author_id')
            //     ->references('id')->on('authors')
            //     ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
            $table->dropColumn('author_id');
        });
    }
};
