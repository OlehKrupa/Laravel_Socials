@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Welcome to Socials</h1>

        <button class="btn btn-primary" onclick="loadContent('/news')">{{__("View news")}}</button>
        <button class="btn btn-success" onclick="loadContent('/news/create')">{{__("Offer news")}}</button>

        <div id="content-container"></div>
    </div>

    <script>
        function loadContent(url) {
            fetch(url)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('content-container').innerHTML = data;
                });
        }
    </script>
@endsection
