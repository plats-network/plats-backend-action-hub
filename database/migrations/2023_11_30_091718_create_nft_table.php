<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//https://www.timescale.com/blog/how-to-store-and-analyze-nft-data-in-a-relational-database/
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //NFT Owner
        Schema::create('nft_owner', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('address');
            $table->string('description');
            $table->string('balance');
        });

        //Collection
        Schema::create('nft_collection', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('slug');
            $table->string('description');
            $table->string('url');
        });

        Schema::create('nft', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->string('name');
            $table->string('description');
            $table->string('image_url');
            $table->string('permalink');
            $table->string('asset_contract');
            $table->string('collection_id');
            //owner_id
            $table->string('owner_id');
            //contract_date
            $table->string('contract_date');
            //Blockchain
            $table->string('blockchain');
            //IS send
            $table->string('is_send');
        });


        //CREATE TABLE nft_sales (
        //   id BIGINT,
        //   "time" TIMESTAMP WITH TIME ZONE,
        //   asset_id BIGINT REFERENCES assets (id), -- asset
        //   collection_id BIGINT REFERENCES collections (id), -- collection
        //   auction_type auction,
        //   contract_address TEXT,
        //   quantity NUMERIC,
        //   payment_symbol TEXT,
        //   total_price DOUBLE PRECISION,
        //   seller_account BIGINT REFERENCES accounts (id), -- account
        //   from_account BIGINT REFERENCES accounts (id), -- account
        //   to_account BIGINT REFERENCES accounts (id), -- account
        //   winner_account BIGINT REFERENCES accounts (id), -- account
        //   CONSTRAINT id_time_unique UNIQUE (id, time)
        //);

        Schema::create('nft_sales', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->string('time');
            $table->string('asset_id');
            $table->string('collection_id')->nullable();
            $table->string('auction_type')->nullable();
            $table->string('contract_address')->nullable();

            $table->string('quantity')->nullable();
            $table->string('payment_symbol')->nullable();

            $table->string('total_price')->nullable();
            $table->string('seller_account')->nullable();

            $table->string('from_account')->nullable();
            $table->string('to_account')->nullable();
            $table->string('winner_account')->nullable();
        });
    }

    /**
     *  Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nft');
    }

};
