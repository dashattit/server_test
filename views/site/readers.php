<div class="body-container">
    <div class="table-container">
        <table>
            <caption>Список читателей</caption>
            <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Отчество</th>
                <th>Адрес</th>
                <th>Телефон</th>
                <th>Книги (дата выдачи - дата сдачи)</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($readers as $reader): ?>
                <tr>
                    <td><?= $reader->id; ?></td>
                    <td><?= $reader->first_name; ?></td>
                    <td><?= $reader->last_name; ?></td>
                    <td><?= $reader->patronym ?: "Нет данных"; ?></td>
                    <td><?= $reader->address; ?></td>
                    <td><?= $reader->telephone; ?></td>
                    <td>
                        <?php if ($reader->deliveries->count() > 0): ?>
                            <ul style="list-style: none">
                                <?php foreach ($reader->deliveries as $delivery): ?>
                                    <li>
                                        <?= $delivery->book->title; ?>
                                        (<?= $delivery->date_extradition ?> -
                                        <?= $delivery->date_return ?: 'не сдана'; ?>)
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            Нет выданных книг
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="right-panel">
        <div class="book-actions">
            <a href="<?= app()->route->getUrl('/readers/create') ?>">+ Добавить читателя</a>
        </div>


        <form action="<?= app()->route->getUrl('/readers') ?>" method="get" class="search-form">
            <h4>Поиск по книгам</h4>
            <label>
                <input name="search_field" class="search-field" type="text"
                       placeholder="введите название книги..."
                       value="<?= $request->get('search_field') ?? '' ?>">
            </label>

            <div class="form-buttons">
                <button type="submit" class="search-button">Применить</button>
                <a href="<?= app()->route->getUrl('/readers') ?>" class="reset-button">Сбросить</a>
            </div>
        </form>
    </div>

</div>

