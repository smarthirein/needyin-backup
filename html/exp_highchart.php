<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>


<div id="container" style="min-width: 100px; height: 150px; margin: 0 auto"></div>

<script>
	

Highcharts.chart('container', {

    chart: {
        type: 'columnrange',
        inverted: true
    },

    title: {
        text: 'Experience'
    },

    subtitle: {
        text: ''
    },

    xAxis: {
        categories: ['Jobseeker', 'Employer']
    },

    yAxis: {
        title: {
            text: 'in years'
        }
    },

    tooltip: {
        valueSuffix: ''
    },

    plotOptions: {
        columnrange: {
            dataLabels: {
                enabled: true,
                format: '{y}'
            }
        }
    },

    legend: {
        enabled: false
    },
	credits: {
    enabled: false
  },

    series: [{
        name: 'Experience(min-max)',
        data: [
            [<?php  echo  $_GET['min_avg']; ?>, <?php  echo  $_GET['max_avg']; ?>],
            [<?php  echo  $_GET['mine']; ?>, <?php  echo  $_GET['maxe']; ?>]
          
        ]
    }]

});

	</script>
	