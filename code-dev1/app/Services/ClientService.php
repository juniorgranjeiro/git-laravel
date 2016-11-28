<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Services;

use CodeProject\Repositories\ClientRepository;

class ClientService {

//put your code here


    protected $repository;

    public function __construct(ClientRepository $repository) {

        $this->repository = $repository;
    }

    public function create(array $data) {
        return $this->repository->create($data);
    }

    public function update(array $data, $id) {
        return $this->repository->update($data, $id);
    }

}
