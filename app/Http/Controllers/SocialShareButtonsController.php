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
            abort(404); // Обработка случая, когда новость не найдена
        }

        $shareComponent = Share::page(
            route('news.index'), // URL новости (замените на актуальный маршрут)
            $news->title, // Заголовок новости
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
