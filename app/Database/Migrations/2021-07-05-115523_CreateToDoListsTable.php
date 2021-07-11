<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateToDoListsTable extends Migration
{
	public function up()
	{
		$fields = 
		[
			"id" => 
			[
				"type" => "INT",
				"constraint" => 11,
				"unsigned" => true,
				"auto_increment" => true
			],
			"user_id" =>
			[
				"type" => "INT",
				"constraint" => 11,
				"unsigned" => true
			],
			"slug" => 
			[
				"type" => "VARCHAR",
				"constraint" => 255
			],
			"banner" =>
			[
				"type" => "VARCHAR",
				"constraint" => "255"
			],
			"title" => 
			[
				"type" => "VARCHAR",
				"constraint" => "100"
			],
			"desc" =>
			[
				"type" => "text"
			],
			"due_date" =>
			[
				"type" => "DATETIME"
			], 
			"status" => 
			[
				"type" => "INT",
				"constraint" => 2,
			],
			"created_at" =>
			[
				"type" => "DATETIME",
				"null" => true
			],
			"updated_at" =>
			[
				"type" => "DATETIME",
				"null" => true
			]
		];

		$this->forge->addKey("id", true, true);
		$this->forge->addField($fields);
		
		$this->forge->addForeignKey("user_id", "users", "id");
		$this->forge->createTable("todolists");
	}

	public function down()
	{
		$this->forge->dropTable("todolists");
	}
}
