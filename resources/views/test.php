<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Test1</h1>
    <?php
        $arrayPoint = [2 ,5, 7, 8, 9];
        $arrayAnimal = ['Meo', 'Cho', 'Ca', 'Gau', 'Huu Cao Co'];

    foreach($arrayAnimal as $key=>$animal){
        // echo ($key+1).$animal."<br>";
        $color = "red";
        if(($key+1) % 2 === 0){
            // echo ($key+1)."<span style='color:red';>".$animal."<span>"."<br>";
            $color = "green";
        }
        echo ($key+1)."<span style='color:".$color."';>".$animal."<span>"."<br>";

    }




    ?>
</body>
</html>
