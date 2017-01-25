<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        return $this->repository->with(['owner', 'project'])->find($id);
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
        try {
            return $this->repository->find($id);
        } catch (ModelNotFoundException $e) {
            return ['error' => true, 'Projeto não encontrado.'];
        }
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

}
