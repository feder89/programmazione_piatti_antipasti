<?php
	require_once '../include/core.inc.php';
	$link=connectToDb();
	$date=ottieni_data_serata_attuale();
    if($date <=0){
        $comanda=array('error' => '#error#Errore durante l\'acquisizione della data');
    }
    else{
		$portate=array();
		$idprg=0;
		$query_idprog="SELECT min(idprogrammazione) as idprg FROM programmazioneordini WHERE stato = 2 AND categoria IN ('antipasto','bruschette e crostoni','dolce') AND serata='$date'";
		$result_idprog = mysqli_query($link, $query_idprog) or die("#error#".mysqli_error($link));
		while ($row_idprg = mysqli_fetch_assoc($result_idprog)) {
			$idprg=$row_idprg['idprg'];
		}	  
		if($idprg>0){
			$query="SELECT *,COUNT(id) AS nr FROM programmazioneordini 
			WHERE idprogrammazione=$idprg
			AND stato=2 
			AND categoria IN ('antipasto','bruschette e crostoni','dolce')
			AND serata='$date'
			GROUP BY portata,idprogrammazione
			ORDER BY portata";

			$result = mysqli_query($link, $query) or die("#error#".mysqli_error($link));
			while ($row = mysqli_fetch_assoc($result)) {
				array_push($portate, array('portata' => $row['portata'], 
											'indice' => $row['indice'],
											'tavolo' => $row['tavolo'],
											'nr' => $row['nr'],
											'idprg' => $row['idprogrammazione'],
											'cat' => $row['categoria']));
			}  
		}	
	}													
		
	disconnetti_mysql($link, NULL); #visto che non ho un result_set gli passo NULL.. nella funzione in core.in.php ho aggiunto il controllo

	echo json_encode($portate);
	

?>

 