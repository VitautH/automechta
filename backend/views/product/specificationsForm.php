<?php
/* @var $this yii\web\View */
/* @var $productSpecifications common\models\ProductSpecification[] */

use yii\helpers\Html;
use backend\models\forms\Specification as SpecificationForm;

?>
<table class="mdl-list-table specifications-list-table auto-width-col">
    <?php foreach ($productSpecifications as $productSpecification): ?>
    <?php
        $specification = $productSpecification->getSpecification()->one();
    ?>
    <tr>
        <td>
            <strong><?= $specification->i18n()->name ?></strong><br>
            <?= $specification->i18n()->comment ?>
        </td>
        <td>
            <?= SpecificationForm::getControl($specification, $productSpecification, $form) ?>
        </td>
    </tr>
    <?php endforeach ?>
</table>