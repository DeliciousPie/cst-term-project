<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                   <i class="fa fa-bar-chart-o fa-fw">@yield('ActivityName')</i>
                </h3>
            </div>
            <div class="panel-body">  
                <div class="form-group">
                <form id="garbage" method="post" action='/Classes'>
                   <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                   @foreach ($errors->all() as $error)
                       <p class="alert alert-danger">{{ $error }}</p>
                   @endforeach
                   @if (session('status'))
                       <div class="alert alert-success">
                           {{ session('status') }}
                       </div>
                   @endif

                    <label for="timeEstimated">Your Estimate</label>
                    <input type="number" class="form-control" id="timeEstimated" name="timeEstimated" min="0" max="100" step="0.5" ></input>
                    </br>
                    <label for="timeSpent">Your Actual</label>
                    <input type="number" class="form-control" id="timeSpent" name="timeSpent" min="0" max="100" step="0.5" ></input>
                    </br>

                    <label for="stressLevel">Stress Level</label>
                    <input type="range" id="stressLevel" name="stressLevel" min="0" max="10" step="1" value="5"></input>
                    </br>
                    <textarea class="form-control" id="comments" name="comments" form="garbage" placeholder="Comments"></textarea>
                    </br>
                    <input type="submit" value="Submit">                                
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
