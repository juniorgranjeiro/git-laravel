<?php
namespace CodeProject\Services;


use CodeProject\Repositories\ClientRepository;
use CodeProject\Validators\ClientValidator;
use Prettus\Validators\Exceptions\ValidatorException;




class ProjectTaskService {


    /**
     * @var ClientRepository
     */
    protected $repository;
    
    /**
     * @var ClientValidator
     */
    protected $validator;
    

    public function __construct(ProjectTaskRepository $repository, ProjectTaskValidator $validator) {

        $this->repository = $repository;
        $this->validator = $validator;
        
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
}

    

    
    
    
    
    
    
    
    
    
    
    

