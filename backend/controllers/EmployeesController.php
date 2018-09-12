<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Employees;


class EmployeesController extends Controller
{

    public function actionIndex()
    {
        $employees = Employees::getEmployees();

        return $this->render('index', [
            'users' => $employees
        ]);
    }
}