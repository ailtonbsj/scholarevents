<?php

if (!isset($_SESSION)) {
  session_start();
}

function captadata($string){
    $token = explode(" ", $string);
    return $token[0];
}

function captahora($string){
    $token = explode(" ", $string);
    return $token[1];
}

function horaToPosition($string){
    $token = explode(":",$string);
    return ((((int) $token[0]) + ((float) ((int) $token[1])/60))*60)-200;
}

function horaToWidth($inic,$fina){
    $inic = explode(":",$inic);
    $fina = explode(":", $fina);
    return (($fina[0]-$inic[0])*60) + ($fina[1]-$inic[1]);
}

    require './link1.php';
    
    $sqlhorario = "SELECT momento_ini,momento_fin,local,titulo FROM sch_espacotempo,sch_locais,sch_acontecimentos WHERE (id=id_local) AND (id_acon=id_acontec) ORDER BY momento_ini";
    $buscahora = mysql_query($sqlhorario,$link1);
    if(!$buscahora){
        echo "ERRO";
        exit;
    }
    
    $dataselect = "";
    $indice = 0;
    $idreg = 0;
    if(mysql_num_rows($buscahora) != 0){
    while($linha = mysql_fetch_assoc($buscahora)){
        if(captadata($linha['momento_ini']) != $dataselect){
            $dataselect = captadata($linha['momento_ini']);
            $arrayData[$indice] = array($dataselect,null);
            $indice++;
            $idreg=0;
        }
        $arrayData[$indice-1][1][$idreg] = array(captahora($linha['momento_ini']),
                                    captahora($linha['momento_fin']),
                                    $linha['local'],$linha['titulo']);
        $idreg++;
    }
    echo "<h1 style='text-align:center;'>Cronograma de Acontecimentos</h1>";
    echo "</div>";
    for($v=0;$v<count($arrayData);$v++){
    
    echo "<div style='padding:5px;margin:2px;background-color:". $_SESSION['cor1'] .";'>";
    echo "<div style='font-weight: bold;'>Data: ". $arrayData[$v][0] ."</div>";
?>
<div style="background-color: <?php echo $_SESSION['cor2'] ?>; padding: 5px; position: relative">
    <div style="font-weight: bold;">Locais</div>
    <?php
    for($i=6;$i<=24;$i++){
    ?>
    <div style="position: absolute;left: <?php echo (($i*60))-200 ?>px; top: 5px;"><?php echo $i ?>h</div>
    <?php
    }
    ?>
</div>
<?php
    $local_now = $arrayData[$v][1][0][2];
    while($local_now != null){
?>
<div style="background-color: <?php echo $_SESSION['cor2'] ?>; padding: 5px; position: relative">
    <div><?php echo $local_now ?></div>
<?php
    for($h=0;$h<count($arrayData[$v][1]);$h++){
        if($arrayData[$v][1][$h][2] == $local_now){
            if(!isset($arrayCores[$arrayData[$v][1][$h][3]])){
                $arrayCores[$arrayData[$v][1][$h][3]] = array(rand(120, 255),rand(0, 10),rand(0, 10));
            }
            //$cor = $arrayCores[$arrayData[$v][1][$h][3]][0] . "," . $arrayCores[$arrayData[$v][1][$h][3]][1] . "," . $arrayCores[$arrayData[$v][1][$h][3]][2];
?>
    <div class="acontcmt" style="position: absolute;left: <?php echo horaToPosition($arrayData[$v][1][$h][0]) ?>px; width: <?php echo horaToWidth($arrayData[$v][1][$h][0],$arrayData[$v][1][$h][1]) ?>px; top: 5px; background-color: <?php echo $_SESSION['cor3'] ?>; border: 1px #666 solid; border-radius: 10px;" title="<?php echo "EVENTO: " . $arrayData[$v][1][$h][3] . "\nINICIO: ". $arrayData[$v][1][$h][0] ."\nFIM: " . $arrayData[$v][1][$h][1]  ?>" alt="<?php echo $arrayData[$v][1][$h][3] ?>">
        &nbsp;
    </div>
<?php
    $arrayData[$v][1][$h] = null;
        }
    }
?>
</div>
<?php
        $local_now = null;
        for($g=0;$g<count($arrayData[$v][1]);$g++){
            if($arrayData[$v][1][$g] != null){
            $local_now = $arrayData[$v][1][$g][2];
            break;
            }
        }
    }
    echo "</div>";
    }
    }
    echo "<div>";
?>

<script type="text/javascript">
    $(function(){
        $(".acontcmt").mouseenter(function(){
            $(this).html("");
            $(this).append("<marquee title=\""+ $(this).attr("title") +"\">"+$(this).attr("alt")+"</marquee>");
        }).mouseleave(function(){
           $(this).html("&nbsp;");
        });
        
    });
</script>