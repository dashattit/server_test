<br>
<div class="login-container">
    <h2>Создание читателя</h2>
    <form id="loginForm" method="post">
        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
        <div class="input-group">
            <input type="text" name="first_name" placeholder="введите имя..." value="<?= $old['first_name'] ?? '' ?>" >
        </div>
        <div class="input-group">
            <input type="text" name="last_name" placeholder="введите фамилию..." value="<?= $old['last_name'] ?? '' ?>" >
        </div>
        <div class="input-group">
            <input type="text" name="patronym" placeholder="введите отчество..." value="<?= $old['patronym'] ?? '' ?>">
        </div>
        <div class="input-group">
            <input type="text" name="address" placeholder="введите адрес..." value="<?= $old['address'] ?? '' ?>">
        </div>
        <div class="input-group">
            <input type="text" name="telephone" placeholder="введите номер телефона..." value="<?= $old['telephone'] ?? '' ?>">
        </div>
        <div class="divider"></div>
        <button type="submit">Создать</button>
        <a href="<?= app()->route->getUrl('/readers') ?>">Отмена</a>
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