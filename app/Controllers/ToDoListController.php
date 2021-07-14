<?php

namespace App\Controllers;

use App\Models\ToDoList;
use App\Controllers\BaseController;

class ToDoListController extends BaseController
{
	public $tdlist;

	public function __construct()
	{
		$this->tdlist = new ToDoList();
	}

	public function index()
	{
		if(!logged_in())
		{
			return redirect()->route("login");
		}

		$title = "Home";
		$user = user()->toArray(); # ambil row user yang sedang login
		
		// dapatkan data dari table todolist dengan user_id yang dikirimkan
		$data = $this->tdlist->where("user_id", user_id())->orderBy("created_at", "DESC")->paginate(3, "tdl");
		$pager = $this->tdlist->pager;

		return view("todolist/index", compact("title", "data", "user", "pager"));
	}

	public function show($slug)
	{
		$user = user()->toArray();
		$title = "Detail Jadwal";
		$tdl = $this->tdlist->getToDoList($slug);

		return view("todolist/show", compact("title", "user", "tdl"));
	}

	public function create()
	{
		$user = user()->toArray();
		$title = "Buat Jadwal Kegiatan";
		return view("todolist/create", compact("title", "user"));
	}

	public function edit($slug)
	{
		$user = user()->toArray();
		$title = "Sunting Jadwal";
		$tdl = $this->tdlist->getToDoList($slug);
		
		$back_to = base_url() . "/show/detail/$slug";

		session()->setFlashData("edit", true);
		return view("todolist/create", compact("title", "tdl", "user", "back_to"));
	}

	public function profile()
	{
		$title = "My Profile";
		$user = user()->toArray();
		
		return view("profiles/index", compact("title", "user"));
	}
}
