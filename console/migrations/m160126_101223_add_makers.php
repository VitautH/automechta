<?php

use yii\db\Schema;
use yii\db\Migration;
use common\models\ProductMake;

class m160126_101223_add_makers extends Migration
{
    private $makes = [
        'Acura',
        'Alfa Romeo',
        'Aston Martin',
        'Audi',
        'Avia',
        'Barkas',
        'BAW',
        'Bentley',
        'BMW',
        'Brilliance',
        'Buick',
        'Cadillac',
        'Changan',
        'Chery',
        'Chevrolet',
        'Chrysler',
        'Citroen',
        'Dacia',
        'Daewoo',
        'DAF',
        'Daihatsu',
        'Datsun',
        'Derways',
        'Dodge',
        'FAW',
        'Ferrari',
        'Fiat',
        'Ford',
        'Foton',
        'Freightliner',
        'Geely',
        'GMC',
        'Great Wall',
        'Hafei',
        'Haima',
        'Honda',
        'Hummer',
        'Hyundai',
        'IFA',
        'Infiniti',
        'Iran Khodro',
        'Isuzu',
        'Iveco',
        'JAC',
        'Jaguar',
        'Jeep',
        'Jiangling',
        'KIA',
        'Lada (ВАЗ)',
        'Lancia',
        'Land Rover',
        'Lexus',
        'LIAZ',
        'Lifan',
        'Lincoln',
        'MAN',
        'Maserati',
        'Mazda',
        'MCC Smart',
        'Mercedes',
        'Mercury',
        'MG',
        'Mini',
        'Mitsubishi',
        'Mudan',
        'Nissan',
        'Nysa',
        'Opel',
        'Peugeot',
        'Plymouth',
        'Pontiac',
        'Porsche',
        'Proton',
        'Renault',
        'Rover',
        'SAAB',
        'Samand',
        'Saturn',
        'Scania',
        'Scion',
        'SEAT',
        'Skoda',
        'Smart',
        'SsangYong',
        'Subaru',
        'Suzuki',
        'Tatra',
        'Tesla',
        'Toyota',
        'Trabant',
        'Volkswagen',
        'Volvo',
        'Wartburg',
        'Zuk',
        'ZX',
        'Автобус',
        'Богдан',
        'Водный трансп.',
        'ГАЗ',
        'Гидроцикл',
        'Другой транспорт',
        'ЕрАЗ',
        'ЗАЗ',
        'ЗИЛ',
        'ИЖ',
        'Камаз',
        'Краз',
        'ЛУАЗ',
        'Люблин',
        'МАЗ',
        'МАЗ-MAN',
        'Москвич',
        'Полуприцепы',
        'Прицепы',
        'Сельхозтехника',
        'Спецтехника',
        'Стройтехника',
        'УАЗ',
        'Урал',
        'Эксклюзив',
    ];

    public function up()
    {
        foreach ($this->makes as $make) {
            $model = new ProductMake();
            $model->detachBehavior('BlameableBehavior');
            $model->name = $make;
            $model->created_by = 1;
            $model->updated_by = 1;
            $model->save();
        }
    }

    public function down()
    {
        echo "m160126_101223_add_makers cannot be reverted.\n";

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
