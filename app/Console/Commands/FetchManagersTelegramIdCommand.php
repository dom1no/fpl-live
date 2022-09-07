<?php

namespace App\Console\Commands;

use App\Models\Manager;
use Illuminate\Console\Command;
use NotificationChannels\Telegram\TelegramUpdates;

class FetchManagersTelegramIdCommand extends Command
{
    protected $signature = 'telegram:fetch-managers-id';

    protected $description = 'Fetch managers telegram ids from Telegram Bot updates';

    public function handle(): void
    {
        $managers = Manager::query()
            ->where('telegram_chat_id', Manager::DEFAULT_TELEGRAM_CHAT_ID)
            ->pluck('id', 'telegram_username');
        if ($managers->count() <= 1) {
            return;
        }

        $updates = TelegramUpdates::create()
            ->latest()
            ->limit(20)
            ->get();

        $isOk = $updates['ok'] ?? false;
        if (! $isOk) {
            return;
        }

        foreach ($updates['result'] as $update) {
            $telegramUsername = $update['message']['from']['username'] ?? null;
            $telegramChatId = $update['message']['from']['id'] ?? null;
            if (! $telegramUsername || ! $telegramChatId) {
                continue;
            }

            if ($managers->has($telegramUsername)) {
                $manager = Manager::find($managers->get($telegramUsername));
                $manager->update([
                    'telegram_chat_id' => $telegramChatId,
                ]);
                $managers->forget($telegramUsername);

                $this->info("Store chat id for {$telegramUsername} - {$telegramChatId}");
            }
        }
    }
}
