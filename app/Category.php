<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;
use App\Business\Traits\SluggableTrait;

/**
 * Class Category
 * @package App
 *
 * @property string $_id
 * @property $products_count
 * @property $name
 * @property $slug
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
class Category extends Model
{
    use SluggableTrait;

    // TODO Trigger update when category saved
    protected $attributes = array(
        'products_count' => 0
    );

    protected $fillable = ['name', 'slug', 'filename', 'products_count', 'meta_title', 'meta_description' , 'meta_slug', 'external_id'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(self::class, 'father_id', '_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function father()
    {
        return $this->belongsTo(self::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
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
    public static function actionButtons($id, $edit = true, $delete = true) {
        $buttons = collect();

        $edit ? $buttons->push('<a href="'.route('category.edit', ['id' => $id]).'" class=""><i class="icon-pencil4"></i></a>') : null ;
        $deleteButton = '<form method="POST" action="'. route('category.destroy', ['id' => $id]).'" accept-charset="UTF-8" style="display:inline">
            <input name="_method" value="DELETE" type="hidden">
            <input name="_token" value="'.csrf_token().'" type="hidden">
            <button type="submit" class="btn-link"><i class="icon-bin" alt="edit"></i></button>
        </form>';
        $delete ? $buttons->push($deleteButton) : null ;

        return '<ul class="icons-list no-padding"><li>'.$buttons->implode('</li><li>').'</li></ul>';
    }
}
