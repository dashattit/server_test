<br>
<div class="login-container">
    <h2>Принятие книги</h2>
    <form method="get">
        <label for="ticket_number">Читатель:</label>
        <select id="ticket_number" name="ticket_number" onchange="this.form.submit()">
            <option value="">Выберите читателя</option>
            <?php foreach ($readers as $reader): ?>
                <option value="<?= $reader->id ?>"
                    <?= !empty($selectedReader) && $selectedReader == $reader->id ? 'selected' : '' ?>>
                    <?= $reader->last_name . ' ' . $reader->first_name . ' ' . ($reader->patronym ?: '') ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <form id="acceptForm" method="post">
        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>

        <div class="input-group">
            <label for="book_id">Книга:</label>
            <?php if (empty($selectedReader)): ?>
                <p>Выберите читалеля</p>
            <?php else: ?>
                <?php if ($books->count() == 0): ?>
                    <p>Нет занятых книг</p>
                <?php else: ?>
                    <select id="book_id" name="book_id">
                        <?php foreach ($books as $book): ?>
                            <option value="<?= $book->id ?>"><?= $book->title ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <div class="divider"></div>
        <?php if ($books->count() != 0): ?>
            <button type="submit">Принять</button>
        <?php endif; ?>
        <a href="<?= app()->route->getUrl('/books') ?>">Отмена</a>
    </form>
    <?php if (!empty($errors)): ?>
        <div class="errors">
            <ul>
                <?php foreach ($errors as $field => $fieldErrors): ?>
                    <?php foreach ($fieldErrors as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>