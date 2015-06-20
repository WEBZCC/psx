<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2015 Christoph Kappestein <k42b3.x@gmail.com>
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *     http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace PSX\Data;

use DateTime;
use Serializable;
use JsonSerializable;

/**
 * RecordAbstract
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
abstract class RecordAbstract implements RecordInterface, Serializable, JsonSerializable
{
	public function getRecordInfo()
	{
		$parts  = explode('\\', get_class($this));
		$name   = lcfirst(end($parts));
		$vars   = get_object_vars($this);
		$fields = array();

		foreach($vars as $key => $value)
		{
			if($key[0] != '_')
			{
				$fields[$key] = $value;
			}
		}

		return new RecordInfo($name, $fields);
	}

	public function serialize()
	{
		$vars = get_object_vars($this);
		$data = array();

		foreach($vars as $key => $value)
		{
			if($key[0] != '_')
			{
				$data[$key] = $value;
			}
		}

		return serialize($data);
	}

	public function unserialize($data)
	{
		$data = unserialize($data);

		if(is_array($data))
		{
			foreach($data as $key => $value)
			{
				$this->$key = $value;
			}
		}
	}

	public function jsonSerialize()
	{
		return $this->getRecordInfo()->getData();
	}
}
