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
        <div id="pokemon">
        <?php
            $ch = curl_init();
            $url = "https://pokeapi.co/api/v2/pokemon/".$_GET["url"]."/";
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $json_data = curl_exec($ch);
            curl_close($ch);
            $json_decod = json_decode($json_data, true);


            echo "<div id='fotoPokemon'>";
            echo "<img src='". $json_decod["sprites"]["front_default"] ."' class='fotoPokemon'>";
            echo "</div>";
            echo "<div id='info'>";
            echo "<div>";
            echo "<strong>Nombre:</strong> <br>". $json_decod["species"]["name"]; 
            echo "</div>";
            echo "<div>";
            echo "<strong>Tipo:</strong> <br>";
            foreach ($json_decod["types"] as $key => $value) {
                echo $value["type"]["name"] . "<br>";
            } 
            echo "</div>";
            foreach($json_decod["stats"] as $key => $value){
                echo "<div>";
                echo "<strong>" . $value["stat"]["name"] . ":</strong><br>";
                echo $value["base_stat"];
                echo "</div>";
            }
            echo "</div>";
        ?>
        </div>
</div>

<div id="sep"></div>

<div class="abajo"></div>

<footer> Trabajo &nbsp;<strong> Desarrollo Web en Entorno Servidor </strong>&nbsp; 2023/2024 IES Serra Perenxisa.</footer>

</body>
</html>
