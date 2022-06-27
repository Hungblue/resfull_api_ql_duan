<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\Resources;
use App\Models\User;
use App\Models\UserSkill;
use App\Repositories\Repository;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\role;
use Exception;

class UserRepository extends Repository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\User::class;
    }

    
    public function getAllUsers($data)
    {
        $usersQr = User::where('id', '!=', 1);
        if (isset($data['status'])) {
            $usersQr = $usersQr->where('status', $data['status']);
        }

        if (isset($data['name'])) {
            $usersQr = $usersQr->where('users.name','like' , '%'.$data['name'].'%')
            ->orWhere('users.username','like' , '%'.$data['name'].'%');
        }

        $users = $usersQr->get();

        foreach ($users as $user) {
            $user->busy_rate = $this->getBusyRate($user->id);
            $user->join_projects = $this->getJoinProjects($user->id);
            // $user->skill_id = $this->userKill($user->id);
        }

        // $a=$this->model->with('kill')->get();

        return $users;
    }

    public function getAllSearchableUsers($data)
    {
        $usersQr = User::where('id', '!=', 1);
        if (isset($data['status'])) {
            $usersQr = $usersQr->where('status', $data['status']);
        }

        if (isset($data['name'])) {
            $usersQr = $usersQr->where('users.name','like' , '%'.$data['name'].'%')
            ->orWhere('users.username','like' , '%'.$data['name'].'%');
        }

        if (isset($data['pageSize'])) {
			$users = $usersQr->paginate($data['pageSize']);
		}
        else {
            $users = $usersQr->get();
        }
        
        foreach ($users as $user) {
            $user->busy_rate = $this->getBusyRate($user->id);
            $user->join_projects = $this->getJoinProjects($user->id);
            // $user->skill_id = $this->userKill($user->id);
        }

        
        return [
            'status' => true,
            'message' => 'Lấy danh sách thành công',
            'data' => $users->items(),
            'pages'=>[
                    'totalElements'      =>$users->total(),
                    'numberItemPerPage'    =>$users->perPage(),
                    'currentPage'=>$users->currentPage()
                ]
            ];
        // $a=$this->model->with('kill')->get();

        return $users;
    }

    public function getUser($id)
    {
        $user = $this->find($id);
        $user->kill;
        $user->busy_rate = $this->getBusyRate($id);
        $user->join_projects = $this->getJoinProjects($id);

        // dd($user->join_projects);die;
        return $user;
    }

    public function getJoinProjects($id)
    {
        $list_project_name = [];
        $list_project_id = Resources::select('project_id')->where(
            [
                ['user_id', $id],
                ['end_date', '>=', now()]
            ]
        )->get();
        if (count($list_project_id) > 0) {
            foreach ($list_project_id as $id) {
                // $project_name = ((Project::firstWhere('id', $id->project_id))->code);
                $project_name = (DB::table('projects')->where('id', $id->project_id)->first())->code;
                array_push($list_project_name, $project_name);
            }
        }
        $list_project_name = count($list_project_name) > 0 ? implode(',', $list_project_name) : '';
        return $list_project_name;
    }

    public function getBusyRate($id)
    {
        return Resources::select('busy_rate')->where(
            [
                ['user_id', $id],
                ['end_date', '>=', now()]
            ]
        )->sum('busy_rate');
    }
    public function createSkill($data)
    {
        try {
            $proObj = DB::transaction(function () use ($data) {

                $user = new User();
                if (isset($data['name'])) {
                    $user->name = $data['name'];
                }
                if (isset($data['username'])) {
                    $user->username = $data['username'];
                }
                if (isset($data['password'])) {
                    $user->password = $data['password'];
                }
                if (isset($data['status'])) {
                    $user->status = $data['status'];
                }
                if (isset($data['email'])) {
                    $user->email = $data['email'];
                }
                if (isset($data['joined_date'])) {
                    $user->joined_date = $data['joined_date'];
                }
                if (isset($data['number_years_experience'])) {
                    $user->number_years_experience = $data['number_years_experience'];
                }
                if (isset($data['birthday'])){
                    $user->birthday = $data['birthday'];
                }
                // $user->joined_date = $data['joined_date']->format('d-m-Y');
                $user->country = $data['country'];
                $user->phone_number = $data['phone_number'];
                $user->cmnd = $data['cmnd'];
                $user->role_id = 4;
                $user->save();
                if (isset($data['skill_id'])) {
                    foreach ($data['skill_id'] as $key => $item) {
                        if(is_numeric($item)){
                            $skill = new UserSkill();
                            $skill->user_id = $user->id;
                            $skill->skill_id = $item;
                            $skill->time_experience = $data['time_experience'][$key];
                            $skill->save();
                        }
                    }
                }
            });
            return response()->json([
                'status' => true,
                'message' => 'Thành công',
                'data' => $proObj,
            ])->setStatusCode(200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function updates($id, $data)
    {
        try {
            DB::beginTransaction();
            $user = $this->update($id, $data);
            if (isset($data['skill_id']) && is_numeric($data['skill_id'][0]) ) {
                foreach ($data['skill_id'] as $key => $value) {
                    if(is_numeric($value)){
                        $a[$value] = [
                            'skill_id' => $value,
                            'time_experience' => $data['time_experience'][$key]
                        ];
                    }
                }
                $user->kill()->sync($a);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
        return $user;
    }
    public function loginProvider($data)
    {
        // $check = $this->model->where('provider_id', $data['provider_id'])->where('provider_name', $data['provider_name'])->first();
        // $user_name = $this->convert_name($data['name']);
        // if (!$check) {
        //     $users = new User();
        //     $users->name = $data['name'];
        //     $users->username = $user_name . Str::random(4);
        //     $users->email = (!empty($data['email'])) ? $data['email'] : '';
        //     $users->provider_id = $data['provider_id'];
        //     $users->provider_name = $data['provider_name'];
        //     $users->status = 3;
        //     $users->role_id = 3;
        //     $users->phone = (!empty($data['phone']) ? $data['phone'] : '');
        //     $users->password = bcrypt(Str::random(8));
        //     $users->save();
        //     Auth::login($users, true);
        // } else {
        //     $check->update([
        //         'email' => (!empty($data['email'])) ? $data['email'] : '',
        //         'provider_id' => $data['provider_id'],
        //         'phone' => (!empty($data['phone'])) ? $data['phone'] : ''
        //     ]);

        //     auth()->login($check);
        // }

        if(isset($data['email'])){
            $checkUser = $this->model->where('email',$data['email'])->first();
            $dataUser = [
                'email' => $checkUser ?  $checkUser->email :'',
            ];
            if ($checkUser){
                auth()->login($checkUser);
                $user = Auth::user();
                $token = $user->createToken('TutsForWeb')->accessToken;
                $message = [
                    'Status' => true,
                    'Message' => 'Đăng nhập thành công!',
                    'token_type' => 'Bearer',
                    'access_token' => $token,
                    'Data' => Auth::user()
                ];
            } else {
                $message = [
                    'Status' => false,
                    'Message' => 'Đăng nhập thất bại!',
                ];
            }
        }else {
            $message = [
                'Status' => false,
                'Message' => 'Đăng nhập thất bại!',
            ];
        }
        
        return $message;

        // $user = Auth::user();
        // $token = $user->createToken('TutsForWeb')->accessToken;
        // $user_id = $user->id;
        // $getData = role::where('users.id', '=', $user_id)
        //     ->join('users', 'users.role_id', '=', 'role.id')
        //     ->select('role.name as role_name ', 'users.*')
        //     ->first();
        // return [
        //     'Status' => true,
        //     'Message' => 'Đăng nhập thành công!',
        //     'token_type' => 'Bearer',
        //     'access_token' => $token,
        //     'Data' => $getData
        // ];
    }

    public function changePassword($data) {
        $user = Auth::user();
        // var_dump($data['password']);
        // dd($user->password);
        $data['username'] = $user->username;
        $check = Auth::guard('web')->attempt([
            'username'=> $user->username,
            'password'=> $data['password']
        ]);
        if (!$check) return false;
        $user->password = bcrypt($data['newPassword']);
        $user->token()->revoke();
        $user->save();
        return true;
    }

    public function adminResetPassword($data) {
        $user = User::find($data["userId"]);
        if ($user) {
            $user->password = bcrypt($data['password']);
            $user->save();
        }

        return $user;
    }

    public function convert_name($str)
    {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
        $str = preg_replace("/(\“|\”|\‘|\’|\,|\!|\&|\;|\@|\#|\%|\~|\`|\=|\_|\'|\]|\[|\}|\{|\)|\(|\+|\^)/", '-', $str);
        $str = preg_replace("/( )/", '', $str);
        return $str;
    }
    public function userKill($id)
    {
        $user = UserSkill::where('user_id', $id)->get();
        return $user;
    }
    public function check($data)
    {
        return $this->model->where('username', $data)->first();
    }
}
