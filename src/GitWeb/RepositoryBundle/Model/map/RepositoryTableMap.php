<?php

namespace GitWeb\RepositoryBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'repository' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.media/OS/gitweb/src/GitWeb/RepositoryBundle/Model.map
 */
class RepositoryTableMap extends TableMap
{

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'media/OS/gitweb/src/GitWeb/RepositoryBundle/Model.map.RepositoryTableMap';

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
		$this->setName('repository');
		$this->setPhpName('Repository');
		$this->setClassname('GitWeb\\RepositoryBundle\\Model\\Repository');
		$this->setPackage('media/OS/gitweb/src/GitWeb/RepositoryBundle/Model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'user', 'ID', true, null, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', true, 255, null);
		$this->getColumn('NAME', false)->setPrimaryString(true);
		$this->addColumn('DESCRIPTION', 'Description', 'VARCHAR', false, 555, null);
		$this->addColumn('BARE_PATH', 'BarePath', 'LONGVARCHAR', false, null, null);
		$this->addColumn('CLONE_PATH', 'ClonePath', 'LONGVARCHAR', false, null, null);
		$this->addForeignKey('FORKED_FROM_ID', 'ForkedFromId', 'INTEGER', 'repository', 'ID', false, null, null);
		$this->addColumn('FORKED_AT', 'ForkedAt', 'VARCHAR', false, 555, null);
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
		$this->addRelation('RepositoryRelatedByForkedFromId', 'GitWeb\\RepositoryBundle\\Model\\Repository', RelationMap::MANY_TO_ONE, array('forked_from_id' => 'id', ), 'SET NULL', 'CASCADE');
		$this->addRelation('PullRequestRelatedByRepositorySrcId', 'GitWeb\\PullRequestBundle\\Model\\PullRequest', RelationMap::ONE_TO_MANY, array('id' => 'repository_src_id', ), 'CASCADE', 'CASCADE', 'PullRequestsRelatedByRepositorySrcId');
		$this->addRelation('PullRequestRelatedByRepositoryTargetId', 'GitWeb\\PullRequestBundle\\Model\\PullRequest', RelationMap::ONE_TO_MANY, array('id' => 'repository_target_id', ), 'CASCADE', 'CASCADE', 'PullRequestsRelatedByRepositoryTargetId');
		$this->addRelation('RepositoryRelatedById', 'GitWeb\\RepositoryBundle\\Model\\Repository', RelationMap::ONE_TO_MANY, array('id' => 'forked_from_id', ), 'SET NULL', 'CASCADE', 'RepositorysRelatedById');
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

} // RepositoryTableMap
