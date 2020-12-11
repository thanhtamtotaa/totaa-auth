<?php

namespace ToTaa\Auth\Http\Livewire;

use Livewire\Component;
use Auth;
use Illuminate\Support\Facades\Cache;
use Totaa\TotaaBfo\Models\BfoInfo;
use Totaa\TotaaTeam\Models\Team;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Totaa\TotaaTeam\Traits\BfoHasTeamTraits;
use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthLivewire extends Component
{
    use PasswordValidationRules;

    /**
     * Các biến sử dụng trong Component
     *
     * @var mixed
     */
    public $account, $account_id, $name, $email, $phone, $info_mnv, $password, $password_confirmation, $yeucaucapquyen, $active;
    public $bfo_info, $modal_title, $toastr_message;

    /**
     * Cho phép cập nhật updateMode
     *
     * @var bool
     */
    public $updateMode = false;
    public $editStatus = false;

    /**
     * Các biển sự kiện
     *
     * @var array
     */
    protected $listeners = ['edit_account', 'link_account', 'reset_password', ];

    /**
     * Validation rules
     *
     * @var array
     */
    protected function rules() {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'info_mnv' => 'nullable|exists:bfo_infos,mnv',
            'password' => $this->passwordRules(),
            'active' => 'nullable|boolean',
        ];
    }

    /**
     * render view
     *
     * @return void
     */
    public function render()
    {
        return view('totaa::livewire.account-livewire');
    }

    /**
     * mount data
     *
     * @return void
     */
    public function mount()
    {
        $this->bfo_info = Auth::user()->bfo_info;
    }

    /**
     * On updated action
     *
     * @param  mixed $propertyName
     * @return void
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedName()
    {
        $this->name = mb_convert_case(trim($this->name), MB_CASE_TITLE, "UTF-8");
    }

    /**
     * cancel
     *
     * @return void
     */
    public function cancel()
    {
        $this->updateMode = false;
        $this->editStatus = false;
        $this->resetValidation();
        $this->reset();
        $this->mount();
        $this->dispatchBrowserEvent('hide_modal');
    }

    /**
     * edit_account method
     *
     * @return void
     */
    public function edit_account($id)
    {
        if ($this->bfo_info->cannot("edit-account")) {
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Bạn không có quyền thực hiện hành động này"]);
            return null;
        }

        $this->modal_title = "Chỉnh sửa tài khoản - ID: ". $id;
        $this->toastr_message = "Chỉnh sửa tài khoản thành công";
        $this->editStatus = true;
        $this->updateMode = true;

        $this->account_id = $id;
        $this->account = User::withTrashed()->find($this->account_id);
        $this->name = $this->account->name;
        $this->email = $this->account->email;
        $this->phone = $this->account->phone;
        $this->info_mnv = $this->account->info_mnv;
        $this->active = !!!$this->account->deleted_at;

        $this->dispatchBrowserEvent('show_modal', "#add_edit_modal");
    }

    /**
     * save_account
     *
     * @return void
     */
    public function save_account()
    {
        if ($this->bfo_info->cannot("edit-account")) {
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Bạn không có quyền thực hiện hành động này"]);
            return null;
        }

       $validateData = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
        ]);

        try {
            $this->account->update($validateData);

            if (!!$this->active && !!$this->account->deleted_at) {
                $this->account->restore();
            }

            if (!!!$this->active && !!!$this->account->deleted_at) {
                $this->account->delete();
            }

        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => implode(" - ", $e->errorInfo)]);
            return null;
        }

        //Đầy thông tin về trình duyệt
        $this->dispatchBrowserEvent('dt_draw');
        $toastr_message = $this->toastr_message;
        $this->cancel();
        $this->dispatchBrowserEvent('toastr', ['type' => 'success', 'title' => "Thành công", 'message' => $toastr_message]);
    }
    
    /**
     * link_account method
     *
     * @return void
     */
    public function link_account($id)
    {
        if ($this->bfo_info->cannot("edit-account")) {
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Bạn không có quyền thực hiện hành động này"]);
            return null;
        }

        $this->modal_title = "Liên kết nhân viên";
        $this->toastr_message = "Liên kết thông tin nhân viên thành công";
        $this->editStatus = true;
        $this->updateMode = true;

        $this->account_id = $id;
        $this->account = User::withTrashed()->find($this->account_id);
        $this->name = $this->account->name;
        $this->email = $this->account->email;
        $this->phone = $this->account->phone;
        $this->info_mnv = $this->account->info_mnv;
        $this->yeucaucapquyen = $this->account->yeucaucapquyen;

        $this->dispatchBrowserEvent('show_modal', "#link_modal");
    }

    /**
     * save_link_account method
     *
     * @return void
     */
    public function save_link_account()
    {
        if ($this->bfo_info->cannot("edit-account")) {
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Bạn không có quyền thực hiện hành động này"]);
            return null;
        }

        $validateData = $this->validate([
            'info_mnv' => 'nullable|exists:bfo_infos,mnv',
        ]);

        try {
            $this->account->forceFill($validateData)->save();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => implode(" - ", $e->errorInfo)]);
            return null;
        }

        //Đầy thông tin về trình duyệt
        $this->dispatchBrowserEvent('dt_draw');
        $toastr_message = $this->toastr_message;
        $this->cancel();
        $this->dispatchBrowserEvent('toastr', ['type' => 'success', 'title' => "Thành công", 'message' => $toastr_message]);
    }

    
    /**
     * reset_password method
     *
     * @return void
     */
    public function reset_password($id)
    {
        if ($this->bfo_info->cannot("edit-account")) {
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Bạn không có quyền thực hiện hành động này"]);
            return null;
        }

        $this->modal_title = "Reset mật khẩu";
        $this->toastr_message = "Reset mật khẩu thành công";
        $this->editStatus = true;
        $this->updateMode = true;

        $this->account_id = $id;
        $this->account = User::withTrashed()->find($this->account_id);
        $this->name = $this->account->name;
        $this->email = $this->account->email;
        $this->phone = $this->account->phone;
        $this->yeucaucapquyen = $this->account->yeucaucapquyen;

        $this->dispatchBrowserEvent('show_modal', "#reset_modal");
    }

    /**
     * save_password method
     *
     * @return void
     */
    public function save_password()
    {
        if ($this->bfo_info->cannot("edit-account")) {
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Bạn không có quyền thực hiện hành động này"]);
            return null;
        }

        $validateData = $this->validate([
            'password' => $this->passwordRules(),
        ]);

        try {
            $this->account->forceFill(['password' => Hash::make($this->password),])->save();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => implode(" - ", $e->errorInfo)]);
            return null;
        }

        //Đầy thông tin về trình duyệt
        $this->dispatchBrowserEvent('dt_draw');
        $toastr_message = $this->toastr_message;
        $this->cancel();
        $this->dispatchBrowserEvent('toastr', ['type' => 'success', 'title' => "Thành công", 'message' => $toastr_message]);
    }
}
