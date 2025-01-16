<?php 
namespace  kirshet\yii2-dialog-widget\DialogWidget; 

use yii\base\Widget;
use kirshet\yii2-dialog-widget\DialogWidget\assets\DialogWidgetAsset;

class DialogWidget extends Widget
{
    public $callid;
    public $callurl;

    public function run()
    {
        if (!$this->callid || !$this->callurl) {
            return '<p>Недостаточно данных для запроса.</p>';
        }

        $response = \Yii::$app->sttApi->sendRequest($this->callid, $this->callurl);

        if ($response) {
            return $this->renderResponse($response);
        }

        return '<p>Ошибка при получении данных от STT API.</p>';
    }

    /**
     * Рендеринг ответа API в формате сообщения чата.
     *
     * @param array $response Данные ответа.
     * @return string Отрендеренный HTML.
     */
    private function renderResponse(array $response)
    {
    $html = '<div class="chat-container mw-100">';

    foreach ($response as $message) {
        $sourceClass = $message['source'] === 'transmitter' ? 'is-out' : 'is-in';
        $peerStyle = $message['source'] === 'receiver' 
            ? 'style="--peer-color-rgb: var(--peer-2-color-rgb); --peer-border-background: var(--peer-2-border-background);"'
            : '';
            $p1 = $message['source'] === 'transmitter' 
            ? 'Диспетчер'
            : 'Заявитель';
        $html .= '<div class="d-flex flex-column align-items-start mb-3">';
        $html .= '<div data-mid="314994" data-timestamp="' . htmlspecialchars((string)$message['start']) . '" class="bubble ' . $sourceClass . ' bubble is-out can-have-tail is-group-first is-group-last bg-white border rounded p-2 shadow-sm" ' . $peerStyle . '>';
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
        $html .= '<svg viewBox="0 0 11 20" width="11" height="20" class="bubble-tail"><use href="#message-tail-filled"></use></svg>';
        $html .= '</div></div></div></div>';
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
