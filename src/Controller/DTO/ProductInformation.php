<?php

namespace App\Controller\DTO;


use JsonSerializable;

class ProductInformation implements JsonSerializable
{
    /**
     * @var int
     */
    private $productId;

    /**
     * @var $string
     */
    private $title;

    /**
     * @var ?string
     */
    private $subtitle;

    /**
     * @var ?string
     */
    private $image;

    /**
     * @var ?string
     */
    private $thumbnail;

    /**
     * @var string[]
     */
    private $category = [];

    /**
     * @var ?string
     */
    private $url;

    /**
     * @var ?string
     */
    private $upc;

    /**
     * @var ?string
     */
    private $gtin14;

    /**
     * @var ?string
     */
    private $createdAt;

    /**
     * @var ?ProductBrand
     */
    private $brand;

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @param int $productId
     */
    public function setProductId(int $productId): void
    {
        $this->productId = $productId;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    /**
     * @param string|null $subtitle
     */
    public function setSubtitle(?string $subtitle): void
    {
        $this->subtitle = $subtitle;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return string|null
     */
    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    /**
     * @param string|null $thumbnail
     */
    public function setThumbnail(?string $thumbnail): void
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @return string[]
     */
    public function getCategory(): array
    {
        return $this->category;
    }

    /**
     * @param string[] $category
     */
    public function setCategory(array $category): void
    {
        $this->category = $category;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     */
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string|null
     */
    public function getUpc(): ?string
    {
        return $this->upc;
    }

    /**
     * @param string|null $upc
     */
    public function setUpc(?string $upc): void
    {
        $this->upc = $upc;
    }

    /**
     * @return string|null
     */
    public function getGtin14(): ?string
    {
        return $this->gtin14;
    }

    /**
     * @param string|null $gtin14
     */
    public function setGtin14(?string $gtin14): void
    {
        $this->gtin14 = $gtin14;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @param string|null $createdAt
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return ProductBrand|null
     */
    public function getBrand(): ?ProductBrand
    {
        return $this->brand;
    }

    /**
     * @param ProductBrand|null $brand
     */
    public function setBrand(?ProductBrand $brand): void
    {
        $this->brand = $brand;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}