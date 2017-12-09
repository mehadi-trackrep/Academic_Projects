
<div  style="margin-top: -80px;opacity: .9;height: 550px;">
  <img class="mySlides" src="images/back_img10.jpg" style="width:100%;height:80%">
  <img class="mySlides" src="images/back_img13.jpg" style="width:100%;height:80%">
  <img class="mySlides" src="images/back_img14.jpg" style="width:100%;height:80%">
</div>

<script>
  var myIndex = 0;
  carousel();

  function carousel() {
      var i;
      var x = document.getElementsByClassName("mySlides");
      for (i = 0; i < x.length; i++) {
         x[i].style.display = "none";  
      }
      myIndex++;
      if (myIndex > x.length) {myIndex = 1}    
      x[myIndex-1].style.display = "block";  
      setTimeout(carousel, 2000); // Change image every 2 seconds
  }
</script>
