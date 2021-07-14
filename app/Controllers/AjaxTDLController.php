<?php

namespace App\Controllers;

use Myth\Auth\Password;
use App\Models\ToDoList;
use Myth\Auth\Models\UserModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\RESTful\ResourceController;

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
		if($this->request->getPost("title") === "maulana")
		{
			return $this->respond(["result" => true]);
		}

		$this->tdl->changeValidationRules();
		$slug = uniqid() . "-" . user()->toArray()["username"];
		
		$banner = $this->request->getFile("banner");
		$banner_name = $banner?->getRandomName();

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

		// jika status bernilai 0 / belum tuntas dan masih memiliki tenggat waktu, maka data bisa di sunting/update
		if( !$tdl["status"] && date_format(date_create("now"), "Y-m-d H:I:s" ) < $tdl["due_date"] ) 
		{
			$fields = [
				"id" => $tdl["id"],
				"title" => $this->request->getVar("title"),
				"desc" => $this->request->getVar("desc"),
				"due_date" => $tdl["due_date"],
				"status" => !$tdl["status"] ? $this->request->getVar("status") : $tdl["status"]
			];
	
			if($this->request->getFile("banner")->getError() !== 4)
			{
				$banner = $this->request->getFile("banner");
				$banner_name = $banner->getRandomName();
				
				$fields["banner"] = $banner_name;
			}
			
			if($this->tdl->save($fields) === false)
			{
				return $this->respond(["error" => $this->tdl->errors(), "result" => false]);
			}
			else
			{
				if(isset($banner))
				{
					unlink("banners/{$tdl['banner']}");
					$banner->move("banners", $banner_name);
				}
			}
	
			
			
			session()->setFlashData("success", "Berhasil mensunting data jadwal");
			return $this->respond(["result" => true]);
		}
	}

	public function deleted($slug)
	{
		$tdl = $this->tdl->getToDoList($slug);

		unlink("banners/{$tdl["banner"]}");
		$this->tdl->delete($tdl["id"]);

		session()->setFlashData("success", "Berhasil menghapus jadwal");
		return $this->respond(["result" => "success"]);
	}

	public function search($query)
	{
		$result = '';
		if(strlen($query))
		{
			$result_data = $this->tdl->searchData($query)->getResultObject();
			if(count($result_data))
			{
				foreach($result_data as $tdl)
				{
					$result .= 
					'
					<div class="card mb-5">
						<div class="card-header">
							' . $tdl->title . '
						</div>
						<div class="card-body">
							<div class="d-lg-flex">
								<img class="img-thumbnail" src="' . base_url() . '/banners/' . $tdl->banner . '" alt="thumbnail jadwal" width="300">
								<div class="ml-lg-5 mt-3">
									<p><b>Deskripsi Jadwal :</b> ' . $tdl->desc . '</p>
								</div>
							</div>
							<div class="float-lg-right mt-sm-3">
								<!-- <button class="btn btn-danger btn-sm delete-tdl" data-tdl="' . $tdl->slug . '">Hapus</button>
								<button class="btn btn-primary btn-sm update-tdl" data-tdl="' . $tdl->slug . '">Sunting</button> -->
								<button class="btn btn-outline-info btn-sm show-tdl mr-4" data-tdl="' . $tdl->slug . '">Detail</button>
							</div>
						</div>
					</div>
					';
				}
			}
			else
			{
				$result .= 
				'
					<h4 class="text-center">Tidak ada jadwal / tugas bernama <b>' . $query . '</b></h4>
				';
			}
		}
		else
		{
			$data = $this->tdl->where("user_id", user_id())->orderBy("created_at", "DESC")->paginate(3, "tdl");
			$pager = $this->tdl->pager;
			$result .= $pager->links("tdl", "custom_pagination");
			foreach($data as $tdl)
				{
					$result .= 
					'
					<div class="card mb-5">
						<div class="card-header">
							' . $tdl["title"] . '
						</div>
						<div class="card-body">
							<div class="d-lg-flex">
								<img class="img-thumbnail" src="' . base_url() . '/banners/' . $tdl["banner"] . '" alt="thumbnail jadwal" width="300">
								<div class="ml-lg-5 mt-3">
									<p><b>Deskripsi Jadwal :</b> ' . $tdl["desc"] . '</p>
								</div>
							</div>
							<div class="float-lg-right mt-sm-3">
								<!-- <button class="btn btn-danger btn-sm delete-tdl" data-tdl="' . $tdl["slug"] . '">Hapus</button>
								<button class="btn btn-primary btn-sm update-tdl" data-tdl="' . $tdl["slug"] . '">Sunting</button> -->
								<button class="btn btn-outline-info btn-sm show-tdl mr-4" data-tdl="' . 
								$tdl["slug"] . '">Detail</button>
							</div>
						</div>
					</div>
					';
				}
		}


		return $this->respond(["result" => $result]);
	}

	public function updateProfile()
	{
		$user = new UserModel();
		$user_login = user()->toArray();

		$fields = [
			"id" => user_id(),
			"fullname" => $this->request->getVar("fullname"),
			"username" => $this->request->getVar("username"),
			"email" => $this->request->getVar("email"),
			"password" => $this->request->getVar("password") ? 
					Password::hash($this->request->getVar("password")) 
					: $user_login["password_hash"]
		];

		if($this->request->getFile("image")?->getError() !== 4)
		{

			$image = $this->request->getFile("image");
			$image_name = $image->getRandomName();

			$fields["image"] = $image_name;
		}

		if($user->save($fields) === false)
		{
			return $this->respond(["result" => false, "error" => $user->errors()]);
		}
		else
		{
			// store image
			$image->move("profiles", $image_name);
			// delete old image
			if($user_login["image"] !== "default.svg")
			{
				unlink("profiles/{$user_login['image']}");
			}
		}

		session()->setFlashData("success", "Berhasil menyunting profile user anda!");
		return $this->respond(["result" => true]);
	}
}
