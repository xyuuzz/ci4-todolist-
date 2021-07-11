<?php

namespace App\Controllers;

use App\Models\{ToDoList, User};
use App\Controllers\BaseController;

class AuthControllers extends BaseController
{
	public $user, $todolist;

	public function __construct()
	{
		$this->user = new User();
		$this->todolist = new ToDoList();
	}

	// method for test table relatioship
	public function relation()
	{
		dd($this->user->toDoList(2)->getResultObject());
	}

	public function login()
	{
		$title = "Login";
		return view("auth/login", compact("title"));
	}

	public function Clogin()
	{
		dd($this->request->getVar("email"));
	}

	public function register()
	{
		$title = "Register Page";
		return view("auth/register", compact("title"));
	}

	public function Cregister()
	{
		dd($this->request->getVar("email"));
	}
}
