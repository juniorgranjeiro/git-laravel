<?php

namespace CodeProject\Http\Controllers;


use CodeProject\Entities\Project;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;

use Illuminate\Http\Request;

class ProjectController extends Controller {

    /**
     *
     * @var ClientRepository;
     */
    /**
     *
     * @var ClientService
     */
    
    private $repository;

    public function __construct(ProjectRepository $repository, ProjectService $service) {
    


        $this->repository = $repository;
        $this->service = $service;
        
    }

    public function index() {
        return $this->repository->all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        
     
        return $this->service->create($request->all()); 

               
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return Project::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        return $this->service->update($request->all());
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
       return $this->repository->delete($id);
    }

}
