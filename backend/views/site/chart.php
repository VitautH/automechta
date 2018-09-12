<?php

use common\models\Product;
use common\models\User;
use common\models\AuthAssignment;
use common\models\CreditApplication;
use yii\helpers\Url;
use backend\assets\AppAsset;

$this->title = 'Графики';
$this->registerJsFile('/plugins/bootstrap/js/bootstrap.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('/plugins/chartjs-old/Chart.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);


$date = new DateTime('-1 years');
$lastYearDate = $date->format('Y-m-d');
$from = new DateTime($lastYearDate);
$to = new DateTime(date("Y-m-d 00:01"));

$period = new DatePeriod($from, new DateInterval('P1D'), $to);

$arrayOfDates = array_map(
    function ($item) {
        $dateOfMonth = array();
        $dateOfMonth['month'] = $item->format('m');
        $dateOfMonth['date'] = $item->format('Y-m-d');

        return $dateOfMonth;
    },
    iterator_to_array($period)
);


$lastYearMonth = $date->format('Y-m-d');
$from = new DateTime($lastYearMonth);
$to = new DateTime(date('Y-m-d'));

$period = new DatePeriod($from, new DateInterval('P32D'), $to);

$arrayOfMonth = array_map(
    function ($item) {
        return $item->format('m');;
    },
    iterator_to_array($period)
);


foreach ($arrayOfDates as $days) {
    switch ($days['month']) {
        case '01':
            $january += AuthAssignment::find()->andFilterWhere([
                'like',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->andFilterWhere(['!=', 'item_name', 'RegisteredUnconfirmed'])->count();


            $januaryCredit += CreditApplication::find()->andFilterWhere([
                'like',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->count();

            $januaryProduct += Product::find()->andFilterWhere([
                'like',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->andFilterWhere(['!=', 'status', Product::STATUS_BEFORE_CREATE_ADS])
                ->andFilterWhere(['!=', 'status', Product::STATUS_TO_BE_VERIFIED])->count();

            break;

        case '02':

            $february += AuthAssignment::find()->andFilterWhere([
                '=',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->andFilterWhere(['!=', 'item_name', 'RegisteredUnconfirmed'])->count();

            $februaryCredit += CreditApplication::find()->andFilterWhere([
                'like',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->count();

            $februaryProduct += Product::find()->andFilterWhere([
                'like',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->andFilterWhere(['!=', 'status', Product::STATUS_BEFORE_CREATE_ADS])
                ->andFilterWhere(['!=', 'status', Product::STATUS_TO_BE_VERIFIED])->count();

            break;

        case '03':
            $march += AuthAssignment::find()->andFilterWhere([
                '=',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->andFilterWhere(['!=', 'item_name', 'RegisteredUnconfirmed'])->count();

            $marchCredit += CreditApplication::find()->andFilterWhere([
                'like',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->count();

            $marchProduct += Product::find()->andFilterWhere([
                'like',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->andFilterWhere(['!=', 'status', Product::STATUS_BEFORE_CREATE_ADS])
                ->andFilterWhere(['!=', 'status', Product::STATUS_TO_BE_VERIFIED])->count();

            break;

        case '04':
            $april += AuthAssignment::find()->andFilterWhere([
                '=',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->andFilterWhere(['!=', 'item_name', 'RegisteredUnconfirmed'])->count();

            $aprilCredit += CreditApplication::find()->andFilterWhere([
                'like',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->count();

            $aprilProduct += Product::find()->andFilterWhere([
                'like',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->andFilterWhere(['!=', 'status', Product::STATUS_BEFORE_CREATE_ADS])
                ->andFilterWhere(['!=', 'status', Product::STATUS_TO_BE_VERIFIED])->count();

            break;

        case '05':
            $may += AuthAssignment::find()->andFilterWhere([
                '=',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->andFilterWhere(['!=', 'item_name', 'RegisteredUnconfirmed'])->count();

            $mayCredit += CreditApplication::find()->andFilterWhere([
                'like',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->count();

            $mayProduct += Product::find()->andFilterWhere([
                'like',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->andFilterWhere(['!=', 'status', Product::STATUS_BEFORE_CREATE_ADS])
                ->andFilterWhere(['!=', 'status', Product::STATUS_TO_BE_VERIFIED])->count();

            break;

        case '06':
            $june += AuthAssignment::find()->andFilterWhere([
                '=',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->andFilterWhere(['!=', 'item_name', 'RegisteredUnconfirmed'])->count();

            $juneCredit += CreditApplication::find()->andFilterWhere([
                'like',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->count();

            $juneProduct += Product::find()->andFilterWhere([
                'like',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->andFilterWhere(['!=', 'status', Product::STATUS_BEFORE_CREATE_ADS])
                ->andFilterWhere(['!=', 'status', Product::STATUS_TO_BE_VERIFIED])->count();

            break;

        case '07':
            $july += AuthAssignment::find()->andFilterWhere([
                '=',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->andFilterWhere(['!=', 'item_name', 'RegisteredUnconfirmed'])->count();

            $julyCredit += CreditApplication::find()->andFilterWhere([
                'like',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->count();

            $julyProduct += Product::find()->andFilterWhere([
                'like',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->andFilterWhere(['!=', 'status', Product::STATUS_BEFORE_CREATE_ADS])
                ->andFilterWhere(['!=', 'status', Product::STATUS_TO_BE_VERIFIED])->count();

            break;

        case '08':
            $august += AuthAssignment::find()->andFilterWhere([
                '=',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->andFilterWhere(['!=', 'item_name', 'RegisteredUnconfirmed'])->count();

            $augustCredit += CreditApplication::find()->andFilterWhere([
                'like',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->count();

            $augustProduct += Product::find()->andFilterWhere([
                'like',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->andFilterWhere(['!=', 'status', Product::STATUS_BEFORE_CREATE_ADS])
                ->andFilterWhere(['!=', 'status', Product::STATUS_TO_BE_VERIFIED])->count();

            break;

        case '09':
            $september += AuthAssignment::find()->andFilterWhere([
                '=',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->andFilterWhere(['!=', 'item_name', 'RegisteredUnconfirmed'])->count();

            $septemberCredit += CreditApplication::find()->andFilterWhere([
                'like',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->count();

            $septemberProduct += Product::find()->andFilterWhere([
                'like',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->andFilterWhere(['!=', 'status', Product::STATUS_BEFORE_CREATE_ADS])
                ->andFilterWhere(['!=', 'status', Product::STATUS_TO_BE_VERIFIED])->count();

            break;

        case '10':
            $october += AuthAssignment::find()->andFilterWhere([
                '=',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->andFilterWhere(['!=', 'item_name', 'RegisteredUnconfirmed'])->count();

            $octoberCredit += CreditApplication::find()->andFilterWhere([
                'like',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->count();

            $octoberProduct += Product::find()->andFilterWhere([
                'like',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->andFilterWhere(['!=', 'status', Product::STATUS_BEFORE_CREATE_ADS])
                ->andFilterWhere(['!=', 'status', Product::STATUS_TO_BE_VERIFIED])->count();

            break;

        case '11':
            $november += AuthAssignment::find()->andFilterWhere([
                '=',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->andFilterWhere(['!=', 'item_name', 'RegisteredUnconfirmed'])->count();

            $novemberCredit += CreditApplication::find()->andFilterWhere([
                'like',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->count();

            $novemberProduct += Product::find()->andFilterWhere([
                'like',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->andFilterWhere(['!=', 'status', Product::STATUS_BEFORE_CREATE_ADS])
                ->andFilterWhere(['!=', 'status', Product::STATUS_TO_BE_VERIFIED])->count();

            break;

        case '12':
            $december += AuthAssignment::find()->andFilterWhere([
                '=',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->andFilterWhere(['!=', 'item_name', 'RegisteredUnconfirmed'])->count();

            $decemberCredit += CreditApplication::find()->andFilterWhere([
                'like',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->count();

            $decemberProduct += Product::find()->andFilterWhere([
                'like',
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
                $days['date']
            ])->andFilterWhere(['!=', 'status', Product::STATUS_BEFORE_CREATE_ADS])
                ->andFilterWhere(['!=', 'status', Product::STATUS_TO_BE_VERIFIED])->count();

            break;
    }
}

$chartDataArray = [
    '01' => [
        'nameMonth' => 'Янв',
        'countUser' => $january,
        'countCreditApplication' => $januaryCredit,
        'countProduct' => $januaryProduct
    ],
    '02' => [
        'nameMonth' => 'Фев',
        'countUser' => $february,
        'countCreditApplication' => $februaryCredit,
        'countProduct' => $februaryProduct
    ],
    '03' => [
        'nameMonth' => 'Март',
        'countUser' => $march,
        'countCreditApplication' => $marchCredit,
        'countProduct' => $marchProduct
    ],
    '04' => [
        'nameMonth' => 'Апр',
        'countUser' => $april,
        'countCreditApplication' => $aprilCredit,
        'countProduct' => $aprilProduct
    ],
    '05' => [
        'nameMonth' => 'Май',
        'countUser' => $may,
        'countCreditApplication' => $mayCredit,
        'countProduct' => $mayProduct
    ],
    '06' => [
        'nameMonth' => 'Июнь',
        'countUser' => $june,
        'countCreditApplication' => $juneCredit,
        'countProduct' => $juneProduct
    ],
    '07' => [
        'nameMonth' => 'Июль',
        'countUser' => $july,
        'countCreditApplication' => $julyCredit,
        'countProduct' => $julyProduct
    ],
    '08' => [
        'nameMonth' => 'Авг',
        'countUser' => $august,
        'countCreditApplication' => $augustCredit,
        'countProduct' => $augustProduct
    ],
    '09' => [
        'nameMonth' => 'Сент',
        'countUser' => $september,
        'countCreditApplication' => $septemberCredit,
        'countProduct' => $septemberProduct
    ],
    '10' => [
        'nameMonth' => 'Окт',
        'countUser' => $october,
        'countCreditApplication' => $octoberCredit,
        'countProduct' => $octoberProduct
    ],
    '11' => [
        'nameMonth' => 'Нояб',
        'countUser' => $november,
        'countCreditApplication' => $novemberCredit,
        'countProduct' => $novemberProduct
    ],
    '12' => [
        'nameMonth' => 'Дек',
        'countUser' => $december,
        'countCreditApplication' => $decemberCredit,
        'countProduct' => $decemberProduct
    ],
];

$month = "[";
$countUserYear = "[";
$countCreditYear = "[";
$countProductYear = "[";
foreach ($arrayOfMonth as $key => $value) {

    $month .= "'";
    $month .= $chartDataArray[$value]["nameMonth"];
    $month .= "',";

    $countUserYear .= $chartDataArray[$value]['countUser'];
    $countUserYear .= ",";

    $countCreditYear .= $chartDataArray[$value]['countCreditApplication'];
    $countCreditYear .= ",";

    $countProductYear .= $chartDataArray[$value]['countProduct'];
    $countProductYear .= ",";
}
$countUserYear .= "]";
$month .= "]";
$countCreditYear .= "]";
$countProductYear .= "]";


$this->registerJs("
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#userChart').get(0).getContext('2d')
    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas)

    var areaChartData = {
      labels  : " . $month . ",
      datasets: [
        {
          label               : 'Заявок на кредит',
          fillColor           : 'rgba(255,255,255,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
data : " . $countUserYear . ",       
}
      ]
    }

    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale               : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : false,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - Whether the line is curved between points
      bezierCurve             : true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension      : 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot                : false,
      //Number - Radius of each point dot in pixels
      pointDotRadius          : 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth     : 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius : 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke           : true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth      : 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill             : true,
      //String - A legend template
      legendTemplate          : '<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio     : true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive              : true
    }

//Create the line chart
    areaChart.Line(areaChartData, areaChartOptions)
      })
");
$this->registerJs("
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#creditapplicationofyearsChart').get(0).getContext('2d')
    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas)

    var areaChartData = {
      labels  : " . $month . ",
      datasets: [
        {
          label               : 'Заявок на кредит',
          fillColor           : 'rgba(255,255,255,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : " . $countCreditYear . ",
          }
      ]
    }

    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale               : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : false,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - Whether the line is curved between points
      bezierCurve             : true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension      : 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot                : false,
      //Number - Radius of each point dot in pixels
      pointDotRadius          : 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth     : 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius : 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke           : true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth      : 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill             : true,
      //String - A legend template
      legendTemplate          : '<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio     : true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive              : true
    }

//Create the line chart
    areaChart.Line(areaChartData, areaChartOptions)
      })
");
$this->registerJs("
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#productofyearsChart').get(0).getContext('2d')
    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas)

    var areaChartData = {
      labels  : " . $month . ",
      datasets: [
        {
          label               : 'Заявок на кредит',
          fillColor           : 'rgba(255,255,255,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : " . $countProductYear . ",
          }
      ]
    }

    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale               : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : false,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - Whether the line is curved between points
      bezierCurve             : true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension      : 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot                : false,
      //Number - Radius of each point dot in pixels
      pointDotRadius          : 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth     : 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius : 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke           : true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth      : 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill             : true,
      //String - A legend template
      legendTemplate          : '<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio     : true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive              : true
    }

//Create the line chart
    areaChart.Line(areaChartData, areaChartOptions)
      })
");
AppAsset::register($this);
dmstr\web\AdminLteAsset::register($this);
?>
<!-- Main content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <!-- AREA CHART -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">График пользователей за год</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="chart">
                    <canvas id="userChart" style="height: 250px; width: 510px;" width="510" height="250"></canvas>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-6">
            <!-- AREA CHART -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">График заявок за год</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="chart">
                    <canvas id="creditapplicationofyearsChart" style="height: 250px; width: 510px;" width="510"
                            height="250"></canvas>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <!-- AREA CHART -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">График объявлений за год</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="chart">
                    <canvas id="productofyearsChart" style="height: 250px; width: 510px;" width="510"
                            height="250"></canvas>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
