<?php

namespace GitWeb\PullRequestBundle\Model\om;

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
use GitWeb\PullRequestBundle\Model\PullRequestPeer;
use GitWeb\PullRequestBundle\Model\PullRequestQuery;
use GitWeb\RepositoryBundle\Model\Repository;

/**
 * Base class that represents a query for the 'pull_request' table.
 *
 * 
 *
 * @method     PullRequestQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     PullRequestQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     PullRequestQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     PullRequestQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     PullRequestQuery orderByRepositorySrcId($order = Criteria::ASC) Order by the repository_src_id column
 * @method     PullRequestQuery orderByRepositorySrcBranch($order = Criteria::ASC) Order by the repository_src_branch column
 * @method     PullRequestQuery orderByRepositoryTargetId($order = Criteria::ASC) Order by the repository_target_id column
 * @method     PullRequestQuery orderByRepositoryTargetBranch($order = Criteria::ASC) Order by the repository_target_branch column
 * @method     PullRequestQuery orderByStartRev($order = Criteria::ASC) Order by the start_rev column
 * @method     PullRequestQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     PullRequestQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     PullRequestQuery groupById() Group by the id column
 * @method     PullRequestQuery groupByUserId() Group by the user_id column
 * @method     PullRequestQuery groupByTitle() Group by the title column
 * @method     PullRequestQuery groupByDescription() Group by the description column
 * @method     PullRequestQuery groupByRepositorySrcId() Group by the repository_src_id column
 * @method     PullRequestQuery groupByRepositorySrcBranch() Group by the repository_src_branch column
 * @method     PullRequestQuery groupByRepositoryTargetId() Group by the repository_target_id column
 * @method     PullRequestQuery groupByRepositoryTargetBranch() Group by the repository_target_branch column
 * @method     PullRequestQuery groupByStartRev() Group by the start_rev column
 * @method     PullRequestQuery groupByCreatedAt() Group by the created_at column
 * @method     PullRequestQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     PullRequestQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     PullRequestQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     PullRequestQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     PullRequestQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     PullRequestQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     PullRequestQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     PullRequestQuery leftJoinRepositoryRelatedByRepositorySrcId($relationAlias = null) Adds a LEFT JOIN clause to the query using the RepositoryRelatedByRepositorySrcId relation
 * @method     PullRequestQuery rightJoinRepositoryRelatedByRepositorySrcId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RepositoryRelatedByRepositorySrcId relation
 * @method     PullRequestQuery innerJoinRepositoryRelatedByRepositorySrcId($relationAlias = null) Adds a INNER JOIN clause to the query using the RepositoryRelatedByRepositorySrcId relation
 *
 * @method     PullRequestQuery leftJoinRepositoryRelatedByRepositoryTargetId($relationAlias = null) Adds a LEFT JOIN clause to the query using the RepositoryRelatedByRepositoryTargetId relation
 * @method     PullRequestQuery rightJoinRepositoryRelatedByRepositoryTargetId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RepositoryRelatedByRepositoryTargetId relation
 * @method     PullRequestQuery innerJoinRepositoryRelatedByRepositoryTargetId($relationAlias = null) Adds a INNER JOIN clause to the query using the RepositoryRelatedByRepositoryTargetId relation
 *
 * @method     PullRequest findOne(PropelPDO $con = null) Return the first PullRequest matching the query
 * @method     PullRequest findOneOrCreate(PropelPDO $con = null) Return the first PullRequest matching the query, or a new PullRequest object populated from the query conditions when no match is found
 *
 * @method     PullRequest findOneById(int $id) Return the first PullRequest filtered by the id column
 * @method     PullRequest findOneByUserId(int $user_id) Return the first PullRequest filtered by the user_id column
 * @method     PullRequest findOneByTitle(string $title) Return the first PullRequest filtered by the title column
 * @method     PullRequest findOneByDescription(string $description) Return the first PullRequest filtered by the description column
 * @method     PullRequest findOneByRepositorySrcId(int $repository_src_id) Return the first PullRequest filtered by the repository_src_id column
 * @method     PullRequest findOneByRepositorySrcBranch(string $repository_src_branch) Return the first PullRequest filtered by the repository_src_branch column
 * @method     PullRequest findOneByRepositoryTargetId(int $repository_target_id) Return the first PullRequest filtered by the repository_target_id column
 * @method     PullRequest findOneByRepositoryTargetBranch(string $repository_target_branch) Return the first PullRequest filtered by the repository_target_branch column
 * @method     PullRequest findOneByStartRev(string $start_rev) Return the first PullRequest filtered by the start_rev column
 * @method     PullRequest findOneByCreatedAt(string $created_at) Return the first PullRequest filtered by the created_at column
 * @method     PullRequest findOneByUpdatedAt(string $updated_at) Return the first PullRequest filtered by the updated_at column
 *
 * @method     array findById(int $id) Return PullRequest objects filtered by the id column
 * @method     array findByUserId(int $user_id) Return PullRequest objects filtered by the user_id column
 * @method     array findByTitle(string $title) Return PullRequest objects filtered by the title column
 * @method     array findByDescription(string $description) Return PullRequest objects filtered by the description column
 * @method     array findByRepositorySrcId(int $repository_src_id) Return PullRequest objects filtered by the repository_src_id column
 * @method     array findByRepositorySrcBranch(string $repository_src_branch) Return PullRequest objects filtered by the repository_src_branch column
 * @method     array findByRepositoryTargetId(int $repository_target_id) Return PullRequest objects filtered by the repository_target_id column
 * @method     array findByRepositoryTargetBranch(string $repository_target_branch) Return PullRequest objects filtered by the repository_target_branch column
 * @method     array findByStartRev(string $start_rev) Return PullRequest objects filtered by the start_rev column
 * @method     array findByCreatedAt(string $created_at) Return PullRequest objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return PullRequest objects filtered by the updated_at column
 *
 * @package    propel.generator.media/OS/gitweb/src/GitWeb/PullRequestBundle/Model.om
 */
abstract class BasePullRequestQuery extends ModelCriteria
{
	
	/**
	 * Initializes internal state of BasePullRequestQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'default', $modelName = 'GitWeb\\PullRequestBundle\\Model\\PullRequest', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new PullRequestQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    PullRequestQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof PullRequestQuery) {
			return $criteria;
		}
		$query = new PullRequestQuery();
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
	 * @return    PullRequest|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ($key === null) {
			return null;
		}
		if ((null !== ($obj = PullRequestPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
			// the object is alredy in the instance pool
			return $obj;
		}
		if ($con === null) {
			$con = Propel::getConnection(PullRequestPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
	 * @return    PullRequest A model object, or null if the key is not found
	 */
	protected function findPkSimple($key, $con)
	{
		$sql = 'SELECT `ID`, `USER_ID`, `TITLE`, `DESCRIPTION`, `REPOSITORY_SRC_ID`, `REPOSITORY_SRC_BRANCH`, `REPOSITORY_TARGET_ID`, `REPOSITORY_TARGET_BRANCH`, `START_REV`, `CREATED_AT`, `UPDATED_AT` FROM `pull_request` WHERE `ID` = :p0';
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
			$obj = new PullRequest();
			$obj->hydrate($row);
			PullRequestPeer::addInstanceToPool($obj, (string) $row[0]);
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
	 * @return    PullRequest|array|mixed the result, formatted by the current formatter
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
	 * @return    PullRequestQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(PullRequestPeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    PullRequestQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(PullRequestPeer::ID, $keys, Criteria::IN);
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
	 * @return    PullRequestQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(PullRequestPeer::ID, $id, $comparison);
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
	 * @return    PullRequestQuery The current query, for fluid interface
	 */
	public function filterByUserId($userId = null, $comparison = null)
	{
		if (is_array($userId)) {
			$useMinMax = false;
			if (isset($userId['min'])) {
				$this->addUsingAlias(PullRequestPeer::USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($userId['max'])) {
				$this->addUsingAlias(PullRequestPeer::USER_ID, $userId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(PullRequestPeer::USER_ID, $userId, $comparison);
	}

	/**
	 * Filter the query on the title column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
	 * $query->filterByTitle('%fooValue%'); // WHERE title LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $title The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PullRequestQuery The current query, for fluid interface
	 */
	public function filterByTitle($title = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($title)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $title)) {
				$title = str_replace('*', '%', $title);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(PullRequestPeer::TITLE, $title, $comparison);
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
	 * @return    PullRequestQuery The current query, for fluid interface
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
		return $this->addUsingAlias(PullRequestPeer::DESCRIPTION, $description, $comparison);
	}

	/**
	 * Filter the query on the repository_src_id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByRepositorySrcId(1234); // WHERE repository_src_id = 1234
	 * $query->filterByRepositorySrcId(array(12, 34)); // WHERE repository_src_id IN (12, 34)
	 * $query->filterByRepositorySrcId(array('min' => 12)); // WHERE repository_src_id > 12
	 * </code>
	 *
	 * @see       filterByRepositoryRelatedByRepositorySrcId()
	 *
	 * @param     mixed $repositorySrcId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PullRequestQuery The current query, for fluid interface
	 */
	public function filterByRepositorySrcId($repositorySrcId = null, $comparison = null)
	{
		if (is_array($repositorySrcId)) {
			$useMinMax = false;
			if (isset($repositorySrcId['min'])) {
				$this->addUsingAlias(PullRequestPeer::REPOSITORY_SRC_ID, $repositorySrcId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($repositorySrcId['max'])) {
				$this->addUsingAlias(PullRequestPeer::REPOSITORY_SRC_ID, $repositorySrcId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(PullRequestPeer::REPOSITORY_SRC_ID, $repositorySrcId, $comparison);
	}

	/**
	 * Filter the query on the repository_src_branch column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByRepositorySrcBranch('fooValue');   // WHERE repository_src_branch = 'fooValue'
	 * $query->filterByRepositorySrcBranch('%fooValue%'); // WHERE repository_src_branch LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $repositorySrcBranch The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PullRequestQuery The current query, for fluid interface
	 */
	public function filterByRepositorySrcBranch($repositorySrcBranch = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($repositorySrcBranch)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $repositorySrcBranch)) {
				$repositorySrcBranch = str_replace('*', '%', $repositorySrcBranch);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(PullRequestPeer::REPOSITORY_SRC_BRANCH, $repositorySrcBranch, $comparison);
	}

	/**
	 * Filter the query on the repository_target_id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByRepositoryTargetId(1234); // WHERE repository_target_id = 1234
	 * $query->filterByRepositoryTargetId(array(12, 34)); // WHERE repository_target_id IN (12, 34)
	 * $query->filterByRepositoryTargetId(array('min' => 12)); // WHERE repository_target_id > 12
	 * </code>
	 *
	 * @see       filterByRepositoryRelatedByRepositoryTargetId()
	 *
	 * @param     mixed $repositoryTargetId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PullRequestQuery The current query, for fluid interface
	 */
	public function filterByRepositoryTargetId($repositoryTargetId = null, $comparison = null)
	{
		if (is_array($repositoryTargetId)) {
			$useMinMax = false;
			if (isset($repositoryTargetId['min'])) {
				$this->addUsingAlias(PullRequestPeer::REPOSITORY_TARGET_ID, $repositoryTargetId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($repositoryTargetId['max'])) {
				$this->addUsingAlias(PullRequestPeer::REPOSITORY_TARGET_ID, $repositoryTargetId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(PullRequestPeer::REPOSITORY_TARGET_ID, $repositoryTargetId, $comparison);
	}

	/**
	 * Filter the query on the repository_target_branch column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByRepositoryTargetBranch('fooValue');   // WHERE repository_target_branch = 'fooValue'
	 * $query->filterByRepositoryTargetBranch('%fooValue%'); // WHERE repository_target_branch LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $repositoryTargetBranch The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PullRequestQuery The current query, for fluid interface
	 */
	public function filterByRepositoryTargetBranch($repositoryTargetBranch = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($repositoryTargetBranch)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $repositoryTargetBranch)) {
				$repositoryTargetBranch = str_replace('*', '%', $repositoryTargetBranch);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(PullRequestPeer::REPOSITORY_TARGET_BRANCH, $repositoryTargetBranch, $comparison);
	}

	/**
	 * Filter the query on the start_rev column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByStartRev('fooValue');   // WHERE start_rev = 'fooValue'
	 * $query->filterByStartRev('%fooValue%'); // WHERE start_rev LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $startRev The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PullRequestQuery The current query, for fluid interface
	 */
	public function filterByStartRev($startRev = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($startRev)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $startRev)) {
				$startRev = str_replace('*', '%', $startRev);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(PullRequestPeer::START_REV, $startRev, $comparison);
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
	 * @return    PullRequestQuery The current query, for fluid interface
	 */
	public function filterByCreatedAt($createdAt = null, $comparison = null)
	{
		if (is_array($createdAt)) {
			$useMinMax = false;
			if (isset($createdAt['min'])) {
				$this->addUsingAlias(PullRequestPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdAt['max'])) {
				$this->addUsingAlias(PullRequestPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(PullRequestPeer::CREATED_AT, $createdAt, $comparison);
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
	 * @return    PullRequestQuery The current query, for fluid interface
	 */
	public function filterByUpdatedAt($updatedAt = null, $comparison = null)
	{
		if (is_array($updatedAt)) {
			$useMinMax = false;
			if (isset($updatedAt['min'])) {
				$this->addUsingAlias(PullRequestPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedAt['max'])) {
				$this->addUsingAlias(PullRequestPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(PullRequestPeer::UPDATED_AT, $updatedAt, $comparison);
	}

	/**
	 * Filter the query by a related User object
	 *
	 * @param     User|PropelCollection $user The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PullRequestQuery The current query, for fluid interface
	 */
	public function filterByUser($user, $comparison = null)
	{
		if ($user instanceof User) {
			return $this
				->addUsingAlias(PullRequestPeer::USER_ID, $user->getId(), $comparison);
		} elseif ($user instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(PullRequestPeer::USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
	 * @return    PullRequestQuery The current query, for fluid interface
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
	 * @return    PullRequestQuery The current query, for fluid interface
	 */
	public function filterByRepositoryRelatedByRepositorySrcId($repository, $comparison = null)
	{
		if ($repository instanceof Repository) {
			return $this
				->addUsingAlias(PullRequestPeer::REPOSITORY_SRC_ID, $repository->getId(), $comparison);
		} elseif ($repository instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(PullRequestPeer::REPOSITORY_SRC_ID, $repository->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByRepositoryRelatedByRepositorySrcId() only accepts arguments of type Repository or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the RepositoryRelatedByRepositorySrcId relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    PullRequestQuery The current query, for fluid interface
	 */
	public function joinRepositoryRelatedByRepositorySrcId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('RepositoryRelatedByRepositorySrcId');

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
			$this->addJoinObject($join, 'RepositoryRelatedByRepositorySrcId');
		}

		return $this;
	}

	/**
	 * Use the RepositoryRelatedByRepositorySrcId relation Repository object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    \GitWeb\RepositoryBundle\Model\RepositoryQuery A secondary query class using the current class as primary query
	 */
	public function useRepositoryRelatedByRepositorySrcIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinRepositoryRelatedByRepositorySrcId($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'RepositoryRelatedByRepositorySrcId', '\GitWeb\RepositoryBundle\Model\RepositoryQuery');
	}

	/**
	 * Filter the query by a related Repository object
	 *
	 * @param     Repository|PropelCollection $repository The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PullRequestQuery The current query, for fluid interface
	 */
	public function filterByRepositoryRelatedByRepositoryTargetId($repository, $comparison = null)
	{
		if ($repository instanceof Repository) {
			return $this
				->addUsingAlias(PullRequestPeer::REPOSITORY_TARGET_ID, $repository->getId(), $comparison);
		} elseif ($repository instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(PullRequestPeer::REPOSITORY_TARGET_ID, $repository->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByRepositoryRelatedByRepositoryTargetId() only accepts arguments of type Repository or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the RepositoryRelatedByRepositoryTargetId relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    PullRequestQuery The current query, for fluid interface
	 */
	public function joinRepositoryRelatedByRepositoryTargetId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('RepositoryRelatedByRepositoryTargetId');

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
			$this->addJoinObject($join, 'RepositoryRelatedByRepositoryTargetId');
		}

		return $this;
	}

	/**
	 * Use the RepositoryRelatedByRepositoryTargetId relation Repository object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    \GitWeb\RepositoryBundle\Model\RepositoryQuery A secondary query class using the current class as primary query
	 */
	public function useRepositoryRelatedByRepositoryTargetIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinRepositoryRelatedByRepositoryTargetId($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'RepositoryRelatedByRepositoryTargetId', '\GitWeb\RepositoryBundle\Model\RepositoryQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     PullRequest $pullRequest Object to remove from the list of results
	 *
	 * @return    PullRequestQuery The current query, for fluid interface
	 */
	public function prune($pullRequest = null)
	{
		if ($pullRequest) {
			$this->addUsingAlias(PullRequestPeer::ID, $pullRequest->getId(), Criteria::NOT_EQUAL);
		}

		return $this;
	}

	// timestampable behavior
	
	/**
	 * Filter by the latest updated
	 *
	 * @param      int $nbDays Maximum age of the latest update in days
	 *
	 * @return     PullRequestQuery The current query, for fluid interface
	 */
	public function recentlyUpdated($nbDays = 7)
	{
		return $this->addUsingAlias(PullRequestPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Filter by the latest created
	 *
	 * @param      int $nbDays Maximum age of in days
	 *
	 * @return     PullRequestQuery The current query, for fluid interface
	 */
	public function recentlyCreated($nbDays = 7)
	{
		return $this->addUsingAlias(PullRequestPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Order by update date desc
	 *
	 * @return     PullRequestQuery The current query, for fluid interface
	 */
	public function lastUpdatedFirst()
	{
		return $this->addDescendingOrderByColumn(PullRequestPeer::UPDATED_AT);
	}
	
	/**
	 * Order by update date asc
	 *
	 * @return     PullRequestQuery The current query, for fluid interface
	 */
	public function firstUpdatedFirst()
	{
		return $this->addAscendingOrderByColumn(PullRequestPeer::UPDATED_AT);
	}
	
	/**
	 * Order by create date desc
	 *
	 * @return     PullRequestQuery The current query, for fluid interface
	 */
	public function lastCreatedFirst()
	{
		return $this->addDescendingOrderByColumn(PullRequestPeer::CREATED_AT);
	}
	
	/**
	 * Order by create date asc
	 *
	 * @return     PullRequestQuery The current query, for fluid interface
	 */
	public function firstCreatedFirst()
	{
		return $this->addAscendingOrderByColumn(PullRequestPeer::CREATED_AT);
	}

} // BasePullRequestQuery