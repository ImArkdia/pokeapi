<?php
    $errorNombre = "";
    $errorTipo = "";
    $errorRegion = "";
    $errorNoencontrado = "";
    $nombre = "";
    $existe = false;
    $flag = true;
    $sprite = "";
    $numeroPokemon = "";

        
        if(isset($_POST["name"]) && $_POST["name"] == ""){
            $errorNombre = "ERROR: El campo 'Nombre' no puede estar vacío<br>";
            $flag = false;
        }
        if(isset($_POST["name"]) && $_POST["name"] != ""){
            $nombre = $_POST["name"];
        }

        if(isset($_GET["noencontrado"])){
            $errorNoencontrado = "ERROR: El Pokémon no existe<br>";
        }
        if($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST["tipo"])){
            $errorTipo = "ERROR: Debes seleccionar un tipo<br>";
            $flag = false;
        }

        if($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST["region"])){
            $errorRegion = "ERROR: Debes seleccionar una región<br>";
            $flag = false;
        }
        
        
        
        
        if($_SERVER["REQUEST_METHOD"] == "POST" && $flag == true){
            $type = $_POST["tipo"];
            $name = $_POST["name"];
            $region = "https://pokeapi.co/api/v2/generation/".$_POST["region"]."/";

            $ch = curl_init();
            $url = $region;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $json_data = curl_exec($ch);
            curl_close($ch);
            $json_decod = json_decode($json_data, true);
            $existe = false;

            foreach($json_decod["pokemon_species"] as $key => $value){
                if($value["name"] == $name){
                    $placeholder = $value["url"];
                    $placeholder = substr($placeholder, strlen($placeholder)-5);
                    $placeholder = intval(preg_replace('/\D+/', '', $placeholder));

                    $ch = curl_init();
                    $url = "https://pokeapi.co/api/v2/pokemon/".$placeholder;
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $json_data2 = curl_exec($ch);
                    curl_close($ch);
                    $infoPokemon = json_decode($json_data2, true);

                    foreach ($infoPokemon["types"] as $key2 => $value2) {
                        if($value2["type"]["name"] == $type){
                            $numeroPokemon = $placeholder;
                            $sprite = $infoPokemon["sprites"]["front_default"];
                            $nombre = $infoPokemon["name"];
                            $existe = true;
                            break;
                        }
                    }
                    if($existe){
                        $errorNoencontrado = "";
                        break;
                    }
                }
            }
            

            if(!$existe){
                header("Location: ./buscar.php?noencontrado=true");
                exit();
            }
        }
    ?>

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

<div id="sep"></div>

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

<div id="buscar">

    <section>
<form action="#" method="POST">
    <div class="sep">
        Buscador Pokémon
    </div>
    <div id="nombre">
        <label for="name">Nombre:</label>
        <input type="text" name="name" id="name">
    </div>
    <article class="article1">
        <div class="tipo">
            Tipo:
        </div>
    <div>
        <input type="radio" id="normal" name="tipo" value="normal">
        <label for="normal">Normal</label>
    </div>
    <div>
        <input type="radio" id="fighting" name="tipo" value="fighting">
        <label for="fighting">Lucha</label>
    </div>
    <div>
        <input type="radio" id="flying" name="tipo" value="flying">
        <label for="flying">Volador</label>
    </div>
    <div>
        <input type="radio" id="poison" name="tipo" value="poison">
        <label for="poison">Veneno</label>
    </div>
    <div>
        <input type="radio" id="ground" name="tipo" value="ground">
        <label for="ground">Tierra</label>
    </div>
    <div>
        <input type="radio" id="rock" name="tipo" value="rock">
        <label for="rock">Roca</label>
    </div>
    <div>
        <input type="radio" id="bug" name="tipo" value="bug">
        <label for="bug">Bicho</label>
    </div>
    <div>
        <input type="radio" id="ghost" name="tipo" value="ghost">
        <label for="ghost">Fantasma</label>
    </div>
    <div>
        <input type="radio" id="steel" name="tipo" value="steel">
        <label for="steel">Acero</label>
    </div>
    <div>
        <input type="radio" id="fire" name="tipo" value="fire">
        <label for="fire">Fuego</label>
    </div>
    <div>
        <input type="radio" id="water" name="tipo" value="water">
        <label for="water">Agua</label>
    </div>
    <div>
        <input type="radio" id="grass" name="tipo" value="grass">
        <label for="grass">Planta</label>
    </div>
    <div>
        <input type="radio" id="electric" name="tipo" value="electric">
        <label for="electric">Eléctrico</label>
    </div>
    <div>
        <input type="radio" id="psychic" name="tipo" value="psychic">
        <label for="psychic">Psíquico</label>
    </div>
    <div>
        <input type="radio" id="ice" name="tipo" value="ice">
        <label for="ice">Hielo</label>
    </div>
    <div>
        <input type="radio" id="dragon" name="tipo" value="dragon">
        <label for="dragon">Dragón</label>
    </div>
    <div>
        <input type="radio" id="dark" name="tipo" value="dark">
        <label for="dark">Oscuridad</label>
    </div>
    <div>
        <input type="radio" id="fairy" name="tipo" value="fairy">
        <label for="fairy">Hada</label>
    </div>
    <div>
        <input type="radio" id="unknown" name="tipo" value="unknown">
        <label for="unknown">Desconocido</label>
    </div>
    <div>
        <input type="radio" id="shadow" name="tipo" value="shadow">
        <label for="shadow">Sombra</label>
    </div>
    </article>
    <article class="article2">
    <div class="region">
        Región:
    </div>
    <div>
        <input type="radio" id="1" name="region" value="1">
        <label for="1">Kanto</label>
    </div>
    <div>
        <input type="radio" id="2" name="region" value="2">
        <label for="2">Johto</label>
    </div>
    <div>
        <input type="radio" id="3" name="region" value="3">
        <label for="3">Hoenn</label>
    </div>
    <div>
        <input type="radio" id="4" name="region" value="4">
        <label for="4">Sinnoh</label>
    </div>
    <div>
        <input type="radio" id="5" name="region" value="5">
        <label for="5">Unova</label>
    </div>
    <div>
        <input type="radio" id="6" name="region" value="6">
        <label for="6">Kalos</label>
    </div>
    <div>
        <input type="radio" id="7" name="region" value="7">
        <label for="7">Alola</label>
    </div>
    <div>
        <input type="radio" id="8" name="region" value="8">
        <label for="8">Galar</label>
    </div>
    <div>
        <input type="radio" id="9" name="region" value="9">
        <label for="9">Hisui</label>
    </div>
    <div>
        <input type="radio" id="10" name="region" value="10">
        <label for="10">Paldea</label>
    </div>
    </article>
    <article class="article3">
        <input type="submit" name="enviar" id="enviar" value="Buscar">
    </article>
    </form>
    <article class="article4">
        <div>
        <?php
            echo $errorNombre;
            echo $errorTipo;
            echo $errorRegion;
            echo $errorNoencontrado;
        ?>
        </div>
    </article>

    </section>
    </div>
    <div id="iniciales">
        <section>
            <?php
                if($existe){
                    echo "<div>";
                    echo "<a href='./perfil.php?url=". $numeroPokemon ."'>";
                    echo "<img src='".$sprite."'>";
                    echo ucfirst($nombre);
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