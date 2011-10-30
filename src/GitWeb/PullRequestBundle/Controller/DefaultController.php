<?php

namespace GitWeb\PullRequestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use GitWeb\RepositoryBundle\Model\RepositoryQuery;
use GitWeb\PullRequestBundle\Model\PullRequest;
use GitWeb\PullRequestBundle\Model\PullRequestQuery;

class DefaultController extends Controller
{
	/**
     * @Route("/show/{id}", name="show_pull_request")
     * @Template()
     */
    public function showPullRequestAction($id)
    {
        $pr = PullRequestQuery::create()
                ->innerJoinRepositoryRelatedByRepositoryTargetId()
                ->joinWith('RepositoryRelatedByRepositoryTargetId')
                ->filterById($id)
                ->findOne();

        //Log
        $src = $pr->getRepositoryRelatedByRepositorySrcId();
        $gitFolder = $this->container->getParameter('kernel.root_dir').DIRECTORY_SEPARATOR.$src->getClonePath();

        $head = exec('cd '.$gitFolder.' && /usr/bin/git rev-parse --branches='.$pr->getRepositorySrcBranch().' HEAD');

        exec('cd '.$gitFolder.' && /usr/bin/git log '.$pr->getRepositorySrcBranch().' '.$src->getForkedAt().'..'.$head.' --pretty=format:\'{ "message": "%s", "author_email": "%ae", "author_name": "%an", "hash": "%H", "relative_date": "%ar" }\' ', $commits);
        exec('cd '.$gitFolder.' && /usr/bin/git diff '.$src->getForkedAt().'..'.$head, $diff);
        exec('cd '.$gitFolder.' && /usr/bin/git diff '.$src->getForkedAt().'..'.$head.' | git apply --numstat --summary', $stats);

        //Prepare stats
        $o_stats = array();
        foreach ($stats as $stat) {
            //3 1 README.md
            preg_match('#([0-9]+)(.+)([0-9]+)(.+)#', $stat, $tmp);

            $o_stats[] = array(
                'additions' => $tmp[1],
                'deletions'  => $tmp[3],
                'file'      => trim($tmp[4]),
            );
        }

        //Prépare commits
        array_walk($commits, function(&$commit) { $commit=json_decode($commit); });

        return array(
            'repository'   => $pr->getRepositoryRelatedByRepositoryTargetId(),
            'pull_request' => $pr,
            'commits'      => $commits,
            'stats'        => $o_stats,
            'diff'         => implode("\n", $diff),
        );
    }

    /**
     * @Route("/list/{username}/{repository_name}", name="list_pull_requests")
     * @Template()
     */
    public function listPullRequestsAction($username, $repository_name)
    {
        $repository = $this->findRepository($username, $repository_name);

        return array(
            'repository' => $repository,
        );
    }

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
                                ->innerJoinPullRequestRelatedByRepositoryTargetId()
                                ->joinWith('PullRequestRelatedByRepositoryTargetId')
                                ->findOne();

        if (!$repositoy) {
            throw $this->createNotFoundException('The repository does not exist');
        }

        return $repositoy;
    }
}
