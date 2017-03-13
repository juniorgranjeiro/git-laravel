<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Services\ProjectTaskService;

    
class ProjectTaskController extends Controller
{
    /**
     *
        * @var ProjectTaskRepository
     */
    /**
     *
     * @var type ProjectTaskService
     */
    
    private $repository;
    private $service;
    
    public function __construct(ProjectTaskRepository $repository, ProjectTaskService $service)
            {
        $this->repository = $repository;
        $this->service = $service;
    }
    
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
    //    return Client::all();

        return $this->repository->findWhere(['project_id'=>$id]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
    
        $data = $request->all();
        $data['project_id'] = $id;
        return $this->service->create($data);
    }    



//dd ($request->all());
     //return $this->service->create($request->all());
        //Client::create($request->all());
     

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $taskId)
    {
       // if($this->repository->find($taskId));{
        return $this->repository->find($taskId);
        //if($this->repository->find($taskId)){

  //  return "Registro não encontrado!";

        
      //  } 
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $taskId)
    {
        return $this->service->update($request->all(), $taskId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $taskId)
    {
    //return $this->repository->delete($taskId);
    
    
    if($this->repository->delete($taskId)){

    return "Registro excluído com sucesso!";

}

return "Registro não excluído!";
    }
    
    
    }

