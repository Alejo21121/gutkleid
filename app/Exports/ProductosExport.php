<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductosExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Producto::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID Producto',
            'Nombre',
            'Valor',
            'Marca',
            'Talla',
            'Color',
            'Categoría',
            'ID Factura Venta',
            'ID Inventario',
        ];
    }
}