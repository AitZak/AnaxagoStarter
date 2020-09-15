<?php


namespace App\Manager;


use App\Entity\Project;
use App\Repository\InterestMarksRepository;
use Psr\Container\ContainerInterface;

class EmailManager
{
    private $mailer;
    private $container;
    private $interestMarksRepository;

    public function __construct(\Swift_Mailer $mailer, ContainerInterface $container, InterestMarksRepository $interestMarksRepository)
    {
        $this->mailer = $mailer;
        $this->container = $container;
        $this->interestMarksRepository = $interestMarksRepository;
    }

    public function sendMailProjectFunded(Project $project)
    {
        $interests= $this->interestMarksRepository->findBy(["project" => $project]);
        foreach ($interests as $interest){
            $message = new  \Swift_Message('Le seuil de déclenchement du projet a été atteint !');
            $message->setTo($interest->getUser()->getEmail())
                ->setFrom('test@test.fr')
                ->setBody(
                    $this->renderView(
                        'emails/project_funded.html.twig',
                        [
                            'firstName' => $interest->getUser()->getFirstName(),
                            'titleProject' => $project->getTitle(),
                        ]
                    ),
                    'text/html'
                );
            $this->mailer->send($message);
        }
    }

    /**
     * Returns a rendered view.
     *
     * @final
     */
    protected function renderView(string $view, array $parameters = []): string
    {
        if ($this->container->has('templating')) {
            @trigger_error('Using the "templating" service is deprecated since version 4.3 and will be removed in 5.0; use Twig instead.', E_USER_DEPRECATED);

            return $this->container->get('templating')->render($view, $parameters);
        }

        if (!$this->container->has('twig')) {
            throw new \LogicException('You can not use the "renderView" method if the Templating Component or the Twig Bundle are not available. Try running "composer require symfony/twig-bundle".');
        }

        return $this->container->get('twig')->render($view, $parameters);
    }
}