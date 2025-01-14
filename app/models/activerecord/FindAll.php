<?php

namespace app\models\activerecord;

use app\interfaces\ActiveRecordExecuteInterface;
use app\interfaces\ActiveRecordInterface;
use app\models\connection\Connection;
use Throwable;

class FindAll implements ActiveRecordExecuteInterface
{
	public function __construct(
		private array $where = [],
		private string|int $limit = '',
		private string|int $offset = '',
		private string $fields = '*',
		private array $joins = []
	) {}

	public function execute(ActiveRecordInterface $activeRecordInterface)
	{
		try {
			$query = $this->createQuery($activeRecordInterface);

			$connection = Connection::connect();

			$prepare = $connection->prepare($query);
			$prepare->execute($this->where);
			return $prepare->fetchAll();
		} catch (Throwable $throw) {
			formatException($throw);
		}
	}

	private function createQuery(ActiveRecordInterface $activeRecordInterface)
	{
		$where = array_keys($this->where);

		$sql = "SELECT {$this->fields} FROM {$activeRecordInterface->getTable()}";

		$sql .= (!$this->where) ? '' : " WHERE {$where[0]} = :{$where[0]}";
		$sql .= (!$this->limit) ? '' : " LIMIT {$this->limit}";
		$sql .= ($this->offset != '') ? " OFFSET {$this->offset}" : '';

		return $sql;
	}
}
