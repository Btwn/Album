<?php

namespace Album\Model;

use RuntimeException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class AlbumTable
{
	private $tableGateway;

	public function __construct(TableGatewayInterface $tableGateway){
		$this->tableGateway = $tableGateway;
	}

	public function fetchAll($paginated = false){
		if ($paginated){
			return $this->fetchPaginateResults();
		}
		return $this->tableGateway->select();
	}

	public function fetchPaginateResults(){
		$select = new Select($this->tableGateway->getTable());
		$resultSetPrototype = new ResultSet();
		$resultSetPrototype->setArrayObjectPrototype(new Album());

		$paginatorAdapter = new DbSelect(
			$select,
			$this->tableGateway->getAdapter(),
			$resultSetPrototype
		);
		$paginator = new Paginator ($paginatorAdapter);
		return $paginator;
	}

	public function getAlbum($id){
		$id = (int) $id;
		$rowset = $this->tableGateway->select(['id' => $id]);
		$row = $rowset->current();
		if (! $row){
			throw new RuntimeException(sprintf('Fila no encontrada con el identificador %d', $id));
		}
		return $row;
	}

	public function saveAlbum(Album $album){
		$data = [
			'artist' => $album->artist,
			'title' => $album->title
		];
		$id = (int) $album->id;
		if ($id === 0){
			$this->tableGateway->insert($data);
			return;
		}
		if (! $this->getAlbum($id)){
			throw new RuntimeException(sprintf('No se puede actualizar el album con el identificador $d; no existe' , $id));
		}
		$this->tableGateway->update($data, ['id' => $id]);
	}

	public function deleteAlbum($id){
		$this->tableGateway->delete(['id' => (int) $id]);
	}
}