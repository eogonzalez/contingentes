
<?php 
$carpetaAdjunta="archivos/";
// Contar envían por el plugin
$Imagenes =count(isset($_FILES['doctosDefensa']['name'])?$_FILES['doctosDefensa']['name']:0);
$infoImagenesSubidas = array();
for($i = 0; $i < $Imagenes; $i++) {
	// El nombre y nombre temporal del archivo que vamos para adjuntar
	$nombreArchivo=isset($_FILES['doctosDefensa']['name'][$i])?$_FILES['doctosDefensa']['name'][$i]:null;
	$nombreTemporal=isset($_FILES['doctosDefensa']['tmp_name'][$i])?$_FILES['doctosDefensa']['tmp_name'][$i]:null;
	
	$rutaArchivo=$carpetaAdjunta.$nombreArchivo;
	
	move_uploaded_file($nombreTemporal,$rutaArchivo);
	
	$infoImagenesSubidas[$i]=array("caption"=>"$nombreArchivo","height"=>"120px","url"=>"borrar.php","key"=>$nombreArchivo);
	$ImagenesSubidas[$i]="<img  height='120px'  src='$rutaArchivo' class='file-preview-image'>";
	}
$arr = array("file_id"=>0,"overwriteInitial"=>true,"initialPreviewConfig"=>$infoImagenesSubidas,
			 "initialPreview"=>$ImagenesSubidas);
echo json_encode($arr);
?>