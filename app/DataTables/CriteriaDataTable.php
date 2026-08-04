<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class CriteriaDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('checkbox', function (User $user) {
                return view('pages.formEvaluate.criteria.columns._actions', compact('user'));
            })
            ->editColumn('no', function (User $user) {
                return '1';
            })
            ->editColumn('name', function (User $user) {
                return 'การทำงานเป็นทีม';
            })
            ->editColumn('topic_en', function (User $user) {
                return 'Team player';
            })
            ->editColumn('create_date', function (User $user) {
                return 'วว/ดด/ปปปป';
            });
    }


    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('criteria-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-7'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(2)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages//formEvaluate/criteria/columns/_draw-scripts.js')) . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('checkbox')->title(''),
            Column::make('no')->title('No.'),
            Column::make('name')->title('หัวข้อ (ภาษาไทย)'),
            Column::make('topic_en')->title('Title (English)'),
            Column::make('create_date')->title('วันที่สร้าง'),
        ];
    }
}
