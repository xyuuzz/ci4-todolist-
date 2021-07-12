<?php

namespace App\Models;

use CodeIgniter\Model;

class ToDoList extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'todolists';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = ["user_id", "banner", "title", "desc", "due_date", "status", "slug"];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation
	protected $validationRules = [
        'banner'         => 'is_image[banner]|max_size[banner, 1024]|mime_in[banner,image/png,image/jpg,image/jpeg]|ext_in[banner,png,jpeg,jpg]',
        'title'      => 'required|string|min_length[5]|max_length[200]',
        'desc' => 'required|string|min_length[30]|max_length[2000]',
		"due_date" => "required|date"
    ];

    protected $validationMessages = [
		"banner" => [
			"max_size" => "Max ukuran gambar adalah 1 MB",
			"mime_in" => "Gambar harus memiliki ekstensi png, jpeg atau jpg",
			"ext_in" => "Gambar harus memiliki ekstensi png, jpeg atau jpg",
		],
		"title" => [
			"required" => "Wajib mengisi field judul",
			"string" => "Field judul wajib memiliki tipe string",
			"min_length" => "Field judul setidaknya memiliki 5 huruf",
			"max_length" => "Panjang dari field judul tidak boleh dari 200",
		],
		"desc" => [
			"required" => "Field deskripsi wajib diisi!",
			"string" => "Field deskripsi wajib memiliki tipe string",
			"min_length" => "Field deskripsi setidaknya memiliki 30 huruf",
			"max_length" => "Panjang dari field deskripsi tidak boleh dari 2000",
		],
		"due_date" => [
			"required" => "Field Tanggal wajib diisi!",
			"date" => "Field tanggal harus memiliki format tanggal, tidak boleh yang lain",
		]
	];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];

	// buat fungsi yang menghubungkan antara table todolists dan table users, dengan fk di todolists dengan nama user_id.
	public function user($id)
	{
		return $this->db->table("users")
					->join("todolists", "users.id = todolists.id")
					->where("todolists.user_id", "$id")
					->get();
	}

	public function getToDoList($slug = null)
	{
		if($slug)
		{
			return $this->where(["slug" => $slug])->first();
		}
		
		return $this->all();
	}

	public function changeValidationRules()
	{
		$this->validationRules["banner"] .= "|uploaded[banner]";
		$this->validationMessages["banner"]["uploaded"] = "Wajib mengunggah foto jadwal / tugas";
	}

	public function searchData($query)
	{
		return $this->db->table("todolists")
				->like("title", "%$query%")
				->get();
	}
}
