<?php

function num($num){
    return ($num < 10) ? '0'.$num : $num;
}

function montaEnsaios($info){
    $pdo = new PDO('mysql:host=localhost;dbname=alacid','root','');
    $pdo->exec('set names utf8');
    // $tabela, $data

    $tabela = $info['tabela'];
    $data = $info['data'];

    $now = date('Y-m-d');
    // $eventos = $pdo->prepare("SELECT * FROM `".$tabela."` WHERE `".$data."` > NOW()");
    $ensaios = $pdo->prepare("SELECT * FROM $tabela WHERE $data >= $now ");
    $ensaios->execute();    
    $retorno = [];
        while ($row = $ensaios->fetchObject()) {
            $retorno[$row->{$data}] = [
            ];
        }    
        return $retorno;
    }

function diasMeses(){
    $retorno = [];

    for ($i=1; $i <= 12; $i++) { 
        $retorno[$i] = cal_days_in_month(CAL_GREGORIAN, $i, date('Y'));
    }
    return $retorno;
}


function montaCalendario($ensaios = [])
{
    $daysWeek = [
        'Sun',
        'Mon',
        'Tue',
        'Wed',
        'Thu',
        'Fri',
        'Sat'
    ];

    $diasSemana = [
        'Dom',
        'Seg',
        'Ter',
        'Qua',
        'Qui',
        'Sex',
        'Sáb'
    ];

    $arrayMes = [
       1 =>  'Janeiro',
       2 =>  'Fevereiro',
       3 =>  'Março',
       4 =>  'Abril',
       5 =>  'Maio',
       6 =>  'junho',
       7 =>  'Julho',
       8 =>  'Agosto',
       9 =>  'Setembro',
       10 =>  'Outubro',
       11 =>  'Novembro',
       12 =>  'Dezembro'
    ];

    $diasMeses = diasMeses();

    $arrayRetorno = [];

    for ($i=1; $i <= 12; $i++) { 
        $arrayRetorno[$i] = [];
        for ($n=1; $n < $diasMeses[$i]; $n++) { 
            $dayMonth = gregoriantojd($i, $n, date('Y'));
            $weekMonth = jddayofweek($dayMonth, 2);
            if ($weekMonth == 'Mun') $weekMonth = 'Mon';
            $arrayRetorno[$i][$n] = $weekMonth;
        }
    }

 
    echo '<div class="setas"><a href="#" id="volta">&laquo;</a><a href="#" id="vai">&raquo;</a></div>';
    echo '<table>';
    foreach ($arrayMes as $num => $mes) {
        echo '<tbody id="mes_'.$num.'" class="mes">';
        echo '<tr class="mes_title"><td colspan="7">'.$mes.'</td></tr>';
        echo '<tr class"dias_title">';
        foreach ($diasSemana as $i => $day) {
            echo '<td class="dia-semana">'.$day.'</td>';
        }
        echo '</tr><tr>';
        $y = 0;
        foreach ($arrayRetorno[$num] as $numero => $dia) {
            $y++; 
            if ($numero == 1) {
                $qtd = array_search($dia, $daysWeek);
                for ($i=1; $i <=$qtd ; $i++) { 
                    echo '<td></td>';
                    $y+=1;
                }
            }
            if (count($ensaios) > 0) {
                $month = num($num);
                $dayNow = num($numero);
                $date = date('Y').'-'.$month.'-'.$dayNow;
                if (in_array($date, array_keys($ensaios))) {
                    echo '<td class="ensaio">'.$numero.'</td>';
                }else
                {
                    echo '<td><a href="#" target="blank">'.$numero.'</a></td>';
                }
            }else
            {
                    echo '<td><a href="#" target="blank">'.$numero.'</a></td>';
            }
            if ($y == 7) {
                $y = 0;
                echo '</tr><tr>';
            }
        }
        echo '</tr></tbody>';
    }
    echo '</table>';


}