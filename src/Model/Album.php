<?php

namespace Album\Model;

class Album
{
	public $id;
	public $artist;
	public $title;

	public function exchangeArray(array $data){
		$this->id = !empty($data['id']) ? $data['id'] : null;
		$this->artistic = !empty($data['artistic']) ? $data['artistic'] : null;
		$this->title = !empty($data['title']) ? $data['title'] : null;
	}
}