
// Load the Visualization API and the piechart package.
google.load('visualization', '1.0', {'packages': ['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(distribucionNiveles);
google.setOnLoadCallback(distribucionNiveles2);

$(window).resize(function(){
  distribucionNiveles();
  distribucionNiveles2();
});
