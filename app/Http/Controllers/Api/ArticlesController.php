<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function index()
    {
        $articles = Article::with('user')->latest()->get();
        return ArticleResource::collection($articles);
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
