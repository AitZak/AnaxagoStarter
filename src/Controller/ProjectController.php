<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

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
        $projects = $this->projectRepository->findAll();

        return $this->view($projects, Response::HTTP_OK);
    }
}
