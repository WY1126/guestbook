<?php

namespace App\EventSubscriber;

use App\Repository\ConferenceRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Twig\Environment;

class TwigEventSubscriber implements EventSubscriberInterface
{
    private $twig;
    private $conferenceRepository;

    public function __construct(Environment $twig, ConferenceRepository $conferenceRepository)
    {
        $this->twig = $twig;
        $this->conferenceRepository = $conferenceRepository;
    }
    public function onSymfonyComponentHttpKernelEventControllerEvent($event)
    {
        // ...
        $this->twig->addGlobal('conferences',$this->conferenceRepository->findAll());
    }

    public static function getSubscribedEvents()
    {
        return [
            'SymfonyComponentHttpKernelEventControllerEvent' => 'onSymfonyComponentHttpKernelEventControllerEvent',
        ];
    }
}
