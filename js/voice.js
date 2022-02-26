function Voice(){
if (!('webkitSpeechRecognition' in window)) {
  upgrade();
}
else{
var recognition = new webkitSpeechRecognition();
recognition.continuous = false;
recognition.interimResults = false;
recognition.onresult = function(event) { 
  console.log(event);
  mytype = event.results[0][0].transcript;
  document.cookie = "voice="+mytype;
  location.href = "sample3.php";
}
recognition.start();
}
}