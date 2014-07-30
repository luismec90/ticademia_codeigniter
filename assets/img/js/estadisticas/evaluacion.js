
// Load the Visualization API and the piechart package.
google.load('visualization', '1.0', {'packages': ['corechart']});


google.setOnLoadCallback(distribucionNivelesPorDia);

$(window).resize(function(){
  distribucionNivelesPorDia();
});
