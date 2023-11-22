<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Share;
use App\Models\News;

class SocialShareButtonsController extends Controller
{
    public function ShareWidget($newsId)
    {
        $news = News::find($newsId);

        if (!$news) {
            abort(404);
        }

        $shareComponent = Share::page(
            $news->title,
            route('news.show', ['id' => $news->id])
        )
            ->facebook()
            ->twitter()
            ->linkedin()
            ->telegram()
            ->whatsapp()
            ->reddit();

        return view('posts', compact('shareComponent', 'news'));
    }
}
