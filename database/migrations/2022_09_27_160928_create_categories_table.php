<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string("title")->nullable(false);
            $table->string("color")->default("#FFFFFF");
            $table->foreignIdFor(User::class)->references("id")->on("users")->onDelete("CASCADE");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("categories", function (Blueprint $table) {
            $table->dropForeignIIdFor(User::class);
        });
        Schema::dropIfExists('categories');
    }
}
