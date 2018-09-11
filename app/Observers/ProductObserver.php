<?php

namespace App\Observers;

use App\Notifications\NewProduct;
use App\Models\Product;

class ProductObserver
{
    public function created(Product $product)
    {
        $user = $product->user;
        foreach ($user->followers as $follower) {
            $follower->notify(new NewProduct($user, $product));
        }
    }
}