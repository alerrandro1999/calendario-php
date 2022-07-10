<?php include 'calendario.php'; 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>

<section class="section-calendario">
<div class="calendario">
<?php
    $info = [
        'tabela' => 'ensaios',
        'data' => 'data_evento'
    ];
    $ensaios = montaEnsaios($info);
    montaCalendario($ensaios);
?>
</div>
</section>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/scripts.js"></script>
<script src="https://kit.fontawesome.com/0e81c77e4f.js" crossorigin="anonymous"></script>
</body>
</html>