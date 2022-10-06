<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends ModelUuid
{
    use HasFactory;

    public const TABLE = 'products';

    public const ID_COLUMN = 'id';
    public const TITLE_COLUMN = 'title';
    public const PRICE_COLUMN = 'price';
    public const DISCOUNT_COLUMN = 'discount';
    public const DESCRIPTION_COLUMN = 'description';
    public const THUMBNAIL_COLUMN = 'thumbnail';
    public const CREATED_AT_COLUMN = 'created_at';

    protected $table = self::TABLE;

    protected $fillable = [
        self::TITLE_COLUMN,
        self::PRICE_COLUMN,
        self::DISCOUNT_COLUMN,
        self::DESCRIPTION_COLUMN,
        self::THUMBNAIL_COLUMN,
    ];

    private ?Collection $variants = null;
    private ?Collection $extraImages = null;

    public function getId(): string
    {
        return $this->getAttribute(self::ID_COLUMN);
    }

    public function getVariants(): ?Collection
    {
        return $this->variants;
    }

    public function setVariants(Collection $variants): self
    {
        $this->variants = $variants;

        return $this;
    }

    public function getExtraImages(): ?Collection
    {
        return $this->extraImages;
    }

    public function setExtraImages(Collection $extraImages): self
    {
        $this->extraImages = $extraImages;

        return $this;
    }

    public function getThumbnail(): string
    {
        return $this->getAttribute(self::THUMBNAIL_COLUMN);
    }

    public function getTitle(): string
    {
        return $this->getAttribute(self::TITLE_COLUMN);
    }

    public function getPrice(): int
    {
        return $this->getAttribute(self::PRICE_COLUMN);
    }

    public function getPriceFormatted(): string
    {
        return number_format($this->getPrice() / 100, 2);
    }

    public function getDiscount(): int
    {
        return $this->getAttribute(self::DISCOUNT_COLUMN);
    }

    public function getDescription(): string
    {
        return $this->getAttribute(self::DESCRIPTION_COLUMN);
    }
}
