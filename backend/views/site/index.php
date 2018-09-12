<?php

use common\models\Product;
use common\models\User;
use common\models\AuthAssignment;
use common\models\CreditApplication;
use yii\helpers\Url;
use backend\assets\AppAsset;
use common\models\ProductSearch;
use common\models\CreditApplicationSearch;
use yii\db\Query;
use backend\models\Tasks;

/* @var $this yii\web\View */

$this->title = 'Автомечта';
$products = Product::find()->notVerified()->orderBy('created_at DESC')->all();
$creditApplication = CreditApplication::find()->orderBy('created_at DESC')->active()->all();
$creditArriveTomorrow = CreditApplication::find()->arriveTomorrow()->count();
$tasks = Tasks::find()->where(['employee_to'=>Yii::$app->user->id])->andWhere(['!=','status',Tasks::DRAFT_STATUS])->orderBy('priority DESC')->addOrderBy('created_at DESC')->asArray()->all();
$tasksCount = count($tasks);
$dateTomorrow = date("Y-m-d", strtotime('tomorrow'));
$this->registerJsFile('/plugins/bootstrap/js/bootstrap.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('/plugins/chart.js/Chart.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs("
new Chart(document.getElementById('creditapplicationChart'), {
  type: 'line',
  data: {
    labels: " . $chartCreditApplicationMonth['days'] . ",
    datasets: [{ 
        data: " . $chartCreditApplicationMonth['countCreditApplication'] . ",
        label: 'Кол-во',
        borderColor: '#3e95cd',
        fill: false
      }
    ]
  },
  options: {
    title: {
      display: false
    }
  }
});
");

$date = new DateTime('-11 month');
$lastYearDate = $date->format('Y-m-d ');
$from = new DateTime($lastYearDate);
$to = new DateTime(date("Y-m-d 00:01"));

$period = new DatePeriod($from, new DateInterval('P1M'), $to);


$lastYearMonth = $date->format('Y-m-d');
$from = new DateTime($lastYearMonth);
$to = new DateTime(date('Y-m-d'));

$period = new DatePeriod($from, new DateInterval('P1M'), $to);

$arrayOfMonth = array_map(
    function ($item) {
        $dateOfMonth = array();
        $dateOfMonth['year'] = $item->format('Y');
        $dateOfMonth['month'] = $item->format('m');
        $dateOfMonth['first_days'] = $item->format('Y-m-01');
        $dateOfMonth['last_days'] = $item->format('Y-m-t');

        return $dateOfMonth;
    },
    iterator_to_array($period)
);


foreach ($arrayOfMonth as $days) {
    switch ($days['month']) {
        case '01':
            $query = new Query;
            $query->select('*')
                ->from('user')
                ->leftJoin('auth_assignment', 'user_id =id')
                ->where([
                    'between',
                    'FROM_UNIXTIME(user.created_at, "%Y-%m-%d")',
                    $days['first_days'],
                    $days['last_days']
                ])
                ->andWhere(['!=', 'item_name', 'RegisteredUnconfirmed'])
                ->count();

            $command = $query->createCommand();
            $january = count($command->queryAll());


            $credit = new CreditApplicationSearch();
            $params ["CreditApplicationSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $credit->load($params);
            $januaryCredit = $credit->search()->totalCount;


            $productUnpublished = new ProductSearch();
            $params ["ProductSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $params ["ProductSearch"]["status"] = Product::STATUS_UNPUBLISHED;
            $productUnpublished->loadI18n($params);
            $productUnpublished->search()->totalCount;

            $productPublished = new ProductSearch();
            $params ["ProductSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $params ["ProductSearch"]["status"] = Product::STATUS_PUBLISHED;
            $productPublished->loadI18n($params);
            $productPublished->search()->totalCount;

            $januaryProduct = $productPublished->search()->totalCount + $productUnpublished->search()->totalCount;

            break;

        case '02':
            $query = new Query;
            $query->select('*')
                ->from('user')
                ->leftJoin('auth_assignment', 'user_id =id')
                ->where([
                    'between',
                    'FROM_UNIXTIME(user.created_at, "%Y-%m-%d")',
                    $days['first_days'],
                    $days['last_days']
                ])
                ->andWhere(['!=', 'item_name', 'RegisteredUnconfirmed'])
                ->count();

            $command = $query->createCommand();
            $february = count($command->queryAll());


            $credit = new CreditApplicationSearch();
            $params ["CreditApplicationSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $credit->load($params);
            $februaryCredit = $credit->search()->totalCount;


            $productUnpublished = new ProductSearch();
            $params ["ProductSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $params ["ProductSearch"]["status"] = Product::STATUS_UNPUBLISHED;
            $productUnpublished->loadI18n($params);
            $productUnpublished->search()->totalCount;

            $productPublished = new ProductSearch();
            $params ["ProductSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $params ["ProductSearch"]["status"] = Product::STATUS_PUBLISHED;
            $productPublished->loadI18n($params);
            $productPublished->search()->totalCount;

            $februaryProduct = $productPublished->search()->totalCount + $productUnpublished->search()->totalCount;

            break;

        case '03':
            $query = new Query;
            $query->select('*')
                ->from('user')
                ->leftJoin('auth_assignment', 'user_id =id')
                ->where([
                    'between',
                    'FROM_UNIXTIME(user.created_at, "%Y-%m-%d")',
                    $days['first_days'],
                    $days['last_days']
                ])
                ->andWhere(['!=', 'item_name', 'RegisteredUnconfirmed'])
                ->count();

            $command = $query->createCommand();
            $march = count($command->queryAll());


            $credit = new CreditApplicationSearch();
            $params ["CreditApplicationSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $credit->load($params);
            $marchCredit = $credit->search()->totalCount;


            $productUnpublished = new ProductSearch();
            $params ["ProductSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $params ["ProductSearch"]["status"] = Product::STATUS_UNPUBLISHED;
            $productUnpublished->loadI18n($params);
            $productUnpublished->search()->totalCount;

            $productPublished = new ProductSearch();
            $params ["ProductSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $params ["ProductSearch"]["status"] = Product::STATUS_PUBLISHED;
            $productPublished->loadI18n($params);
            $productPublished->search()->totalCount;

            $marchProduct = $productPublished->search()->totalCount + $productUnpublished->search()->totalCount;


            break;

        case '04':

            $query = new Query;
            $query->select('*')
                ->from('user')
                ->leftJoin('auth_assignment', 'user_id =id')
                ->where([
                    'between',
                    'FROM_UNIXTIME(user.created_at, "%Y-%m-%d")',
                    $days['first_days'],
                    $days['last_days']
                ])
                ->andWhere(['!=', 'item_name', 'RegisteredUnconfirmed'])
                ->count();

            $command = $query->createCommand();
            $april = count($command->queryAll());

            $credit = new CreditApplicationSearch();
            $params ["CreditApplicationSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $credit->load($params);
            $aprilCredit = $credit->search()->totalCount;


            $productUnpublished = new ProductSearch();
            $params ["ProductSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $params ["ProductSearch"]["status"] = Product::STATUS_UNPUBLISHED;
            $productUnpublished->loadI18n($params);
            $productUnpublished->search()->totalCount;

            $productPublished = new ProductSearch();
            $params ["ProductSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $params ["ProductSearch"]["status"] = Product::STATUS_PUBLISHED;
            $productPublished->loadI18n($params);
            $productPublished->search()->totalCount;

            $aprilProduct = $productPublished->search()->totalCount + $productUnpublished->search()->totalCount;

            break;

        case '05':
            $query = new Query;
            $query->select('*')
                ->from('user')
                ->leftJoin('auth_assignment', 'user_id =id')
                ->where([
                    'between',
                    'FROM_UNIXTIME(user.created_at, "%Y-%m-%d")',
                    $days['first_days'],
                    $days['last_days']
                ])
                ->andWhere(['!=', 'item_name', 'RegisteredUnconfirmed'])
                ->count();

            $command = $query->createCommand();
            $may = count($command->queryAll());

            $credit = new CreditApplicationSearch();
            $params ["CreditApplicationSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $credit->load($params);
            $mayCredit = $credit->search()->totalCount;


            $productUnpublished = new ProductSearch();
            $params ["ProductSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $params ["ProductSearch"]["status"] = Product::STATUS_UNPUBLISHED;
            $productUnpublished->loadI18n($params);
            $productUnpublished->search()->totalCount;

            $productPublished = new ProductSearch();
            $params ["ProductSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $params ["ProductSearch"]["status"] = Product::STATUS_PUBLISHED;
            $productPublished->loadI18n($params);
            $productPublished->search()->totalCount;

            $mayProduct = $productPublished->search()->totalCount + $productUnpublished->search()->totalCount;

            break;

        case '06':
            $query = new Query;
            $query->select('*')
                ->from('user')
                ->leftJoin('auth_assignment', 'user_id =id')
                ->where([
                    'between',
                    'FROM_UNIXTIME(user.created_at, "%Y-%m-%d")',
                    $days['first_days'],
                    $days['last_days']
                ])
                ->andWhere(['!=', 'item_name', 'RegisteredUnconfirmed'])
                ->count();

            $command = $query->createCommand();
            $june = count($command->queryAll());


            $credit = new CreditApplicationSearch();
            $params ["CreditApplicationSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $credit->load($params);
            $juneCredit = $credit->search()->totalCount;

            $productUnpublished = new ProductSearch();
            $params ["ProductSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $params ["ProductSearch"]["status"] = Product::STATUS_UNPUBLISHED;
            $productUnpublished->loadI18n($params);
            $productUnpublished->search()->totalCount;

            $productPublished = new ProductSearch();
            $params ["ProductSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $params ["ProductSearch"]["status"] = Product::STATUS_PUBLISHED;
            $productPublished->loadI18n($params);
            $productPublished->search()->totalCount;

            $juneProduct = $productPublished->search()->totalCount + $productUnpublished->search()->totalCount;

            break;

        case '07':
            $query = new Query;
            $query->select('*')
                ->from('user')
                ->leftJoin('auth_assignment', 'user_id =id')
                ->where([
                    'between',
                    'FROM_UNIXTIME(user.created_at, "%Y-%m-%d")',
                    $days['first_days'],
                    $days['last_days']
                ])
                ->andWhere(['!=', 'item_name', 'RegisteredUnconfirmed'])
                ->count();

            $command = $query->createCommand();
            $july = count($command->queryAll());


            $credit = new CreditApplicationSearch();
            $params ["CreditApplicationSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $credit->load($params);
            $julyCredit = $credit->search()->totalCount;


            $productUnpublished = new ProductSearch();
            $params ["ProductSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $params ["ProductSearch"]["status"] = Product::STATUS_UNPUBLISHED;
            $productUnpublished->loadI18n($params);
            $productUnpublished->search()->totalCount;

            $productPublished = new ProductSearch();
            $params ["ProductSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $params ["ProductSearch"]["status"] = Product::STATUS_PUBLISHED;
            $productPublished->loadI18n($params);
            $productPublished->search()->totalCount;

            $julyProduct = $productPublished->search()->totalCount + $productUnpublished->search()->totalCount;

            break;

        case '08':
            $query = new Query;
            $query->select('*')
                ->from('user')
                ->leftJoin('auth_assignment', 'user_id =id')
                ->where([
                    'between',
                    'FROM_UNIXTIME(user.created_at, "%Y-%m-%d")',
                    $days['first_days'],
                    $days['last_days']
                ])
                ->andWhere(['!=', 'item_name', 'RegisteredUnconfirmed'])
                ->count();

            $command = $query->createCommand();
            $august = count($command->queryAll());

            $credit = new CreditApplicationSearch();
            $params ["CreditApplicationSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $credit->load($params);
            $augustCredit = $credit->search()->totalCount;


            $productUnpublished = new ProductSearch();
            $params ["ProductSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $params ["ProductSearch"]["status"] = Product::STATUS_UNPUBLISHED;
            $productUnpublished->loadI18n($params);
            $productUnpublished->search()->totalCount;

            $productPublished = new ProductSearch();
            $params ["ProductSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $params ["ProductSearch"]["status"] = Product::STATUS_PUBLISHED;
            $productPublished->loadI18n($params);
            $productPublished->search()->totalCount;

            $augustProduct = $productPublished->search()->totalCount + $productUnpublished->search()->totalCount;


            break;

        case '09':
            $query = new Query;
            $query->select('*')
                ->from('user')
                ->leftJoin('auth_assignment', 'user_id =id')
                ->where([
                    'between',
                    'FROM_UNIXTIME(user.created_at, "%Y-%m-%d")',
                    $days['first_days'],
                    $days['last_days']
                ])
                ->andWhere(['!=', 'item_name', 'RegisteredUnconfirmed'])
                ->count();

            $command = $query->createCommand();
            $september = count($command->queryAll());


            $credit = new CreditApplicationSearch();
            $params ["CreditApplicationSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $credit->load($params);
            $septemberCredit = $credit->search()->totalCount;


            $productUnpublished = new ProductSearch();
            $params ["ProductSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $params ["ProductSearch"]["status"] = Product::STATUS_UNPUBLISHED;
            $productUnpublished->loadI18n($params);
            $productUnpublished->search()->totalCount;

            $productPublished = new ProductSearch();
            $params ["ProductSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $params ["ProductSearch"]["status"] = Product::STATUS_PUBLISHED;
            $productPublished->loadI18n($params);
            $productPublished->search()->totalCount;

            $septemberProduct = $productPublished->search()->totalCount + $productUnpublished->search()->totalCount;

            break;

        case '10':

            $query = new Query;
            $query->select('*')
                ->from('user')
                ->leftJoin('auth_assignment', 'user_id =id')
                ->where([
                    'between',
                    'FROM_UNIXTIME(user.created_at, "%Y-%m-%d")',
                    $days['first_days'],
                    $days['last_days']
                ])
                ->andWhere(['!=', 'item_name', 'RegisteredUnconfirmed'])
                ->count();

            $command = $query->createCommand();
            $october = count($command->queryAll());


            $credit = new CreditApplicationSearch();
            $params ["CreditApplicationSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $credit->load($params);
            $octoberCredit = $credit->search()->totalCount;


            $productUnpublished = new ProductSearch();
            $params ["ProductSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $params ["ProductSearch"]["status"] = Product::STATUS_UNPUBLISHED;
            $productUnpublished->loadI18n($params);
            $productUnpublished->search()->totalCount;

            $productPublished = new ProductSearch();
            $params ["ProductSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $params ["ProductSearch"]["status"] = Product::STATUS_PUBLISHED;
            $productPublished->loadI18n($params);
            $productPublished->search()->totalCount;

            $octoberProduct = $productPublished->search()->totalCount + $productUnpublished->search()->totalCount;

            break;

        case '11':
            $query = new Query;
            $query->select('*')
                ->from('user')
                ->leftJoin('auth_assignment', 'user_id =id')
                ->where([
                    'between',
                    'FROM_UNIXTIME(user.created_at, "%Y-%m-%d")',
                    $days['first_days'],
                    $days['last_days']
                ])
                ->andWhere(['!=', 'item_name', 'RegisteredUnconfirmed'])
                ->count();

            $command = $query->createCommand();
            $november = count($command->queryAll());


            $credit = new CreditApplicationSearch();
            $params ["CreditApplicationSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $credit->load($params);
            $novemberCredit = $credit->search()->totalCount;

            $productUnpublished = new ProductSearch();
            $params ["ProductSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $params ["ProductSearch"]["status"] = Product::STATUS_UNPUBLISHED;
            $productUnpublished->loadI18n($params);
            $productUnpublished->search()->totalCount;

            $productPublished = new ProductSearch();
            $params ["ProductSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $params ["ProductSearch"]["status"] = Product::STATUS_PUBLISHED;
            $productPublished->loadI18n($params);
            $productPublished->search()->totalCount;

            $novemberProduct = $productPublished->search()->totalCount + $productUnpublished->search()->totalCount;

            break;

        case '12':
            $query = new Query;
            $query->select('*')
                ->from('user')
                ->leftJoin('auth_assignment', 'user_id =id')
                ->where([
                    'between',
                    'FROM_UNIXTIME(user.created_at, "%Y-%m-%d")',
                    $days['first_days'],
                    $days['last_days']
                ])
                ->andWhere(['!=', 'item_name', 'RegisteredUnconfirmed'])
                ->count();

            $command = $query->createCommand();
            $december = count($command->queryAll());


            $credit = new CreditApplicationSearch();
            $params ["CreditApplicationSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $credit->load($params);
            $decemberCredit = $credit->search()->totalCount;


            $productUnpublished = new ProductSearch();
            $params ["ProductSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $params ["ProductSearch"]["status"] = Product::STATUS_UNPUBLISHED;
            $productUnpublished->loadI18n($params);
            $productUnpublished->search()->totalCount;

            $productPublished = new ProductSearch();
            $params ["ProductSearch"]["created_at"] = '' . $days['first_days'] . ' / ' . $days['last_days'] . '';
            $params ["ProductSearch"]["status"] = Product::STATUS_PUBLISHED;
            $productPublished->loadI18n($params);
            $productPublished->search()->totalCount;

            $decemberProduct = $productPublished->search()->totalCount + $productUnpublished->search()->totalCount;

            break;
    }
}

/*
 * Current Month Chart
 */
$date = new DateTime();
$currentMonthNumber = $date->format('m');

$first_days = $date->format('Y-m-01');
$last_days = $date->format('Y-m-t');

$query = new Query;
$query->select('*')
    ->from('user')
    ->leftJoin('auth_assignment', 'user_id =id')
    ->where([
        'between',
        'FROM_UNIXTIME(user.created_at, "%Y-%m-%d")',
        $first_days,
        $last_days
    ])
    ->andWhere(['!=', 'item_name', 'RegisteredUnconfirmed'])
    ->count();

$command = $query->createCommand();
$currentMonth = count($command->queryAll());


$credit = new CreditApplicationSearch();
$params ["CreditApplicationSearch"]["created_at"] = '' . $first_days . ' / ' . $last_days . '';
$credit->load($params);
$currentMonthCredit = $credit->search()->totalCount;


$productUnpublished = new ProductSearch();
$params ["ProductSearch"]["created_at"] = '' . $first_days . ' / ' . $last_days . '';
$params ["ProductSearch"]["status"] = Product::STATUS_UNPUBLISHED;
$productUnpublished->loadI18n($params);
$productUnpublished->search()->totalCount;

$productPublished = new ProductSearch();
$params ["ProductSearch"]["created_at"] = '' . $first_days . ' / ' . $last_days . '';
$params ["ProductSearch"]["status"] = Product::STATUS_PUBLISHED;
$productPublished->loadI18n($params);
$productPublished->search()->totalCount;

$currentMonthProduct = $productPublished->search()->totalCount + $productUnpublished->search()->totalCount;

/*
* End Current Month Chart
*/

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

    $numberMonth = $value['month'];

    $month .= "'";
    $month .= $chartDataArray[$numberMonth]["nameMonth"];
    $month .= "',";

    $countUserYear .= $chartDataArray[$numberMonth]['countUser'];
    $countUserYear .= ",";

    $countCreditYear .= $chartDataArray[$numberMonth]['countCreditApplication'];
    $countCreditYear .= ",";

    $countProductYear .= $chartDataArray[$numberMonth]['countProduct'];
    $countProductYear .= ",";

}

$month .= "'";
$month .= $chartDataArray[$currentMonthNumber]['nameMonth'];
$month .= "',";

$countUserYear .= $currentMonth;
$countUserYear .= ",";

$countCreditYear .= $currentMonthCredit;
$countCreditYear .= ",";

$countProductYear .= $currentMonthProduct;
$countProductYear .= ",";

$countUserYear .= "]";
$month .= "]";
$countCreditYear .= "]";
$countProductYear .= "]";


$this->registerJs("
new Chart(document.getElementById('userChart'), {
  type: 'line',
  data: {
    labels: " . $month . ",
    datasets: [{ 
        data: " . $countUserYear . ", 
        label: 'Кол-во',
        borderColor: '#3e95cd',
        fill: false
      }
    ]
  },
  options: {
    title: {
      display: false
    }
  }
});
");
$this->registerJs("
new Chart(document.getElementById('creditapplicationofyearsChart'), {
  type: 'line',
  data: {
    labels: " . $month . ",
    datasets: [{ 
        data: " . $countCreditYear . ", 
        label: 'Кол-во',
        borderColor: '#3e95cd',
        fill: false
      }
    ]
  },
  options: {
    title: {
      display: false
    }
  }
});

");
$this->registerJs("
new Chart(document.getElementById('productofyearsChart'), {
  type: 'line',
  data: {
    labels: " . $month . ",
    datasets: [{ 
        data: " . $countProductYear . ", 
        label: 'Кол-во',
        borderColor: '#3e95cd',
        fill: false
      }
    ]
  },
  options: {
    title: {
      display: false
    }
  }
});
");
AppAsset::register($this);
dmstr\web\AdminLteAsset::register($this);


?>
<!-- Main content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-flag-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Объявления</span>
                    <span class="info-box-text">(новые)</span>
                    <span class="info-box-number"><?= count($products) ?></span>
                    <a href="<?= Url::to(['product/index', 'ProductSearch[status]' => Product::STATUS_TO_BE_VERIFIED]) ?>">
                        <span>Перейти</span>
                    </a>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa  fa-bank"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Кредит</span>
                    <span class="info-box-text">(заявки)</span>
                    <span class="info-box-number"><?= count($creditApplication) ?></span>
                    <a href="/credit-application/index">
                        <span>Перейти</span>
                    </a>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-warning"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Жалобы</span>
                    <span class="info-box-number"><?= $complaint ?></span>
                    <a href="/complaint">
                        <span>Перейти</span>
                    </a>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-car"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Клиенты</span>
                    <span class="info-box-text">(завтра приедут)</span>
                    <span class="info-box-number"><?= $creditArriveTomorrow ?></span>
                    <a href="/credit-application/index?CreditApplicationSearch%5Bdate_arrive%5D=<?= $dateTomorrow ?>">
                        <span>Перейти</span>
                    </a>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa  fa-phone"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Обратный</span>
                    <span class="info-box-text">звонок</span>
                    <span class="info-box-number"><?= $callback; ?></span>
                    <a href="<?= Url::to(['callback/index']) ?>">
                        <span>Перейти</span>
                    </a>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Чат</span>
                    <span class="info-box-number chat-count"><? echo $countChatNewMessage;?></span>
                    <a href="/chat/index">
                        <span>Перейти</span>
                    </a>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-tasks"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Задачи</span>
                <span class="info-box-number"><?php
                    echo $tasksCount;
                    ?></span>
                <a href="/task/user">
                    <span>Перейти</span>
                </a>
            </div>
            <!-- /.info-box-content -->
        </div>
    </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <!-- AREA CHART -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">График заявок на кредит за месяц</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                    class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="chart">
                    <canvas id="creditapplicationChart" style="height: 250px; width: 510px;" width="510"
                            height="250"></canvas>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><?php
                        echo $countProductMonth;
                        ?></h3>

                    <p>Объявлений (за месяц)</p>
                </div>
                <div class="icon">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <a href="/product/index?ProductSearch%5Bcreated_at%5D=<?php echo $daysOfMonth[0]; ?>+%2F+<?php echo date('Y-m-d'); ?>"
                   class="small-box-footer">
                    Перейти <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3><?php echo $countUserMonth; ?></h3>
                    <p>Пользователей (за месяц)</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="/users/index?created_at%5D=<?php echo $daysOfMonth[0]; ?>+%2F+<?php echo date('Y-m-d'); ?>"
                   class="small-box-footer">
                    Перейти <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
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