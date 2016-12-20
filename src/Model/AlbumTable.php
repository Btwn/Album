<?php

namespace Album\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class AlbumTable
{
	private $tableGateway;

	public function __construct(TableGatewayInterface $tableGateway){
		$this->tableGateway = $tableGateway;
	}

	public function fetchAll(){
		return $this->tableGateway->select();
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
		$this->tableGateway->update($data. ['id' => $id]);
	}

	public function deleteAlbum($id){
		$this->tableGateway->delete(['id' => (int) $id]);
	}
}