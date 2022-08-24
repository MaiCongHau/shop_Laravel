<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Staff extends Authenticatable
{
    use HasFactory;
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
    
    protected $permissionList=[];
    public function roles()
    {
        return $this->belongsToMany(Role::class,'staff_roles','staff_id','role_id'); // 
    }
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);// dò lên cột 'name' trong bảng role, nếu có vai trò đó thì trả về true ko thì flase
        }
        return false;
    }

    public function hasPermission($permission = null) // boolean
    {
      
        if (is_null($permission)) {
            return $this->getPermissions()->count();
        }

        if (is_string($permission)) {
            return $this->getPermissions()->contains('name', $permission); // 'name': cột name nên đừng điên mà sửa lại, $permission: nếu nó match với giá trị trong cột name nếu có thì trả về true, ko thì false
        }
        return false;
    }

    private function getPermissions() // thằng này nó sẽ trả về 1 danh sách các quyền của Auth
    {
        $role = $this->roles->first();// lấy ra nhiều model 
        if ($role) {
            if (!$role->relationLoaded('permissions')) { // 'permissions': được định nghĩa trong model Role.php, thằng này nghĩa là kiểm tra nếu mới quan hệ trả về Object thì true ko thì false
                $this->roles->load('permissions');  // 'permissions': được định nghĩa trong model Role.php
            }
            $this->permissionList = $this->roles->pluck('permissions')->flatten(); 
        }
        return $this->permissionList ?? collect(); // trả về danh sách permission hoặc là trả về rỗng
    }
   
}
