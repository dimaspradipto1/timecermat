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
     * @param QueryBuilder<User> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('name', function ($row) {
                return '<div class="fw-bold text-dark">' . e($row->name) . '</div>';
            })
            ->editColumn('email', function ($row) {
                return '<span class="text-muted"><i class="bi bi-envelope me-1"></i>' . e($row->email) . '</span>';
            })
            ->editColumn('role', function ($row) {
                $badgeClass = match ($row->role) {
                    'admin' => 'bg-danger text-white',
                    'operator' => 'bg-primary text-white',
                    'juri' => 'bg-success text-white',
                    default => 'bg-secondary text-white',
                };
                return '<span class="badge ' . $badgeClass . ' px-2 py-1 text-uppercase">' . e($row->role) . '</span>';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at->format('d/m/Y H:i') : '-';
            })
            ->addColumn('action', function ($row) {
                $deleteUrl = route('dashboard.users.destroy', $row->id);
                $isSelf = auth()->id() === $row->id;

                $deleteBtn = $isSelf
                    ? '<button type="button" class="btn btn-outline-secondary btn-sm disabled" title="Tidak dapat menghapus akun sendiri"><i class="bi bi-trash"></i></button>'
                    : '<button type="button" class="btn btn-outline-danger btn-sm btn-delete-user" data-id="' . $row->id . '" data-name="' . e($row->name) . '" data-url="' . $deleteUrl . '" title="Hapus"><i class="bi bi-trash"></i></button>';

                return '
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-outline-primary btn-sm btn-edit-user" data-id="' . $row->id . '" data-name="' . e($row->name) . '" data-email="' . e($row->email) . '" data-role="' . e($row->role) . '" data-url="' . route('dashboard.users.update', $row->id) . '" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    ' . $deleteBtn . '
                </div>
                ';
            })
            ->rawColumns(['name', 'email', 'role', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<User>
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('id', 'desc');
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
                    ->responsive(true)
                    ->parameters([
                        'processing' => false,
                        'language' => [
                            'search' => 'Cari:',
                            'lengthMenu' => 'Tampilkan _MENU_ data',
                            'zeroRecords' => 'Tidak ada data pengguna ditemukan',
                            'info' => 'Menampilkan _START_ s/d _END_ dari _TOTAL_ pengguna',
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
            Column::make('name')->title('Nama Lengkap'),
            Column::make('email')->title('Email / Username'),
            Column::make('role')->title('Role Akses')->width(130)->addClass('text-center'),
            Column::make('created_at')->title('Terdaftar Pada')->width(150),
            Column::computed('action')->title('Aksi')->exportable(false)->printable(false)->width(110)->addClass('text-center'),
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
