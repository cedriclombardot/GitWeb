<?php

namespace GitWeb\RepositoryBundle\Model\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \DateTime;
use \DateTimeZone;
use \PDO;
use \Persistent;
use \Propel;
use \PropelCollection;
use \PropelDateTime;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use FOS\UserBundle\Propel\User;
use FOS\UserBundle\Propel\UserQuery;
use GitWeb\PullRequestBundle\Model\PullRequest;
use GitWeb\PullRequestBundle\Model\PullRequestQuery;
use GitWeb\RepositoryBundle\Model\Repository;
use GitWeb\RepositoryBundle\Model\RepositoryPeer;
use GitWeb\RepositoryBundle\Model\RepositoryQuery;

/**
 * Base class that represents a row from the 'repository' table.
 *
 * 
 *
 * @package    propel.generator.media/OS/gitweb/src/GitWeb/RepositoryBundle/Model.om
 */
abstract class BaseRepository extends BaseObject  implements Persistent
{

	/**
	 * Peer class name
	 */
	const PEER = 'GitWeb\\RepositoryBundle\\Model\\RepositoryPeer';

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        RepositoryPeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the user_id field.
	 * @var        int
	 */
	protected $user_id;

	/**
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;

	/**
	 * The value for the description field.
	 * @var        string
	 */
	protected $description;

	/**
	 * The value for the bare_path field.
	 * @var        string
	 */
	protected $bare_path;

	/**
	 * The value for the clone_path field.
	 * @var        string
	 */
	protected $clone_path;

	/**
	 * The value for the forked_from_id field.
	 * @var        int
	 */
	protected $forked_from_id;

	/**
	 * The value for the forked_at field.
	 * @var        string
	 */
	protected $forked_at;

	/**
	 * The value for the created_at field.
	 * @var        string
	 */
	protected $created_at;

	/**
	 * The value for the updated_at field.
	 * @var        string
	 */
	protected $updated_at;

	/**
	 * @var        User
	 */
	protected $aUser;

	/**
	 * @var        Repository
	 */
	protected $aRepositoryRelatedByForkedFromId;

	/**
	 * @var        array PullRequest[] Collection to store aggregation of PullRequest objects.
	 */
	protected $collPullRequestsRelatedByRepositorySrcId;

	/**
	 * @var        array PullRequest[] Collection to store aggregation of PullRequest objects.
	 */
	protected $collPullRequestsRelatedByRepositoryTargetId;

	/**
	 * @var        array Repository[] Collection to store aggregation of Repository objects.
	 */
	protected $collRepositorysRelatedById;

	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInSave = false;

	/**
	 * Flag to prevent endless validation loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInValidation = false;

	/**
	 * An array of objects scheduled for deletion.
	 * @var		array
	 */
	protected $pullRequestsRelatedByRepositorySrcIdScheduledForDeletion = null;

	/**
	 * An array of objects scheduled for deletion.
	 * @var		array
	 */
	protected $pullRequestsRelatedByRepositoryTargetIdScheduledForDeletion = null;

	/**
	 * An array of objects scheduled for deletion.
	 * @var		array
	 */
	protected $repositorysRelatedByIdScheduledForDeletion = null;

	/**
	 * Get the [id] column value.
	 * 
	 * @return     int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Get the [user_id] column value.
	 * 
	 * @return     int
	 */
	public function getUserId()
	{
		return $this->user_id;
	}

	/**
	 * Get the [name] column value.
	 * The repository name
	 * @return     string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Get the [description] column value.
	 * 
	 * @return     string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * Get the [bare_path] column value.
	 * The path to find the repository in server related to app/
	 * @return     string
	 */
	public function getBarePath()
	{
		return $this->bare_path;
	}

	/**
	 * Get the [clone_path] column value.
	 * The path to find the clonned repository in server related to app/
	 * @return     string
	 */
	public function getClonePath()
	{
		return $this->clone_path;
	}

	/**
	 * Get the [forked_from_id] column value.
	 * The original repository
	 * @return     int
	 */
	public function getForkedFromId()
	{
		return $this->forked_from_id;
	}

	/**
	 * Get the [forked_at] column value.
	 * The hash of the last commint on the main repository when you fork
	 * @return     string
	 */
	public function getForkedAt()
	{
		return $this->forked_at;
	}

	/**
	 * Get the [optionally formatted] temporal [created_at] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getCreatedAt($format = NULL)
	{
		if ($this->created_at === null) {
			return null;
		}


		if ($this->created_at === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->created_at);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->created_at, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [optionally formatted] temporal [updated_at] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getUpdatedAt($format = NULL)
	{
		if ($this->updated_at === null) {
			return null;
		}


		if ($this->updated_at === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->updated_at);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->updated_at, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     Repository The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = RepositoryPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [user_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Repository The current object (for fluent API support)
	 */
	public function setUserId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->user_id !== $v) {
			$this->user_id = $v;
			$this->modifiedColumns[] = RepositoryPeer::USER_ID;
		}

		if ($this->aUser !== null && $this->aUser->getId() !== $v) {
			$this->aUser = null;
		}

		return $this;
	} // setUserId()

	/**
	 * Set the value of [name] column.
	 * The repository name
	 * @param      string $v new value
	 * @return     Repository The current object (for fluent API support)
	 */
	public function setName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = RepositoryPeer::NAME;
		}

		return $this;
	} // setName()

	/**
	 * Set the value of [description] column.
	 * 
	 * @param      string $v new value
	 * @return     Repository The current object (for fluent API support)
	 */
	public function setDescription($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->description !== $v) {
			$this->description = $v;
			$this->modifiedColumns[] = RepositoryPeer::DESCRIPTION;
		}

		return $this;
	} // setDescription()

	/**
	 * Set the value of [bare_path] column.
	 * The path to find the repository in server related to app/
	 * @param      string $v new value
	 * @return     Repository The current object (for fluent API support)
	 */
	public function setBarePath($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->bare_path !== $v) {
			$this->bare_path = $v;
			$this->modifiedColumns[] = RepositoryPeer::BARE_PATH;
		}

		return $this;
	} // setBarePath()

	/**
	 * Set the value of [clone_path] column.
	 * The path to find the clonned repository in server related to app/
	 * @param      string $v new value
	 * @return     Repository The current object (for fluent API support)
	 */
	public function setClonePath($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->clone_path !== $v) {
			$this->clone_path = $v;
			$this->modifiedColumns[] = RepositoryPeer::CLONE_PATH;
		}

		return $this;
	} // setClonePath()

	/**
	 * Set the value of [forked_from_id] column.
	 * The original repository
	 * @param      int $v new value
	 * @return     Repository The current object (for fluent API support)
	 */
	public function setForkedFromId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->forked_from_id !== $v) {
			$this->forked_from_id = $v;
			$this->modifiedColumns[] = RepositoryPeer::FORKED_FROM_ID;
		}

		if ($this->aRepositoryRelatedByForkedFromId !== null && $this->aRepositoryRelatedByForkedFromId->getId() !== $v) {
			$this->aRepositoryRelatedByForkedFromId = null;
		}

		return $this;
	} // setForkedFromId()

	/**
	 * Set the value of [forked_at] column.
	 * The hash of the last commint on the main repository when you fork
	 * @param      string $v new value
	 * @return     Repository The current object (for fluent API support)
	 */
	public function setForkedAt($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->forked_at !== $v) {
			$this->forked_at = $v;
			$this->modifiedColumns[] = RepositoryPeer::FORKED_AT;
		}

		return $this;
	} // setForkedAt()

	/**
	 * Sets the value of [created_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.
	 *               Empty strings are treated as NULL.
	 * @return     Repository The current object (for fluent API support)
	 */
	public function setCreatedAt($v)
	{
		$dt = PropelDateTime::newInstance($v, null, 'DateTime');
		if ($this->created_at !== null || $dt !== null) {
			$currentDateAsString = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
			if ($currentDateAsString !== $newDateAsString) {
				$this->created_at = $newDateAsString;
				$this->modifiedColumns[] = RepositoryPeer::CREATED_AT;
			}
		} // if either are not null

		return $this;
	} // setCreatedAt()

	/**
	 * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.
	 *               Empty strings are treated as NULL.
	 * @return     Repository The current object (for fluent API support)
	 */
	public function setUpdatedAt($v)
	{
		$dt = PropelDateTime::newInstance($v, null, 'DateTime');
		if ($this->updated_at !== null || $dt !== null) {
			$currentDateAsString = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
			if ($currentDateAsString !== $newDateAsString) {
				$this->updated_at = $newDateAsString;
				$this->modifiedColumns[] = RepositoryPeer::UPDATED_AT;
			}
		} // if either are not null

		return $this;
	} // setUpdatedAt()

	/**
	 * Indicates whether the columns in this object are only set to default values.
	 *
	 * This method can be used in conjunction with isModified() to indicate whether an object is both
	 * modified _and_ has some values set which are non-default.
	 *
	 * @return     boolean Whether the columns in this object are only been set with default values.
	 */
	public function hasOnlyDefaultValues()
	{
		// otherwise, everything was equal, so return TRUE
		return true;
	} // hasOnlyDefaultValues()

	/**
	 * Hydrates (populates) the object variables with values from the database resultset.
	 *
	 * An offset (0-based "start column") is specified so that objects can be hydrated
	 * with a subset of the columns in the resultset rows.  This is needed, for example,
	 * for results of JOIN queries where the resultset row includes columns from two or
	 * more tables.
	 *
	 * @param      array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
	 * @param      int $startcol 0-based offset column which indicates which restultset column to start with.
	 * @param      boolean $rehydrate Whether this object is being re-hydrated from the database.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->user_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->name = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->description = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->bare_path = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->clone_path = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->forked_from_id = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
			$this->forked_at = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
			$this->created_at = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
			$this->updated_at = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			return $startcol + 10; // 10 = RepositoryPeer::NUM_HYDRATE_COLUMNS.

		} catch (Exception $e) {
			throw new PropelException("Error populating Repository object", $e);
		}
	}

	/**
	 * Checks and repairs the internal consistency of the object.
	 *
	 * This method is executed after an already-instantiated object is re-hydrated
	 * from the database.  It exists to check any foreign keys to make sure that
	 * the objects related to the current object are correct based on foreign key.
	 *
	 * You can override this method in the stub class, but you should always invoke
	 * the base method from the overridden method (i.e. parent::ensureConsistency()),
	 * in case your model changes.
	 *
	 * @throws     PropelException
	 */
	public function ensureConsistency()
	{

		if ($this->aUser !== null && $this->user_id !== $this->aUser->getId()) {
			$this->aUser = null;
		}
		if ($this->aRepositoryRelatedByForkedFromId !== null && $this->forked_from_id !== $this->aRepositoryRelatedByForkedFromId->getId()) {
			$this->aRepositoryRelatedByForkedFromId = null;
		}
	} // ensureConsistency

	/**
	 * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
	 *
	 * This will only work if the object has been saved and has a valid primary key set.
	 *
	 * @param      boolean $deep (optional) Whether to also de-associated any related objects.
	 * @param      PropelPDO $con (optional) The PropelPDO connection to use.
	 * @return     void
	 * @throws     PropelException - if this object is deleted, unsaved or doesn't have pk match in db
	 */
	public function reload($deep = false, PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("Cannot reload a deleted object.");
		}

		if ($this->isNew()) {
			throw new PropelException("Cannot reload an unsaved object.");
		}

		if ($con === null) {
			$con = Propel::getConnection(RepositoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = RepositoryPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aUser = null;
			$this->aRepositoryRelatedByForkedFromId = null;
			$this->collPullRequestsRelatedByRepositorySrcId = null;

			$this->collPullRequestsRelatedByRepositoryTargetId = null;

			$this->collRepositorysRelatedById = null;

		} // if (deep)
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      PropelPDO $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(RepositoryPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$con->beginTransaction();
		try {
			$deleteQuery = RepositoryQuery::create()
				->filterByPrimaryKey($this->getPrimaryKey());
			$ret = $this->preDelete($con);
			if ($ret) {
				$deleteQuery->delete($con);
				$this->postDelete($con);
				$con->commit();
				$this->setDeleted(true);
			} else {
				$con->commit();
			}
		} catch (Exception $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Persists this object to the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All modified related objects will also be persisted in the doSave()
	 * method.  This method wraps all precipitate database operations in a
	 * single transaction.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(RepositoryPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
				// timestampable behavior
				if (!$this->isColumnModified(RepositoryPeer::CREATED_AT)) {
					$this->setCreatedAt(time());
				}
				if (!$this->isColumnModified(RepositoryPeer::UPDATED_AT)) {
					$this->setUpdatedAt(time());
				}
			} else {
				$ret = $ret && $this->preUpdate($con);
				// timestampable behavior
				if ($this->isModified() && !$this->isColumnModified(RepositoryPeer::UPDATED_AT)) {
					$this->setUpdatedAt(time());
				}
			}
			if ($ret) {
				$affectedRows = $this->doSave($con);
				if ($isInsert) {
					$this->postInsert($con);
				} else {
					$this->postUpdate($con);
				}
				$this->postSave($con);
				RepositoryPeer::addInstanceToPool($this);
			} else {
				$affectedRows = 0;
			}
			$con->commit();
			return $affectedRows;
		} catch (Exception $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Performs the work of inserting or updating the row in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave(PropelPDO $con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;

			// We call the save method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aUser !== null) {
				if ($this->aUser->isModified() || $this->aUser->isNew()) {
					$affectedRows += $this->aUser->save($con);
				}
				$this->setUser($this->aUser);
			}

			if ($this->aRepositoryRelatedByForkedFromId !== null) {
				if ($this->aRepositoryRelatedByForkedFromId->isModified() || $this->aRepositoryRelatedByForkedFromId->isNew()) {
					$affectedRows += $this->aRepositoryRelatedByForkedFromId->save($con);
				}
				$this->setRepositoryRelatedByForkedFromId($this->aRepositoryRelatedByForkedFromId);
			}

			if ($this->isNew() || $this->isModified()) {
				// persist changes
				if ($this->isNew()) {
					$this->doInsert($con);
				} else {
					$this->doUpdate($con);
				}
				$affectedRows += 1;
				$this->resetModified();
			}

			if ($this->pullRequestsRelatedByRepositorySrcIdScheduledForDeletion !== null) {
				if (!$this->pullRequestsRelatedByRepositorySrcIdScheduledForDeletion->isEmpty()) {
					PullRequestQuery::create()
						->filterByPrimaryKeys($this->pullRequestsRelatedByRepositorySrcIdScheduledForDeletion->getPrimaryKeys(false))
						->delete($con);
					$this->pullRequestsRelatedByRepositorySrcIdScheduledForDeletion = null;
				}
			}

			if ($this->collPullRequestsRelatedByRepositorySrcId !== null) {
				foreach ($this->collPullRequestsRelatedByRepositorySrcId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->pullRequestsRelatedByRepositoryTargetIdScheduledForDeletion !== null) {
				if (!$this->pullRequestsRelatedByRepositoryTargetIdScheduledForDeletion->isEmpty()) {
					PullRequestQuery::create()
						->filterByPrimaryKeys($this->pullRequestsRelatedByRepositoryTargetIdScheduledForDeletion->getPrimaryKeys(false))
						->delete($con);
					$this->pullRequestsRelatedByRepositoryTargetIdScheduledForDeletion = null;
				}
			}

			if ($this->collPullRequestsRelatedByRepositoryTargetId !== null) {
				foreach ($this->collPullRequestsRelatedByRepositoryTargetId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->repositorysRelatedByIdScheduledForDeletion !== null) {
				if (!$this->repositorysRelatedByIdScheduledForDeletion->isEmpty()) {
					RepositoryQuery::create()
						->filterByPrimaryKeys($this->repositorysRelatedByIdScheduledForDeletion->getPrimaryKeys(false))
						->delete($con);
					$this->repositorysRelatedByIdScheduledForDeletion = null;
				}
			}

			if ($this->collRepositorysRelatedById !== null) {
				foreach ($this->collRepositorysRelatedById as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;

		}
		return $affectedRows;
	} // doSave()

	/**
	 * Insert the row in the database.
	 *
	 * @param      PropelPDO $con
	 *
	 * @throws     PropelException
	 * @see        doSave()
	 */
	protected function doInsert(PropelPDO $con)
	{
		$modifiedColumns = array();
		$index = 0;

		$this->modifiedColumns[] = RepositoryPeer::ID;
		if (null !== $this->id) {
			throw new PropelException('Cannot insert a value for auto-increment primary key (' . RepositoryPeer::ID . ')');
		}

		 // check the columns in natural order for more readable SQL queries
		if ($this->isColumnModified(RepositoryPeer::ID)) {
			$modifiedColumns[':p' . $index++]  = '`ID`';
		}
		if ($this->isColumnModified(RepositoryPeer::USER_ID)) {
			$modifiedColumns[':p' . $index++]  = '`USER_ID`';
		}
		if ($this->isColumnModified(RepositoryPeer::NAME)) {
			$modifiedColumns[':p' . $index++]  = '`NAME`';
		}
		if ($this->isColumnModified(RepositoryPeer::DESCRIPTION)) {
			$modifiedColumns[':p' . $index++]  = '`DESCRIPTION`';
		}
		if ($this->isColumnModified(RepositoryPeer::BARE_PATH)) {
			$modifiedColumns[':p' . $index++]  = '`BARE_PATH`';
		}
		if ($this->isColumnModified(RepositoryPeer::CLONE_PATH)) {
			$modifiedColumns[':p' . $index++]  = '`CLONE_PATH`';
		}
		if ($this->isColumnModified(RepositoryPeer::FORKED_FROM_ID)) {
			$modifiedColumns[':p' . $index++]  = '`FORKED_FROM_ID`';
		}
		if ($this->isColumnModified(RepositoryPeer::FORKED_AT)) {
			$modifiedColumns[':p' . $index++]  = '`FORKED_AT`';
		}
		if ($this->isColumnModified(RepositoryPeer::CREATED_AT)) {
			$modifiedColumns[':p' . $index++]  = '`CREATED_AT`';
		}
		if ($this->isColumnModified(RepositoryPeer::UPDATED_AT)) {
			$modifiedColumns[':p' . $index++]  = '`UPDATED_AT`';
		}

		$sql = sprintf(
			'INSERT INTO `repository` (%s) VALUES (%s)',
			implode(', ', $modifiedColumns),
			implode(', ', array_keys($modifiedColumns))
		);

		try {
			$stmt = $con->prepare($sql);
			foreach ($modifiedColumns as $identifier => $columnName) {
				switch ($columnName) {
					case '`ID`':
						$stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
						break;
					case '`USER_ID`':
						$stmt->bindValue($identifier, $this->user_id, PDO::PARAM_INT);
						break;
					case '`NAME`':
						$stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
						break;
					case '`DESCRIPTION`':
						$stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
						break;
					case '`BARE_PATH`':
						$stmt->bindValue($identifier, $this->bare_path, PDO::PARAM_STR);
						break;
					case '`CLONE_PATH`':
						$stmt->bindValue($identifier, $this->clone_path, PDO::PARAM_STR);
						break;
					case '`FORKED_FROM_ID`':
						$stmt->bindValue($identifier, $this->forked_from_id, PDO::PARAM_INT);
						break;
					case '`FORKED_AT`':
						$stmt->bindValue($identifier, $this->forked_at, PDO::PARAM_STR);
						break;
					case '`CREATED_AT`':
						$stmt->bindValue($identifier, $this->created_at, PDO::PARAM_STR);
						break;
					case '`UPDATED_AT`':
						$stmt->bindValue($identifier, $this->updated_at, PDO::PARAM_STR);
						break;
				}
			}
			$stmt->execute();
		} catch (Exception $e) {
			Propel::log($e->getMessage(), Propel::LOG_ERR);
			throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
		}

		try {
			$pk = $con->lastInsertId();
		} catch (Exception $e) {
			throw new PropelException('Unable to get autoincrement id.', $e);
		}
		$this->setId($pk);

		$this->setNew(false);
	}

	/**
	 * Update the row in the database.
	 *
	 * @param      PropelPDO $con
	 *
	 * @see        doSave()
	 */
	protected function doUpdate(PropelPDO $con)
	{
		$selectCriteria = $this->buildPkeyCriteria();
		$valuesCriteria = $this->buildCriteria();
		BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
	}

	/**
	 * Array of ValidationFailed objects.
	 * @var        array ValidationFailed[]
	 */
	protected $validationFailures = array();

	/**
	 * Gets any ValidationFailed objects that resulted from last call to validate().
	 *
	 *
	 * @return     array ValidationFailed[]
	 * @see        validate()
	 */
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	/**
	 * Validates the objects modified field values and all objects related to this table.
	 *
	 * If $columns is either a column name or an array of column names
	 * only those columns are validated.
	 *
	 * @param      mixed $columns Column name or an array of column names.
	 * @return     boolean Whether all columns pass validation.
	 * @see        doValidate()
	 * @see        getValidationFailures()
	 */
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	/**
	 * This function performs the validation work for complex object models.
	 *
	 * In addition to checking the current object, all related objects will
	 * also be validated.  If all pass then <code>true</code> is returned; otherwise
	 * an aggreagated array of ValidationFailed objects will be returned.
	 *
	 * @param      array $columns Array of column names to validate.
	 * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
	 */
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			// We call the validate method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aUser !== null) {
				if (!$this->aUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aUser->getValidationFailures());
				}
			}

			if ($this->aRepositoryRelatedByForkedFromId !== null) {
				if (!$this->aRepositoryRelatedByForkedFromId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aRepositoryRelatedByForkedFromId->getValidationFailures());
				}
			}


			if (($retval = RepositoryPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collPullRequestsRelatedByRepositorySrcId !== null) {
					foreach ($this->collPullRequestsRelatedByRepositorySrcId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPullRequestsRelatedByRepositoryTargetId !== null) {
					foreach ($this->collPullRequestsRelatedByRepositoryTargetId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collRepositorysRelatedById !== null) {
					foreach ($this->collRepositorysRelatedById as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	/**
	 * Retrieves a field from the object by name passed in as a string.
	 *
	 * @param      string $name name
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = RepositoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	/**
	 * Retrieves a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @return     mixed Value of field at $pos
	 */
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getUserId();
				break;
			case 2:
				return $this->getName();
				break;
			case 3:
				return $this->getDescription();
				break;
			case 4:
				return $this->getBarePath();
				break;
			case 5:
				return $this->getClonePath();
				break;
			case 6:
				return $this->getForkedFromId();
				break;
			case 7:
				return $this->getForkedAt();
				break;
			case 8:
				return $this->getCreatedAt();
				break;
			case 9:
				return $this->getUpdatedAt();
				break;
			default:
				return null;
				break;
		} // switch()
	}

	/**
	 * Exports the object as an array.
	 *
	 * You can specify the key type of the array by passing one of the class
	 * type constants.
	 *
	 * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
	 *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
	 *                    Defaults to BasePeer::TYPE_PHPNAME.
	 * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
	 * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
	 * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
	 *
	 * @return    array an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
	{
		if (isset($alreadyDumpedObjects['Repository'][$this->getPrimaryKey()])) {
			return '*RECURSION*';
		}
		$alreadyDumpedObjects['Repository'][$this->getPrimaryKey()] = true;
		$keys = RepositoryPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getUserId(),
			$keys[2] => $this->getName(),
			$keys[3] => $this->getDescription(),
			$keys[4] => $this->getBarePath(),
			$keys[5] => $this->getClonePath(),
			$keys[6] => $this->getForkedFromId(),
			$keys[7] => $this->getForkedAt(),
			$keys[8] => $this->getCreatedAt(),
			$keys[9] => $this->getUpdatedAt(),
		);
		if ($includeForeignObjects) {
			if (null !== $this->aUser) {
				$result['User'] = $this->aUser->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
			}
			if (null !== $this->aRepositoryRelatedByForkedFromId) {
				$result['RepositoryRelatedByForkedFromId'] = $this->aRepositoryRelatedByForkedFromId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
			}
			if (null !== $this->collPullRequestsRelatedByRepositorySrcId) {
				$result['PullRequestsRelatedByRepositorySrcId'] = $this->collPullRequestsRelatedByRepositorySrcId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collPullRequestsRelatedByRepositoryTargetId) {
				$result['PullRequestsRelatedByRepositoryTargetId'] = $this->collPullRequestsRelatedByRepositoryTargetId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collRepositorysRelatedById) {
				$result['RepositorysRelatedById'] = $this->collRepositorysRelatedById->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
		}
		return $result;
	}

	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name peer name
	 * @param      mixed $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     void
	 */
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = RepositoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	/**
	 * Sets a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @param      mixed $value field value
	 * @return     void
	 */
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setUserId($value);
				break;
			case 2:
				$this->setName($value);
				break;
			case 3:
				$this->setDescription($value);
				break;
			case 4:
				$this->setBarePath($value);
				break;
			case 5:
				$this->setClonePath($value);
				break;
			case 6:
				$this->setForkedFromId($value);
				break;
			case 7:
				$this->setForkedAt($value);
				break;
			case 8:
				$this->setCreatedAt($value);
				break;
			case 9:
				$this->setUpdatedAt($value);
				break;
		} // switch()
	}

	/**
	 * Populates the object using an array.
	 *
	 * This is particularly useful when populating an object from one of the
	 * request arrays (e.g. $_POST).  This method goes through the column
	 * names, checking to see whether a matching key exists in populated
	 * array. If so the setByName() method is called for that column.
	 *
	 * You can specify the key type of the array by additionally passing one
	 * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
	 * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
	 * The default key type is the column's phpname (e.g. 'AuthorId')
	 *
	 * @param      array  $arr     An array to populate the object from.
	 * @param      string $keyType The type of keys the array uses.
	 * @return     void
	 */
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = RepositoryPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUserId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setDescription($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setBarePath($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setClonePath($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setForkedFromId($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setForkedAt($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setCreatedAt($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setUpdatedAt($arr[$keys[9]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(RepositoryPeer::DATABASE_NAME);

		if ($this->isColumnModified(RepositoryPeer::ID)) $criteria->add(RepositoryPeer::ID, $this->id);
		if ($this->isColumnModified(RepositoryPeer::USER_ID)) $criteria->add(RepositoryPeer::USER_ID, $this->user_id);
		if ($this->isColumnModified(RepositoryPeer::NAME)) $criteria->add(RepositoryPeer::NAME, $this->name);
		if ($this->isColumnModified(RepositoryPeer::DESCRIPTION)) $criteria->add(RepositoryPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(RepositoryPeer::BARE_PATH)) $criteria->add(RepositoryPeer::BARE_PATH, $this->bare_path);
		if ($this->isColumnModified(RepositoryPeer::CLONE_PATH)) $criteria->add(RepositoryPeer::CLONE_PATH, $this->clone_path);
		if ($this->isColumnModified(RepositoryPeer::FORKED_FROM_ID)) $criteria->add(RepositoryPeer::FORKED_FROM_ID, $this->forked_from_id);
		if ($this->isColumnModified(RepositoryPeer::FORKED_AT)) $criteria->add(RepositoryPeer::FORKED_AT, $this->forked_at);
		if ($this->isColumnModified(RepositoryPeer::CREATED_AT)) $criteria->add(RepositoryPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(RepositoryPeer::UPDATED_AT)) $criteria->add(RepositoryPeer::UPDATED_AT, $this->updated_at);

		return $criteria;
	}

	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return     Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(RepositoryPeer::DATABASE_NAME);
		$criteria->add(RepositoryPeer::ID, $this->id);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	/**
	 * Generic method to set the primary key (id column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	/**
	 * Returns true if the primary key for this object is null.
	 * @return     boolean
	 */
	public function isPrimaryKeyNull()
	{
		return null === $this->getId();
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of Repository (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
	{
		$copyObj->setUserId($this->getUserId());
		$copyObj->setName($this->getName());
		$copyObj->setDescription($this->getDescription());
		$copyObj->setBarePath($this->getBarePath());
		$copyObj->setClonePath($this->getClonePath());
		$copyObj->setForkedFromId($this->getForkedFromId());
		$copyObj->setForkedAt($this->getForkedAt());
		$copyObj->setCreatedAt($this->getCreatedAt());
		$copyObj->setUpdatedAt($this->getUpdatedAt());

		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getPullRequestsRelatedByRepositorySrcId() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPullRequestRelatedByRepositorySrcId($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getPullRequestsRelatedByRepositoryTargetId() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPullRequestRelatedByRepositoryTargetId($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getRepositorysRelatedById() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addRepositoryRelatedById($relObj->copy($deepCopy));
				}
			}

		} // if ($deepCopy)

		if ($makeNew) {
			$copyObj->setNew(true);
			$copyObj->setId(NULL); // this is a auto-increment column, so set to default value
		}
	}

	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return     Repository Clone of current object.
	 * @throws     PropelException
	 */
	public function copy($deepCopy = false)
	{
		// we use get_class(), because this might be a subclass
		$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	/**
	 * Returns a peer instance associated with this om.
	 *
	 * Since Peer classes are not to have any instance attributes, this method returns the
	 * same instance for all member of this class. The method could therefore
	 * be static, but this would prevent one from overriding the behavior.
	 *
	 * @return     RepositoryPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new RepositoryPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a User object.
	 *
	 * @param      User $v
	 * @return     Repository The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setUser(User $v = null)
	{
		if ($v === null) {
			$this->setUserId(NULL);
		} else {
			$this->setUserId($v->getId());
		}

		$this->aUser = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the User object, it will not be re-added.
		if ($v !== null) {
			$v->addRepository($this);
		}

		return $this;
	}


	/**
	 * Get the associated User object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     User The associated User object.
	 * @throws     PropelException
	 */
	public function getUser(PropelPDO $con = null)
	{
		if ($this->aUser === null && ($this->user_id !== null)) {
			$this->aUser = UserQuery::create()->findPk($this->user_id, $con);
			/* The following can be used additionally to
				guarantee the related object contains a reference
				to this object.  This level of coupling may, however, be
				undesirable since it could result in an only partially populated collection
				in the referenced object.
				$this->aUser->addRepositorys($this);
			 */
		}
		return $this->aUser;
	}

	/**
	 * Declares an association between this object and a Repository object.
	 *
	 * @param      Repository $v
	 * @return     Repository The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setRepositoryRelatedByForkedFromId(Repository $v = null)
	{
		if ($v === null) {
			$this->setForkedFromId(NULL);
		} else {
			$this->setForkedFromId($v->getId());
		}

		$this->aRepositoryRelatedByForkedFromId = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Repository object, it will not be re-added.
		if ($v !== null) {
			$v->addRepositoryRelatedById($this);
		}

		return $this;
	}


	/**
	 * Get the associated Repository object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Repository The associated Repository object.
	 * @throws     PropelException
	 */
	public function getRepositoryRelatedByForkedFromId(PropelPDO $con = null)
	{
		if ($this->aRepositoryRelatedByForkedFromId === null && ($this->forked_from_id !== null)) {
			$this->aRepositoryRelatedByForkedFromId = RepositoryQuery::create()->findPk($this->forked_from_id, $con);
			/* The following can be used additionally to
				guarantee the related object contains a reference
				to this object.  This level of coupling may, however, be
				undesirable since it could result in an only partially populated collection
				in the referenced object.
				$this->aRepositoryRelatedByForkedFromId->addRepositorysRelatedById($this);
			 */
		}
		return $this->aRepositoryRelatedByForkedFromId;
	}


	/**
	 * Initializes a collection based on the name of a relation.
	 * Avoids crafting an 'init[$relationName]s' method name
	 * that wouldn't work when StandardEnglishPluralizer is used.
	 *
	 * @param      string $relationName The name of the relation to initialize
	 * @return     void
	 */
	public function initRelation($relationName)
	{
		if ('PullRequestRelatedByRepositorySrcId' == $relationName) {
			return $this->initPullRequestsRelatedByRepositorySrcId();
		}
		if ('PullRequestRelatedByRepositoryTargetId' == $relationName) {
			return $this->initPullRequestsRelatedByRepositoryTargetId();
		}
		if ('RepositoryRelatedById' == $relationName) {
			return $this->initRepositorysRelatedById();
		}
	}

	/**
	 * Clears out the collPullRequestsRelatedByRepositorySrcId collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPullRequestsRelatedByRepositorySrcId()
	 */
	public function clearPullRequestsRelatedByRepositorySrcId()
	{
		$this->collPullRequestsRelatedByRepositorySrcId = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPullRequestsRelatedByRepositorySrcId collection.
	 *
	 * By default this just sets the collPullRequestsRelatedByRepositorySrcId collection to an empty array (like clearcollPullRequestsRelatedByRepositorySrcId());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initPullRequestsRelatedByRepositorySrcId($overrideExisting = true)
	{
		if (null !== $this->collPullRequestsRelatedByRepositorySrcId && !$overrideExisting) {
			return;
		}
		$this->collPullRequestsRelatedByRepositorySrcId = new PropelObjectCollection();
		$this->collPullRequestsRelatedByRepositorySrcId->setModel('PullRequest');
	}

	/**
	 * Gets an array of PullRequest objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this Repository is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array PullRequest[] List of PullRequest objects
	 * @throws     PropelException
	 */
	public function getPullRequestsRelatedByRepositorySrcId($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collPullRequestsRelatedByRepositorySrcId || null !== $criteria) {
			if ($this->isNew() && null === $this->collPullRequestsRelatedByRepositorySrcId) {
				// return empty collection
				$this->initPullRequestsRelatedByRepositorySrcId();
			} else {
				$collPullRequestsRelatedByRepositorySrcId = PullRequestQuery::create(null, $criteria)
					->filterByRepositoryRelatedByRepositorySrcId($this)
					->find($con);
				if (null !== $criteria) {
					return $collPullRequestsRelatedByRepositorySrcId;
				}
				$this->collPullRequestsRelatedByRepositorySrcId = $collPullRequestsRelatedByRepositorySrcId;
			}
		}
		return $this->collPullRequestsRelatedByRepositorySrcId;
	}

	/**
	 * Sets a collection of PullRequestRelatedByRepositorySrcId objects related by a one-to-many relationship
	 * to the current object.
	 * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
	 * and new objects from the given Propel collection.
	 *
	 * @param      PropelCollection $pullRequestsRelatedByRepositorySrcId A Propel collection.
	 * @param      PropelPDO $con Optional connection object
	 */
	public function setPullRequestsRelatedByRepositorySrcId(PropelCollection $pullRequestsRelatedByRepositorySrcId, PropelPDO $con = null)
	{
		$this->pullRequestsRelatedByRepositorySrcIdScheduledForDeletion = $this->getPullRequestsRelatedByRepositorySrcId(new Criteria(), $con)->diff($pullRequestsRelatedByRepositorySrcId);

		foreach ($pullRequestsRelatedByRepositorySrcId as $pullRequestRelatedByRepositorySrcId) {
			// Fix issue with collection modified by reference
			if ($pullRequestRelatedByRepositorySrcId->isNew()) {
				$pullRequestRelatedByRepositorySrcId->setRepositoryRelatedByRepositorySrcId($this);
			}
			$this->addPullRequestRelatedByRepositorySrcId($pullRequestRelatedByRepositorySrcId);
		}

		$this->collPullRequestsRelatedByRepositorySrcId = $pullRequestsRelatedByRepositorySrcId;
	}

	/**
	 * Returns the number of related PullRequest objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PullRequest objects.
	 * @throws     PropelException
	 */
	public function countPullRequestsRelatedByRepositorySrcId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collPullRequestsRelatedByRepositorySrcId || null !== $criteria) {
			if ($this->isNew() && null === $this->collPullRequestsRelatedByRepositorySrcId) {
				return 0;
			} else {
				$query = PullRequestQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByRepositoryRelatedByRepositorySrcId($this)
					->count($con);
			}
		} else {
			return count($this->collPullRequestsRelatedByRepositorySrcId);
		}
	}

	/**
	 * Method called to associate a PullRequest object to this object
	 * through the PullRequest foreign key attribute.
	 *
	 * @param      PullRequest $l PullRequest
	 * @return     Repository The current object (for fluent API support)
	 */
	public function addPullRequestRelatedByRepositorySrcId(PullRequest $l)
	{
		if ($this->collPullRequestsRelatedByRepositorySrcId === null) {
			$this->initPullRequestsRelatedByRepositorySrcId();
		}
		if (!$this->collPullRequestsRelatedByRepositorySrcId->contains($l)) { // only add it if the **same** object is not already associated
			$this->doAddPullRequestRelatedByRepositorySrcId($l);
		}

		return $this;
	}

	/**
	 * @param	PullRequestRelatedByRepositorySrcId $pullRequestRelatedByRepositorySrcId The pullRequestRelatedByRepositorySrcId object to add.
	 */
	protected function doAddPullRequestRelatedByRepositorySrcId($pullRequestRelatedByRepositorySrcId)
	{
		$this->collPullRequestsRelatedByRepositorySrcId[]= $pullRequestRelatedByRepositorySrcId;
		$pullRequestRelatedByRepositorySrcId->setRepositoryRelatedByRepositorySrcId($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Repository is new, it will return
	 * an empty collection; or if this Repository has previously
	 * been saved, it will retrieve related PullRequestsRelatedByRepositorySrcId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Repository.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array PullRequest[] List of PullRequest objects
	 */
	public function getPullRequestsRelatedByRepositorySrcIdJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = PullRequestQuery::create(null, $criteria);
		$query->joinWith('User', $join_behavior);

		return $this->getPullRequestsRelatedByRepositorySrcId($query, $con);
	}

	/**
	 * Clears out the collPullRequestsRelatedByRepositoryTargetId collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPullRequestsRelatedByRepositoryTargetId()
	 */
	public function clearPullRequestsRelatedByRepositoryTargetId()
	{
		$this->collPullRequestsRelatedByRepositoryTargetId = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPullRequestsRelatedByRepositoryTargetId collection.
	 *
	 * By default this just sets the collPullRequestsRelatedByRepositoryTargetId collection to an empty array (like clearcollPullRequestsRelatedByRepositoryTargetId());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initPullRequestsRelatedByRepositoryTargetId($overrideExisting = true)
	{
		if (null !== $this->collPullRequestsRelatedByRepositoryTargetId && !$overrideExisting) {
			return;
		}
		$this->collPullRequestsRelatedByRepositoryTargetId = new PropelObjectCollection();
		$this->collPullRequestsRelatedByRepositoryTargetId->setModel('PullRequest');
	}

	/**
	 * Gets an array of PullRequest objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this Repository is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array PullRequest[] List of PullRequest objects
	 * @throws     PropelException
	 */
	public function getPullRequestsRelatedByRepositoryTargetId($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collPullRequestsRelatedByRepositoryTargetId || null !== $criteria) {
			if ($this->isNew() && null === $this->collPullRequestsRelatedByRepositoryTargetId) {
				// return empty collection
				$this->initPullRequestsRelatedByRepositoryTargetId();
			} else {
				$collPullRequestsRelatedByRepositoryTargetId = PullRequestQuery::create(null, $criteria)
					->filterByRepositoryRelatedByRepositoryTargetId($this)
					->find($con);
				if (null !== $criteria) {
					return $collPullRequestsRelatedByRepositoryTargetId;
				}
				$this->collPullRequestsRelatedByRepositoryTargetId = $collPullRequestsRelatedByRepositoryTargetId;
			}
		}
		return $this->collPullRequestsRelatedByRepositoryTargetId;
	}

	/**
	 * Sets a collection of PullRequestRelatedByRepositoryTargetId objects related by a one-to-many relationship
	 * to the current object.
	 * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
	 * and new objects from the given Propel collection.
	 *
	 * @param      PropelCollection $pullRequestsRelatedByRepositoryTargetId A Propel collection.
	 * @param      PropelPDO $con Optional connection object
	 */
	public function setPullRequestsRelatedByRepositoryTargetId(PropelCollection $pullRequestsRelatedByRepositoryTargetId, PropelPDO $con = null)
	{
		$this->pullRequestsRelatedByRepositoryTargetIdScheduledForDeletion = $this->getPullRequestsRelatedByRepositoryTargetId(new Criteria(), $con)->diff($pullRequestsRelatedByRepositoryTargetId);

		foreach ($pullRequestsRelatedByRepositoryTargetId as $pullRequestRelatedByRepositoryTargetId) {
			// Fix issue with collection modified by reference
			if ($pullRequestRelatedByRepositoryTargetId->isNew()) {
				$pullRequestRelatedByRepositoryTargetId->setRepositoryRelatedByRepositoryTargetId($this);
			}
			$this->addPullRequestRelatedByRepositoryTargetId($pullRequestRelatedByRepositoryTargetId);
		}

		$this->collPullRequestsRelatedByRepositoryTargetId = $pullRequestsRelatedByRepositoryTargetId;
	}

	/**
	 * Returns the number of related PullRequest objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PullRequest objects.
	 * @throws     PropelException
	 */
	public function countPullRequestsRelatedByRepositoryTargetId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collPullRequestsRelatedByRepositoryTargetId || null !== $criteria) {
			if ($this->isNew() && null === $this->collPullRequestsRelatedByRepositoryTargetId) {
				return 0;
			} else {
				$query = PullRequestQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByRepositoryRelatedByRepositoryTargetId($this)
					->count($con);
			}
		} else {
			return count($this->collPullRequestsRelatedByRepositoryTargetId);
		}
	}

	/**
	 * Method called to associate a PullRequest object to this object
	 * through the PullRequest foreign key attribute.
	 *
	 * @param      PullRequest $l PullRequest
	 * @return     Repository The current object (for fluent API support)
	 */
	public function addPullRequestRelatedByRepositoryTargetId(PullRequest $l)
	{
		if ($this->collPullRequestsRelatedByRepositoryTargetId === null) {
			$this->initPullRequestsRelatedByRepositoryTargetId();
		}
		if (!$this->collPullRequestsRelatedByRepositoryTargetId->contains($l)) { // only add it if the **same** object is not already associated
			$this->doAddPullRequestRelatedByRepositoryTargetId($l);
		}

		return $this;
	}

	/**
	 * @param	PullRequestRelatedByRepositoryTargetId $pullRequestRelatedByRepositoryTargetId The pullRequestRelatedByRepositoryTargetId object to add.
	 */
	protected function doAddPullRequestRelatedByRepositoryTargetId($pullRequestRelatedByRepositoryTargetId)
	{
		$this->collPullRequestsRelatedByRepositoryTargetId[]= $pullRequestRelatedByRepositoryTargetId;
		$pullRequestRelatedByRepositoryTargetId->setRepositoryRelatedByRepositoryTargetId($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Repository is new, it will return
	 * an empty collection; or if this Repository has previously
	 * been saved, it will retrieve related PullRequestsRelatedByRepositoryTargetId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Repository.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array PullRequest[] List of PullRequest objects
	 */
	public function getPullRequestsRelatedByRepositoryTargetIdJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = PullRequestQuery::create(null, $criteria);
		$query->joinWith('User', $join_behavior);

		return $this->getPullRequestsRelatedByRepositoryTargetId($query, $con);
	}

	/**
	 * Clears out the collRepositorysRelatedById collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addRepositorysRelatedById()
	 */
	public function clearRepositorysRelatedById()
	{
		$this->collRepositorysRelatedById = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collRepositorysRelatedById collection.
	 *
	 * By default this just sets the collRepositorysRelatedById collection to an empty array (like clearcollRepositorysRelatedById());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initRepositorysRelatedById($overrideExisting = true)
	{
		if (null !== $this->collRepositorysRelatedById && !$overrideExisting) {
			return;
		}
		$this->collRepositorysRelatedById = new PropelObjectCollection();
		$this->collRepositorysRelatedById->setModel('Repository');
	}

	/**
	 * Gets an array of Repository objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this Repository is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Repository[] List of Repository objects
	 * @throws     PropelException
	 */
	public function getRepositorysRelatedById($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collRepositorysRelatedById || null !== $criteria) {
			if ($this->isNew() && null === $this->collRepositorysRelatedById) {
				// return empty collection
				$this->initRepositorysRelatedById();
			} else {
				$collRepositorysRelatedById = RepositoryQuery::create(null, $criteria)
					->filterByRepositoryRelatedByForkedFromId($this)
					->find($con);
				if (null !== $criteria) {
					return $collRepositorysRelatedById;
				}
				$this->collRepositorysRelatedById = $collRepositorysRelatedById;
			}
		}
		return $this->collRepositorysRelatedById;
	}

	/**
	 * Sets a collection of RepositoryRelatedById objects related by a one-to-many relationship
	 * to the current object.
	 * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
	 * and new objects from the given Propel collection.
	 *
	 * @param      PropelCollection $repositorysRelatedById A Propel collection.
	 * @param      PropelPDO $con Optional connection object
	 */
	public function setRepositorysRelatedById(PropelCollection $repositorysRelatedById, PropelPDO $con = null)
	{
		$this->repositorysRelatedByIdScheduledForDeletion = $this->getRepositorysRelatedById(new Criteria(), $con)->diff($repositorysRelatedById);

		foreach ($repositorysRelatedById as $repositoryRelatedById) {
			// Fix issue with collection modified by reference
			if ($repositoryRelatedById->isNew()) {
				$repositoryRelatedById->setRepositoryRelatedByForkedFromId($this);
			}
			$this->addRepositoryRelatedById($repositoryRelatedById);
		}

		$this->collRepositorysRelatedById = $repositorysRelatedById;
	}

	/**
	 * Returns the number of related Repository objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Repository objects.
	 * @throws     PropelException
	 */
	public function countRepositorysRelatedById(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collRepositorysRelatedById || null !== $criteria) {
			if ($this->isNew() && null === $this->collRepositorysRelatedById) {
				return 0;
			} else {
				$query = RepositoryQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByRepositoryRelatedByForkedFromId($this)
					->count($con);
			}
		} else {
			return count($this->collRepositorysRelatedById);
		}
	}

	/**
	 * Method called to associate a Repository object to this object
	 * through the Repository foreign key attribute.
	 *
	 * @param      Repository $l Repository
	 * @return     Repository The current object (for fluent API support)
	 */
	public function addRepositoryRelatedById(Repository $l)
	{
		if ($this->collRepositorysRelatedById === null) {
			$this->initRepositorysRelatedById();
		}
		if (!$this->collRepositorysRelatedById->contains($l)) { // only add it if the **same** object is not already associated
			$this->doAddRepositoryRelatedById($l);
		}

		return $this;
	}

	/**
	 * @param	RepositoryRelatedById $repositoryRelatedById The repositoryRelatedById object to add.
	 */
	protected function doAddRepositoryRelatedById($repositoryRelatedById)
	{
		$this->collRepositorysRelatedById[]= $repositoryRelatedById;
		$repositoryRelatedById->setRepositoryRelatedByForkedFromId($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Repository is new, it will return
	 * an empty collection; or if this Repository has previously
	 * been saved, it will retrieve related RepositorysRelatedById from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Repository.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Repository[] List of Repository objects
	 */
	public function getRepositorysRelatedByIdJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = RepositoryQuery::create(null, $criteria);
		$query->joinWith('User', $join_behavior);

		return $this->getRepositorysRelatedById($query, $con);
	}

	/**
	 * Clears the current object and sets all attributes to their default values
	 */
	public function clear()
	{
		$this->id = null;
		$this->user_id = null;
		$this->name = null;
		$this->description = null;
		$this->bare_path = null;
		$this->clone_path = null;
		$this->forked_from_id = null;
		$this->forked_at = null;
		$this->created_at = null;
		$this->updated_at = null;
		$this->alreadyInSave = false;
		$this->alreadyInValidation = false;
		$this->clearAllReferences();
		$this->resetModified();
		$this->setNew(true);
		$this->setDeleted(false);
	}

	/**
	 * Resets all references to other model objects or collections of model objects.
	 *
	 * This method is a user-space workaround for PHP's inability to garbage collect
	 * objects with circular references (even in PHP 5.3). This is currently necessary
	 * when using Propel in certain daemon or large-volumne/high-memory operations.
	 *
	 * @param      boolean $deep Whether to also clear the references on all referrer objects.
	 */
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
			if ($this->collPullRequestsRelatedByRepositorySrcId) {
				foreach ($this->collPullRequestsRelatedByRepositorySrcId as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collPullRequestsRelatedByRepositoryTargetId) {
				foreach ($this->collPullRequestsRelatedByRepositoryTargetId as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collRepositorysRelatedById) {
				foreach ($this->collRepositorysRelatedById as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		if ($this->collPullRequestsRelatedByRepositorySrcId instanceof PropelCollection) {
			$this->collPullRequestsRelatedByRepositorySrcId->clearIterator();
		}
		$this->collPullRequestsRelatedByRepositorySrcId = null;
		if ($this->collPullRequestsRelatedByRepositoryTargetId instanceof PropelCollection) {
			$this->collPullRequestsRelatedByRepositoryTargetId->clearIterator();
		}
		$this->collPullRequestsRelatedByRepositoryTargetId = null;
		if ($this->collRepositorysRelatedById instanceof PropelCollection) {
			$this->collRepositorysRelatedById->clearIterator();
		}
		$this->collRepositorysRelatedById = null;
		$this->aUser = null;
		$this->aRepositoryRelatedByForkedFromId = null;
	}

	/**
	 * Return the string representation of this object
	 *
	 * @return string The value of the 'name' column
	 */
	public function __toString()
	{
		return (string) $this->getName();
	}

	// timestampable behavior
	
	/**
	 * Mark the current object so that the update date doesn't get updated during next save
	 *
	 * @return     Repository The current object (for fluent API support)
	 */
	public function keepUpdateDateUnchanged()
	{
		$this->modifiedColumns[] = RepositoryPeer::UPDATED_AT;
		return $this;
	}

} // BaseRepository
