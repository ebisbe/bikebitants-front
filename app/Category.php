<?php

namespace App;

use App\Business\Traits\Presenters\CategoryPresenter;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Business\Traits\SluggableTrait;

/**
 * Class Category
 * @package App
 *
 * @property string $_id
 * @property $products_count
 * @property $name
 * @property $title
 * @property $slug
 * @property Category $father
 * @property $filename
 * @property $meta_title
 * @property $meta_description
 * @property $meta_slug
 * @property $order
 * @property-read $updated_at
 * @property-read $created_at
 *
 * @method static Builder whereSlug($slug)
 */
class Category extends \App\Business\Integration\WooCommerce\Models\Category
{
    use SluggableTrait;

    // TODO Trigger update when category saved

    protected static function boot()
    {
        parent::boot();

        Category::saving(function ($category) {
            //Categories are created at parent level, never on child level
            if (empty($category->order) && !is_int($category->order)) {
                $order = Category::where('father_id', 'exists', false)->orderBy('order', 'desc')->first();
                $category->order = !is_null($order) ? $order->order + 1 : 1;
            }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * @return mixed
     */
    public function getOrderedChildren()
    {
        return $this->children
            ->sortBy(function ($child) {
                return $child->order;
            })
            ->map(function ($child) {
                return [
                    '_id' => $child->_id,
                    'title' => $child->name,
                    'products_count' => $child->products_count,
                    'actionButtons' => Category::actionButtons($child->_id),
                ];
            })
            ->values();
    }

    /**
     * Create actions buttons for tree
     * @param $id
     * @param bool $edit
     * @param bool $delete
     * @return string
     */
    public static function actionButtons($id, $edit = true, $delete = true)
    {
        $buttons = collect();

        $edit ? $buttons->push(
            '<a href="' . route('category.edit', ['id' => $id]) . '" class=""><i class="icon-pencil4"></i></a>'
        ) : null;
        $deleteButton = '<form method="POST" action="' . route('category.destroy', ['id' => $id]) . '" accept-charset="UTF-8" style="display:inline">
            <input name="_method" value="DELETE" type="hidden">
            <input name="_token" value="' . csrf_token() . '" type="hidden">
            <button type="submit" class="btn-link"><i class="icon-bin" alt="edit"></i></button>
        </form>';
        $delete ? $buttons->push($deleteButton) : null;

        return '<ul class="icons-list no-padding"><li>' . $buttons->implode('</li><li>') . '</li></ul>';
    }
}
