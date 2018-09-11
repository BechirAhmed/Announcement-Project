<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
| Middleware options can be located in `app/Http/Kernel.php`
|
*/

// Homepage Route
Route::get('/', 'WelcomeController@welcome')->name('welcome');
//Route::get('/{catSlug}/{subCatSlug}/{id}', ['as' => 'product', 'uses' => 'WelcomeController@showProduct']);
//Route::get('/men/men-clothes/{slug}_{sku}', ['as' => 'product', 'uses' => 'WelcomeController@product']);
Route::get('/{catSlug}/{subCatSlug}/{slug}_{id}_{sku}', ['as' => 'product', 'uses' => 'WelcomeController@product']);

Route::get('stores', 'WelcomeController@showStores')->name('stores');
Route::get('stores/{userName}', 'WelcomeController@showStorePage')->name('store');
Route::post('stores/{user}/follow', 'UserController@follow')->name('follow');
Route::delete('stores/{user}/unfollow', 'UserController@unfollow')->name('unfollow');
Route::get('/notifications', 'UserController@notifications');

Route::get('stores/status', function () {
    return view('stores.status');
});

// Authentication Routes
Auth::routes();

// Public Routes
Route::group(['middleware' => ['web', 'activity']], function () {

    // Activation Routes
    Route::get('/activate', ['as' => 'activate', 'uses' => 'Auth\ActivateController@initial']);

    Route::get('/activate/{token}', ['as' => 'authenticated.activate', 'uses' => 'Auth\ActivateController@activate']);
    Route::get('/activation', ['as' => 'authenticated.activation-resend', 'uses' => 'Auth\ActivateController@resend']);
    Route::get('/exceeded', ['as' => 'exceeded', 'uses' => 'Auth\ActivateController@exceeded']);

    // Socialite Register Routes
    Route::get('/social/redirect/{provider}', ['as' => 'social.redirect', 'uses' => 'Auth\SocialController@getSocialRedirect']);
    Route::get('/social/handle/{provider}', ['as' => 'social.handle', 'uses' => 'Auth\SocialController@getSocialHandle']);

    // Route to for user to reactivate their user deleted account.
    Route::get('/re-activate/{token}', ['as' => 'user.reactivate', 'uses' => 'RestoreUserController@userReActivate']);
});

// Registered and Activated User Routes
Route::group(['middleware' => ['auth', 'activated', 'activity']], function () {

    // Activation Routes
    Route::get('/activation-required', ['uses' => 'Auth\ActivateController@activationRequired'])->name('activation-required');
    Route::get('/logout', ['uses' => 'Auth\LoginController@logout'])->name('logout');
});

// Registered and Activated User Routes
Route::group(['middleware' => ['auth', 'activated', 'activity', 'twostep']], function () {

    //  Homepage Route - Redirect based on user role is in controller.
    Route::get('/home', ['as' => 'public.home',   'uses' => 'UserController@index']);

    // Show users profile - viewable by other users.
    Route::get('profile/{username}', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@show',
    ]);
});
// Route to show user avatar
Route::get('images/profile/{id}/avatar/{image}', [
    'uses' => 'WelcomeController@userProfileAvatar',
]);

// Route to show user cover
Route::get('images/profile/{id}/cover/{image}', [
    'uses' => 'WelcomeController@userProfileCover',
]);
// Registered, activated, and is current user routes.
Route::group(['middleware' => ['auth', 'activated', 'currentUser', 'activity', 'twostep']], function () {

    // User Profile and Account Routes
    Route::resource(
        'profile',
        'ProfilesController', [
            'only' => [
                'show',
                'edit',
                'update',
                'create',
            ],
        ]
    );
    Route::put('profile/{username}/updateUserAccount', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@updateUserAccount',
    ]);
    Route::put('profile/{username}/updateUserPassword', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@updateUserPassword',
    ]);
    Route::delete('profile/{username}/deleteUserAccount', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@deleteUserAccount',
    ]);

//    // Route to show user avatar
//    Route::get('images/profile/{id}/avatar/{image}', [
//        'uses' => 'ProfilesController@userProfileAvatar',
//    ]);
//
//    // Route to show user cover
//    Route::get('images/profile/{id}/cover/{image}', [
//        'uses' => 'ProfilesController@userProfileCover',
//    ]);

    // Route to upload user avatar.
    Route::post('avatar/upload', ['as' => 'avatar.upload', 'uses' => 'ProfilesController@upload']);
    Route::post('cover/upload', ['as' => 'cover.upload', 'uses' => 'ProfilesController@coverUpload']);

    Route::group(
        [
            'prefix' => 'products',
        ], function () {

        Route::get('/', 'ProductsController@index')
            ->name('products.product.index');

        Route::get('/getProducts', 'ProductsController@getProducts')
            ->name('products.product.getProducts');

        Route::get('/create','ProductsController@create')
            ->name('products.product.create');

        Route::get('/show/{product}','ProductsController@show')
            ->name('products.product.show')
            ->where('id', '[0-9]+');

        Route::get('/{product}/edit','ProductsController@edit')
            ->name('products.product.edit')
            ->where('id', '[0-9]+');


        Route::put('product/{product}', 'ProductsController@update')
            ->name('products.product.update')
            ->where('id', '[0-9]+');

        Route::delete('/product/{product}','ProductsController@destroy')
            ->name('products.product.destroy')
            ->where('id', '[0-9]+');

        Route::post('product/changeStatus', ['as' => 'changeStatus', 'uses' => 'ProductsController@changeStatus']);
        Route::post('product/soldStatus', ['as' => 'soldStatus', 'uses' => 'ProductsController@soldStatus']);

    });
    Route::post('store', 'ProductsController@store')
        ->name('products.product.store');

    Route::post('/upload' , 'ProductsController@upload');
    Route::post('/images-save/{id}', 'ProductsController@storeImages');
    Route::post('/images-delete', 'ProductsController@destroyImages');


});

// Registered, activated, and is admin routes.
Route::group(['middleware' => ['auth', 'activated', 'role:admin', 'activity', 'twostep']], function () {
    Route::resource('/users/deleted', 'SoftDeletesController', [
        'only' => [
            'index', 'show', 'update', 'destroy',
        ],
    ]);

    Route::resource('users', 'UsersManagementController', [
        'names' => [
            'index'   => 'users',
            'destroy' => 'user.destroy',
        ],
        'except' => [
            'deleted',
        ],
    ]);
    Route::post('search-users', 'UsersManagementController@search')->name('search-users');

    Route::resource('themes', 'ThemesManagementController', [
        'names' => [
            'index'   => 'themes',
            'destroy' => 'themes.destroy',
        ],
    ]);

    Route::group(
        [
            'prefix' => 'categories',
        ], function () {

        Route::get('/', 'CategoriesController@index')
            ->name('categories.category.index');

        Route::get('/create','CategoriesController@create')
            ->name('categories.category.create');

        Route::get('/show/{category}','CategoriesController@show')
            ->name('categories.category.show')
            ->where('id', '[0-9]+');

        Route::get('/{category}/edit','CategoriesController@edit')
            ->name('categories.category.edit')
            ->where('id', '[0-9]+');

        Route::post('/', 'CategoriesController@store')
            ->name('categories.category.store');

        Route::put('category/{category}', 'CategoriesController@update')
            ->name('categories.category.update')
            ->where('id', '[0-9]+');

        Route::delete('/category/{category}','CategoriesController@destroy')
            ->name('categories.category.destroy')
            ->where('id', '[0-9]+');

    });

    Route::group(
        [
            'prefix' => 'sub_categories',
        ], function () {

        Route::get('/', 'SubCategoriesController@index')
            ->name('sub_categories.sub_category.index');

        Route::get('/create','SubCategoriesController@create')
            ->name('sub_categories.sub_category.create');

        Route::get('/show/{subCategory}','SubCategoriesController@show')
            ->name('sub_categories.sub_category.show')
            ->where('id', '[0-9]+');

        Route::get('/{subCategory}/edit','SubCategoriesController@edit')
            ->name('sub_categories.sub_category.edit')
            ->where('id', '[0-9]+');

        Route::post('/', 'SubCategoriesController@store')
            ->name('sub_categories.sub_category.store');

        Route::put('sub_category/{subCategory}', 'SubCategoriesController@update')
            ->name('sub_categories.sub_category.update')
            ->where('id', '[0-9]+');

        Route::delete('/sub_category/{subCategory}','SubCategoriesController@destroy')
            ->name('sub_categories.sub_category.destroy')
            ->where('id', '[0-9]+');

    });

    Route::group(
        [
            'prefix' => 'regions',
        ], function () {

        Route::get('/', 'RegionsController@index')
            ->name('regions.region.index');

        Route::get('/create','RegionsController@create')
            ->name('regions.region.create');

        Route::get('/show/{region}','RegionsController@show')
            ->name('regions.region.show')
            ->where('id', '[0-9]+');

        Route::get('/{region}/edit','RegionsController@edit')
            ->name('regions.region.edit')
            ->where('id', '[0-9]+');

        Route::post('/', 'RegionsController@store')
            ->name('regions.region.store');

        Route::put('region/{region}', 'RegionsController@update')
            ->name('regions.region.update')
            ->where('id', '[0-9]+');

        Route::delete('/region/{region}','RegionsController@destroy')
            ->name('regions.region.destroy')
            ->where('id', '[0-9]+');

    });


    // Route to show user avatar
    Route::get('images/products/categories/image/{image}', [
        'uses' => 'CategoriesController@categoryImage',
    ]);

    // Route to upload user avatar.
    Route::post('image/upload', ['as' => 'catImage.upload', 'uses' => 'CategoriesController@upload']);

    Route::group(
        [
            'prefix' => 'unit_relateds',
        ], function () {

        Route::get('/', 'UnitRelatedsController@index')
            ->name('unit_relateds.unit_related.index');

        Route::get('/create','UnitRelatedsController@create')
            ->name('unit_relateds.unit_related.create');

        Route::get('/show/{unitRelated}','UnitRelatedsController@show')
            ->name('unit_relateds.unit_related.show')
            ->where('id', '[0-9]+');

        Route::get('/{unitRelated}/edit','UnitRelatedsController@edit')
            ->name('unit_relateds.unit_related.edit')
            ->where('id', '[0-9]+');

        Route::post('/', 'UnitRelatedsController@store')
            ->name('unit_relateds.unit_related.store');

        Route::put('unit_related/{unitRelated}', 'UnitRelatedsController@update')
            ->name('unit_relateds.unit_related.update')
            ->where('id', '[0-9]+');

        Route::delete('/unit_related/{unitRelated}','UnitRelatedsController@destroy')
            ->name('unit_relateds.unit_related.destroy')
            ->where('id', '[0-9]+');

    });

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    Route::get('routes', 'AdminDetailsController@listRoutes');
    Route::get('active-users', 'AdminDetailsController@activeUsers');
});

Route::redirect('/php', '/phpinfo', 301);






Route::get("search","WelcomeController@Search");

Route::get('/{catSlug}', ['as' => 'category', 'uses' => 'WelcomeController@showCategory']);
Route::get('/{catSlug}/{slug}', ['as' => 'sub_category', 'uses' => 'WelcomeController@showSubCategory']);