<?php

namespace GitWeb\PullRequestBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'pull_request' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.media/OS/gitweb/src/GitWeb/PullRequestBundle/Model.map
 */
class PullRequestTableMap extends TableMap
{

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'media/OS/gitweb/src/GitWeb/PullRequestBundle/Model.map.PullRequestTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
		// attributes
		$this->setName('pull_request');
		$this->setPhpName('PullRequest');
		$this->setClassname('GitWeb\\PullRequestBundle\\Model\\PullRequest');
		$this->setPackage('media/OS/gitweb/src/GitWeb/PullRequestBundle/Model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'user', 'ID', true, null, null);
		$this->addColumn('TITLE', 'Title', 'VARCHAR', true, 255, null);
		$this->getColumn('TITLE', false)->setPrimaryString(true);
		$this->addColumn('DESCRIPTION', 'Description', 'LONGVARCHAR', false, null, null);
		$this->addForeignKey('REPOSITORY_SRC_ID', 'RepositorySrcId', 'INTEGER', 'repository', 'ID', true, null, null);
		$this->addColumn('REPOSITORY_SRC_BRANCH', 'RepositorySrcBranch', 'VARCHAR', true, 255, null);
		$this->addForeignKey('REPOSITORY_TARGET_ID', 'RepositoryTargetId', 'INTEGER', 'repository', 'ID', true, null, null);
		$this->addColumn('REPOSITORY_TARGET_BRANCH', 'RepositoryTargetBranch', 'VARCHAR', true, 255, null);
		$this->addColumn('START_REV', 'StartRev', 'VARCHAR', true, 255, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
		$this->addRelation('User', 'FOS\\UserBundle\\Propel\\User', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), 'CASCADE', 'CASCADE');
		$this->addRelation('RepositoryRelatedByRepositorySrcId', 'GitWeb\\RepositoryBundle\\Model\\Repository', RelationMap::MANY_TO_ONE, array('repository_src_id' => 'id', ), 'CASCADE', 'CASCADE');
		$this->addRelation('RepositoryRelatedByRepositoryTargetId', 'GitWeb\\RepositoryBundle\\Model\\Repository', RelationMap::MANY_TO_ONE, array('repository_target_id' => 'id', ), 'CASCADE', 'CASCADE');
	} // buildRelations()

	/**
	 *
	 * Gets the list of behaviors registered for this table
	 *
	 * @return array Associative array (name => parameters) of behaviors
	 */
	public function getBehaviors()
	{
		return array(
			'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', ),
		);
	} // getBehaviors()

} // PullRequestTableMap
