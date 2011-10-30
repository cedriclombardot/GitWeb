<?php

namespace GitWeb\PullRequestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use GitWeb\RepositoryBundle\Model\RepositoryQuery;
use GitWeb\PullRequestBundle\Model\PullRequest;

class DefaultController extends Controller
{
    /**
     * @Route("/{repository_name}/{branch}")
     * @Template()
     */
    public function indexAction($repository_name, $branch)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $repository = $this->findRepository($user->getUsername(), $repository_name);

        $pr = new PullRequest();
        $pr->setRepositorySrcId($repository->getId());
        $pr->setRepositorySrcBranch($branch);
        $pr->setRepositoryTargetId($repository->getForkedFromId());
        $pr->setRepositoryTargetBranch('master');

        $form = $this->createFormBuilder($pr)
                    ->add('title', 'text')
                    ->add('description', 'textarea')
                    ->add('repository_src_id', 'hidden')
                    ->add('repository_src_branch', 'hidden')
                    ->add('repository_target_id', 'hidden')
                    ->add('repository_target_branch', 'hidden')
                    ->getForm();

        if ($this->get('request')->getMethod() == 'POST') {
            $form->bindRequest($this->get('request'));

            if ($form->isValid()) {
                // perform some action, such as saving the task to the database
                $pr->save();
            }
        }


        return array(
        	'form'            => $form->createView(),
            'repository_name' => $repository_name,
            'branch'          => $branch,
        );
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
