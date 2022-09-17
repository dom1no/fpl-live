<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Notifications\TelegramMySquadNotification;
use App\Notifications\TelegramWelcomeNotification;
use App\Services\TelegramService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TelegramController extends Controller
{
    private TelegramService $telegramService;

    public function __construct(TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    public function webhook(Request $request, TelegramService $telegramService): JsonResponse
    {
        $message = $request->message;
        if (! $message || ! isset($message['text'])) {
            return response()->json();
        }

        logs('single')->info('telegram', [$message]);

        $this->handleStartMessage($message);

        $manager = $telegramService->findManager($message);

        $this->handleMySquadMessage($message, $manager);

        return response()->json();
    }

    private function handleStartMessage(array $message): void
    {
        if (! Str::of($message['text'])->is('/start')) {
            return;
        }

        $manager = $this->telegramService->storeManagerTelegramId($message);

        if ($manager) {
            $manager->notify(new TelegramWelcomeNotification());
        }
    }

    private function handleMySquadMessage(array $message, Manager $manager): void
    {
        if (! Str::of($message['text'])->lower()->is(['мой состав', '/mysquad'])) {
            return;
        }

        $manager->notify(new TelegramMySquadNotification());
    }
}
