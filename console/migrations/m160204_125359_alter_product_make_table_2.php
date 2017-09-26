<?php

use yii\db\Schema;
use yii\db\Migration;
use common\models\ProductMake;

class m160204_125359_alter_product_make_table_2 extends Migration
{
    private $makes = [
        'Acura' => [
            'CL',
            'CSX',
            'EL',
            'ILX',
            'Integra',
            'Legend',
            'MDX',
            'NSX',
            'RDX',
            'RL',
            'RSX',
            'SLX',
            'TL',
            'TSX',
            'Vigor',
            'ZDX',
        ],
        'Alfa Romeo' => [
            '145',
            '146',
            '147',
            '155',
            '156',
            '159',
            '159 SW',
            '164',
            '166',
            '33',
            '75',
            '90',
            'Brera',
            'Giulietta',
            'GT',
            'GTV',
            'MiTo',
            'Spider',
            'Sport Wagon',
        ],
        'Aston Martin' => [
            '2326',
            'DB9',
            'DBS',
            'Rapide',
            'V12 Vanquish',
            'V8',
            'Vantage',
        ],
        'Audi' => [],
        'Avia' => [],
        'Barkas' => [],
        'BAW' => [],
        'Bentley' => [],
        'BMW' => [],
        'Brilliance' => [],
        'Buick' => [],
        'Cadillac' => [],
        'Changan' => [],
        'Chery' => [],
        'Chevrolet' => [],
        'Chrysler' => [],
        'Citroen' => [],
        'Dacia' => [],
        'Daewoo' => [],
        'DAF' => [],
        'Daihatsu' => [],
        'Datsun' => [],
        'Derways' => [],
        'Dodge' => [],
        'FAW' => [],
        'Ferrari' => [],
        'Fiat' => [],
        'Ford' => [],
        'Foton' => [],
        'Freightliner' => [],
        'Geely' => [],
        'GMC' => [],
        'Great Wall'  => [],
        'Hafei'  => [],
        'Haima'  => [],
        'Honda'  => [],
        'Hummer'  => [],
        'Hyundai'  => [],
        'IFA'  => [],
        'Infiniti'  => [],
        'Iran Khodro'  => [],
        'Isuzu'  => [],
        'Iveco'  => [],
        'JAC'  => [],
        'Jaguar'  => [],
        'Jeep'  => [],
        'Jiangling'  => [],
        'KIA'  => [],
        'Lada (ВАЗ)'  => [],
        'Lancia'  => [],
        'Land Rover'  => [],
        'Lexus'  => [],
        'LIAZ'  => [],
        'Lifan'  => [],
        'Lincoln'  => [],
        'MAN'  => [],
        'Maserati'  => [],
        'Mazda'  => [],
        'MCC Smart'  => [],
        'Mercedes'  => [],
        'Mercury'  => [],
        'MG'  => [],
        'Mini'  => [],
        'Mitsubishi'  => [],
        'Mudan'  => [],
        'Nissan'  => [],
        'Nysa'  => [],
        'Opel'  => [],
        'Peugeot'  => [],
        'Plymouth'  => [],
        'Pontiac'  => [],
        'Porsche'  => [],
        'Proton'  => [],
        'Renault'  => [],
        'Rover'  => [],
        'SAAB'  => [],
        'Samand'  => [],
        'Saturn'  => [],
        'Scania'  => [],
        'Scion'  => [],
        'SEAT'  => [],
        'Skoda'  => [],
        'Smart'  => [],
        'SsangYong'  => [],
        'Subaru'  => [],
        'Suzuki'  => [],
        'Tatra'  => [],
        'Tesla'  => [],
        'Toyota'  => [],
        'Trabant'  => [],
        'Volkswagen'  => [],
        'Volvo'  => [],
        'Wartburg'  => [],
        'Zuk'  => [],
        'ZX'  => [],
        'Автобус'  => [],
        'Богдан'  => [],
        'Водный трансп.'  => [],
        'ГАЗ'  => [],
        'Гидроцикл'  => [],
        'Другой транспорт'  => [],
        'ЕрАЗ'  => [],
        'ЗАЗ'  => [],
        'ЗИЛ'  => [],
        'ИЖ'  => [],
        'Камаз'  => [],
        'Краз'  => [],
        'ЛУАЗ'  => [],
        'Люблин'  => [],
        'МАЗ'  => [],
        'МАЗ-MAN'  => [],
        'Москвич'  => [],
        'Полуприцепы'  => [],
        'Прицепы'  => [],
        'Сельхозтехника'  => [],
        'Спецтехника'  => [],
        'Стройтехника'  => [],
        'УАЗ'  => [],
        'Урал'  => [],
        'Эксклюзив'  => [],
    ];

    public function up()
    {
        $this->delete('product_i18n');
        $this->delete('product');
        $this->delete('product_make');

        $this->alterColumn('product_make', 'created_by', $this->integer()->defaultValue(0));
        $this->alterColumn('product_make', 'updated_by', $this->integer()->defaultValue(0));

        $root = ProductMake::getRoot();

        foreach ($this->makes as $make => $models) {
            $model = new ProductMake();
            $model->detachBehavior('BlameableBehavior');
            $model->name = $make;
            $model->created_by = 1;
            $model->updated_by = 1;
            $model->appendTo($root);
            if (!empty($models)) {
                foreach ($models as $make) {
                    $nestedModel = new ProductMake();
                    $nestedModel->detachBehavior('BlameableBehavior');
                    $nestedModel->name = $make;
                    $nestedModel->created_by = 1;
                    $nestedModel->updated_by = 1;
                    $nestedModel->appendTo($model);
                }
            }
        }
    }

    public function down()
    {
        echo "m160204_125359_alter_product_make_table_2 cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
