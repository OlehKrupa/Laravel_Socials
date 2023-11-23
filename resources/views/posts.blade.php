@extends('layouts.app')

@section('content')
    <div class="container">
        <style>
            div#social-links {
                margin: 0 auto;
                max-width: 500px;
                text-align: center;
            }

            div#social-links ul {
                list-style: none;
                padding: 0;
            }

            div#social-links ul li {
                display: inline-block;
                margin: 0 10px;
            }

            div#social-links ul li a {
                display: block;
                width: 40px;
                height: 40px;
                line-height: 40px;
                border: 1px solid #ccc;
                border-radius: 50%;
                font-size: 18px;
                color: #222;
                text-decoration: none;
                transition: background-color 0.3s;
            }

            div#social-links ul li a:hover {
                background-color: #eee;
            }
        </style>

        <div class="container mt-4">
            {!! $shareComponent !!}
        </div>
    </div>
@endsection
