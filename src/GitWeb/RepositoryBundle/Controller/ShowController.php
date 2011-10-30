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
        $base = substr($this->convertTreeFromUrl($file), 1);
        exec('cd '.$this->container->getParameter('kernel.root_dir').DIRECTORY_SEPARATOR.$repository->getClonePath().' && /usr/bin/git ls-tree --full-tree master -r '.$base, $ls_tree);

        list($mode, $blob, $hash, $file) = explode(' ', str_replace('	', ' ', $ls_tree[0]));

        exec('cd '.$this->container->getParameter('kernel.root_dir').DIRECTORY_SEPARATOR.$repository->getClonePath().' && /usr/bin/git cat-file -p '.$hash, $fileContent);

        return array(
            'fileContent' => implode("\n",$fileContent),
        );
    }

    /**
     * Browse the repository
     *
     * @Template()
     */
    public function browseAction(Repository $repository, $tree = "")
    {
        $gitFolder = $this->container->getParameter('kernel.root_dir').DIRECTORY_SEPARATOR.$repository->getClonePath().$this->convertTreeFromUrl($tree);
        $base = substr($this->convertTreeFromUrl($tree), 1);

        $logs = $files = $folders = array();

        // Find all files
        exec('cd '.$this->container->getParameter('kernel.root_dir').DIRECTORY_SEPARATOR.$repository->getClonePath().' && /usr/bin/git ls-tree --full-tree master -r '.$base, $ls_tree);

        foreach ($ls_tree as $ltree) {
            //100644 blob 214e4119653f9c6a4c48cd0ebb06a6754f00f62b	web/robots.txt
            list($mode, $blob, $hash, $file) = explode(' ', str_replace('	', ' ', $ltree));
            $file = $base ? str_replace($base.'/','', $file) : $file;

            if (strstr($file, '/')) {
                list($dir, $other) = explode('/', $file, 2);

                if (!isset($folders[$dir])) {
                    $folders[$dir] = $dir;
                    $logs[$dir] = $this->getGitLog($gitFolder, $dir);
                }
            } else {
                $files[$file] = $file;
                $logs[$file] = $this->getGitLog($gitFolder, $file);
            }
        }

        return array(
            'repository' => $repository,
            'files'      => $files,
            'folders'    => $folders,
            'logs'       => $logs,
            'tree'       => $tree != "/" ? $tree.'/' : "/",
        );
    }

    protected function convertTreeFromUrl($tree)
    {
        return str_replace('|','/', $tree);
    }

    //@todo make a service to find log
    /**
     * Option	Description of Output
        %H	Commit hash
        %h	Abbreviated commit hash
        %T	Tree hash
        %t	Abbreviated tree hash
        %P	Parent hashes
        %p	Abbreviated parent hashes
        %an	Author name
        %ae	Author e-mail
        %ad	Author date (format respects the –date= option)
        %ar	Author date, relative
        %cn	Committer name
        %ce	Committer email
        %cd	Committer date
        %cr	Committer date, relative
        %s	Subject
     * @param unknown_type $gitFolder
     * @param unknown_type $file
     */
    protected function getGitLog($gitFolder, $file)
    {
        $output = exec('cd '.$gitFolder.' && /usr/bin/git log master --pretty=format:\'{ "message": "%s", "author_email": "%ae", "author_name": "%an", "hash": "%H", "relative_date": "%ar" }\' -1 '.$file);
        return json_decode($output);
    }
}
