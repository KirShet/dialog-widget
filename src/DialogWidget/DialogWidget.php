<?php 
namespace  kirshet\yii2_dialog_widget\DialogWidget; 

use Yii;
use yii\base\Widget;
use kirshet\stt_api_component\SttApiComponent\SttApiComponent;
use kirshet\yii2_dialog_widget\DialogWidget\assets\DialogWidgetAsset;

class DialogWidget extends Widget
{
    public $callid;
    public $callurl;

    public function run()
    {
        if (!$this->callid || !$this->callurl) {
            return '<p>Недостаточно данных для запроса.</p>';
        }

        $sttApi = $this->getSttApi();
        $response = $sttApi->sendRequest($this->callid, $this->callurl);

        if ($response) {
            return $this->renderResponse($response);
        }

        return '<p>Ошибка при получении данных от STT API.</p>';
    }

    private function getSttApi()
    {

        if (\Yii::$app->has('sttApi')) {
            return \Yii::$app->sttApi;
        }

        return new SttApiComponent();
    }

    /**
     * Рендеринг ответа API в формате сообщения чата.
     *
     * @param array $response Данные ответа.
     * @return string Отрендеренный HTML.
     */
    private function renderResponse(array $response)
    {
    $html = '<svg style="display:none;" ><symbol id="message-tail-filled" viewBox="0 0 11 20" ><path d="M6 17H0V0c.193 2.84.876 5.767 2.05 8.782.904 2.325 2.446 4.485 4.625 6.48A1 1 0 016 17z" /></symbol></svg><div class="chat-container mw-100">';

    foreach ($response as $message) {
        $sourceClass = $message['source'] === 'transmitter' ? 'is-out' : 'is-in';
            $p1 = $message['source'] === 'transmitter' 
            ? 'Диспетчер'
            : 'Заявитель';
        $html .= '<div class="d-flex flex-column align-items-start mb-3">';
        $html .= '<div data-mid="314994" data-timestamp="' . htmlspecialchars((string)$message['start']) . '" class="bubble ' . $sourceClass . ' bubble is-out can-have-tail is-group-first is-group-last bg-white rounded p-2 shadow-sm">';
        $html .= '<div class="position-relative">';
        $html .= '<div class="position-relative">';
        $html .= '<div class="message spoilers-container" dir="auto">';
        $html .= '<h6 class="card-title">'.$p1.'</h6>';
        $html .= '<span>'.htmlspecialchars($message['text']).'</span>';
        $html .= '<span class="time-start d-inline-block text-muted"><span class="i18n" dir="auto">' . htmlspecialchars((string)$message['start']) . '</span>';
        $html .= '<div class="time-inner" title="Сообщение началось ' . htmlspecialchars((string)$message['start']) . '"><span class="i18n" dir="auto">' . htmlspecialchars((string)$message['start']) . '</span></div></span>';
        $html .= '<span class="time-end text-muted"><span class="i18n" dir="auto">' . htmlspecialchars((string)$message['end']) . '</span>';
        $html .= '<div class="time-inner" title="Сообщение закончилось ' . htmlspecialchars((string)$message['end']) . '"><span class="i18n" dir="auto">' . htmlspecialchars((string)$message['end']) . '</span></div></span>';
        $html .= '<span class="score">'.htmlspecialchars($message['score']).'</span></div>';
        $html .= '</div></div>';
        $html .= '<svg viewBox="-11 -4 29 29" class="bubble-tail"><use href="#message-tail-filled"></use></svg></div></div>';
    }

    $html .= '</div>';
    return $html;
    }

    public function init()
    {
        parent::init();
        DialogWidgetAsset::register($this->getView());
    }
}
