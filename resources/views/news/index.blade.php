@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ __("News") }}</h1>
        <div class="row">
            @foreach ($news as $item)
                <div class="col-md-4">
                    <div class="card mb-4" style="height: 400px;">
                        @if ($item->image)
                            <img src="{{ asset($item->image) }}" class="card-img-top" alt="{{ $item->title }}"
                                 style="object-fit: cover; height: 200px;">
                        @endif
                        <div class="card-body" style="height: 200px; overflow: hidden;">
                            <a href="{{ route('news.show', ['id' => $item->id]) }}">
                                <h5 class="card-title">{{ $item->title }}</h5>
                            </a>
                            <p class="card-text" style="overflow: hidden;">
                                {{ $item->content }}
                            </p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center"
                             style="height: 50px; padding: 12px;">
                            <p class="card-text"><small
                                    class="text-muted">{{ __("Author: ") }} {{ $item->user->name }}</small></p>
                            <a href="{{ route('social.share', ['newsId' => $item->id]) }}" class="btn p-0"
                               style="width: 33px; height: 33px;">
                                <img src="https://img.icons8.com/share.png" class="img-fluid" alt="Share">
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
