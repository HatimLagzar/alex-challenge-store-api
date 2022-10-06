<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariant extends ModelUuid
{
    use HasFactory;

    public const TABLE = 'products_variants';

    public const ID_COLUMN = 'id';
    public const PRODUCT_ID_COLUMN = 'product_id';
    public const SIZE_COLUMN = 'size';
    public const STOCK_COLUMN = 'stock';

    protected $table = self::TABLE;

    protected $fillable = [
        self::PRODUCT_ID_COLUMN,
        self::SIZE_COLUMN,
        self::STOCK_COLUMN,
    ];

    public function getId(): string
    {
        return $this->getAttribute(self::ID_COLUMN);
    }

    public function getProductId(): string
    {
        return $this->getAttribute(self::PRODUCT_ID_COLUMN);
    }

    public function getSize(): string
    {
        return $this->getAttribute(self::SIZE_COLUMN);
    }

    public function getStock(): int
    {
        return $this->getAttribute(self::STOCK_COLUMN);
    }
}
