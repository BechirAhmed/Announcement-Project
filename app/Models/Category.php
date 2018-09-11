<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\subCategory;
use App\Models\Product;
use App;

class Category extends Model
{
    
    use SoftDeletes;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories';

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

    public function getCategories()
    {
        return $this->select('categories.*', 'slug', 'name', 'description', 'image', 'is_active')
//                    ->admitted()
//                    ->sort()
//                    ->groupBy('categories.id')
//                    ->where('is_active', true)
                    ->get();
    }

    public function getProducts($category)
    {
        return $this->join('category_sub_category as cp', 'categories.id', '=', 'cp.category_id')
//                    ->join('product_sub_category as psc', 'sub_categories.id', '=', 'psc.sub_category_id')
                    ->select('products.*', 'name', 'description', 'price', 'discount', 'preferred', 'count', 'sku', 'sold', 'is_active', 'psc.sub_category_id')->where('cp.category_id', $category->id)->paginate(10);

    }

    public function getCategoryBySlug($slug)
    {
        return $this->where('slug', $slug)->first();
    }

    public function getCategoryById($id)
    {
        return $this->findOrFail($id);
    }


    public function getSubCategories($category)
    {
        return $category->subCategories()->where('is_active', 1)->paginate(10);
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

    public function subCategories()
    {
        return $this->belongsToMany('App\Models\subCategory');
    }

    public function products()
    {
        return $this->belongsTo(Product::class);
    }

}
