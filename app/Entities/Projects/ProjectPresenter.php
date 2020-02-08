<?php

namespace App\Entities\Projects;

use Laracasts\Presenter\Presenter;
use ProjectStatus;

class ProjectPresenter extends Presenter
{
  

    public function projectLink()
    {
        return link_to_route('projects.show', $this->name, [$this->id]);
    }

    public function status()
    {
        return ProjectStatus::getNameById($this->entity->status_id);
    }

    public function workDuration()
    {
        if (is_null($this->entity->end_date)) {
            return '-';
        }

        $workDuration = dateDifference($this->entity->start_date, $this->entity->end_date);
        if ((int) $workDuration > 30) {
            return dateDifference($this->entity->start_date, $this->entity->end_date, '%m Month %d Day');
        }

        return $workDuration.' Day';   
    }
}
