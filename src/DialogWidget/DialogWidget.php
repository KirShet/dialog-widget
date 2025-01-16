<?php 
namespace common\widgets; 

use yii\base\Widget;

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
        $html = '<div class="chat-container">';

        foreach ($response as $message) {
            $sourceClass = $message['source'] === 'transmitter' ? 'is-out' : 'is-in';
            $peerStyle = $message['source'] === 'receiver' 
                ? 'style="--peer-color-rgb: var(--peer-2-color-rgb); --peer-border-background: var(--peer-2-border-background);"'
                : '';
    
            $html .= '<div class="bubbles-group">';
            $html .= '<div data-mid="314994" data-timestamp="' . htmlspecialchars((string)$message['start']) . '" class="bubble ' . $sourceClass . ' can-have-tail is-group-first is-group-last" ' . $peerStyle . '>';
            $html .= '<div class="bubble-content-wrapper">';
            $html .= '<div class="bubble-content hover-reaction-visible">';
            $html .= '<div class="message spoilers-container" dir="auto">';
            $html .= htmlspecialchars($message['text']);
            $html .= '<span class="time-start"><span class="i18n" dir="auto">' . htmlspecialchars((string)$message['start']) . '</span>';
            $html .= '<div class="time-inner" title="Сообщение началось ' . htmlspecialchars((string)$message['start']) . '"><span class="i18n" dir="auto">' . htmlspecialchars((string)$message['start']) . '</span></div></span>';
            $html .= '<span class="time-end"><span class="i18n" dir="auto">' . htmlspecialchars((string)$message['end']) . '</span>';
            $html .= '<div class="time-inner" title="Сообщение закончилось ' . htmlspecialchars((string)$message['end']) . '"><span class="i18n" dir="auto">' . htmlspecialchars((string)$message['end']) . '</span></div></span>';
            $html .= '<span class="clearfix"></span></div>';
            $html .= '<svg viewBox="0 0 11 20" width="11" height="20" class="bubble-tail"><use href="#message-tail-filled"></use></svg>';
            $html .= '</div></div></div></div>';
        }
    
        $html .= '</div>';
        return $html;
    }

    // /**
    //  * Рекурсивный рендеринг вложенных массивов для чата.
    //  *
    //  * @param array $array Вложенный массив.
    //  * @return string Отрендеренный HTML.
    //  */
    // private function renderNestedArray(array $array)
    // {
    //     $html = '<ul>';
    //     foreach ($array as $key => $value) {
    //         $html .= '<li><strong>' . htmlspecialchars((string) $key) . ':</strong> ';
    //         if (is_array($value)) {
    //             $html .= $this->renderNestedArray($value); // Рекурсивный вызов для вложенных массивов
    //         } else {
    //             $html .= htmlspecialchars((string) $value);
    //         }
    //         $html .= '</li>';
    //     }
    //     $html .= '</ul>';

    //     return $html;
    // }

}
