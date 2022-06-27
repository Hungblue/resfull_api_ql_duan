<?php

namespace App\Repositories;

use App\Models\Deadlines;
use App\Models\User;
use App\Repositories\Repository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class ProjectRepository extends Repository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Project::class;
    }

    public function getList()
    {
        $projects = [];
        $list = [];
        // get project theo user
        if (Auth::user()->role_id != 4 ) {
            $list = $this->getAll();
        } else {
            // $list = $this->model->where('leader_id', Auth::user()->id)->get();
            $list =$this->model->where('leader_id', Auth::user()->id)->orwhereHas('resources', function (Builder $query) {
                $query->where('user_id',Auth::user()->id);
            })->get();
            // dd($list);
        }

        foreach ($list as $project) {
            $this->project($project);
            array_push($projects, collect($project)->except(['estimations', 'deadlines', 'resources']));
        }
        return $projects;
    }

    public function getDetailProject($id)
    {
        $project = $this->find($id);
        if ($project) {
            $this->project($project);
        }
        return $project;
    }

    public function project($project)
    {
        $resources = [];
        // $project->total = $project->type == 1 ? $project->unit_price : $project->estimations->sum('total');
        $project->total = $project->estimations->sum('total');
        $project->size = $project->estimations->sum('effort');
        $project->deadline = $project->deadlines->count();
        if ($project->deadlines) {
            foreach ($project->deadlines as $deadline) {
                $deadline->status_name = DB::table('master_status_deadline')->select('name')->where('id', $deadline->status)->first()->name;
            }
        }
        if ($project->resources) {
            foreach ($project->resources as $r) {
                $user = User::where('id', $r->user_id)->first();
                if ($user) {
                    $r->user_name = $user->username;
                    $r->status_name = $user->name;
                    array_push($resources, $r->user_name);
                }
            }
        }
        if (count($resources) > 0) {
            $project->count_resource = count($resources);
            $project->resource = implode(', ', $resources);
        }
        $recent_deadline = Deadlines::select('date', 'name')->where([
            ['project_id', '=', $project->id],
            ['date', '>=', Carbon::now()->format('Y-m-d')]
        ])->orderBy('date', 'asc')->first();
        if ($recent_deadline) {
            $project->recent = $recent_deadline->date;
            $project->recent_name = $recent_deadline->name;
        }
        // dd($project->recent);die;
        if ($project->start_date > now()) {
            $project->status = 'Opened';
        } else {
            if ($project->start_date <= now() && now() <= $project->plan_close_date) {
                $project->status = 'In progress';
            } else
                $project->status = 'Closed';
        }
        $project->leader_name = User::where('id', $project->leader_id)->first() ? User::where('id', $project->leader_id)->first()->name : '';
        $project->type_name = DB::table('master_types')->select('name')->where('id', $project->type)->first()->name;
        $project->contract_status_name = DB::table('master_status_contract')->select('name')->where('id', $project->contract_status)->first()->name;
    }
}
