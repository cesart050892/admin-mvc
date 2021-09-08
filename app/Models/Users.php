<?php

namespace App\Models;

use CodeIgniter\Model;

class Users extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'users';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'App\Entities\Users';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['name', 'surname', 'display', 'email', 'img', 'username' ,'password'];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
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

	// Functions

	public function getAll(){
		$data = $this->builder()
		->select('
		users.id, 
		users.`name`, 
		users.surname, 
		users.display, 
		users.img, 
		users.phone, 
		users.address, 
		auth.email, 
		auth.username,
		auth.id AS auth
		')
		->join('auth', 'users.id = auth.user_fk' )
		->where('users.deleted_at', null)
		->get()
		->getResultArray();
		$entity = [];
		foreach ($data as $key) {
			array_push($entity, new \App\Entities\Users($key));
		}
		return $entity;
	}
}
