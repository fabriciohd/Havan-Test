<head>
    <link rel="stylesheet" type="text/css" href="{{ url('css/app.css') }}">
    <style>
        .topnav {
            overflow: hidden;
            background-color: #333;
        }
        .topnav a {
            float: left;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }
        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }
        .topnav a.active {
            background-color: #04AA6D;
            color: white;
        }
    </style>
</head>

<nav class="topnav">
    <a class="@if(Route::current()->getName() == 'home') active @endif" href="/">Home</a>
    <a class="@if(Route::current()->getName() == 'table') active @endif" href="/operations">Operações</a>
</nav>