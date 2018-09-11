<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class subCategory extends Model
{
    
    use SoftDeletes;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sub_categories';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'slug',
                  'category_id',
                  'name',
                  'description',
                  'image',
                  'is_active'
              ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
               'deleted_at'
           ];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    public function getSubCategories()
    {
        return $this->select('sub_categories.*', 'slug', 'category_id', 'name', 'description', 'image', 'is_active')
//                    ->admitted()
//                    ->sort()
//                    ->groupBy('categories.id')
            ->where('is_active', 1)
            ->get();
    }

    public function getSubCategoriesByCat($id)
    {
        return $this->select('sub_categories.*', 'slug', 'category_id', 'name', 'description', 'image', 'is_active')
//                    ->admitted()
//                    ->sort()
//                    ->groupBy('categories.id')
            ->where('is_active', 1)
            ->where('category_id', $id)
            ->get();
    }

    public function getSubCategoryBySlug($slug)
    {
        return $this->where('slug', $slug)->first();
    }
    public function getProductsList($subCategory)
    {
        return $subCategory->products()->where('is_active', true)->orderBy('created_at', 'desc')->paginate(10);
    }
//    public function getProducts($subCategore)
//    {
////        $category = $subCategory->category();
//        return $subCategore->products->where('is_active', 1);
//    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
    }
    /**
     * Get the category for this model.
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }


    /**
     * Get deleted_at in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getDeletedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

}
