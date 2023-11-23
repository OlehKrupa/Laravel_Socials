<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Share;
use App\Models\News;

class SocialShareButtonsController extends Controller
{
    public function ShareWidget($newsId)
    {
        Share::currentPage()->facebook();
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
            ->linkedin('Extra linkedin summary can be passed here')
            ->telegram()
            ->whatsapp()
            ->reddit();

        return view('posts', compact('shareComponent', 'news'));
    }

    public function ShareCurrentPageWidget()
    {

        $shareComponent = Share::page(
            'Socials website',
            route('welcome')
        )
            ->facebook()
            ->twitter()
            ->linkedin('Дополнительное описание для LinkedIn')
            ->telegram()
            ->whatsapp()
            ->reddit();

        return view('posts', compact('shareComponent'));
    }
}
