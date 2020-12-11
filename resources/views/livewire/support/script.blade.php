<script>

    //Ẩn toàn bộ modal
    window.addEventListener('hide_modal', function(e) {
        $(".modal.fade[style='display: block;']").modal("hide");
    })

    //Hiện modal cụ thể
    window.addEventListener('show_modal', event => {
        $(event.detail).modal("show");
    })

    //UI block
    $(document).on("click", "[totaa-click-block-ui]", function() {
        ToTaa_BlockUI();
    });

    //Toastr thông báo
    window.addEventListener('toastr', event => {
        toastr[event.detail.type](event.detail.message, event.detail.title, {
            positionClass: "toast-top-right",
            closeButton: true,
            progressBar: true,
            timeOut: 15000,
            extendedTimeOut: 2000,
            preventDuplicates: false,
            newestOnTop: true,
            rtl: $("body").attr("dir") === "rtl" ||
                $("html").attr("dir") === "rtl"
        });
    })

    //Block UI khi ấn thêm mới
    Livewire.on('add_account', function() {
        ToTaa_BlockUI();
    });

    //Gọi view sửa thông tin
    $(document).on("click", "[totaa-edit-account]", function() {
        ToTaa_BlockUI();
        Livewire.emit('edit_account', $(this).attr("totaa-edit-account"));
    });

    //Gọi view set team
    $(document).on("click", "[totaa-link-account]", function() {
        ToTaa_BlockUI();
        Livewire.emit('link_account', $(this).attr("totaa-link-account"));
    });

    //Gọi view set thành viên
    $(document).on("click", "[totaa-reset-password]", function() {
        ToTaa_BlockUI();
        Livewire.emit('reset_password', $(this).attr("totaa-reset-password"));
    });

    //Xử lý khi dữ liệu đã được load xong
    document.addEventListener("DOMContentLoaded", () => {
        Livewire.hook("message.processed", (message, component) => {
            $.unblockUI();

            if ($("select.select2-totaa").length != 0) {
                $("select.select2-totaa").each(function(e) {
                    $(this)
                    .wrap('<div class="position-relative"></div>')
                    .select2({
                        placeholder: $(this).attr("totaa-placeholder"),
                        minimumResultsForSearch: $(this).attr("totaa-search"),
                        dropdownParent: $("#" + $(this).attr("id") + "_div"),
                    });
                });
            }

            if ($("input.datepicker-totaa").length != 0) {
                $("input.datepicker-totaa").each(function(e) {
                    $(this).datepicker('update');
                });
            }
        });
    });

    if ($("select.select2-totaa").length != 0) {
        $("select.select2-totaa").each(function(e) {
            $(this).on('select2:close', function (e) {
                @this.set($(this).attr("wire:model"), $(this).val());
            });
        });
    }


    if ($("input.datepicker-totaa").length != 0) {
        $("input.datepicker-totaa").each(function(e) {
            $(this)
                .datepicker({
                    language: "vi",
                    autoclose: true,
                    toggleActive: true,
                    todayHighlight: true,
                    todayBtn: "linked",
                    clearBtn: true,
                    maxViewMode: 3,
                    minViewMode: 0,
                    startView: $(this).attr("startview-totaa"),
                    weekStart: 1,
                    format: "dd-mm-yyyy",
                    container: $(this).attr("container-totaa"),
                    orientation: isRtl ? "auto right" : "auto left"
                })
                .on("hide", function(e) {
                    @this.set($(this).attr("wire:model"), $(this).val());
                });
        });
    }


</script>
