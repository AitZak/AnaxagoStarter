<?php

namespace App\Controller;

use App\Entity\InterestMarks;
use App\Manager\EmailManager;
use App\Repository\InterestMarksRepository;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

class InterestMarksController extends AbstractFOSRestController
{

    private $em;
    private $interestMarksRepository;

    public function __construct(EntityManagerInterface $em, InterestMarksRepository $interestMarksRepository)
    {
        $this->em = $em;
        $this->interestMarksRepository = $interestMarksRepository;
    }

    /**
     * @Rest\View(serializerGroups={"interests"})
     * @Rest\Get("api/interest")
     */
    public function getInterestMarks(Request $request, UserRepository $userRepository)
    {

        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);


        $user = $userRepository->findOneBy(['apiKey' => $request->headers->get('x-auth-token')]);

        $interestMarks = $this->interestMarksRepository->findBy(['user'=> $user]);
        $json = $serializer->normalize($interestMarks,'json', ['groups' => ['interests']]);

        $view = $this->view($json, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @Rest\View(serializerGroups={"interests"})
     * @Rest\Post("api/interest")
     * @ParamConverter("interestMarks", converter="fos_rest.request_body")
     * @return \FOS\RestBundle\View\View
     */
    public function postInterestMarks(InterestMarks $interestMarks, Request $request, ProjectRepository $projectRepository, UserRepository $userRepository, EmailManager $emailManager)
    {
        $user = $userRepository->findOneBy(['apiKey' => $request->headers->get('x-auth-token')]);
        $project = $projectRepository->findOneBy(['slug' => $interestMarks->getProject()->getSlug()]);

        if(is_null($project)) {
            throw new NotFoundHttpException('this project does not exist');
        }

        $interestMarks->setUser($user);
        $interestMarks->setProject($project);

        $this->em->persist($interestMarks);
        $this->em->flush();

        $newFunding = $project->getFunding() + $interestMarks->getAmountInvested();

        if ($newFunding >= $project->getTriggeringTreshold() && $project->getFunding() < $project->getTriggeringTreshold()) {
            $project->setStatus('financé');
            $emailManager->sendMailProjectFunded($project);
        }

        $project->setFunding($newFunding);

        $this->em->persist($project);
        $this->em->flush();


        return $this->view($interestMarks);
    }
}
