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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('unique_key')->unique(); // UNIQUE_KEY
            $table->string('product_title'); // PRODUCT_TITLE
            $table->text('product_description'); // PRODUCT_DESCRIPTION
            $table->string('style_number'); // STYLE#
            $table->string('available_sizes'); // AVAILABLE_SIZES
            $table->string('brand_logo_image'); // BRAND_LOGO_IMAGE
            $table->string('thumbnail_image'); // THUMBNAIL_IMAGE
            $table->string('color_swatch_image'); // COLOR_SWATCH_IMAGE
            $table->string('product_image'); // PRODUCT_IMAGE
            $table->string('spec_sheet'); // SPEC_SHEET
            $table->string('price_text'); // PRICE_TEXT
            $table->decimal('suggested_price', 8, 2); // SUGGESTED_PRICE
            $table->string('category_name'); // CATEGORY_NAME
            $table->string('subcategory_name'); // SUBCATEGORY_NAME
            $table->string('color_name'); // COLOR_NAME
            $table->string('color_square_image'); // COLOR_SQUARE_IMAGE
            $table->string('color_product_image'); // COLOR_PRODUCT_IMAGE
            $table->string('color_product_image_thumbnail'); // COLOR_PRODUCT_IMAGE_THUMBNAIL
            $table->string('size'); // SIZE
            $table->integer('qty'); // QTY
            $table->decimal('piece_weight', 8, 2); // PIECE_WEIGHT
            $table->decimal('piece_price', 8, 2); // PIECE_PRICE
            $table->decimal('dozens_price', 8, 2); // DOZENS_PRICE
            $table->decimal('case_price', 8, 2); // CASE_PRICE
            $table->string('price_group'); // PRICE_GROUP
            $table->string('case_size'); // CASE_SIZE
            $table->string('inventory_key'); // INVENTORY_KEY
            $table->integer('size_index'); // SIZE_INDEX
            $table->string('sanmar_mainframe_color'); // SANMAR_MAINFRAME_COLOR
            $table->string('mill'); // MILL
            $table->string('product_status'); // PRODUCT_STATUS
            $table->string('companion_styles'); // COMPANION_STYLES
            $table->decimal('msrp', 8, 2); // MSRP
            $table->decimal('map_pricing', 8, 2); // MAP_PRICING
            $table->string('front_model_image_url'); // FRONT_MODEL_IMAGE_URL
            $table->string('back_model_image'); // BACK_MODEL_IMAGE
            $table->string('front_flat_image'); // FRONT_FLAT_IMAGE
            $table->string('back_flat_image'); // BACK_FLAT_IMAGE
            $table->text('product_measurements'); // PRODUCT_MEASUREMENTS
            $table->string('pms_color'); // PMS_COLOR
            $table->string('gtin'); // GTIN
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
