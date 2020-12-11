
<div wire:ignore.self class="modal fade" id="link_modal" tabindex="-1" role="dialog" aria-labelledby="link_modal" aria-hidden="true" data-toggle="modal" data-backdrop="static" data-keyboard="false">

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

                            @if (!!$yeucaucapquyen)
                                
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Mã nhân viên:</label>
                                        <div>
                                            <span type="text" class="form-control px-2 h-auto">{{ $yeucaucapquyen->mnv }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Nhóm:</label>
                                        <div>
                                            <span type="text" class="form-control px-2 h-auto">{{ $yeucaucapquyen->nhom }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Ngày sinh:</label>
                                        <div>
                                            <span type="text" class="form-control px-2 h-auto">{{ $yeucaucapquyen->ngaysinh->format("d-m-Y") }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Ngày vào làm:</label>
                                        <div>
                                            <span type="text" class="form-control px-2 h-auto">{{ $yeucaucapquyen->ngaythuviec->format("d-m-Y") }}</span>
                                        </div>
                                    </div>
                                </div>

                            @endif

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label text-indigo" for="info_mnv">Nhân viên:</label>
                                    <div class="select2-success" id="info_mnv_div">
                                        <select class="form-control px-2 select2-totaa" totaa-placeholder="Liên kết với nhân viên ..." totaa-search="10" wire:model="info_mnv" id="info_mnv" style="width: 100%">
                                            @if (!!count($bfo_info_arrays))
                                                <option selected></option>
                                                @foreach ($bfo_info_arrays as $bfo_info_array)
                                                    <option value="{{ $bfo_info_array["mnv"] }}">[{{ $bfo_info_array["mnv"] }}] {{ $bfo_info_array["full_name"] }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @error('info_mnv')
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
                <button wire:click.prevent="save_link_account()" totaa-click-block-ui class="btn btn-success" wire:loading.attr="disabled">Xác nhận</button>
            </div>

        </div>
    </div>

</div>
