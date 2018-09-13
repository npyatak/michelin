<?php
namespace common\components;

use yii\base\InvalidConfigException;
use yii\db\ActiveRecordInterface;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use unclead\multipleinput\components\BaseColumn;


class CustomTableRenderer extends \unclead\multipleinput\renderers\TableRenderer {

    public function renderFooter()
    {
        if (!$this->isAddButtonPositionFooter()) {
            return '';
        }

        $cells = [];
        // $cells[] = Html::tag('td', $this->renderAddButton(), [
        //     'class' => 'list-cell__button'
        // ]);
        $cells[] = Html::tag('td', $this->renderAddButton(), [
        	'colspan' => count($this->columns) - 1,
        	'class' => 'list-cell__button'
        ]);

        return Html::tag('tfoot', Html::tag('tr', implode("\n", $cells)));
    }

    private function renderAddButton()
    {
        $options = [
            'class' => 'btn multiple-input-list__btn js-input-plus',
        ];
        Html::addCssClass($options, $this->addButtonOptions['class']);
        
        return Html::tag('div', $this->addButtonOptions['label'], $options);
    }
}
