<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * Class ProductImage
 * @package Common\Models
 * @property int $id
 * @property int $product_id
 * @property string $filename
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ProductImage extends ModelUuid
{
    use HasFactory;

    public const TABLE = 'products_images';

    public const ID_COLUMN = 'id';
    public const PRODUCT_ID_COLUMN = 'product_id';
    public const FILENAME_COLUMN = 'filename';
    public const CREATED_AT_COLUMN = 'created_at';
    public const UPDATED_AT_COLUMN = 'updated_at';

    protected $table = self::TABLE;

    protected $fillable = [
        self::PRODUCT_ID_COLUMN,
        self::FILENAME_COLUMN,
    ];

    public function getId(): string
    {
        return $this->getAttribute(self::ID_COLUMN);
    }

    public function getProductId(): string
    {
        return $this->getAttribute(self::PRODUCT_ID_COLUMN);
    }

    public function getFileName(): string
    {
        return $this->getAttribute(self::FILENAME_COLUMN);
    }

    public function getCreatedAt(): string
    {
        return $this->getAttribute(self::CREATED_AT_COLUMN);
    }

    public function getUpdatedAt(): string
    {
        return $this->getAttribute(self::UPDATED_AT_COLUMN);
    }
}
