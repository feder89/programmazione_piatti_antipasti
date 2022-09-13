<?php
	require_once '../include/core.inc.php';
	$link=connectToDb();
	$portate=array();
	$date=ottieni_data_serata_attuale();
    if($date <=0){
        $comanda=array('error' => '#error#Errore durante l\'acquisizione della data');
    }
    else{  
		if(isset($_GET['index'])){
			$idprg=$_GET['index'];
			$idprg_next=0;
			$query_next_idprg="SELECT min(idprogrammazione) as minid FROM programmazioneordini 
								WHERE stato = 2 AND idprogrammazione>$idprg AND categoria IN ('antipasto','bruschette e crostoni','dolce') AND serata='$date'";
			
				$result_idprog_next = mysqli_query($link, $query_next_idprg) or die("#error#".mysqli_error($link));
				while ($row_idprg_next = mysqli_fetch_assoc($result_idprog_next)) {
					$idprg_next=$row_idprg_next['minid'];
				}
			
			if($idprg_next>0){
				$query="SELECT *,COUNT(id) AS nr FROM programmazioneordini 
				WHERE idprogrammazione=$idprg_next
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
	}
	    		
	disconnetti_mysql($link, NULL); #visto che non ho un result_set gli passo NULL.. nella funzione in core.in.php ho aggiunto il controllo

	echo json_encode($portate);
	

?>

 