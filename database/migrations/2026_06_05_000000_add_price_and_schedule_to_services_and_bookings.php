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
        Schema::table('services', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->default(0)->after('description');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->date('booking_date')->nullable()->after('service_id');
            $table->string('time_slot')->nullable()->after('booking_date');
            $table->decimal('service_price', 10, 2)->default(0)->after('time_slot');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['booking_date', 'time_slot', 'service_price']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
};
