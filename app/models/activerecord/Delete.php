<?php

namespace app\models\activerecord;

use Throwable;
use app\interfaces\ActiveRecordExecuteInterface;
use app\interfaces\ActiveRecordInterface;
use app\models\connection\Connection;

class Delete implements ActiveRecordExecuteInterface
{
	public function __construct(
		private string $field,
		private string|int $value
	) {}

	public function execute(ActiveRecordInterface $activeRecordInterface)
	{
		try {
			$query = $this->createQuery($activeRecordInterface);

			$connection = Connection::connect();

			$attributes = array_merge($activeRecordInterface->getAttributes(), [
				$this->field => $this->value
			]);

			$prepare = $connection->prepare($query);
			$prepare->execute($attributes);
			
			return $prepare->rowCount();
		} catch (Throwable $throw) {
			formatException($throw);
		}
	}

	private function createQuery(ActiveRecordInterface $activeRecordInterface)
	{
		$sql = "UPDATE {$activeRecordInterface->getTable()} SET ativo = 0 WHERE {$this->field} = :{$this->field}";

		return $sql;
	}
}
