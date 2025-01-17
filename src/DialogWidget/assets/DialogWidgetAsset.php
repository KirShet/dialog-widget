<?php

namespace kirshet\yii2_dialog_widget\DialogWidget\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class DialogWidgetAsset extends AssetBundle
{
    public $sourcePath = '@vendor/kirshet/yii2_dialog_widget/src/DialogWidget/assets';

    public $css = [
        'css/dialog-widget.css',
    ]; 
    public $publishOptions = ['forceCopy' => true];
}