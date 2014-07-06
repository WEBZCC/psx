<?php
/*
 * psx
 * A object oriented and modular based PHP framework for developing
 * dynamic web applications. For the current version and informations
 * visit <http://phpsx.org>
 *
 * Copyright (c) 2010-2014 Christoph Kappestein <k42b3.x@gmail.com>
 *
 * This file is part of psx. psx is free software: you can
 * redistribute it and/or modify it under the terms of the
 * GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or any later version.
 *
 * psx is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with psx. If not, see <http://www.gnu.org/licenses/>.
 */

namespace PSX\Controller\Foo\Application;

use PSX\Data\Record;
use PSX\Data\RecordAbstract;
use PSX\Controller\ApiAbstract;
use PSX\Sql;

/**
 * TestApiController
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.gnu.org/licenses/gpl.html GPLv3
 * @link    http://phpsx.org
 */
class TestApiController extends ApiAbstract
{
	/**
	 * @Inject
	 * @var PHPUnit_Framework_TestCase
	 */
	protected $testCase;

	public function doIndex()
	{
		$record = new Record('foo', array('bar' => 'foo'));

		$this->setResponse($record);
	}

	public function doInsert()
	{
		$record = new NewsRecord();
		$record = $this->import($record);

		$this->setResponse($record);
	}

	public function doInspect()
	{
		$params = $this->getRequestParams();

		$this->testCase->assertEquals(array('foo', 'bar'), $params['fields']);
		$this->testCase->assertEquals('2014-01-26', $params['updatedSince']->format('Y-m-d'));
		$this->testCase->assertEquals(8, $params['count']);
		$this->testCase->assertEquals('id', $params['filterBy']);
		$this->testCase->assertEquals('equals', $params['filterOp']);
		$this->testCase->assertEquals('12', $params['filterValue']);
		$this->testCase->assertEquals('id', $params['sortBy']);
		$this->testCase->assertEquals(Sql::SORT_DESC, $params['sortOrder']);
		$this->testCase->assertEquals(4, $params['startIndex']);

		$condition = $this->getRequestCondition();

		$this->testCase->assertEquals(array(array('id', '=', '12', 'AND', 1), array('date', '>', '2014-01-26 00:00:00', 'AND', 1)), $condition->toArray());

		// get preferred writer
		$writer = $this->getPreferredWriter();

		$this->testCase->assertInstanceOf('PSX\Data\Writer\Json', $writer);
		$this->testCase->assertTrue($this->isWriter('PSX\Data\Writer\Json'));
	}
}

class NewsRecord extends RecordAbstract
{
	protected $title;
	protected $user;

	/**
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}
	
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param string $user
	 */
	public function setUser($user)
	{
		$this->user = $user;
	}
	
	public function getUser()
	{
		return $this->user;
	}
}
