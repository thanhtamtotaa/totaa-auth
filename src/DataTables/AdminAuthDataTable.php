<?php

namespace ToTaa\Auth\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Auth;

class AdminAuthDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($query) {
                $Action_Icon="<div class='action-div icon-4 px-0 mx-1 d-flex justify-content-around text-center'>";

                if (Auth::user()->bfo_info->can("edit-account")) {
                    $Action_Icon.="<div class='col action-icon-w-50 action-icon' totaa-edit-account='$query->id'><i class='text-twitter fas fa-user-edit'></i></div>";

                    $Action_Icon.="<div class='col action-icon-w-50 action-icon' totaa-link-account='$query->id'><i class='text-success fas fa-link'></i></div>";

                    $Action_Icon.="<div class='col action-icon-w-50 action-icon' totaa-reset-password='$query->id'><i class='text-linux fas fa-user-lock'></i></div>";
                }

                $Action_Icon.="</div>";

                return $Action_Icon;
            })
            ->editColumn('bfo_info.mnv', function ($query) {
                if (!!optional($query->bfo_info)->mnv) {
                    return "[".optional($query->bfo_info)->mnv ."] ".optional($query->bfo_info)->full_name;
                } else {
                    return NULL;
                }
            })
            ->editColumn('created_at', function ($query) {
                if (!!$query->created_at) {
                    return $query->created_at->format("d-m-Y H:i");
                } else {
                    return NULL;
                }
            })
            ->editColumn('deleted_at', function ($query) {
                if (!!$query->deleted_at) {
                    return "Đã xóa";
                } else {
                    return "Đang hoạt động";
                }
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        $query = $model->newQuery()->withTrashed();

        if (!request()->has('order')) {
            $query->orderBy('id', 'desc');
        };

        return $query->with(["bfo_info:mnv,full_name"]);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('user-table')
                    ->columns($this->getColumns())
                    ->dom("<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'row'<'col-sm-12 table-responsive't>><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>")
                    ->parameters([
                        "autoWidth" => false,
                        "lengthMenu" => [
                            [10, 25, 50, -1],
                            [10, 25, 50, "Tất cả"]
                        ],
                        "order" => [],
                        'initComplete' => 'function(settings, json) {
                            var api = this.api();
                            window.addEventListener("dt_draw", function(e) {
                                api.draw(false);
                                e.preventDefault();
                            })
                            api.buttons()
                                .container()
                                .appendTo($("#datatable-button"));
                        }',
                    ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('action')
                    ->exportable(false)
                    ->printable(false)
                    ->width(60)
                    ->addClass('text-center')
                    ->title("")
                    ->footer(""),
            Column::make('id')
                  ->title("ID")
                  ->addClass('text-center')
                  ->width(5)
                  ->searchable(true)
                  ->orderable(true)
                  ->footer("ID"),
            Column::make("name")
                  ->title("Họ tên")
                  ->width(200)
                  ->searchable(true)
                  ->orderable(true)
                  ->footer("Họ tên"),
            Column::make("email")
                  ->title("Email")
                  ->width(150)
                  ->searchable(true)
                  ->orderable(false)
                  ->footer("Email"),
            Column::make("phone")
                  ->title("Số điện thoại")
                  ->width(50)
                  ->searchable(true)
                  ->orderable(false)
                  ->footer("Số điện thoại"),
            Column::make("bfo_info.mnv")
                  ->title("Liên kết với nhân viên")
                  ->width(200)
                  ->searchable(true)
                  ->orderable(false)
                  ->render("function() {
                        if (!!data) {
                            return data;
                        } else {
                            return null;
                        }
                    }")
                  ->footer("Liên kết với nhân viên"),
            Column::computed("deleted_at")
                  ->title("Trạng thái")
                  ->searchable(true)
                  ->width(20)
                  ->orderable(true)
                  ->footer("Trạng thái"),
            Column::computed("created_at")
                  ->title("Thời gian đăng ký")
                  ->searchable(false)
                  ->orderable(false)
                  ->footer("Thời gian đăng ký"),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'User_' . date('YmdHis');
    }
}
