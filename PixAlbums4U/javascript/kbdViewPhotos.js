function kbdViewPhotos(e){
   e = e || window.event;
            
   var prev = $('.prev a');

   var next = $('.next a');
            
   if(e.keyCode == '37'){
      //alert("left");
      if(prev[0] != null) prev[0].click();
   } else if(e.keyCode == '39') {
      //alert('right');
      if(next[0] != null) next[0].click();
   }
}