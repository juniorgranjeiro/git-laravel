<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;

class ProjectTaskValidator extends LaravelValidator{

    
    protected $rules =[
        
        'name'=> 'required',
        'project_id'=> 'required|integer',
        'start_date'=> 'date',
        'due_date'=>'date',
        'status'=>'integer'
        
        
        
    ];
    
    
}
