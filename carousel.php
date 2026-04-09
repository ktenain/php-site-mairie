	<?php
	if ($parampage=="carousel"){
	//Si on est logué...
	if (isset($_SESSION['login'])){
		?>
		<div class="container">
  <br>
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
      <li data-target="#myCarousel" data-slide-to="3"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">

      <div class="item active">
        <img src="carousel/image1.png" alt="image 1">
        <div class="carousel-caption">
          <h3>Image 1</h3>
        </div>
      </div>

      <div class="item">
        <img src="carousel/image2.png" alt="image 2">
        <div class="carousel-caption">
          <h3>Image 2</h3>
        </div>
      </div>
    
      <div class="item">
        <img src="carousel/image3.png" alt="image 3">
        <div class="carousel-caption">
          <h3>Image 3</h3>
        </div>
      </div>

      <div class="item">
        <img src="carousel/image4.png" alt="image 4">
        <div class="carousel-caption">
          <h3>Image 4</h3>
        </div>
      </div>
  
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>
		<?php
		}
	}
		?>