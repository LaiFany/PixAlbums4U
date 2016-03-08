var terms = [
"What I like about photographs is that they capture a moment that's gone forever, impossible to reproduce.", 
"Nothing happens when you sit at home. I always make it a point to carry a camera with me at all times… I just shoot at what interests me at that moment.", 
"Every photo you take communicates something about a moment in time - a brief slice of time of where you were, who you were with, and what you were doing."];

var authors = ["Karl Lagerfeld", "Elliott Erwitt", "Kevin Systrom"];

function rotateQuote() {
  var ct = $("#rotatequote").data("term") || 0;
  $("#rotatequote").data("term", ct == terms.length -1 ? 0 : ct + 1).text(terms[ct]).fadeIn()
              .delay(7000).fadeOut(800, rotateQuote);
              
  var dt = $("#rotateauthor").data("term") || 0;
  $("#rotateauthor").data("term", dt == authors.length -1 ? 0 : dt + 1).text(authors[dt]).fadeIn()
              .delay(7000).fadeOut(800, rotateQuote);
}
$(rotateQuote);