<?php


namespace CodeProject\Presenters;

use Prettus\Repository\Presenter\FractalPresenter;

class ProjectPresenters extends FractalPresenter

{
    public function getTransformer()
    {
      return new ProjectTransformer();
    }
   
}
