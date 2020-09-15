<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ProjectController extends AbstractFOSRestController
{
    private $em;
    private $projectRepository;

    public function __construct(EntityManagerInterface $em, ProjectRepository $projectRepository)
    {
        $this->em = $em;
        $this->projectRepository = $projectRepository;
    }

    /**
     * @Rest\View(serializerGroups={"projects"})
     * @Rest\Get("/api/anonymous/projects")
     */
    public function getProjects()
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);

        $projects = $this->projectRepository->findAll();
        $json = $serializer->normalize($projects,'json', ['groups' => ['projects']]);
        $view = $this->view($json, Response::HTTP_OK);

        return $this->handleView($view);
    }
}
