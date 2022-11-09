<?php 
function parcelar(float $taxa, int $parcelas=1): float
{
    $coeficiente  = pow((1 + ($taxa/100)), $parcelas)/$parcelas;
    return $coeficiente; // Parcelas fixas

    // return ($capital+$taxa)*$parcelas;
}

function dataTexto (DateTime $data){
    $intervalo = $data->diff(new DateTime());
    return $intervalo->format('%y anos, %m meses e %d dias');
}
?>