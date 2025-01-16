Установка через Composer
Установите виджет с помощью команды:
```
composer require kirshet/yii2-dialog-widget
```
Использование в представлении
```
use common\widgets\DialogWidget;

// Вызов виджета с параметрами callid и callurl
echo DialogWidget::widget([
    'callid' => '',
    'callurl' => '',
]);
```
Настройка автозагрузки
```
{
    "name": "kirshet/yii2-dialog-widget",
    "description": "A Dialog Widget for user interactions in Yii2 applications.",
    "type": "library",
    "license": "MIT",
    "autoload": {
        "psr-4": {
            "kirshet\\yii2\\": "src/"
        }
    },
    "authors": [
        {
            "name": "Kirill Shetko",
            "email": "kirshet2000@gmail.com"
        }
    ],
    "minimum-stability": "stable",
    "extra": {
        "installer-paths": {
            "common/widgets/DialogWidget": ["kirshet/yii2"]
        }
    }
}
```
Использование в контроллере
```
use yii\web\Controller;

class CallController extends Controller
{
    public function actionIndex()
    {
        $callid = '';
        $callurl = '';

        return $this->render('index', [
            'callid' => $callid,
            'callurl' => $callurl,
        ]);
    }
}
```
И в представлении:
```
use common\widgets\DialogWidget;

echo DialogWidget::widget([
    'callid' => $callid,
    'callurl' => $callurl,
]);
```