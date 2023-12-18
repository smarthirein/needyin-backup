<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>


<div id="salary" style="min-width: 100px; height: 150px; margin: 0 auto"></div>

<script>
	

Highcharts.chart('salary', {

    chart: {
        type: 'columnrange',
        inverted: true
    },

    title: {
        text: 'Salary'
    },

    subtitle: {
        text: ''
    },

    xAxis: {
        categories: ['Jobseeker', 'Employer']
    },

    yAxis: {
        title: {
            text: 'in lacs'
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

	credits: {
    enabled: false
  },
    legend: {
        enabled: false
    },

    series: [{
        name: 'Salary(min-max)',
        data: [
            [<?php  echo  $_GET['js_mins']; ?>, <?php  echo  $_GET['js_maxs']; ?>],
            [  <?php  echo  $_GET['maxs']; ?>,<?php  echo  $_GET['mins']; ?>]
          
        ]
    }]

});

	</script>
