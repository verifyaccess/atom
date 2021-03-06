<?php


/**
 * This class defines the structure of the 'taxonomy' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class TaxonomyTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.TaxonomyTableMap';

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
		$this->setName('taxonomy');
		$this->setPhpName('taxonomy');
		$this->setClassname('QubitTaxonomy');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('ID', 'id', 'INTEGER' , 'object', 'ID', true, null, null);
		$this->addColumn('USAGE', 'usage', 'VARCHAR', false, 1024, null);
		$this->addForeignKey('PARENT_ID', 'parentId', 'INTEGER', 'taxonomy', 'ID', false, null, null);
		$this->addColumn('SOURCE_CULTURE', 'sourceCulture', 'VARCHAR', true, 16, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('object', 'object', RelationMap::MANY_TO_ONE, array('id' => 'id', ), 'CASCADE', null);
    $this->addRelation('taxonomyRelatedByparentId', 'taxonomy', RelationMap::MANY_TO_ONE, array('parent_id' => 'id', ), 'CASCADE', null);
    $this->addRelation('taxonomyRelatedByparentId', 'taxonomy', RelationMap::ONE_TO_MANY, array('id' => 'parent_id', ), 'CASCADE', null);
    $this->addRelation('taxonomyI18n', 'taxonomyI18n', RelationMap::ONE_TO_MANY, array('id' => 'id', ), 'CASCADE', null);
    $this->addRelation('term', 'term', RelationMap::ONE_TO_MANY, array('id' => 'taxonomy_id', ), 'CASCADE', null);
	} // buildRelations()

} // TaxonomyTableMap
