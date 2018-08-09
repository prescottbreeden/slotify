<div class="main">
	<div class="main__content">
		<h2 class="main__content--heading">Browse</h2>
		<h4 class="main__content--sub-heading">Soundtrack for your day</h4>
	</div>
	<div class="album__container">
	
<?php
$albumQuery = mysqli_query($con, "SELECT * FROM albums ORDER BY RAND()");

while($row = mysqli_fetch_array($albumQuery)) {

	echo	"<div class='album__container--item'>
				<img src='" . $row['artwork_path'] . "'>	
				<div class='album__container--item-details'>
					" . $row['title_name'] . "
				</div>
			</div>";


}

?>
	</div>
</div>
