<?php

namespace GitWeb\RepositoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use GitWeb\RepositoryBundle\Model\Repository;

class ShowController extends Controller
{

    /**
     * Show a file content
     *
     * @Template()
     */
    public function fileAction(Repository $repository, $file)
    {
        $gitBaseFolder = $this->container->getParameter('kernel.root_dir').DIRECTORY_SEPARATOR.$repository->getClonePath();
        $base = $this->convertTreeFromUrl($file);

        $repositoryFs = new \GitFS\Model\Repository($gitBaseFolder);
        $finder = new \GitFS\Util\Finder($repositoryFs);

        list($dir, $file) = explode('/', strstr($base, '/') ? $base : './'.$base, 2);
        $FilesCollection = $finder->in($dir)
                                  ->search();
        $file = $FilesCollection->getFileByPath($file);

        return array(
            'fileContent' => $file->getContent(),
        );
    }

    /**
     * Browse the repository
     *
     * @Template()
     */
    public function browseAction(Repository $repository, $tree = "")
    {
        $gitBaseFolder = $this->container->getParameter('kernel.root_dir').DIRECTORY_SEPARATOR.$repository->getClonePath();
        $gitFolder = $gitBaseFolder.$this->convertTreeFromUrl($tree);
        $base = substr($this->convertTreeFromUrl($tree), 1);

        $logs = $files = $folders = array();

        // Find all files
        $repositoryFs = new \GitFS\Model\Repository($gitBaseFolder);
        $finder = new \GitFS\Util\Finder($repositoryFs);
        $FilesCollection = $finder->in($this->convertTreeFromUrl($tree))
                                  ->search();

        return array(
            'repository'       => $repository,
            'FilesCollection'  => $FilesCollection,
            'tree'             => $tree != "/" ? $tree.'/' : "/",
        );
    }

    protected function convertTreeFromUrl($tree)
    {
        $tree = str_replace('|','/', $tree);
        return $tree[0] == '/' ? substr($tree, 1) : $tree;
    }
}
