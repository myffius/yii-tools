<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		html, body{
			padding: 0;
			margin: 0;
			height: 100%;
			background: #FAFAFA;
			font-family: Arial;
			font-size: 14px;
			vertical-align: top;
		}
		#wrapper{
			width: 1100px;
			margin: 0 auto;
			background: #FFF;
			min-height: 100%;
			position: relative;
		}
		table{
			border: 1px solid #EEE;
			width: 100%;
			height: 100%;
		}
		h4{
			font-weight: normal;
		}
		hr{
			border: 1px solid #DDD;
		}
	</style>
</head>
<body>
	<div id="wrapper">
		<table>
			<tr>
				<td style="border-right: 1px solid #EEE;">
                    <div id="chart_div"></div>
					<hr>
                    <div id="chart_div1"></div>
				</td>
			</tr>
		</table>
	</div>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Время', 'Задачи'],
			<?php require_once 'run.php';?>
            ]);

            var options = {
                title: 'Нормальный закон распределения',
                hAxis: {title: 'Время',  titleTextStyle: {color: 'black'}},
                width: 700
            };

            var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
            chart.draw(data, options);

            data = google.visualization.arrayToDataTable([
                ['Время', 'Задачи'],
                ['0', 0],
                ['1', 5],
                ['2', 12],
                ['3', 21],
                ['4', 31],
                ['5', 42],
                ['6', 54],
                ['7', 67],
                ['8', 81],
                ['9', 96],
                ['10', 107],
                ['11', 122],
                ['12', 140],
                ['13', 160],
                ['14', 185],
                ['15', 200],
                ['16', 220],
                ['17', 250],
                ['18', 290],
                ['19', 340],
                ['20', 390],
                ['21', 420],
                ['22', 465],
                ['23', 490],
                ['24', 560],
                ['25', 605],
                ['26', 630],
                ['27', 605],
                ['28', 560],
                ['29', 490],
                ['30', 465],
                ['31', 420],
                ['32', 390],
                ['33', 340],
                ['34', 290],
                ['35', 250],
                ['36', 220],
                ['37', 200],
                ['38', 185],
                ['39', 160],
                ['40', 140],
                ['41', 122],
                ['42', 107],
                ['43', 96],
                ['44', 81],
                ['45', 67],
                ['46', 54],
                ['47', 42],
                ['48', 31],
                ['49', 21],
                ['50', 12],
                ['51', 5]
            ]);
            var chart = new google.visualization.AreaChart(document.getElementById('chart_div1'));
            chart.draw(data, options);
        }
    </script>
</body>
</html>