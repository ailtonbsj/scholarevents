<?php

require './link1.php';

if (!isset($_SESSION)) {
    session_start();
}

function dateToSecond($datestring){
    $datestring = explode(" ", $datestring);
    $data = explode("-", $datestring[0]);
    $hora = explode(":", $datestring[1]);
    $sec = intval($hora[2]);
    $min = intval($hora[1]);
    $hor = intval($hora[0]);
    $dia = intval($data[2]);
    $mes = intval($data[1]);
    $ano = intval($data[0]);

    return mktime($hor, $min, $sec, $mes, $dia, $ano);

}

if(!isset($_GET['teste'])){
    

    if(!isset($_SESSION["UserId"])){
        session_unset();
        header("Location: index.php");
    }

    if(!isset($_GET['aid'])){
        echo "ERROR";
        exit;
    }

    $acon_id = $_GET['aid'];

    $sqlCert = "SELECT sch_acontecimentos.titulo,sch_subeventos.titulo AS subevento FROM sch_acontecimentos,sch_subeventos WHERE (sch_acontecimentos.id_subevent = sch_subeventos.id)"
            . " AND (id_acon = $acon_id)";
    $busca_cert = mysql_query($sqlCert,$link1);
    if(!$busca_cert){
        echo "ERROR";
        exit;
    }
    $acontecimentos_d = mysql_fetch_assoc($busca_cert);

    $sqldata = "SELECT * FROM sch_datas WHERE (label = 'Evento:Inicio') OR (label = 'Evento:Fim')";
    $buscadata = mysql_query($sqldata,$link1);
    if(!$buscadata){
        echo "ERROR";
        exit;
    }
    while($lndata = mysql_fetch_assoc($buscadata)){
        switch ($lndata['label']) {
            case "Evento:Inicio":
                $inicioData = $lndata['data'];
                break;
            case "Evento:Fim":
                $fimData = $lndata['data'];
                break;
        }
    }
    $inicioData = explode(" ", $inicioData);
    $fimData = explode(" ", $fimData);

    $inicioData = explode("-", $inicioData[0]);
    $fimData = explode("-", $fimData[0]);
    $inicioData = $inicioData[2] . "/" . $inicioData[1] . "/" . $inicioData[0];
    $fimData = $fimData[2] . "/" . $fimData[1] . "/" . $fimData[0];

    $sqlHorari = "SELECT * FROM sch_espacotempo WHERE id_acontec = '$acon_id'";
    $buscaHorari = mysql_query($sqlHorari);
    $totalHoras = 0.0;
    while($lnHorari = mysql_fetch_assoc($buscaHorari)){
        $dini = dateToSecond($lnHorari['momento_ini']);
        $dfin = dateToSecond($lnHorari['momento_fin']);
        $difereca = $dfin - $dini;
        $totalHoras += (floatval($difereca/(60*60)));
    }
    $totalHoras = ceil($totalHoras);

    $nome = $_SESSION['UserNome'];
    $titulo = $acontecimentos_d['titulo'];
    $subevento = $acontecimentos_d['subevento'];
    
}else{
    $nome = "Fulano Felix Marcia Silva";
    $titulo = "Curso de Vendas";
    $subevento = "Super Vendas Brasil";
    $totalHoras = 300;
    $inicioData = "30/02/2030";
    $fimData = "31/02/2030";
}



$sqlCert = "SELECT * FROM sch_textos WHERE (id = 'cert0') OR (id = 'cert1') OR (id = 'cert2') OR (id = 'cert3') OR (id = 'cert4') OR (id = 'cert5') OR (id = 'cert6') OR (id = 'cert7')";
$buscaCert = mysql_query($sqlCert,$link1);
if(!$buscaCert){
    echo "ERROR";
    exit;
}
while ($lnaCert = mysql_fetch_assoc($buscaCert)){
    $$lnaCert['id'] = $lnaCert['texto'];
}

include("fpdf/fpdf.php");
define('FPDF_FONTPATH','fpdf/font/');

/*
if($_SERVER["DOCUMENT_ROOT"][0] == '/'){
    include("fpdf.php");
    define('FPDF_FONTPATH','fonts/');
}
else {
    include("fpdf/fpdf.php");
    define('FPDF_FONTPATH','fpdf/font/');
}*/

$sqlWhatCert = "SELECT * FROM sch_images WHERE nome_img LIKE '%cer%'";
$buscaWc = mysql_query($sqlWhatCert,$link1);
if(!$buscaWc){
    echo "ERROR";
    exit;
}
$lnWc = mysql_fetch_assoc($buscaWc);
$img1 = "images/" . $lnWc['nome_img'];
$texto = $cert0 ." ". $nome ." ". $cert1 ." ". $subevento ." ". $cert2 ." ". $inicioData ." ". $cert3 ." ". $fimData ." ". $cert4 ." ". $titulo ." ". $cert5 ." ". $totalHoras ." ". $cert6;

$texto = utf8_decode($texto);

$pdf= new FPDF("L","mm","A4");
$pdf->SetTitle("Certificado");
$pdf->SetSubject("Certificado");
$pdf->SetFont('arial','',24);
$pdf->SetXY(-1,-1);
$pdf->Multicell(0,0,'',1,'J',false);
$pdf->Image($img1, 0,0,297,210);
$pdf->setXY(20,75);

$pdf->setMargins(20,20);
$pdf->Multicell(0,20,$texto,0,'J',false);
//$pdf->Write(16,$texto);
$pdf->Output("certificado","I");

?>