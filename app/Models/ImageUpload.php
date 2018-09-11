<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageUpload extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'image_uploads';

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
        'product_id',
        'image_name',
        'original_name',
        'resized_name',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];


    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }
}
