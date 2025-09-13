<div class="mb-3">
    <label class="form-label">Título</label>
    <input name="title" value="{{ old('title', $book->title ?? '') }}" class="form-control" required>
</div>

<div class="mb-3">
    <label class="form-label">Autor</label>
    <input name="author" value="{{ old('author', $book->author ?? '') }}" class="form-control">
</div>

<div class="mb-3">
    <label class="form-label">Editorial</label>
    <input name="editorial" value="{{ old('editorial', $book->editorial ?? '') }}" class="form-control">
</div>

<div class="mb-3">
    <label class="form-label">ISBN</label>
    <input name="isbn" value="{{ old('isbn', $book->isbn ?? '') }}" class="form-control">
</div>

<div class="mb-3">
    <label class="form-label">Año de publicación</label>
    <input name="publication_year" value="{{ old('publication_year', $book->publication_year ?? '') }}" class="form-control">
</div>

<div class="mb-3">
    <label class="form-label">Total de copias</label>
    <input name="total_copies" type="number" value="{{ old('total_copies', $book->total_copies ?? 1) }}" class="form-control" required>
</div>

<div class="mb-3">
    <label class="form-label">Descripción</label>
    <textarea name="description" class="form-control">{{ old('description', $book->description ?? '') }}</textarea>
</div>
