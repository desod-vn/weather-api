<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Jobs\PredictData;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::query();

        if (!empty($request->keyword)) {
            $posts->where('content', 'like', '%' . $request->keyword . '%');
        }

        if (!empty($request->category_id)) {
            $posts->withWhereHas('category', function ($q) use ($request) {
                return $q->where('id', $request->category_id);
            });
        }

        $posts = $posts->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $posts
        ], 200);
    }

    public function store(StorePostRequest $request)
    {
        $categoryIndex = $this->handleFile($request->content);

        if (!isset($categoryIndex)) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể dự đoán bài viết hoặc không nằm trong các danh mục có sẵn',
            ], 200);
        }

        $categoryId = (int)$categoryIndex + 1;
        
        $category = Category::where('id', $categoryId)->get();

        Post::create([
            'content' => $request->content,
            'category_id' => $categoryId,
            'user_id' => Auth::user()->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thêm mới bài viết thành công',
            'category' => $category,
        ], 200);
    }

    public function handleFile($inputStr)
    {
        $input = 'public/input.txt';
        $output = 'public/output.txt';

        if (Storage::exists($input)) {
            Storage::delete($input);
        }
        if (Storage::exists($output)) {
            Storage::delete($output);
        }

        Storage::put($input, $inputStr);
        PredictData::dispatch();
        while (Storage::exists($output)) {
            return Storage::get($output);
        }
    }
}
