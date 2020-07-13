<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Exception;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(): Response
    {
        return $this->render('default/index.html.twig');
    }
    /**
     * @Route("/booo", name="booo")
     */
    public function boooindex(BotApi $botApi): Response
    {

        $chatId = -307725225;
        $message = 'hello =;)';

        try {
            $result = $botApi->sendMessage($chatId, $message);
            $text = 'Message has been sent to '.$result->getChat()->getTitle();
            $this->addFlash('success', $text);
        } catch (Exception $e) {
            $this->addFlash('danger', $e->getMessage());
        }

        return $this->redirectToRoute('default');
    }
}
