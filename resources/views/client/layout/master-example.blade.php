<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <style>
        header{
            background:red;
            color: white;

        }
        main{
            background:blue;
            color: white;
        }
        main .nav{
            background: green;
        }
        aside{
            background: yellow;
            color: black;
        }
        .container {
            background: goldenrod;
        }
        footer{
            background: blueviolet;
            color: white;
        }
    </style>
</head>
<body>
    @include('client.pages.product.header')
   <main>
    <div class="nav">Navigation</div>
    <aside>
        @section('side-bar')
            Side bar Layout Master
        @show
    </aside>
    <div class="content">
        @yield('content')
        @yield('test')
    </div>
   </main>
   @include('client.pages.product.footer')

   @yield('js-custom')
</body>
</html>



