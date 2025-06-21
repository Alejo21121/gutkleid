<form action="{{ route('productos.destroy', $producto->id_producto) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar este producto?');">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
</form>
