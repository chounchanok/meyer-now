<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['user', 'last_login_at'])
            ->editColumn('user', function (User $user) {
                return view('pages.apps.user-management.users.columns._user', compact('user'));
            })
            ->editColumn('role', function (User $user) {
                $roles = $user->roles;
                return view('pages.apps.user-management.permissions.columns._assign-to', compact('roles'));
            })
            ->editColumn('last_login_at', function (User $user) {
                return sprintf('<div class="badge badge-light fw-bold">%s</div>', ($user->last_login_at ? $user->last_login_at->diffForHumans() : ($user->updated_at ? $user->updated_at->diffForHumans():'')) );
            })
            ->editColumn('created_at', function (User $user) {
                return $user->created_at?->format('d M Y, h:i a');
            })
            ->editColumn('active', function (User $user) {
                return view('pages.apps.user-management.users.columns._active', compact('user'));
            })
            ->addColumn('action', function (User $user) {
                return view('pages.apps.user-management.users.columns._actions', compact('user'));
            })
            ->editColumn('sectioncode', function (User $user) {
                return view('pages.apps.user-management.users.columns._sectioncode', compact('user'));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model
        ->select('users.id',
        'users.orisoft_code',
        'users.name',
        'users.email',
        'users.profile_photo_path',
        'users.email_verified_at',
        'users.avatar',
        'users.active',
        'users.created_at',
        'users.updated_at',
        'users.last_login_at',
        'users.last_login_ip',
        'tb_employee_evaluator.section_code'
        )
        ->leftJoin('tb_employee_evaluator','tb_employee_evaluator.employee_no','=','users.orisoft_code')
        ->where('users.id', '>', '1')
        ->where('users.orisoft_code','!=','000000')
        ->groupBy('users.orisoft_code')
        ->orderBy('tb_employee_evaluator.rec_year', 'DESC')
        ->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-7'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            // ->orderBy(2)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages//apps/user-management/users/columns/_draw-scripts.js')) . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('user')->title(__('Name'))->addClass('d-flex align-items-center')->name('name'),
            Column::make('orisoft_code')->name('orisoft_code')->title(__('Employee Code'))->searchable(true)->width(100),
            Column::make('email')->name('email')->title(__('Email'))->searchable(true)->width(100),
            Column::make('sectioncode')->name('section_code')->title(__('Section Code'))->searchable(true)->width(100),
            Column::computed('role')->title(__('Role')),
            Column::make('last_login_at')->title(__('Last Login')),
            Column::make('active')->title(__('Active'))->width(50)->searchable(true),
            // Column::make('created_at')->title('Joined Date')->addClass('text-nowrap'),
            Column::computed('action')->title(__('Action'))
                ->addClass('text-end text-nowrap')
                ->exportable(false)
                ->printable(false)
                ->width(60),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
