<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\AutoComplete;
use app\models\District;
use app\models\Main;
use yii\grid\GridView;

$this->title = 'Адресный стол';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .ui-autocomplete {
        max-height: 300px;
        overflow-y: auto;
    }

    .form-control {
        height: 28px;
        padding: 6px 3px;
    }

    .form-group {
        margin-bottom: 10px;
    }
</style>

<script>
    $(document).ready(function(){

        $('.pagination a').on('click', function(){
            $this = $(this);
            var href = $this.attr('href');

            console.log($('#search-form').serialize());
            href += "&" + $('#search-form').serialize();
            console.log(href);
            window.open(href, "_self");
            return false;
        });
    });

</script>
<div class="uk-grid">
    <div class="uk-width-2-10">
        <div class="uk-panel">
            <h3 class="uk-panel-title">Форма поиска</h3>
            <?php $form = ActiveForm::begin(['id' => 'search-form']); ?>

            <?= $form->field($searchForm, 'lastname')->widget(
                AutoComplete::className(), [
                    'clientOptions' => ['source' => '/index.php?r=site/ajax-search&t=lastname'],
                    'options'=>['class'=>'form-control']
                ]
            ) ?>
            <?= $form->field($searchForm, 'firstname')->widget(
                AutoComplete::className(), [
                    'clientOptions' => ['source' => '/index.php?r=site/ajax-search&t=firstname'],
                    'options'=>['class'=>'form-control']
                ]
            ) ?>
            <?= $form->field($searchForm, 'midname')->widget(
                AutoComplete::className(), [
                    'clientOptions' => ['source' => '/index.php?r=site/ajax-search&t=midname'],
                    'options'=>['class'=>'form-control']
                ]
            ) ?>
            <div class="uk-grid uk-grid-small">
                <div class="uk-width-1-3">
                    <?= $form->field($searchForm, 'byear') ?>
                </div>
                <div class="uk-width-1-3">
                    <?= $form->field($searchForm, 'bmonth')->dropDownList(Main::getMonthList()) ?>
                </div>
                <div class="uk-width-1-3">
                    <?= $form->field($searchForm, 'bdate')->dropDownList(Main::getDateList()) ?>
                </div>
            </div>
            <?= $form->field($searchForm, 'district')->dropDownList($districtList, ['prompt'=>'']); ?>
            <?= $form->field($searchForm, 'city')->widget(
                AutoComplete::className(), [
                    'clientOptions' => ['source' => '/index.php?r=site/ajax-search&t=city'],
                    'options'=>['class'=>'form-control']
                ]
            ) ?>
            <div class="uk-grid uk-grid-small">
                <div class="uk-width-3-5">
                    <?= $form->field($searchForm, 'street')->widget(
                        AutoComplete::className(), [
                            'clientOptions' => ['source' => '/index.php?r=site/ajax-search&t=street'],
                            'options'=>['class'=>'form-control']
                        ]
                    ) ?>
                </div>
                <div class="uk-width-1-5">
                    <?= $form->field($searchForm, 'bld') ?>
                </div>
                <div class="uk-width-1-5">
                    <?= $form->field($searchForm, 'flat') ?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary', 'name' => 'search-button']) ?>
                <?= Html::resetButton('Сброс', ['class' => 'btn btn-primary uk-float-right', 'name' => 'reset-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="uk-width-8-10">

        <div class="report-index">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "{pager}\n{summary}\n{items}\n{pager}",
                'columns' => [
                    [
                        'attribute' => 'lastname',
                        'label' => 'Фамилия',
                    ],
                    [
                        'attribute' => 'firstname',
                        'label' => 'Имя',
                    ],
                    [
                        'attribute' => 'midname',
                        'label' => 'Отчество',
                    ],
                    [
                        'attribute' => 'byear',
                        'label' => 'Год',
                    ],
                    [
                        'attribute' => 'bmonth',
                        'label' => 'месяц',
                    ],
                    [
                        'attribute' => 'bdate',
                        'label' => 'День',
                    ],
                    [
                        'attribute' => 'city',
                        'label' => 'Город',
                    ],
                    [
                        'attribute' => 'street',
                        'label' => 'Улица',
                    ],
                    [
                        'attribute' => 'bld',
                        'label' => 'Дом',
                    ],
                    [
                        'attribute' => 'flat',
                        'label' => 'Кв.',
                    ],
                    [
                        'attribute' => 'district',
                        'label' => 'Район',
                    ],
                ],
            ]); ?>

        </div>

        <?php

        //echo \yii\widgets\LinkPager::widget(['class' => 'pagination', 'pagination' => $dataProvider->pagination]);

        //echo \yii\widgets\LinkPager::widget(['pagination' => $pagination,]);

        //d($list);
        ?>

    </div>
</div>