<?php

namespace app\models\activerecord;

use ReflectionClass;
use app\interfaces\ActiveRecordExecuteInterface;
use app\interfaces\ActiveRecordInterface;

abstract class ActiveRecord implements ActiveRecordInterface
{
	protected $table = null;
	protected array $attributes = [];

	public function __construct()
	{
		if (!$this->table) {
			$this->table = strtolower((new ReflectionClass($this))->getShortName());
		}
	}

	public function getTable()
	{
		return $this->table;
	}

	public function getAttributes()
	{
		return $this->attributes;
	}

	public function __set($attribute, $value)
	{
		$this->attributes[$attribute] = $value;
	}

	public function __get($attribute)
	{
		return $this->attributes[$attribute];
	}

	public function execute(ActiveRecordExecuteInterface $activeRecordExecuteInterface)
	{
		return $activeRecordExecuteInterface->execute($this);
	}
}
