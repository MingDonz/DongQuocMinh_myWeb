<form action="{{ route('admin.categories.destroy', $category->id) }}"
    method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">
        Xóa
    </button>
</form>