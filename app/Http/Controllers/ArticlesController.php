<?php
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function __construct()
    {
        //$this->authorize(Article::class, 'article');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index(): \Illuminate\Http\Response
    {
        $this->authorize('viewAny', Article::class);
        return response(view('articles.index'));
    }
}
