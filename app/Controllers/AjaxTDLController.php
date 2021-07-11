<?php

namespace App\Controllers;

use App\Models\ToDoList;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\RequestInterface;

class AjaxTDLController extends ResourceController
{
	protected $modelName = 'App\Models\TodoList';
    protected $format    = 'json';
	protected $tdl;

	public function __construct()
	{	
		$this->tdl = new ToDoList();
	}

	public function create()
	{
		$slug = uniqid() . "-" . user()->toArray()["username"];
		
		$banner = $this->request->getFile("banner");
		$banner_name = $banner->getRandomName();

		$data = [
			"user_id" => user_id(),
			"slug" => $slug,
			"banner" => $banner_name,
			"title" => $this->request->getPost("title"),
			"desc" => $this->request->getPost("desc"),
			"due_date" => $this->request->getPost("due_date"),
			"status" => 0
		];

		if($this->tdl->insert($data) === false)
		{
			return $this->respond(["error" => $this->tdl->errors(), "result" => false]);
		}

		// uplade foto 
		$banner->move("banners", $banner_name);
		
		session()->setFlashData("success", "Berhasil menambahkan jadwal");
		return $this->respond(["result" => true]);
	}

	public function updated($slug)
	{
		$tdl = $this->tdl->getToDoList($slug);

		$fields = [
			"id" => $tdl->id,
			"title" => $this->request->getPost("title"),
			"desc" => $this->request->getPost("desc"),
			"due_date" => $this->request->getPost("due_date"),
			"status" => 0
		];

		if($this->request->getFile("banner"))
		{
			$banner = $this->request->getFile("banner");
			$banner_name = $banner->getRandomName();
			$banner->move("banners", $banner_name);
			
			$fields["banner"] = $banner_name;
		}

		$tdl->save($fields);
		
		session()->setFlashData("success", "Berhasil mensuntung data jadwal");
		return $this->respond(["result" => "success"]);
	}

	public function deleted($slug)
	{
		$tdl = $this->tdl->where("slug",$slug)->get()->getFirstRow();
		unlink("banners/{$tdl->banner}");
		$this->tdl->delete($tdl->id);

		session()->setFlashData("success", "Berhasil menghapus jadwal");
		return $this->respond(["result" => "success"]);
	}
}
