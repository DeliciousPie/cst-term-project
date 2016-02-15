<?php

namespace App\Http\Controllers\CD\CDCharts;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Khill\Lavacharts\Lavacharts;
use Lava;
class AreaChartController extends Controller
{
    public function actualVsEstimatedTime()
    {
        $avgVsEst = Lava::DataTable();
        
        $avgVsEst->addNumberColumn('Time')
                ->addStringColumn('Tasks')
                ->addRow(['2', "Assignment1"])
                ->addRow(['4', "Assignment1"])
                ->addRow(['22', "Assignment1"]);
        
        return Lava::AreaChart('Actual vs Estimated Time',
                $avgVsEst,['title' => 'Actual vs Estimated Time'] );
        
      
    }
}
