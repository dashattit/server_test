<div class="body-container">
    <div class="table-container">
        <table>
            <caption>Список книг</caption>
            <thead>
            <tr>
                <th>ID</th>
                <th>Заголовок</th>
                <th>Автор</th>
                <th>Год публикации</th>
                <th>Цена (р.)</th>
                <th>Новое издание</th>
                <th>Аннотация</th>
                <th>Выдач</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= $book->id; ?></td>
                    <td><?= $book->title; ?></td>
                    <td>
                    <?=
                    $book->author->last_name . ' ' .
                    ($book->author->first_name) . ' ' .
                    ($book->author->patronym ?: '');
                    ?>
                    </td>
                    <td><?= $book->year_publication; ?></td>
                    <td><?= $book->price; ?></td>
                    <td><?= $book->new_edition ? 'Да' : 'Нет'; ?></td>
                    <td><?= $book->annotation ?: 'Нет данных'; ?></td>
                    <td><?= $book->deliveries_count ?? 0; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="right-panel">
        <?php if ($user): ?>
            <div class="book-actions">
                <a href="<?= app()->route->getUrl('/books/create') ?>">+ Добавить книгу</a>
                <a href="<?= app()->route->getUrl('/books/issue') ?>">Выдать книгу</a>
                <a href="<?= app()->route->getUrl('/books/accept') ?>">Принять книгу</a>
            </div>
        <?php endif; ?>

        <form action="<?= app()->route->getUrl('/books') ?>" method="get" class="search-form">
            <h4>Поиск по читателям</h4>
            <label>
                <input name="search_field" class="search-field" type="text"
                       placeholder="введите ФИО читателя..."
                       value="<?= $request->get('search_field') ?? '' ?>">
            </label>

            <h4>По популярности</h4>
            <label class="checkbox-label">
                <input name="search_checkbox" class="checkbox" type="checkbox" value="1"
                    <?= $request->get('search_checkbox') ? 'checked' : '' ?>>
            </label>

            <div class="form-buttons">
                <button type="submit" class="search-button">Применить</button>
                <a href="<?= app()->route->getUrl('/books') ?>" class="reset-button">Сбросить</a>
            </div>
        </form>

    </div>
</div>