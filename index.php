<?php include("includes/includedFiles.php");  ?>

<h1 class="pageHeadingBig">Escute agora os principais canais</h1>

<div class="gridViewContainer">

	<?php
		// vamos imprimir os albuns agora
		$albumQuery = mysqli_query($con, "SELECT * FROM albums ORDER BY RAND() LIMIT 5"); // $con é variável de conexão com o bando de dados

		while($row = mysqli_fetch_array($albumQuery)) {

			// este while fará um loop sobre cada resultado que é retornada de "SELECT * FROM album"
			// depois ele pega os resultados que foram obtidos e os converte em resultados dentro de uma matriz

			echo "<div class='gridViewItem'>
					<span onclick='openPage(\"album.php?id=" . $row['id'] . "\")'>
						<img src='" . $row['artworkPath'] . "'>

						<div class='gridViewInfo'>"
							. $row['title'] .
						"</div>
					</span>

				</div>";
				// nessas tags HTML será posta para a quantidade de albuns que eu tiver dentro banco de dados
				// os pontos são concatenação entre uma string + info + string
		}
	?>

</div>
