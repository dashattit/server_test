<div class="body-container">
    <div class="table-container">
        <table>
            <caption>Список авторов</caption>
            <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Отчество</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($authors as $author): ?>
                <tr>
                    <td><?= $author->id ?></td>
                    <td><?= $author->first_name ?></td>
                    <td><?= $author->last_name ?></td>
                    <td><?= $author->patronym ?: "Нет данных" ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <a href="<?= app()->route->getUrl('/authors/create') ?>">+ Добавить автора</a>
</div>

