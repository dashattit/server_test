<br>
<div class="login-container">
    <h2>Регистрация</h2>
    <form id="loginForm" method="post" enctype="multipart/form-data">
        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
        <div class="input-group">
            <input type="text" name="first_name" placeholder="введите имя..." >
        </div>
        <div class="input-group">
            <input type="text" name="last_name" placeholder="введите фамилию..." >
        </div>
        <div class="input-group">
            <input type="text" name="patronym" placeholder="введите отчество...">
        </div>
        <div class="input-group">
            <input type="text" name="login" placeholder="введите логин..." >
        </div>
        <div class="input-group">
            <input type="password" name="password" placeholder="введите пароль..." >
        </div>
        <div class="input-group">
            <label for="avatar">Аватар:</label>
            <input type="file" id="avatar" name="avatar" placeholder="введите пароль..." >
        </div>
        <div class="divider"></div>
        <button type="submit">Зарегистрироваться</button>
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
