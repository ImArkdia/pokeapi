<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pokemon</title>
	<link rel="stylesheet" type="text/css" href="examen.css">
</head>
<body>
 
<header> Mi blog de &nbsp;&nbsp; <img src="img/International_Pokémon_logo.svg.png"></header>

<div id="separador"></div>

<nav>
	<?php
		$ch = curl_init();
		$url = "https://pokeapi.co/api/v2/region/";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$json_data = curl_exec($ch);
		curl_close($ch);
		$json_decod = json_decode($json_data, true);
		$cont = 1;
		foreach($json_decod["results"] as $key => $value){
			$regionNumero = $key + 1;
			echo "<div><a href='./pokemons.php?region=".$regionNumero."'> G". $cont ." ".ucfirst($value["name"])."</a></div>";
			$cont++;
		}
	?>
	<div>
        <a href="./buscar.php">Búsqueda</a>
	</div>
</nav>
<div id="sep">

</div>
<div id="iniciales">
    <section>
        <?php
                $ch = curl_init();
                $url = "https://pokeapi.co/api/v2/generation/".$_GET["region"]."/";
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $json_data = curl_exec($ch);
                curl_close($ch);
                $json_decod = json_decode($json_data, true);
                $placeholder = $json_decod["pokemon_species"]["0"]["url"];
                $placeholder = substr($placeholder, strlen($placeholder)-5);
                $menor = intval(preg_replace('/\D+/', '', $placeholder));
                $mayor = $menor;

                foreach($json_decod["pokemon_species"] as $key => $value){
                    $placeholder = $value["url"];
                    $placeholder = substr($placeholder, strlen($placeholder)-5);
                    $placeholder = intval(preg_replace('/\D+/', '', $placeholder));
                    if($placeholder < $menor){
                        $menor = $placeholder;
                    }

                    if($placeholder > $mayor){
                        $mayor = $placeholder;
                    }
                }
                
                for($menor;$menor <= $mayor;$menor++){
                    $ch = curl_init();
                    $url = "https://pokeapi.co/api/v2/pokemon/".$menor;
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $json_data = curl_exec($ch);
                    curl_close($ch);
                    $json_decod = json_decode($json_data, true);

                    echo "<div>";
                    echo "<a href='./perfil.php?url=". $menor ."'>";
                    echo "<img src='".$json_decod["sprites"]["front_default"]."'>";
                    echo ucfirst($json_decod["name"]);
                    echo "</a>";
                    echo "</div>";
                }
            ?>
        </section>
</div>

<div id="sep"></div>

<div class="abajo"></div>

<footer> Trabajo &nbsp;<strong> Desarrollo Web en Entorno Servidor </strong>&nbsp; 2023/2024 IES Serra Perenxisa.</footer>

</body>
</html>