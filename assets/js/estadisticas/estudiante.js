
// Load the Visualization API and the piechart package.
google.load('visualization', '1.0', {'packages': ['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(distribucionNiveles);
google.setOnLoadCallback(distribucionNivelesPorDia);
google.setOnLoadCallback(conexionesPorDia);
google.setOnLoadCallback(conexionesPorHora);

$(window).resize(function(){
  distribucionNiveles();
  distribucionNivelesPorDia();
  conexionesPorDia();
  conexionesPorHora();
});
