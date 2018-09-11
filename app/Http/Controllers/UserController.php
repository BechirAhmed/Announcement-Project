<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ImageUpload;
use App\Models\Product;
use App\Models\Region;
use App\Models\subCategory;
use App\Models\Theme;
use App\Models\User;
use App\Notifications\UserFollowed;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

class UserController extends Controller
{
    use Notifiable;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $users = User::count();
        $products = Product::count();
        $userProducts = Product::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        if ($user->isAdmin()) {
            return view('pages.admin.home', ['users' => $users, 'products' => $products]);
        }

        return view('pages.user.home', compact('userProducts'));
    }

    public function showStores()
    {
        $users = User::where('id', '!=', auth()->user()->id)->get();
        $products = Product::all();
//        $products = $this->productModel->getAllProducts();
        $categories = Category::all();
        $subCategories = SubCategory::all();
        $regions = Region::pluck('name','id')->all();
        $photos = ImageUpload::all();

        return view('stores.index', compact('users', 'products', 'regions', 'categories', 'subCategories', 'photos'));
    }

    public function follow(User $user)
    {
        $follower = auth()->user();
        if ($follower->id == $user->id) {
            return back()->withError("You can't follow yourself");
        }
        if(!$follower->isFollowing($user->id)) {
            $follower->follow($user->id);

            // sending a notification
            $user->notify(new UserFollowed($follower));

            return back()->withSuccess("You are now friends with {$user->name}");
        }
        return back()->withError("You are already following {$user->name}");
    }

    public function unfollow(User $user)
    {
        $follower = auth()->user();
        if($follower->isFollowing($user->id)) {
            $follower->unfollow($user->id);
            return back()->withSuccess("You are no longer friends with {$user->name}");
        }
        return back()->withError("You are not following {$user->name}");
    }

    public function notifications()
    {
        return auth()->user()->unreadNotifications()->limit(5)->get()->toArray();
    }
}
