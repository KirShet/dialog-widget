<?php

namespace kirshet\yii2-dialog-widget\DialogWidget\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class DialogWidgetAsset extends AssetBundle
{
    public $sourcePath = '@vendor/kirshet/yii2-dialog-widget/src/DialogWidget/assets';

    public $css = [
        'css/dialog-widget.css',
    ]; 
    public $publishOptions = ['forceCopy' => true];
}