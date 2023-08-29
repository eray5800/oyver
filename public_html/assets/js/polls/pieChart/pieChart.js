let chartButton = document.querySelector("#piechartdiv");
let voteArrays = JSON.parse(chartButton.getAttribute('data-poll-votes'));
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {

  var data = google.visualization.arrayToDataTable([
    ['Seçenekler', 'Seçeneklerin Oy Oranları'],
    ...voteArrays
  ]);

  var options = {
    title: 'Oy Oranları',
    pieSliceText: 'percentage',
    pieSliceTextStyle: {
      fontSize: 12
    }
  };

  var chart = new google.visualization.PieChart(document.getElementById('piechart'));

  chart.draw(data, options);
}