  $(document).ready(function(){
    $(".cat1").click(function(){
      document.cookie = 'option='+ this.name;
      console.log(this.name)
     location.href = 'sample.php';
    });
  }); 