
// Load the Visualization API and the piechart package.
google.load('visualization', '1.0', {'packages': ['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(visitasPdfs);
//google.setOnLoadCallback(visitasVideos);
//google.setOnLoadCallback(tiempoPromedioReproduccion);
google.setOnLoadCallback(visitasReproduccion);

$(window).resize(function() {
    visitasPdfs();
//    visitasVideos();
//    tiempoPromedioReproduccion();
    visitasReproduccion();
});
