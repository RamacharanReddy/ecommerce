<style>
.mySlides {display: none}

/* Slideshow container */
.slideshow-container {
  margin-top:10%;
  width:98  %;
  height:43%;
  position: relative;
  margin-left:1%;
  margin-right:1%; 
}

.prev, .next {
  cursor: pointer;
  position: absolute;
  top:40%;
  padding:1.5%;
  padding-top:3%;
  padding-bottom:3%;
  color: black;
  transition: 0.6s ease;
  background-color:#FFFFFF;
}

.next {
  right: 0;
}
</style>
<div class="slideshow-container " style="margin-top:0.2%">

<div class="mySlides">
  <img class="img1" src="images/slide1.png" style="width:100%">
</div>

<div class="mySlides">
  <img class="img1" src="images/slide2.png" style="width:100%">
</div>

<div class="mySlides">
  <img class="img1" src="images/slide.png" style="width:100%">
</div>

<label class="prev" onclick="plusSlides(-1)">&#10094;</label>
<label class="next" onclick="plusSlides(1)">&#10095;</label>
</div><br><br>
<hr style="border:1px solid black"><br>