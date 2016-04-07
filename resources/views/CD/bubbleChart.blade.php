<div id="bubbleMultiSelect" hidden>
    <div id="courseMultiSelect">
        <div id="courseFieldLabel"></div>
        <div id="courseField" hidden>
            <div class="row">
                <div class="col-xs-5">
                    <select name="from[]" id="undo_redo" class="form-control" size="13" multiple="multiple">
                        <!--Insert options here. AKA dynamically populate the list-->
                    </select>
                </div>

                <div class="col-xs-2">
                    <br />
                    <br />
                    <!--                                    <button hidden type="button" id="undo_redo_undo" class="btn btn-primary btn-block">undo</button>-->
                    <button type="button" id="undo_redo_rightAll" class="btn btn-default btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                    <button type="button" id="undo_redo_rightSelected" class="btn btn-default btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                    <button type="button" id="undo_redo_leftSelected" class="btn btn-default btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                    <button type="button" id="undo_redo_leftAll" class="btn btn-default btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                    <!--                                    <button hidden type="button" id="undo_redo_redo" class="btn btn-warning btn-block">redo</button>-->
                    <br />
                </div>


                <div class="col-xs-5">
                    <select name="courseList[]" id="undo_redo_to" class="form-control" size="13" multiple="multiple">

                    </select>
                </div>
            </div>
            <br />
        </div>
    </div>
    <div id="studentMultiSelect">
        <div id="studentFieldLabel"></div>
        <div id="studentField" hidden>
            <div class="row">
                <div class="col-xs-5">
                    <select name="from[]" id="studentundo_redo" class="form-control" size="13" multiple="multiple">
                        <!--Insert options here. AKA dynamically populate the list-->
                    </select>
                </div>

                <div class="col-xs-2">
                    <br />
                    <br />
                    <!--                                    <button type="button" id="studentundo_redo_undo" class="btn btn-primary btn-block">undo</button>-->
                    <button type="button" id="studentundo_redo_rightAll" class="btn btn-default btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                    <button type="button" id="studentundo_redo_rightSelected" class="btn btn-default btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                    <button type="button" id="studentundo_redo_leftSelected" class="btn btn-default btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                    <button type="button" id="studentundo_redo_leftAll" class="btn btn-default btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                    <!--                                    <button type="button" id="studentundo_redo_redo" class="btn btn-warning btn-block">redo</button>-->
                    <br />
                </div>


                <div class="col-xs-5">
                    <select name="studentList[]" id="studentundo_redo_to" class="form-control" size="13" multiple="multiple">

                    </select>
                </div>
            </div>
            <br />
        </div>
    </div>
</div><!-- bubble mult select-->
<label for="comparison1" required> Parameter 1:</label>
<select id="comparison1" name="comparison1" class="form-control">
    <option selected value="spent">Select Parameter</option>
    <option value="stressLevel">Stress Level</option> 	
    <option value="timeSpent">Time Actual</option>	
    <option value="timeEstimated" >Time Estimate</option>

</select>

<br />

<label for="comparison2" required> Parameter 2:</label>
<select id="comparison2" name="comparison2" class="form-control">
    <option selected  value="estimated">Select Parameter</option>
    <option value="stressLevel">Stress Level</option> 	
    <option value="timeSpent">Time Actual</option>	
    <option value="timeEstimated" >Time Estimate</option>

</select>
<br />
<label hidden for="comparison3" id="bubbleRadius" required>Bubble Radius:</label>
<select id="comparison3" name="comparison3" class="form-control">
    <option selected value="spent">Select Parameter</option>
    <option value="stressLevel">Stress Level</option> 	
    <option value="timeSpent">Time Actual</option>	
    <option value="timeEstimated" >Time Estimate</option>
</select> 
<br />
