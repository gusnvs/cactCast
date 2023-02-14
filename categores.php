<?php include("includes/includedFiles.php");  ?>

<h1 class="pageHeadingBig">Categorias</h1>

<div class="gridViewContainer">

	<?php
		$albumQuery = mysqli_query($con, "SELECT * FROM genres");

		while($row = mysqli_fetch_array($albumQuery)) {

			echo "<div class='gridViewItemCategores'>
					<span onclick='openPage(\"typecategores.php?id=" . $row['id'] . "\")'>
						<div class='gridViewInfo'>"
							. $row['name'] .
						"</div>
					</span>
				</div>";
		}
	?>
</div>