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
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); //foreign key with id of user
            $table->date('date')->nullable(); // ノートの日付
            $table->longText('highlights')->nullable(); // 今日のハイライト
            $table->longText('highlights_jp')->nullable(); // 今日の出来事（日本語）
            $table->longText('feelings')->nullable(); // 気持ちや感情
            $table->longText('feelings_jp')->nullable(); // 気持ちや感情（日本語）
            $table->longText('learnings')->nullable(); // 学んだことや気づき
            $table->longText('learnings_jp')->nullable(); // 学んだことや気づき（日本語）
            $table->longText('plans')->nullable(); // 明日への計画
            $table->longText('plans_jp')->nullable(); // 明日への計画（日本語）
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};
