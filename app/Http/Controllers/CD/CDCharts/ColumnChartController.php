<?php

namespace App\Http\Controllers\CD\CDCharts;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Lava;

class ColumnChartController extends Controller
{

    public function timeSpentVsTimeEstimatedTotalAvg($avgTimeEstVsActualTime)
    {
        $studentTime = Lava::DataTable();

        $studentTime->addStringColumn('All Students')
                   ->addNumberColumn('Time Estimated')
                   ->addNumberColumn('Time Spent')
                   ->addRow(['Time Estimated vs Time Spent', 
                       $avgTimeEstVsActualTime['timeEstimated'], 
                       $avgTimeEstVsActualTime['timeSpent']]);

        $chart = Lava::ColumnChart('Student Time', $studentTime, [
            'title' => 'Average Student Time Estimated Vs Actual Spent',
                'titleTextStyle' => [
                'color'    => '#eb6b2c',
                'fontSize' => 14
            ],
            'vAxis' => ['gridlines' => ['count'=> 5],
                'minValue' => 0]
        ]);
        
        return array('studentTime'=> $chart);
    }
}
