<?php

namespace common\components;

use Yii;
use yii\base\Component;
use GuzzleHttp\Client;

class Currency extends Component
{
    const USD = 145;
    public $codeCurrency;
    public $currencyRate;

    public function getCurrencyToByn($codeCurrency)
    {
        $this->codeCurrency = $codeCurrency;
        if (Yii::$app->cache->exists('codeCurrencyToBYN')) {
            $this->currencyRate = Yii::$app->cache->get('codeCurrencyToBYN');
        } else {
            $result = $this->_parser();
            $this->saveData('codeCurrencyToBYN', $result->Cur_OfficialRate, 86400);
            $this->currencyRate = $result->Cur_OfficialRate;
        }

        return $this;
    }

    public function convertCurrencyToByn($price){

        $result = $price * $this->currencyRate;

        return intval($result);
    }

    public function convertCurrencyToUsd($price){

        $result = $price / $this->currencyRate;

        return intval($result);
    }

    private function _parser()
    {
        $client = new Client();
        $res = $client->request('GET', 'http://www.nbrb.by/API/ExRates/Rates/' . $this->codeCurrency);
        $result = json_decode($res->getBody());

        return $result;
    }

    private function saveData($key, $value, $duration = null)
    {

        if ($duration == null) {
            if (Yii::$app->cache->set($key, $value)) {
                return true;
            }
        } else {
            if (Yii::$app->cache->set($key, $value, $duration)) {
                return true;
            }
        }
    }
}