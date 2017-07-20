<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use CodeProject\Entities\Project;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectFileController extends Controller {
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

    public function index() 
   {
       //   return $this->repository->all();
       //  return $this->repository->with(['owner', 'project'])->find($id);
    
    return $this->repository->findWhere(['owner_id' => \Authorizer::getResourceOwnerId()]);
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
    public function store(Request $request)
   
    {
     //dd($request->all());
         $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
            
            $data['file'] = $file;    
            $data['extension'] = $extension;
            $data['name'] = $request->name;
            $data['project_id'] = $request->project_id;
            $data['description'] = $request->description;
           
            $this->service->createFile($data);
    
        
        
    }
        
        
    public function members($id) {
        try {
            $members = $this->repository->find($id)->members()->get();
            if (count($members)) {
                return $members;
            }
            return $this->erroMsgm('Esse projeto ainda não tem membros.');
        } catch (ModelNotFoundException $e) {
            return $this->erroMsgm('Projeto não encontrado.');
        } catch (QueryException $e) {
            return $this->erroMsgm('Cliente não encontrado.');
        } catch (\Exception $e) {
            return $this->erroMsgm('Ocorreu um erro ao exibir os membros do projeto.');
        }
    }

    public function addMember($project_id, $member_id) {
        try {
            return $this->service->addMember($project_id, $member_id);
        } catch (ModelNotFoundException $e) {
            return $this->erroMsgm('Projeto não encontrado.');
        } catch (QueryException $e) {
            return $this->erroMsgm('Cliente não encontrado.');
        } catch (\Exception $e) {
            return $this->erroMsgm('Ocorreu um erro ao inserir o membro.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        /*         * $userId = \Authorizer::getResourceOwnerId();


          if ($this->repository->isOwner($id, $userId) == false) {
          return ['success' => false];


          }
         * 
         */
//return ['userId'=>\Authorizer::getResourceOwnerId()];
//$this->checkProjectOwner($id);
        // if ($this->repository->isOwner($id, )){
        if ($this->checkProjectPermissions($id)== false )
        {
            return ['error' => 'Access Forbidden'];
        }
        return $this->repository->find($id);
    }

    /*     * try {
      return $this->repository->find($id);
      } catch (ModelNotFoundException $e) {
      return ['error' => true, 'Projeto não encontrado.'];
      }
     * 
     */

    public function removeMember($project_id, $member_id) {
        $project = $this->repository->find($project_id);
        $project->members()->detach($member_id);
        return $project->members()->get();
    }

    private function erroMsgm($mensagem) {
        return [
            'error' => true,
            'message' => $mensagem,
        ];
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
        try {
            $this->repository->update($request->all(), $id);
            return ['success' => true, 'Projeto atualizado com sucesso!'];
        } catch (QueryException $e) {
            return ['error' => true, 'Projeto não pode ser atualizado pois existe um ou mais clientes vinculados a ele.'];
        } catch (ModelNotFoundException $e) {
            return ['error' => true, 'Projeto não encontrado.'];
        } catch (\Exception $e) {
            return ['error' => true, 'Ocorreu algum erro ao atualizar o projeto.'];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        try {
            $this->repository->find($id)->delete();
            return ['success' => true, 'Projeto deletado com sucesso!'];
        } catch (QueryException $e) {
            return ['error' => true, 'Projeto não pode ser apagado pois existe um ou mais clientes vinculados a ele.'];
        } catch (ModelNotFoundException $e) {
            return ['error' => true, 'Projeto não encontrado.'];
        } catch (\Exception $e) {
            return ['error' => true, 'Ocorreu algum erro ao excluir o projeto.'];
        }
    }

    private function checkProjectOwner($projectId)
    {
        $userId = \Authorizer::getResourceOwnerId();

        return $this->repository->isOwner($projectId, $userId);
    }

    
    
     private function checkProjectMember($projectId)
    {
        $userId = \Authorizer::getResourceOwnerId();

        return $this->repository->hasMember($projectId, $userId);
    }
    
    
    
    
    private function checkProjectPermissions($projectId){
        
        if ($this ->checkProjectOwner($projectId)or $this-> checkProjectMember($projectId))
        {
            return true;
        }
    return false;
        
        }
    
    
    }

