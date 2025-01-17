Установка через Composer
Установите виджет с помощью команды:
```
composer require kirshet/yii2_dialog_widget:dev-main
```
Использование в представлении
```
use kirshet\yii2_dialog_widget\DialogWidget\DialogWidget;

echo DialogWidget::widget([
    'callid' => '11196663',
    'callurl' => 'https://ooo-tehnologija-i-servis.megapbx.ru/api/v2/call-records/record/2024-12-02/62c8e98e-8186-48db-b0f9-994701586c8d/79202603864_in_2024_12_02-15_38_11_79191366941_fmsf.mp3',
]);
```