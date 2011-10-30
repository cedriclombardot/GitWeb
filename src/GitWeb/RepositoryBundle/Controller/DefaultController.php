<?php

namespace GitWeb\RepositoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use GitWeb\RepositoryBundle\Model\RepositoryQuery;

class DefaultController extends Controller
{
    /**
     * List the user Bundles on the home
     *
     * @Template()
     */
    public function listAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $repositories = $user->getRepositorys();

        return array(
            'name' => $user->getUsernameCanonical(),
            'repositories' => $repositories
        );
    }

    /**
     * Show the repository
     *
     * @Route("/{username}/{repository_name}")
     * @Route("/{username}/{repository_name}/tree/{tree}", name="gitweb_repository_default_show_tree")
     *
     * @Template()
     */
    public function showAction($username, $repository_name, $tree = '/')
    {
        return array(
            'repository' => $this->findRepository($username, $repository_name),
            'tree'       => $tree
        );
    }

    /**
     * Show the file content
     *
     * @Route("/{username}/{repository_name}/blob/{file}", name="gitweb_repository_default_show_blob")
     *
     * @Template()
     */
    public function fileAction($username, $repository_name, $file)
    {
        $repository = $this->findRepository($username, $repository_name);

        $tree = implode('|', explode("|", $file, -1));

        return array(
            'repository' => $repository,
            'tree'       => $tree,
            'file'       => $file,
        );
    }

    /**
     * Show the file content
     *
     * @Route("/fork/{username}/{repository_name}", name="gitweb_repository_default_fork")
     */
    public function forkAction($username, $repository_name)
    {
        $repository = $this->findRepository($username, $repository_name);
        $user = $this->get('security.context')->getToken()->getUser();

        // Copy the propel object
        $fork = $repository->copy();
        $fork->setUserId($user->getId());
        $fork->setBarePath('repositories/'.$user->getUsername().'/'.$repository->getName().'.git');
        $fork->setForkedFromId($repository->getId());
        $fork->save();

        //And now fork
        $origin = $this->container->getParameter('kernel.root_dir').DIRECTORY_SEPARATOR;
        exec('cd '.$origin.' && cp -rP "'.$repository->getBarePath().'" "'.$fork->getBarePath().'" ');
        exec('cd '.$origin.' && git clone "'.$fork->getBarePath().'" "'.$fork->getClonePath().'" ');

        return $this->redirect($this->generateUrl('gitweb_repository_default_show', array('username' => $user->getUsername(), 'repository_name' => $fork->getName() )));
    }

    /**
     *
     * @param string $username
     * @param string $repository_name
     *
     * @return Repository
     */
    protected function findRepository($username, $repository_name)
    {
        //Find the repository with the user
        $repositoy = RepositoryQuery::create()
                        ->filterByName($repository_name)
                        ->useUserQuery()
                            ->filterByUsernameCanonical($username)
                        ->endUse()
                        ->joinWith('User')
                        ->findOne();

        if (!$repositoy) {
            throw $this->createNotFoundException('The repository does not exist');
        }

        return $repositoy;
    }
}
