  $(document).ready(function(){
    $(getElementsByName('search')).click(function(){
      document.cookie = 'text='+getElementsByName('myinput');
      location.href = 'sample2.php';
    });
  }); 