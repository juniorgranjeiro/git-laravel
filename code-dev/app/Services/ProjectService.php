<?php
namespace CodeProject\Services;


use CodeProject\Repositories\ClientRepository;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ClientValidator;
use CodeProject\Validators\ProjectValidator;
use Prettus\Validator\Exceptions\ValidatorException;

use Illuminate\Contracts\Filesystem\Factory as Storage;
//use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Facades\File;    

use \Illuminate\Filesystem\Filesystem;



class ProjectService {


    /**
     * @var ClientRepository
     */
    protected $repository;
    
    /**
     * @var ClientValidator
     */
    protected $validator;
    

    public function __construct(ProjectRepository $repository, ProjectValidator $validator, Filesystem $filesystem, Storage $storage) {

        $this->repository = $repository;
        $this->validator = $validator;
        $this->filesystem = $filesystem;
        $this->storage = $storage;
        
        
    }

    public function create(array $data) {

      try {
            $this->validator->with($data)->passesOrFail();
            
            return $this->repository->create($data);
            
            
      } catch (ValidatorException $e) {

            return [

                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }
    }
    
      public function isMember($project_id, $member_id)
    {
        $project = $this->repository->find($project_id)->members()->find(['member_id' => $member_id]);
        if(count($project)){
            return true;
        }
        return false;
    }
    
      public function addMember($project_id, $member_id)
    {
        $project = $this->repository->find($project_id);
        if(!$this->isMember($project_id, $member_id)){
            $project->members()->attach($member_id);
        }
    }
    
    
    public function update(array $data, $id) 
    {
        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->update($data, $id);
        } catch (ValidatorException $e) {

            return [

                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }
    }    

    public function createFile(array $data) {
        
        $project = $this->repository->skipPresenter()->find($data['project_id']);
        
        $projectFile = $project->files()->create($data);
               
         $this->storage->put($projectFile->id . "." . $data['extension'], $this->filesystem->get($data['file']));
    
    }    
   
    
}




    

    
    
    
    
    
    
    
    
    
    
    

