<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use TelegramBot\Api\Types\ReplyKeyboardMarkup; // использование ReplyKeyboardMarkup (основное меню)
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup; // использование InlineKeyboardMarkup (кнопки под сообщением)

use App\Http\Controllers\BaseBotController;

class GetPatientDataController extends BaseBotController
{
    public function processCmd($controller_config_path, $message) 
    {
        $self_config = config($controller_config_path);

        $answer = 'Ваши пациенты';

        $keyboard = $this->generateKeyboard($controller_config_path, $message);

        $this->bot->sendMessage($message->getChat()->getId(), $answer, 'HTML', true, null, $keyboard);

        return;
    }
}
