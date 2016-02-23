

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default" >
            <div class="panel-heading">
                <div class='row'>
                    <div class="col-lg-9">
                        <h3 class="panel-title">
                            <i class="fa fa-bar-chart-o fa-fw">
                                {{$studAct['activityType']}}
                                @if($studAct['submitted'])
                                - Submitted
                                @else
                                - Awaiting Submission
                                @endif

                            </i>
                        </h3>
                    </div>
                    <div class="col-lg-2"></div>
                    <div class="col-lg-1">
                        <span style="font-size: 2em" class="glyphicon glyphicon-collapse-down navbar-right" 
                              aria-hidden="false"  onclick="$('#{{$studAct['activityID']}}panel').toggle();"></span>
                    </div>
                </div>
            </div>
            <div class="panel-body" id="{{$studAct['activityID']}}panel" style="display:none">  
                <div class="form-group">
                    <!-- Look in the $stud variable to assign the values in the
                    DB to the form-->
                    <form id="{{$studAct['activityID']}}" 
                          name="{{ $studAct['activityID']}}" class="activity" 
                          method="post">
                        <input type="hidden" name="activityID" 
                               value="{{$studAct['activityID']}}"
                               method="post">   

                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <label for="timeEstimated">Your Estimate</label>
                        <input type="number" class="form-control" id="timeEstimated" 
                               name="timeEstimated" min="0.0" max="800.0" step="0.5"
                               value="{{$studAct['timeEstimated']}}" required="required"></input>
                        </br>
                        <label for="timeSpent">Your Actual</label>
                        <input type="number" class="form-control" id="timeSpent" 
                               name="timeSpent" min="0.0" max="800.0" step="0.5"
                               value="{{$studAct['timeSpent']}}" required="required"></input>
                        </br>

                        <label for="stressLevel">Stress Level</label>
                        <input type="range" id="stressLevel" name="stressLevel" 
                               min="0" max="10" step="1" value="{{$studAct['stressLevel']}}" list="steplist"
                               ></input>
                        <datalist id="steplist">
                            <option>0</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            <option>6</option>
                            <option>7</option>
                            <option>8</option>
                            <option>9</option>
                            <option>10</option>
                        </datalist>
                        <label for="stressLevel" style="font-weight:normal">Not Stressed</label>
                        <label for="stressLevel" style="float: right;font-weight:normal">Stressed</label>
                        </br>
                        <label for="stressLevel">Comments</label>
                        <!--Need to check if if submitted or not so we don't get default values-->
                        <textarea class="form-control" id="comments" name="comments"
                                  maxlength="300" placeholder="Comment">@if($studAct['submitted']){{$studAct['comments']}}@endif</textarea>
                        </br>
                        <input type="submit" value="Submit">                                
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>




