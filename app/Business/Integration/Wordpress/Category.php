<?php

namespace App\Business\Integration\Wordpress;

use App\Category as AppCategory;
use App\Business\Repositories\CategoryRepository;
use App\Product;
use Illuminate\Support\Collection;

class Category extends Importer
{
    public $wooCommerceCallback = 'products/categories';
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var Image
     */
    private $image;
    private $product;

    /**
     * Category constructor.
     * @param CategoryRepository $categoryRepository
     * @param Image $image
     */
    public function __construct(CategoryRepository $categoryRepository, Image $image)
    {
        $this->categoryRepository = $categoryRepository;
        $this->image = $image;
    }

    /**
     * @param Product $product
     */
    public function product(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Import all categories and relate them to the products
     * @param $categories
     * @return Collection
     */
    public function syncCategories($categories)
    {
        return collect($categories)
            ->sortBy('parent')
            ->each(function ($category) {
                $cat = $this->sync($category);
                $cat->products()->save($this->product);
            });
    }
    /**
     * @param $entity
     * @return AppCategory
     */
    public function sync($entity): AppCategory
    {
        $category = AppCategory::whereExternalId($entity['id'])->first();
        if (empty($category)) {
            $category = new AppCategory();
        }

        $category->name = $entity['name'];
        $category->slug = $entity['slug'];
        if (!empty($entity['menu_order'])) {
            $category->order = $entity['menu_order'];
        }
        if (!empty($entity['count'])) {
            $category->products_count = $entity['count'];
        }
        if (!empty($entity['description'])) {
            $category->description = $entity['description'];
        }
        $category->external_id = $entity['id'];
        if (!empty($entity['image'])) {
            $category->filename = Image::saveImage($entity['image']);
        }

        $this->categoryRepository->update($category, $category->toArray());

        if (!empty($entity['parent'])) {
            /** @var Category $father */
            $father = AppCategory::whereExternalId($entity['parent'])->first();
            if (!is_null($father)) {
                $father->children()->save($category);
            }
        }
        return $category;
    }
}
