<div class="body-container">
    <div class="table-container">
        <table>
            <caption>Список библиотекарей</caption>
            <thead>
            <tr>
                <th>ID</th>
                <th>Аватар</th>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Отчество</th>
                <th>Логин</th>
                <th>Роль</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($librarians as $librarian): ?>
                <tr>
                    <td><?= $librarian->id; ?></td>
                    <td class="avatar">
                        <?php if ($librarian->avatar): ?>
                            <img alt="avatar" src="<?= "$librarian->avatar" ?>" width="100px" height="100px">
                        <?php else: ?>
                            <img alt="avatar" src="<?= "uploads/avatars/default_avatar.jpg" ?>" width="100px" height="100px">
                        <?php endif; ?></td>
                    <td><?= $librarian->first_name; ?></td>
                    <td><?= $librarian->last_name; ?></td>
                    <td><?= $librarian->patronym ?: "Нет данных"; ?></td>
                    <td><?= $librarian->login; ?></td>
                    <td><?= $librarian->role->role_name; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
    if ($userRole == "Администратор"):
        ?>
        <a href="<?= app()->route->getUrl('/librarians/create') ?>">+ Добавить библиотекаря</a>
    <?php endif; ?>
</div>

