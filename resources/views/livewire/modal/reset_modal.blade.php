
<div wire:ignore.self class="modal fade" id="reset_modal" tabindex="-1" role="dialog" aria-labelledby="reset_modal" aria-hidden="true" data-toggle="modal" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content py-2">
            <div class="modal-header">
                <h4 class="modal-title text-purple"><span class="fas fa-user mr-3"></span>{{ $modal_title }}</h4>
                <button type="button" wire:click.prevent="cancel()" class="close" data-dismiss="modal" wire:loading.attr="disabled" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="container-fluid mx-0 px-0">
                    <form>
                        <div class="row">

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label">Họ và tên:</label>
                                    <div>
                                        <span type="text" class="form-control px-2 h-auto">{{ !!$yeucaucapquyen ? $yeucaucapquyen->hoten : $name }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label">Email:</label>
                                    <div>
                                        <span type="text" class="form-control px-2 h-auto">{{ $email }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label">Số điện thoại:</label>
                                    <div>
                                        <span type="text" class="form-control px-2 h-auto">{{ $phone }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label" for="password">Mật khẩu mới:</label>
                                    <div id="password_div">
                                        <input type="password" class="form-control px-2" wire:model.lazy="password" id="password" style="width: 100%" placeholder="Mật khẩu mới ..." autocomplete="off">
                                    </div>
                                    @error('password')
                                        <label class="pl-1 small invalid-feedback d-inline-block" ><i class="fas mr-1 fa-exclamation-circle"></i>{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label" for="password_confirmation">Xác nhân mật khẩu mới:</label>
                                    <div id="password_confirmation_div">
                                        <input type="password" class="form-control px-2" wire:model.lazy="password_confirmation" id="password_confirmation" style="width: 100%" placeholder="Xác nhân mật khẩu mới ..." autocomplete="off">
                                    </div>
                                    @error('password_confirmation')
                                        <label class="pl-1 small invalid-feedback d-inline-block" ><i class="fas mr-1 fa-exclamation-circle"></i>{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-footer mx-auto">
                <button wire:click.prevent="cancel()" class="btn btn-danger" wire:loading.attr="disabled" data-dismiss="modal">Đóng</button>
                <button wire:click.prevent="save_password()" totaa-click-block-ui class="btn btn-success" wire:loading.attr="disabled">Xác nhận</button>
            </div>

        </div>
    </div>

</div>
