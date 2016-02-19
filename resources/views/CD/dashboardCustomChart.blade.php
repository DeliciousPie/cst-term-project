
<div class="container spark-screen">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">CD Dashboard</div>

                <div class="panel-body">
                    
                    <form id="customChartForm" 
                          name="customChartForm" class="activity" 
                          method="post" action="dashboardCustomChart">
                        <input type="hidden" name="activityID" 
                               value="customChartForm"
                               method="post">   

                        <input type="hidden" name="_token" 
                               value="{!! csrf_token() !!}">
                        <label for="chartSelected">Please select a type of chart:</label>
                        <select id="chartSelected" name="chartSelected" class="form-control">
                            <option value ="1" selected>Pie</option>
                            <option value ="2">Donut</option>
                            <option value ="3">Scatter</option>
                            <option value ="4">Bubble</option>
                            <option value ="5" selected>Column</option>
                            <option value ="6">Bar</option>
                            <option value ="7">Combo</option>
                            <option value ="8">Area</option>
                            <option value ="9">Line</option>
                        </select>
                         <br />
                        
                        <label for="classSelected"> Class: </label>
                        <br />
                        <select id="classSelected"  name="classSelected" class="form-control">
                            <option value= "1">All Classes</option>
                            <option>Math 110</option>
                        </select>
                        <br />

                        <label for="comparison1"> Parameter1:</label>
                        <select id="comparison1" name="comparison1" class="form-control">
                            <option value="stressLevel">Stress Level</option> 	
                            <option value="timeSpent">Time Actual</option>	
                            <option value="timeEstimated" selected>Time Estimate</option>

                        </select>
                        
                         <br />
                         
                        <label for="comparison2"> Parameter2:</label>
                        <select id="comparison2" name="comparison2" class="form-control">
                            <option value="stressLevel">Stress Level</option> 	
                            <option value="timeSpent"selected>Time Actual</option>	
                            <option value="timeEstimated">Time Estimate</option>

                        </select>
                        
                        <br />
                        <button for="customChartForm" type="submit" value="Submit">Submit</button> 
                    </form> 
                    <br />
<!--                    <div id="dashboard">
                        <div id="chart">
                        </div>
                        <div id="control">
                        </div>
                    </div>-->
                    <div id="timeChart"></div>
                    
                    
                    @columnchart('StudentParam', 'timeChart')
                    
                </div>
            </div>
        </div>
    </div>
</div>





