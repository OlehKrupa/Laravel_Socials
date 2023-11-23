@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h1 class="text-center">{{ $news->title }}</h1>
                <div class="card mb-3">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            @if ($news->image)
                                <img src="{{ asset($news->image) }}" class="card-img" alt="{{ $news->title }}">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <p class="card-text">{{ $news->content }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <p class="card-text"><small class="text-muted">{{ __("Author: ") }} {{ $news->user->name }}</small></p>
                    <div>
                        <a href="{{ route('social.share', ['newsId' => $news->id]) }}" class="btn p-0" style="width: 33px; height: 33px;">
                            <img src="https://img.icons8.com/share.png" class="img-fluid" alt="Share">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
