<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $blog_list = Blog::join('users', 'blogs.users_id', '=', 'users.id')
                            ->where('blogs.users_id', $user->id)
                            ->select(['blogs.id', 'users.id as users_id', 'blogs.title', 'blogs.description', 'users.name'])
                            ->orderBy('blogs.created_at', 'DESC')->get();

        return $blog_list;
    }

    public function create(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        $blog = new Blog();
        $blog -> users_id = $user->id;
        $blog -> title = $request->title;
        $blog -> description = $request->description;
        $blog -> save();

        return $blog;
    }

    public function show($id)
    {
        $blog = Blog::find($id);
        return $blog;
    }

    public function store(Request $request)
    {
        $update_blog = Blog::find($request->id);
        $update_blog -> title = $request->title;
        $update_blog -> description = $request->description;
        $update_blog -> update();

        return $update_blog;
    }

    public function delete($id)
    {
        $blog = Blog::find($id);
        $blog -> delete();

        return $blog;
    }
}
