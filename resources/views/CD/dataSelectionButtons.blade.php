<!--

<label>Please select a type of chart:</label>
<br>
<select id="chartSelected">
    <option>Table</option>
    <option>Pie</option>
    <option>Donut</option>
    <option>Scatter</option>
    <option>Bubble</option>
    <option>Column</option>
    <option>Bar</option>
    <option>Combo</option>
    <option>Area</option>
    <option>Line</option>
</select>

<br><br>
<label>Please enter in a Professor, Class, and Activity to sort by:</label>
<br>
<select id="professorSelected">
    <option>Professor</option>
    <option>Dr. Young</option>
</select>
<select id="classSelected">
    <option>Class</option>
    <option>Math 110</option>
</select>
<select id="yearSelected">
    <option>Activity</option>
    <option>Year</option>
</select>

<br>
<br>
<label>Please select a report to view:</label>
<br>
<select id="comparisonSelected">

    <optgroup label="Stress Actual" ></optgroup>

    <option>Stress Actual vs Stress Estimate</option> 	
    <option>Stress Actual vs Time Actual	</option>	
    <option>Stress Actual vs Time Estimate	</option>
    <optgroup label="Stress Estimate"></optgroup>	

    <option>Stress Estimate vs Time Actual  </option>
    <option>Stress Estimate vs Time Estimate</option>
    <option>Stress Estimate vs Stress Actual</option>

    <optgroup label="Time Actual">    </optgroup>
    <option>Time Actual vs Time Estimate    </option>
    <option>Time Actual vs Stress Actual    </option>
    <option>Time Actual vs Stress Estimate  </option>
    <optgroup label="Time Estimate">  </optgroup>
    <option>Time Estimate vs Time Actual    </option>
    <option>Time Estimate vs Stress Actual  </option>
    <option>Time Estimate vs Stress Estimate</option>

</select>
<select id="frequnecySelected">
    <option>Day</option>
    <option>Week</option>
    <option>Month</option>
    <option>Year</option>
</select>-->
<div id="pop_div">{{'dashboard''}}</div>
<?= Lava::render('AreaChart', 'Actual vs Estimated Time', 'pop_div')?>

<!--<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<div id="chart_div" style="width: 900px; height: 500px;"></div>-->

<script type="text/javascript">//
//google.charts.load('current', {'packages': ['corechart']});
//google.charts.setOnLoadCallback(drawChart);
//function drawChart() {
//    var data = google.visualization.arrayToDataTable([
//        ['Year', 'Estimates', 'Actual'],
//        ['Assignment 1', 4, 8],
//        ['Midterm', 8, 7],
//        ['Assignment 2', 7, 5],
//        ['Final', 9, 10]
//    ]);
//
//    var options = {
//        title: 'Students Stress - MATH110',
//        hAxis: {title: 'Year', titleTextStyle: {color: '#333'}},
//        vAxis: {minValue: 0}
//    };
//
//    var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
//    chart.draw(data, options);
//}



//google.charts.load('current', {'packages': ['corechart']});
//google.charts.setOnLoadCallback(drawChart);
//function drawChart() {
//
//    var data = google.visualization.arrayToDataTable([
//        ['Estimates', 'Hours per Day'],
//        ['Over Estimates', 46],
//        ['Under Estimates', 33],
//        ['Perfect Estimates', 12]
//    ]);
//
//    var options = {
//        title: 'Student Estimates - ENGL220 Assignment 1'
//    };
//
//    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
//
//    chart.draw(data, options);
//}

//google.charts.load('current', {'packages': ['corechart']});
//google.charts.setOnLoadCallback(drawVisualization);
//
//
//function drawVisualization() {
//    // Some raw data (not necessarily accurate)
//    var data = google.visualization.arrayToDataTable([
//        ['Month', 'John', 'Kendal', 'Anthony', 'Justin', 'Wes', 'Average'],
//        ['Jan', 1, 2, 4, 6, 7, 3],
//        ['Feb', 2, 4, 5, 7, 2, 5],
//        ['March', 1, 3, 5, 6, 3, 2]
//    ]);
//
//    var options = {
//        title: 'Stress Level of Students Over Time',
//        vAxis: {title: 'Stress Level'},
//        hAxis: {title: 'Month'},
//        seriesType: 'bars',
//        series: {5: {type: 'line'}}
//    };
//
//    var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
//    chart.draw(data, options);

</script>
