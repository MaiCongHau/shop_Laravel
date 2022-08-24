<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            $table->string( 'code' )->unique( );
            $table->text( 'description' )->nullable( );
            $table->integer( 'is_fixed'); // có 2 cách discount là % và giảm dựa trên giá tiền trực tiếp, ta có thể quy định 0 là giảm trên %, 1 là giảm trên giá tiền trực tiếp 
            $table->integer( 'discount_amount' );
            $table->timestamp( 'starts_at' )->nullable( );
            $table->timestamp( 'expires_at' )->nullable( );
            $table->timestamps( );
            $table->softDeletes( ); // xóa mềm tức là nó sẽ cho thêm 1 cột deleted_at trong database, nếu muốn xóa thì nó sẽ cho giá trị cột này có giá trị khác null, mặc định lúc đầu của nó là null, lúc mà lấy thì nó sẽ lấy tất cả các cột có giá trị là null và bỏ cột có giá trị khác null
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discounts');
    }
}
