<?php

namespace App\DataTables;

use App\Models\Schools;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SchoolsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Schools> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('name', function ($row) {
                return '<div class="fw-bold text-dark">' . e($row->name) . '</div>';
            })
            ->editColumn('regu', function ($row) {
                if (!$row->regu) {
                    return '<span class="text-muted">-</span>';
                }
                $badgeClass = match ($row->regu) {
                    'Regu A' => 'bg-primary text-white',
                    'Regu B' => 'bg-success text-white',
                    'Regu C' => 'bg-warning text-white',
                    'Regu D' => 'bg-info text-dark',
                    'Regu E' => 'bg-secondary text-white',
                    default => 'bg-dark text-white',
                };
                return '<span class="badge ' . $badgeClass . ' px-2 py-1">' . e($row->regu) . '</span>';
            })
            ->editColumn('score', function ($row) {
                return '<span class="badge bg-light text-dark border fs-6 fw-bold px-3 py-1">' . $row->score . '</span>';
            })
            ->editColumn('slot', function ($row) {
                if ($row->slot) {
                    return '<span class="badge bg-danger fs-7"><i class="bi bi-display me-1"></i> Slot ' . $row->slot . ' (Panggung)</span>';
                }
                return '<span class="badge bg-secondary-subtle text-secondary border">Standby</span>';
            })
            ->addColumn('action', function ($row) {
                $deleteUrl = route('dashboard.schools.destroy', $row->id);
                $scoreUrl = route('dashboard.schools.adjust-score', $row->id);
                $slotUrl = route('dashboard.schools.set-slot', $row->id);

                return '
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-outline-success btn-sm btn-quick-score" data-id="' . $row->id . '" data-name="' . e($row->name) . '" data-score="' . $row->score . '" data-url="' . $scoreUrl . '" title="Ubah Skor">
                        <i class="bi bi-calculator"></i>
                    </button>
                    <button type="button" class="btn btn-outline-info btn-sm btn-set-slot" data-id="' . $row->id . '" data-name="' . e($row->name) . '" data-slot="' . ($row->slot ?? '') . '" data-url="' . $slotUrl . '" title="Atur Slot Panggung">
                        <i class="bi bi-display"></i>
                    </button>
                    <button type="button" class="btn btn-outline-primary btn-sm btn-edit" data-id="' . $row->id . '" data-name="' . e($row->name) . '" data-regu="' . e($row->regu) . '" data-score="' . $row->score . '" data-slot="' . ($row->slot ?? '') . '" data-url="' . route('dashboard.schools.update', $row->id) . '" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm btn-delete" data-id="' . $row->id . '" data-name="' . e($row->name) . '" data-url="' . $deleteUrl . '" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
                ';
            })
            ->rawColumns(['name', 'regu', 'score', 'slot', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Schools>
     */
    public function query(Schools $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('slot', 'asc')->orderBy('id', 'desc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('schools-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->responsive(true)
                    ->parameters([
                        'processing' => false,
                        'language' => [
                            'search' => 'Cari:',
                            'lengthMenu' => 'Tampilkan _MENU_ data',
                            'zeroRecords' => 'Tidak ada data sekolah ditemukan',
                            'info' => 'Menampilkan _START_ s/d _END_ dari _TOTAL_ sekolah',
                            'infoEmpty' => 'Menampilkan 0 data',
                            'infoFiltered' => '(difilter dari _MAX_ total data)',
                            'paginate' => [
                                'first' => 'Awal',
                                'last' => 'Akhir',
                                'next' => 'Selanjutnya',
                                'previous' => 'Sebelumnya',
                            ],
                        ],
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->orderable(false)->searchable(false)->addClass('text-center')->width(50),
            Column::make('name')->title('Nama Sekolah'),
            Column::make('regu')->title('Regu')->width(120),
            Column::make('score')->title('Skor')->addClass('text-center')->width(100),
            Column::make('slot')->title('Status Slot')->addClass('text-center')->width(180),
            Column::computed('action')->title('Aksi')->exportable(false)->printable(false)->width(160)->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Schools_' . date('YmdHis');
    }
}
