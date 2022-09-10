<?php

namespace App\Services;

use App\Models\Manager;

class TelegramService
{
    public function findManager(array $message): Manager
    {
        $telegramChatId = $message['from']['id'] ?? null;

        return Manager::where('telegram_chat_id', $telegramChatId)->firstOrFail();
    }

    public function storeManagerTelegramId(array $message): ?Manager
    {
        $telegramUsername = $message['from']['username'] ?? null;
        $telegramChatId = $message['from']['id'] ?? null;
        if (! $telegramUsername || ! $telegramChatId) {
            return null;
        }

        if ($manager = Manager::where('telegram_username', $telegramUsername)->first()) {
            $manager->update([
                'telegram_chat_id' => $telegramChatId,
            ]);

            return $manager;
        }

        return null;
    }
}
