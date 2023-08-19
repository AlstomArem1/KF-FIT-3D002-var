<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Test2</h1>
    @php
        $arrayPoint = [2, 5, 7, 8, 9];
        $arrayAnimal = ['Meo', 'Cho', 'Ca', 'Gau', 'Huu Cao Co'];
    @endphp
    @foreach ($arrayAnimal as $key => $animal)
        {{ $animal }}
        @if (($key+1) % 2 === 0)
            {!! "<span style='color:red'>" . $animal . '</span><br>' !!}
        @else
            {!! "<span style='color:green'>" . $animal . '</span><br>' !!}
        @endif
    @endforeach
    @foreach ($arrayPoint as $point)
        {{ $point }} <br>
    @endforeach
</body>
</html>
