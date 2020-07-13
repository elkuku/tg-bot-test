<?php

namespace App\BotCommand;

use BoShurik\TelegramBotBundle\Telegram\Command\AbstractCommand;
use BoShurik\TelegramBotBundle\Telegram\Command\PublicCommandInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Exception;
use TelegramBot\Api\InvalidArgumentException;
use TelegramBot\Api\Types\Update;
use UnexpectedValueException;

class Start extends AbstractCommand implements PublicCommandInterface
{
    private EntityManagerInterface $entityManager;
    private TranslatorInterface $translator;

    public function __construct(
        EntityManagerInterface $entityManager,
        TranslatorInterface $translator
    ) {
        $this->entityManager = $entityManager;
        $this->translator = $translator;
    }

    public function getName(): string
    {
        return '/start';
    }

    public function getDescription(): string
    {
        return 'Start command';
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function execute(BotApi $api, Update $update): void
    {
        try {
            $message = $update->getMessage();
            if (!$message) {
                throw new UnexpectedValueException('Missing message');
            }

            $tgUser = $message->getFrom();
            if (!$tgUser) {
                throw new UnexpectedValueException('Missing user');
            }

            $response = 'Hello '.$tgUser->getUsername();

        } catch (UnexpectedValueException $exception) {
            $response = $exception->getMessage();
        }

        $api->sendMessage(
            $update->getMessage()->getChat()->getId(),
            $response,
            'markdown'
        );
    }
}
