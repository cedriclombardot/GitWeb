<?php

namespace GitWeb\RepositoryBundle\Model\om;

use \Criteria;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelPDO;
use FOS\UserBundle\Propel\User;
use GitWeb\PullRequestBundle\Model\PullRequest;
use GitWeb\RepositoryBundle\Model\Repository;
use GitWeb\RepositoryBundle\Model\RepositoryPeer;
use GitWeb\RepositoryBundle\Model\RepositoryQuery;

/**
 * Base class that represents a query for the 'repository' table.
 *
 * 
 *
 * @method     RepositoryQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     RepositoryQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     RepositoryQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     RepositoryQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     RepositoryQuery orderByBarePath($order = Criteria::ASC) Order by the bare_path column
 * @method     RepositoryQuery orderByClonePath($order = Criteria::ASC) Order by the clone_path column
 * @method     RepositoryQuery orderByForkedFromId($order = Criteria::ASC) Order by the forked_from_id column
 * @method     RepositoryQuery orderByForkedAt($order = Criteria::ASC) Order by the forked_at column
 * @method     RepositoryQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     RepositoryQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     RepositoryQuery groupById() Group by the id column
 * @method     RepositoryQuery groupByUserId() Group by the user_id column
 * @method     RepositoryQuery groupByName() Group by the name column
 * @method     RepositoryQuery groupByDescription() Group by the description column
 * @method     RepositoryQuery groupByBarePath() Group by the bare_path column
 * @method     RepositoryQuery groupByClonePath() Group by the clone_path column
 * @method     RepositoryQuery groupByForkedFromId() Group by the forked_from_id column
 * @method     RepositoryQuery groupByForkedAt() Group by the forked_at column
 * @method     RepositoryQuery groupByCreatedAt() Group by the created_at column
 * @method     RepositoryQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     RepositoryQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     RepositoryQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     RepositoryQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     RepositoryQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     RepositoryQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     RepositoryQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     RepositoryQuery leftJoinRepositoryRelatedByForkedFromId($relationAlias = null) Adds a LEFT JOIN clause to the query using the RepositoryRelatedByForkedFromId relation
 * @method     RepositoryQuery rightJoinRepositoryRelatedByForkedFromId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RepositoryRelatedByForkedFromId relation
 * @method     RepositoryQuery innerJoinRepositoryRelatedByForkedFromId($relationAlias = null) Adds a INNER JOIN clause to the query using the RepositoryRelatedByForkedFromId relation
 *
 * @method     RepositoryQuery leftJoinPullRequestRelatedByRepositorySrcId($relationAlias = null) Adds a LEFT JOIN clause to the query using the PullRequestRelatedByRepositorySrcId relation
 * @method     RepositoryQuery rightJoinPullRequestRelatedByRepositorySrcId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PullRequestRelatedByRepositorySrcId relation
 * @method     RepositoryQuery innerJoinPullRequestRelatedByRepositorySrcId($relationAlias = null) Adds a INNER JOIN clause to the query using the PullRequestRelatedByRepositorySrcId relation
 *
 * @method     RepositoryQuery leftJoinPullRequestRelatedByRepositoryTargetId($relationAlias = null) Adds a LEFT JOIN clause to the query using the PullRequestRelatedByRepositoryTargetId relation
 * @method     RepositoryQuery rightJoinPullRequestRelatedByRepositoryTargetId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PullRequestRelatedByRepositoryTargetId relation
 * @method     RepositoryQuery innerJoinPullRequestRelatedByRepositoryTargetId($relationAlias = null) Adds a INNER JOIN clause to the query using the PullRequestRelatedByRepositoryTargetId relation
 *
 * @method     RepositoryQuery leftJoinRepositoryRelatedById($relationAlias = null) Adds a LEFT JOIN clause to the query using the RepositoryRelatedById relation
 * @method     RepositoryQuery rightJoinRepositoryRelatedById($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RepositoryRelatedById relation
 * @method     RepositoryQuery innerJoinRepositoryRelatedById($relationAlias = null) Adds a INNER JOIN clause to the query using the RepositoryRelatedById relation
 *
 * @method     Repository findOne(PropelPDO $con = null) Return the first Repository matching the query
 * @method     Repository findOneOrCreate(PropelPDO $con = null) Return the first Repository matching the query, or a new Repository object populated from the query conditions when no match is found
 *
 * @method     Repository findOneById(int $id) Return the first Repository filtered by the id column
 * @method     Repository findOneByUserId(int $user_id) Return the first Repository filtered by the user_id column
 * @method     Repository findOneByName(string $name) Return the first Repository filtered by the name column
 * @method     Repository findOneByDescription(string $description) Return the first Repository filtered by the description column
 * @method     Repository findOneByBarePath(string $bare_path) Return the first Repository filtered by the bare_path column
 * @method     Repository findOneByClonePath(string $clone_path) Return the first Repository filtered by the clone_path column
 * @method     Repository findOneByForkedFromId(int $forked_from_id) Return the first Repository filtered by the forked_from_id column
 * @method     Repository findOneByForkedAt(string $forked_at) Return the first Repository filtered by the forked_at column
 * @method     Repository findOneByCreatedAt(string $created_at) Return the first Repository filtered by the created_at column
 * @method     Repository findOneByUpdatedAt(string $updated_at) Return the first Repository filtered by the updated_at column
 *
 * @method     array findById(int $id) Return Repository objects filtered by the id column
 * @method     array findByUserId(int $user_id) Return Repository objects filtered by the user_id column
 * @method     array findByName(string $name) Return Repository objects filtered by the name column
 * @method     array findByDescription(string $description) Return Repository objects filtered by the description column
 * @method     array findByBarePath(string $bare_path) Return Repository objects filtered by the bare_path column
 * @method     array findByClonePath(string $clone_path) Return Repository objects filtered by the clone_path column
 * @method     array findByForkedFromId(int $forked_from_id) Return Repository objects filtered by the forked_from_id column
 * @method     array findByForkedAt(string $forked_at) Return Repository objects filtered by the forked_at column
 * @method     array findByCreatedAt(string $created_at) Return Repository objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return Repository objects filtered by the updated_at column
 *
 * @package    propel.generator.media/OS/gitweb/src/GitWeb/RepositoryBundle/Model.om
 */
abstract class BaseRepositoryQuery extends ModelCriteria
{
	
	/**
	 * Initializes internal state of BaseRepositoryQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'default', $modelName = 'GitWeb\\RepositoryBundle\\Model\\Repository', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new RepositoryQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    RepositoryQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof RepositoryQuery) {
			return $criteria;
		}
		$query = new RepositoryQuery();
		if (null !== $modelAlias) {
			$query->setModelAlias($modelAlias);
		}
		if ($criteria instanceof Criteria) {
			$query->mergeWith($criteria);
		}
		return $query;
	}

	/**
	 * Find object by primary key.
	 * Propel uses the instance pool to skip the database if the object exists.
	 * Go fast if the query is untouched.
	 *
	 * <code>
	 * $obj  = $c->findPk(12, $con);
	 * </code>
	 *
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    Repository|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ($key === null) {
			return null;
		}
		if ((null !== ($obj = RepositoryPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
			// the object is alredy in the instance pool
			return $obj;
		}
		if ($con === null) {
			$con = Propel::getConnection(RepositoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
		$this->basePreSelect($con);
		if ($this->formatter || $this->modelAlias || $this->with || $this->select
		 || $this->selectColumns || $this->asColumns || $this->selectModifiers
		 || $this->map || $this->having || $this->joins) {
			return $this->findPkComplex($key, $con);
		} else {
			return $this->findPkSimple($key, $con);
		}
	}

	/**
	 * Find object by primary key using raw SQL to go fast.
	 * Bypass doSelect() and the object formatter by using generated code.
	 *
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con A connection object
	 *
	 * @return    Repository A model object, or null if the key is not found
	 */
	protected function findPkSimple($key, $con)
	{
		$sql = 'SELECT `ID`, `USER_ID`, `NAME`, `DESCRIPTION`, `BARE_PATH`, `CLONE_PATH`, `FORKED_FROM_ID`, `FORKED_AT`, `CREATED_AT`, `UPDATED_AT` FROM `repository` WHERE `ID` = :p0';
		try {
			$stmt = $con->prepare($sql);
			$stmt->bindValue(':p0', $key, PDO::PARAM_INT);
			$stmt->execute();
		} catch (Exception $e) {
			Propel::log($e->getMessage(), Propel::LOG_ERR);
			throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
		}
		$obj = null;
		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$obj = new Repository();
			$obj->hydrate($row);
			RepositoryPeer::addInstanceToPool($obj, (string) $row[0]);
		}
		$stmt->closeCursor();

		return $obj;
	}

	/**
	 * Find object by primary key.
	 *
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con A connection object
	 *
	 * @return    Repository|array|mixed the result, formatted by the current formatter
	 */
	protected function findPkComplex($key, $con)
	{
		// As the query uses a PK condition, no limit(1) is necessary.
		$criteria = $this->isKeepQuery() ? clone $this : $this;
		$stmt = $criteria
			->filterByPrimaryKey($key)
			->doSelect($con);
		return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
	}

	/**
	 * Find objects by primary key
	 * <code>
	 * $objs = $c->findPks(array(12, 56, 832), $con);
	 * </code>
	 * @param     array $keys Primary keys to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    PropelObjectCollection|array|mixed the list of results, formatted by the current formatter
	 */
	public function findPks($keys, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
		}
		$this->basePreSelect($con);
		$criteria = $this->isKeepQuery() ? clone $this : $this;
		$stmt = $criteria
			->filterByPrimaryKeys($keys)
			->doSelect($con);
		return $criteria->getFormatter()->init($criteria)->format($stmt);
	}

	/**
	 * Filter the query by primary key
	 *
	 * @param     mixed $key Primary key to use for the query
	 *
	 * @return    RepositoryQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(RepositoryPeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    RepositoryQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(RepositoryPeer::ID, $keys, Criteria::IN);
	}

	/**
	 * Filter the query on the id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterById(1234); // WHERE id = 1234
	 * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
	 * $query->filterById(array('min' => 12)); // WHERE id > 12
	 * </code>
	 *
	 * @param     mixed $id The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RepositoryQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(RepositoryPeer::ID, $id, $comparison);
	}

	/**
	 * Filter the query on the user_id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByUserId(1234); // WHERE user_id = 1234
	 * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
	 * $query->filterByUserId(array('min' => 12)); // WHERE user_id > 12
	 * </code>
	 *
	 * @see       filterByUser()
	 *
	 * @param     mixed $userId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RepositoryQuery The current query, for fluid interface
	 */
	public function filterByUserId($userId = null, $comparison = null)
	{
		if (is_array($userId)) {
			$useMinMax = false;
			if (isset($userId['min'])) {
				$this->addUsingAlias(RepositoryPeer::USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($userId['max'])) {
				$this->addUsingAlias(RepositoryPeer::USER_ID, $userId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(RepositoryPeer::USER_ID, $userId, $comparison);
	}

	/**
	 * Filter the query on the name column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
	 * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $name The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RepositoryQuery The current query, for fluid interface
	 */
	public function filterByName($name = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($name)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $name)) {
				$name = str_replace('*', '%', $name);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(RepositoryPeer::NAME, $name, $comparison);
	}

	/**
	 * Filter the query on the description column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
	 * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $description The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RepositoryQuery The current query, for fluid interface
	 */
	public function filterByDescription($description = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($description)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $description)) {
				$description = str_replace('*', '%', $description);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(RepositoryPeer::DESCRIPTION, $description, $comparison);
	}

	/**
	 * Filter the query on the bare_path column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByBarePath('fooValue');   // WHERE bare_path = 'fooValue'
	 * $query->filterByBarePath('%fooValue%'); // WHERE bare_path LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $barePath The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RepositoryQuery The current query, for fluid interface
	 */
	public function filterByBarePath($barePath = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($barePath)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $barePath)) {
				$barePath = str_replace('*', '%', $barePath);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(RepositoryPeer::BARE_PATH, $barePath, $comparison);
	}

	/**
	 * Filter the query on the clone_path column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByClonePath('fooValue');   // WHERE clone_path = 'fooValue'
	 * $query->filterByClonePath('%fooValue%'); // WHERE clone_path LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $clonePath The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RepositoryQuery The current query, for fluid interface
	 */
	public function filterByClonePath($clonePath = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($clonePath)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $clonePath)) {
				$clonePath = str_replace('*', '%', $clonePath);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(RepositoryPeer::CLONE_PATH, $clonePath, $comparison);
	}

	/**
	 * Filter the query on the forked_from_id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByForkedFromId(1234); // WHERE forked_from_id = 1234
	 * $query->filterByForkedFromId(array(12, 34)); // WHERE forked_from_id IN (12, 34)
	 * $query->filterByForkedFromId(array('min' => 12)); // WHERE forked_from_id > 12
	 * </code>
	 *
	 * @see       filterByRepositoryRelatedByForkedFromId()
	 *
	 * @param     mixed $forkedFromId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RepositoryQuery The current query, for fluid interface
	 */
	public function filterByForkedFromId($forkedFromId = null, $comparison = null)
	{
		if (is_array($forkedFromId)) {
			$useMinMax = false;
			if (isset($forkedFromId['min'])) {
				$this->addUsingAlias(RepositoryPeer::FORKED_FROM_ID, $forkedFromId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($forkedFromId['max'])) {
				$this->addUsingAlias(RepositoryPeer::FORKED_FROM_ID, $forkedFromId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(RepositoryPeer::FORKED_FROM_ID, $forkedFromId, $comparison);
	}

	/**
	 * Filter the query on the forked_at column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByForkedAt('fooValue');   // WHERE forked_at = 'fooValue'
	 * $query->filterByForkedAt('%fooValue%'); // WHERE forked_at LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $forkedAt The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RepositoryQuery The current query, for fluid interface
	 */
	public function filterByForkedAt($forkedAt = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($forkedAt)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $forkedAt)) {
				$forkedAt = str_replace('*', '%', $forkedAt);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(RepositoryPeer::FORKED_AT, $forkedAt, $comparison);
	}

	/**
	 * Filter the query on the created_at column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
	 * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
	 * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
	 * </code>
	 *
	 * @param     mixed $createdAt The value to use as filter.
	 *              Values can be integers (unix timestamps), DateTime objects, or strings.
	 *              Empty strings are treated as NULL.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RepositoryQuery The current query, for fluid interface
	 */
	public function filterByCreatedAt($createdAt = null, $comparison = null)
	{
		if (is_array($createdAt)) {
			$useMinMax = false;
			if (isset($createdAt['min'])) {
				$this->addUsingAlias(RepositoryPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdAt['max'])) {
				$this->addUsingAlias(RepositoryPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(RepositoryPeer::CREATED_AT, $createdAt, $comparison);
	}

	/**
	 * Filter the query on the updated_at column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
	 * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
	 * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
	 * </code>
	 *
	 * @param     mixed $updatedAt The value to use as filter.
	 *              Values can be integers (unix timestamps), DateTime objects, or strings.
	 *              Empty strings are treated as NULL.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RepositoryQuery The current query, for fluid interface
	 */
	public function filterByUpdatedAt($updatedAt = null, $comparison = null)
	{
		if (is_array($updatedAt)) {
			$useMinMax = false;
			if (isset($updatedAt['min'])) {
				$this->addUsingAlias(RepositoryPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedAt['max'])) {
				$this->addUsingAlias(RepositoryPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(RepositoryPeer::UPDATED_AT, $updatedAt, $comparison);
	}

	/**
	 * Filter the query by a related User object
	 *
	 * @param     User|PropelCollection $user The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RepositoryQuery The current query, for fluid interface
	 */
	public function filterByUser($user, $comparison = null)
	{
		if ($user instanceof User) {
			return $this
				->addUsingAlias(RepositoryPeer::USER_ID, $user->getId(), $comparison);
		} elseif ($user instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(RepositoryPeer::USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByUser() only accepts arguments of type User or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the User relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    RepositoryQuery The current query, for fluid interface
	 */
	public function joinUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('User');

		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}

		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'User');
		}

		return $this;
	}

	/**
	 * Use the User relation User object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    \FOS\UserBundle\Propel\UserQuery A secondary query class using the current class as primary query
	 */
	public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinUser($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'User', '\FOS\UserBundle\Propel\UserQuery');
	}

	/**
	 * Filter the query by a related Repository object
	 *
	 * @param     Repository|PropelCollection $repository The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RepositoryQuery The current query, for fluid interface
	 */
	public function filterByRepositoryRelatedByForkedFromId($repository, $comparison = null)
	{
		if ($repository instanceof Repository) {
			return $this
				->addUsingAlias(RepositoryPeer::FORKED_FROM_ID, $repository->getId(), $comparison);
		} elseif ($repository instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(RepositoryPeer::FORKED_FROM_ID, $repository->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByRepositoryRelatedByForkedFromId() only accepts arguments of type Repository or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the RepositoryRelatedByForkedFromId relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    RepositoryQuery The current query, for fluid interface
	 */
	public function joinRepositoryRelatedByForkedFromId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('RepositoryRelatedByForkedFromId');

		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}

		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'RepositoryRelatedByForkedFromId');
		}

		return $this;
	}

	/**
	 * Use the RepositoryRelatedByForkedFromId relation Repository object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    \GitWeb\RepositoryBundle\Model\RepositoryQuery A secondary query class using the current class as primary query
	 */
	public function useRepositoryRelatedByForkedFromIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinRepositoryRelatedByForkedFromId($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'RepositoryRelatedByForkedFromId', '\GitWeb\RepositoryBundle\Model\RepositoryQuery');
	}

	/**
	 * Filter the query by a related PullRequest object
	 *
	 * @param     PullRequest $pullRequest  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RepositoryQuery The current query, for fluid interface
	 */
	public function filterByPullRequestRelatedByRepositorySrcId($pullRequest, $comparison = null)
	{
		if ($pullRequest instanceof PullRequest) {
			return $this
				->addUsingAlias(RepositoryPeer::ID, $pullRequest->getRepositorySrcId(), $comparison);
		} elseif ($pullRequest instanceof PropelCollection) {
			return $this
				->usePullRequestRelatedByRepositorySrcIdQuery()
				->filterByPrimaryKeys($pullRequest->getPrimaryKeys())
				->endUse();
		} else {
			throw new PropelException('filterByPullRequestRelatedByRepositorySrcId() only accepts arguments of type PullRequest or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the PullRequestRelatedByRepositorySrcId relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    RepositoryQuery The current query, for fluid interface
	 */
	public function joinPullRequestRelatedByRepositorySrcId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('PullRequestRelatedByRepositorySrcId');

		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}

		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'PullRequestRelatedByRepositorySrcId');
		}

		return $this;
	}

	/**
	 * Use the PullRequestRelatedByRepositorySrcId relation PullRequest object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    \GitWeb\PullRequestBundle\Model\PullRequestQuery A secondary query class using the current class as primary query
	 */
	public function usePullRequestRelatedByRepositorySrcIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinPullRequestRelatedByRepositorySrcId($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'PullRequestRelatedByRepositorySrcId', '\GitWeb\PullRequestBundle\Model\PullRequestQuery');
	}

	/**
	 * Filter the query by a related PullRequest object
	 *
	 * @param     PullRequest $pullRequest  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RepositoryQuery The current query, for fluid interface
	 */
	public function filterByPullRequestRelatedByRepositoryTargetId($pullRequest, $comparison = null)
	{
		if ($pullRequest instanceof PullRequest) {
			return $this
				->addUsingAlias(RepositoryPeer::ID, $pullRequest->getRepositoryTargetId(), $comparison);
		} elseif ($pullRequest instanceof PropelCollection) {
			return $this
				->usePullRequestRelatedByRepositoryTargetIdQuery()
				->filterByPrimaryKeys($pullRequest->getPrimaryKeys())
				->endUse();
		} else {
			throw new PropelException('filterByPullRequestRelatedByRepositoryTargetId() only accepts arguments of type PullRequest or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the PullRequestRelatedByRepositoryTargetId relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    RepositoryQuery The current query, for fluid interface
	 */
	public function joinPullRequestRelatedByRepositoryTargetId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('PullRequestRelatedByRepositoryTargetId');

		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}

		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'PullRequestRelatedByRepositoryTargetId');
		}

		return $this;
	}

	/**
	 * Use the PullRequestRelatedByRepositoryTargetId relation PullRequest object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    \GitWeb\PullRequestBundle\Model\PullRequestQuery A secondary query class using the current class as primary query
	 */
	public function usePullRequestRelatedByRepositoryTargetIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinPullRequestRelatedByRepositoryTargetId($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'PullRequestRelatedByRepositoryTargetId', '\GitWeb\PullRequestBundle\Model\PullRequestQuery');
	}

	/**
	 * Filter the query by a related Repository object
	 *
	 * @param     Repository $repository  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RepositoryQuery The current query, for fluid interface
	 */
	public function filterByRepositoryRelatedById($repository, $comparison = null)
	{
		if ($repository instanceof Repository) {
			return $this
				->addUsingAlias(RepositoryPeer::ID, $repository->getForkedFromId(), $comparison);
		} elseif ($repository instanceof PropelCollection) {
			return $this
				->useRepositoryRelatedByIdQuery()
				->filterByPrimaryKeys($repository->getPrimaryKeys())
				->endUse();
		} else {
			throw new PropelException('filterByRepositoryRelatedById() only accepts arguments of type Repository or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the RepositoryRelatedById relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    RepositoryQuery The current query, for fluid interface
	 */
	public function joinRepositoryRelatedById($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('RepositoryRelatedById');

		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}

		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'RepositoryRelatedById');
		}

		return $this;
	}

	/**
	 * Use the RepositoryRelatedById relation Repository object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    \GitWeb\RepositoryBundle\Model\RepositoryQuery A secondary query class using the current class as primary query
	 */
	public function useRepositoryRelatedByIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinRepositoryRelatedById($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'RepositoryRelatedById', '\GitWeb\RepositoryBundle\Model\RepositoryQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     Repository $repository Object to remove from the list of results
	 *
	 * @return    RepositoryQuery The current query, for fluid interface
	 */
	public function prune($repository = null)
	{
		if ($repository) {
			$this->addUsingAlias(RepositoryPeer::ID, $repository->getId(), Criteria::NOT_EQUAL);
		}

		return $this;
	}

	// timestampable behavior
	
	/**
	 * Filter by the latest updated
	 *
	 * @param      int $nbDays Maximum age of the latest update in days
	 *
	 * @return     RepositoryQuery The current query, for fluid interface
	 */
	public function recentlyUpdated($nbDays = 7)
	{
		return $this->addUsingAlias(RepositoryPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Filter by the latest created
	 *
	 * @param      int $nbDays Maximum age of in days
	 *
	 * @return     RepositoryQuery The current query, for fluid interface
	 */
	public function recentlyCreated($nbDays = 7)
	{
		return $this->addUsingAlias(RepositoryPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Order by update date desc
	 *
	 * @return     RepositoryQuery The current query, for fluid interface
	 */
	public function lastUpdatedFirst()
	{
		return $this->addDescendingOrderByColumn(RepositoryPeer::UPDATED_AT);
	}
	
	/**
	 * Order by update date asc
	 *
	 * @return     RepositoryQuery The current query, for fluid interface
	 */
	public function firstUpdatedFirst()
	{
		return $this->addAscendingOrderByColumn(RepositoryPeer::UPDATED_AT);
	}
	
	/**
	 * Order by create date desc
	 *
	 * @return     RepositoryQuery The current query, for fluid interface
	 */
	public function lastCreatedFirst()
	{
		return $this->addDescendingOrderByColumn(RepositoryPeer::CREATED_AT);
	}
	
	/**
	 * Order by create date asc
	 *
	 * @return     RepositoryQuery The current query, for fluid interface
	 */
	public function firstCreatedFirst()
	{
		return $this->addAscendingOrderByColumn(RepositoryPeer::CREATED_AT);
	}

} // BaseRepositoryQuery