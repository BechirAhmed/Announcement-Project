<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App;
use DB;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    
    use SoftDeletes;
    use SearchableTrait;

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
//            'products.slug' => 10,
            'products.name' => 10,
        ]
    ];


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

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
                  'user_id',
                  'name',
                  'description',
                  'price',
                  'discount',
                  'count',
                  'color',
                  'preferred',
                  'sold',
                  'sku',
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

    public function getAllProducts()
    {
        return $this->join('users as u', 'products.user_id', '=', 'u.id')
                    ->join('sub_category_product as sp', 'products.id', '=', 'sp.product_id')
                    ->join('unit_related_product as up', 'products.id', '=', 'up.product_id')
                    ->join('region_product as rp', 'products.id', '=', 'rp.product_id')
//                    ->join('categories as cat', 'sub_categories.category_id', '=', 'cat.id')
                    ->select('products.*', 'name', 'description', 'price', 'discount', 'preferred', 'count', 'sku', 'sold', 'is_active', 'u.name', 'sp.sub_category_id', 'up.unit_related_id', 'rp.region_id')
                    ->where('is_active', 1)
                    ->paginate(10)
                    ->sort()
                    ->groupBy('products.id');
    }

    public function getProductById($id)
    {
        return $this->findOrfail($id);
    }

    public function getProductBySlug($slug)
    {
        return $this->where('slug', $slug)->first();
    }
    
    /**
     * Get the subCategory for this model.
     */
    public function subCategory()
    {
        return $this->belongsTo('App\Models\SubCategory');
    }
    /**
     * Get the subCategory for this model.
     */
    public function subCategories()
    {
        return $this->belongsToMany('App\Models\SubCategory');
    }

    public function categories()
    {
        return $this->hasManyThrough('App\Models\Category', 'App\Models\SubCategory');
    }

    /**
     * Get the user for this model.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    /**
     * Get the region for this model.
     */
    public function regions()
    {
        return $this->belongsToMany('App\Models\Region');
    }

    /**
     * Get the unitRelated for this model.
     */
    public function unitRelateds()
    {
        return $this->belongsToMany('App\Models\UnitRelated');
    }

    /**
     * Get the images for this model
     */
    public function photos()
    {
        return $this->hasMany('App\Models\ImageUpload')->whereProductId($this->id);
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
